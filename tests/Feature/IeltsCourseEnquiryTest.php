<?php

namespace Tests\Feature;

use App\Mail\IeltsCourseMail;
use App\Models\IeltsCourseEnquiry;
use App\Models\IeltsCoursePaymentAttempt;
use App\Services\IeltsCourseRazorpay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class IeltsCourseEnquiryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.foreign_key_constraints' => true,
        ]);
        DB::purge();
        DB::setDefaultConnection('sqlite');

        $migration = require base_path('database/migrations/2026_10_30_000000_create_ielts_course_enquiries_table.php');
        $migration->up();
        Mail::fake();
    }

    public function test_required_fields_email_and_phone_are_validated(): void
    {
        $this->postJson('/ielts-courses/enquiry', [])->assertUnprocessable();

        $payload = $this->validPayload();
        $payload['email'] = 'not-an-email';
        $this->postJson('/ielts-courses/enquiry', $payload)->assertUnprocessable()->assertJsonValidationErrors('email');

        $payload = $this->validPayload();
        $payload['phone'] = '123';
        $this->postJson('/ielts-courses/enquiry', $payload)->assertUnprocessable()->assertJsonValidationErrors('phone');
    }

    public function test_server_plan_price_is_used_instead_of_submitted_amount(): void
    {
        $amounts = collect(config('ielts_courses.plans'))->map(fn ($plan) => $plan['amount'])->all();
        $razorpay = Mockery::mock(IeltsCourseRazorpay::class);
        $razorpay->shouldReceive('createOrder')->times(3)->withArgs(function ($reference, $amount, $planName) use ($amounts) {
            return in_array($amount, $amounts, true);
        })->andReturn('order_test_1', 'order_test_2', 'order_test_3');
        $this->instance(IeltsCourseRazorpay::class, $razorpay);

        foreach ($amounts as $plan => $expectedAmount) {
            $payload = $this->validPayload($plan);
            $payload['amount'] = 1;

            $response = $this->postJson('/ielts-courses/enquiry', $payload)->assertOk();
            $response->assertJsonPath('amount', $expectedAmount * 100);
            $this->assertSame($expectedAmount, IeltsCourseEnquiry::where('plan_key', $plan)->value('amount'));
        }
    }

    public function test_duplicate_submission_reuses_enquiry_order_and_initial_emails(): void
    {
        $razorpay = Mockery::mock(IeltsCourseRazorpay::class);
        $razorpay->shouldReceive('createOrder')->once()->andReturn('order_duplicate');
        $razorpay->shouldReceive('fetchOrderPayments')->once()->with('order_duplicate')->andReturn(['items' => []]);
        $this->instance(IeltsCourseRazorpay::class, $razorpay);
        $payload = $this->validPayload();

        $first = $this->postJson('/ielts-courses/enquiry', $payload)->assertOk();
        $second = $this->postJson('/ielts-courses/enquiry', $payload)->assertOk();

        $this->assertSame($first->json('enquiry_reference'), $second->json('enquiry_reference'));
        $this->assertSame(1, IeltsCourseEnquiry::count());
        Mail::assertSent(IeltsCourseMail::class, 2);
    }

    public function test_duplicate_verified_callback_creates_one_attempt_and_one_pair_of_payment_emails(): void
    {
        $enquiry = $this->createEnquiry();
        $razorpay = Mockery::mock(IeltsCourseRazorpay::class);
        $razorpay->shouldReceive('verifyPayment')->twice()->andReturn($this->capturedPayment($enquiry));
        $this->instance(IeltsCourseRazorpay::class, $razorpay);
        $callback = [
            'razorpay_order_id' => $enquiry->razorpay_order_id,
            'razorpay_payment_id' => 'pay_verified',
            'razorpay_signature' => 'signature',
        ];

        $this->postJson('/ielts-courses/payment/verify', $callback)->assertOk();
        $this->postJson('/ielts-courses/payment/verify', $callback)->assertOk();

        $this->assertSame('paid', $enquiry->fresh()->payment_status);
        $this->assertTrue($enquiry->fresh()->payment_verified);
        $this->assertSame(1, IeltsCoursePaymentAttempt::count());
        Mail::assertSent(IeltsCourseMail::class, 4);
    }

    public function test_payment_is_not_marked_paid_when_signature_verification_fails(): void
    {
        $enquiry = $this->createEnquiry();
        $razorpay = Mockery::mock(IeltsCourseRazorpay::class);
        $razorpay->shouldReceive('verifyPayment')->once()->andThrow(new RuntimeException('invalid signature'));
        $this->instance(IeltsCourseRazorpay::class, $razorpay);

        $this->postJson('/ielts-courses/payment/verify', [
            'razorpay_order_id' => $enquiry->razorpay_order_id,
            'razorpay_payment_id' => 'pay_invalid',
            'razorpay_signature' => 'invalid',
        ])->assertStatus(503);

        $this->assertSame('pending', $enquiry->fresh()->payment_status);
        $this->assertFalse($enquiry->fresh()->payment_verified);
        $this->assertSame(0, IeltsCoursePaymentAttempt::count());
        Mail::assertSent(IeltsCourseMail::class, 2);
    }

    public function test_payment_status_check_reconciles_a_captured_payment(): void
    {
        $enquiry = $this->createEnquiry();
        $razorpay = Mockery::mock(IeltsCourseRazorpay::class);
        $razorpay->shouldReceive('fetchOrderPayments')->once()->with($enquiry->razorpay_order_id)->andReturn([
            'items' => [$this->capturedPayment($enquiry)],
        ]);
        $this->instance(IeltsCourseRazorpay::class, $razorpay);
        $payload = [
            'submission_key' => $enquiry->submission_key,
            'enquiry_reference' => $enquiry->enquiry_reference,
            'retry_token' => $enquiry->submission_key,
        ];

        $this->postJson('/ielts-courses/payment/status', $payload)->assertOk()
            ->assertJsonPath('payment_status', 'paid');

        $this->assertSame('paid', $enquiry->fresh()->payment_status);
        $this->assertSame(1, IeltsCoursePaymentAttempt::count());
        Mail::assertSent(IeltsCourseMail::class, 4);
    }

    private function createEnquiry(): IeltsCourseEnquiry
    {
        $razorpay = Mockery::mock(IeltsCourseRazorpay::class);
        $razorpay->shouldReceive('createOrder')->once()->andReturn('order_for_test');
        $this->instance(IeltsCourseRazorpay::class, $razorpay);

        $this->postJson('/ielts-courses/enquiry', $this->validPayload())->assertOk();

        return IeltsCourseEnquiry::firstOrFail();
    }

    private function validPayload(string $plan = 'progress'): array
    {
        return [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'phone' => '9876543210',
            'city' => 'Delhi',
            'plan' => $plan,
            'submission_key' => (string) Str::uuid(),
        ];
    }

    private function capturedPayment(IeltsCourseEnquiry $enquiry): array
    {
        return [
            'id' => 'pay_verified',
            'order_id' => $enquiry->razorpay_order_id,
            'amount' => $enquiry->amount * 100,
            'currency' => 'INR',
            'status' => 'captured',
            'method' => 'card',
        ];
    }
}
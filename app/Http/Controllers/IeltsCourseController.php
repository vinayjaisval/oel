<?php

namespace App\Http\Controllers;

use App\Mail\IeltsCourseMail;
use App\Models\IeltsCourseEnquiry;
use App\Models\IeltsCoursePaymentAttempt;
use App\Services\IeltsCourseRazorpay;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use RuntimeException;
use Throwable;

class IeltsCourseController extends Controller
{
    public function __construct(private IeltsCourseRazorpay $razorpay)
    {
    }

    public function store(Request $request)
    {
        $requestStartedAt = hrtime(true);
        $correlationId = $this->correlationId($request);
        $request->attributes->set('ielts_correlation_id', $correlationId);
        $validationStartedAt = hrtime(true);
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'city' => ['required', 'string', 'min:2', 'max:100'],
            'plan' => ['required', Rule::in(array_keys(config('ielts_courses.plans', [])))],
            'submission_key' => ['required', 'uuid'],
        ]);
        $validationMs = $this->elapsedMilliseconds($validationStartedAt);

        $plan = config('ielts_courses.plans.' . $validated['plan']);
        $enquiryDbStartedAt = hrtime(true);
        try {
            $enquiry = DB::transaction(function () use ($validated, $plan) {
                $enquiry = IeltsCourseEnquiry::where('submission_key', $validated['submission_key'])
                    ->lockForUpdate()
                    ->first();

                if ($enquiry) {
                    return $enquiry;
                }

                return IeltsCourseEnquiry::create([
                    'enquiry_reference' => 'IELTS-' . Str::upper(Str::random(10)),
                    'submission_key' => $validated['submission_key'],
                    'retry_token_hash' => hash('sha256', $validated['submission_key']),
                    'name' => trim($validated['name']),
                    'email' => strtolower(trim($validated['email'])),
                    'phone' => $validated['phone'],
                    'city' => trim($validated['city']),
                    'plan_key' => $validated['plan'],
                    'plan_name' => $plan['name'],
                    'amount' => $plan['amount'],
                    'currency' => 'INR',
                    'payment_status' => 'pending',
                    'payment_verified' => false,
                ]);
            });
        } catch (QueryException $exception) {
            $enquiry = IeltsCourseEnquiry::where('submission_key', $validated['submission_key'])->first();
            if (!$enquiry) {
                throw $exception;
            }
        }
        $enquiryDbMs = $this->elapsedMilliseconds($enquiryDbStartedAt);

        if (
            strtolower($enquiry->name) !== strtolower(trim($validated['name'])) ||
            strtolower($enquiry->email) !== strtolower(trim($validated['email'])) ||
            $enquiry->phone !== $validated['phone'] ||
            strtolower($enquiry->city) !== strtolower(trim($validated['city'])) ||
            $enquiry->plan_key !== $validated['plan']
        ) {
            return response()->json(['message' => 'This form submission is already in use. Refresh the page and try again.'], 409);
        }

        if ($enquiry->payment_status === 'paid') {
            return response()->json([
                'success' => true,
                'payment_status' => 'paid',
                'enquiry_reference' => $enquiry->enquiry_reference,
            ])->header('X-Correlation-ID', $correlationId);
        }

        if ($enquiry->razorpay_order_id) {
            try {
                $status = $this->reconcilePaymentStatus($enquiry, $correlationId);
                if ($status['payment_status'] === 'paid') {
                    return response()->json([
                        'success' => true,
                        'payment_status' => 'paid',
                        'enquiry_reference' => $enquiry->enquiry_reference,
                    ])->header('X-Correlation-ID', $correlationId);
                }
                if ($status['payment_state_uncertain']) {
                    return response()->json([
                        'message' => 'Payment status is still being confirmed. Check the status before trying again.',
                        'enquiry_reference' => $enquiry->enquiry_reference,
                        'retry_token' => $validated['submission_key'],
                        'payment_state_uncertain' => true,
                    ], 409)->header('X-Correlation-ID', $correlationId);
                }
            } catch (Throwable $exception) {
                Log::warning('IELTS existing order status could not be confirmed.', [
                    'correlation_id' => $correlationId,
                    'enquiry_reference' => $enquiry->enquiry_reference,
                    'exception_type' => get_class($exception),
                    'exception_code' => $exception->getCode(),
                ]);

                return response()->json([
                    'message' => 'Payment status is still being confirmed. Check the status before trying again.',
                    'enquiry_reference' => $enquiry->enquiry_reference,
                    'retry_token' => $validated['submission_key'],
                    'payment_state_uncertain' => true,
                ], 503)->header('X-Correlation-ID', $correlationId);
            }
        }

        $this->deferNotifications($enquiry->id, 'enquiry', $correlationId);

        $orderPreparationStartedAt = hrtime(true);
        try {
            $payload = $this->orderPayload($enquiry->id, $validated['submission_key'], $correlationId);
            Log::info('IELTS enquiry request timing', [
                'correlation_id' => $correlationId,
                'validation_ms' => $validationMs,
                'enquiry_db_ms' => $enquiryDbMs,
                'order_preparation_ms' => $this->elapsedMilliseconds($orderPreparationStartedAt),
                'request_to_order_ready_ms' => $this->elapsedMilliseconds($requestStartedAt),
            ]);

            return response()->json($payload)->header('X-Correlation-ID', $correlationId);
        } catch (Throwable $exception) {
            $this->logOrderFailure('IELTS Razorpay order creation failed.', $enquiry, $exception, $correlationId);
            Log::info('IELTS enquiry request timing', [
                'correlation_id' => $correlationId,
                'validation_ms' => $validationMs,
                'enquiry_db_ms' => $enquiryDbMs,
                'order_preparation_ms' => $this->elapsedMilliseconds($orderPreparationStartedAt),
                'request_to_order_ready_ms' => $this->elapsedMilliseconds($requestStartedAt),
                'result' => 'order_error',
            ]);

            return response()->json([
                'message' => 'Your enquiry was saved, but payment could not be started. Please retry.',
                'enquiry_reference' => $enquiry->enquiry_reference,
                'retry_token' => $validated['submission_key'],
            ], 503)->header('X-Correlation-ID', $correlationId);
        }
    }

    public function retry(Request $request)
    {
        $correlationId = $this->correlationId($request);
        $validated = $request->validate([
            'enquiry_reference' => ['required', 'string', 'max:32'],
            'retry_token' => ['required', 'uuid'],
        ]);

        $enquiry = $this->findAuthorizedEnquiry($validated['enquiry_reference'], $validated['retry_token']);
        if (!$enquiry) {
            return response()->json(['message' => 'This payment retry link is invalid.'], 404);
        }
        if ($enquiry->payment_status === 'paid') {
            return response()->json([
                'success' => true,
                'payment_status' => 'paid',
                'enquiry_reference' => $enquiry->enquiry_reference,
            ])->header('X-Correlation-ID', $correlationId);
        }

        try {
            $status = $this->reconcilePaymentStatus($enquiry, $correlationId);
            if ($status['payment_status'] === 'paid') {
                $status['enquiry_reference'] = $enquiry->enquiry_reference;
                return response()->json($status)->header('X-Correlation-ID', $correlationId);
            }
            if ($status['payment_state_uncertain']) {
                return response()->json([
                    'message' => 'Payment status is still being confirmed. Check the status before trying again.',
                    'payment_status' => $status['payment_status'],
                    'payment_state_uncertain' => true,
                ], 409)->header('X-Correlation-ID', $correlationId);
            }

            $payload = $this->orderPayload($enquiry->id, $validated['retry_token'], $correlationId);
            return response()->json($payload)->header('X-Correlation-ID', $correlationId);
        } catch (Throwable $exception) {
            $this->logOrderFailure('IELTS Razorpay retry order preparation failed.', $enquiry, $exception, $correlationId);

            return response()->json([
                'message' => 'Payment status could not be confirmed. Please check the status before retrying.',
                'payment_state_uncertain' => true,
            ], 503)->header('X-Correlation-ID', $correlationId);
        }
    }

    public function status(Request $request)
    {
        $correlationId = $this->correlationId($request);
        $validated = $request->validate([
            'submission_key' => ['required', 'uuid'],
            'enquiry_reference' => ['nullable', 'string', 'max:32'],
            'retry_token' => ['nullable', 'uuid'],
            'razorpay_payment_id' => ['nullable', 'string', 'max:100'],
        ]);
        $token = $validated['retry_token'] ?? $validated['submission_key'];

        $enquiry = !empty($validated['enquiry_reference'])
            ? $this->findAuthorizedEnquiry($validated['enquiry_reference'], $token)
            : IeltsCourseEnquiry::where('submission_key', $validated['submission_key'])->first();

        if (
            !$enquiry ||
            !hash_equals($enquiry->retry_token_hash, hash('sha256', $token))
        ) {
            return response()->json([
                'message' => 'No saved enquiry was found for this submission.',
                'enquiry_found' => false,
                'payment_state_uncertain' => false,
                'can_retry' => true,
            ])->header('X-Correlation-ID', $correlationId);
        }

        $enquiry = DB::transaction(function () use ($enquiry) {
            return IeltsCourseEnquiry::whereKey($enquiry->id)->lockForUpdate()->firstOrFail();
        });

        try {
            $status = $this->reconcilePaymentStatus(
                $enquiry,
                $correlationId,
                $validated['razorpay_payment_id'] ?? null
            );
            $status['enquiry_reference'] = $enquiry->enquiry_reference;
            $status['retry_token'] = $token;
            $status['enquiry_found'] = true;
            if ($status['order_ready'] && $status['payment_status'] !== 'paid') {
                $status = array_merge($status, $this->checkoutPayload($enquiry->fresh(), $token));
            }

            return response()->json($status)->header('X-Correlation-ID', $correlationId);
        } catch (Throwable $exception) {
            Log::warning('IELTS payment status check failed.', [
                'correlation_id' => $correlationId,
                'enquiry_reference' => $enquiry->enquiry_reference,
                'exception_type' => get_class($exception),
                'exception_code' => $exception->getCode(),
            ]);

            return response()->json([
                'message' => 'Payment status is still being confirmed. Check again before retrying.',
                'payment_status' => $enquiry->payment_status,
                'payment_state_uncertain' => true,
            ], 503)->header('X-Correlation-ID', $correlationId);
        }
    }

    public function verify(Request $request)
    {
        $correlationId = $this->correlationId($request);
        $verificationStartedAt = hrtime(true);
        $validated = $request->validate([
            'razorpay_order_id' => ['required', 'string', 'max:100'],
            'razorpay_payment_id' => ['required', 'string', 'max:100'],
            'razorpay_signature' => ['required', 'string', 'max:255'],
        ]);

        $enquiry = IeltsCourseEnquiry::where('razorpay_order_id', $validated['razorpay_order_id'])->first();
        if (!$enquiry) {
            return response()->json(['message' => 'The payment order could not be matched to an enquiry.'], 404);
        }

        try {
            $gatewayStartedAt = hrtime(true);
            $payment = $this->razorpay->verifyPayment($validated, $correlationId);
            $paymentFetchAndSignatureMs = $this->elapsedMilliseconds($gatewayStartedAt);
            $databaseUpdateStartedAt = hrtime(true);
            $this->applyCapturedPayment($enquiry, $payment);
            $databaseUpdateMs = $this->elapsedMilliseconds($databaseUpdateStartedAt);
        } catch (Throwable $exception) {
            Log::warning('IELTS Razorpay payment verification failed.', [
                'correlation_id' => $correlationId,
                'enquiry_reference' => $enquiry->enquiry_reference,
                'duration_ms' => $this->elapsedMilliseconds($verificationStartedAt),
                'exception_type' => get_class($exception),
                'exception_code' => $exception->getCode(),
            ]);

            return response()->json([
                'message' => 'Payment verification is taking longer than expected. Check payment status before retrying.',
                'payment_state_uncertain' => true,
            ], 503)->header('X-Correlation-ID', $correlationId);
        }

        $this->deferNotifications($enquiry->id, 'payment', $correlationId);
        Log::info('IELTS payment verification timing', [
            'correlation_id' => $correlationId,
            'duration_ms' => $this->elapsedMilliseconds($verificationStartedAt),
            'payment_fetch_and_signature_ms' => $paymentFetchAndSignatureMs,
            'payment_database_update_ms' => $databaseUpdateMs,
            'result' => 'verified_paid',
        ]);

        return response()->json([
            'success' => true,
            'payment_status' => 'paid',
            'enquiry_reference' => $enquiry->enquiry_reference,
        ])->header('X-Correlation-ID', $correlationId);
    }

    private function orderPayload(int $enquiryId, string $retryToken, string $correlationId): array
    {
        $orderStartedAt = hrtime(true);
        $lockWaitMs = 0;
        $razorpayApiMs = 0;
        $orderSaveMs = 0;
        try {
            $enquiry = DB::transaction(function () use ($enquiryId, &$lockWaitMs, &$razorpayApiMs, &$orderSaveMs) {
                $lockStartedAt = hrtime(true);
                $enquiry = IeltsCourseEnquiry::whereKey($enquiryId)->lockForUpdate()->firstOrFail();
                $lockWaitMs = $this->elapsedMilliseconds($lockStartedAt);
                if (!$enquiry->razorpay_order_id) {
                    $razorpayStartedAt = hrtime(true);
                    try {
                        $enquiry->razorpay_order_id = $this->razorpay->createOrder(
                            $enquiry->enquiry_reference,
                            $enquiry->amount,
                            $enquiry->plan_name
                        );
                    } catch (Throwable $exception) {
                        $razorpayApiMs = $this->elapsedMilliseconds($razorpayStartedAt);
                        throw $exception;
                    }
                    $razorpayApiMs = $this->elapsedMilliseconds($razorpayStartedAt);
                    $orderSaveStartedAt = hrtime(true);
                    $enquiry->save();
                    $orderSaveMs = $this->elapsedMilliseconds($orderSaveStartedAt);
                }

                return $enquiry;
            });
        } catch (Throwable $exception) {
            Log::info('IELTS order preparation timing', [
                'correlation_id' => $correlationId,
                'enquiry_id' => $enquiryId,
                'db_lock_and_lookup_ms' => $lockWaitMs,
                'razorpay_order_create_ms' => $razorpayApiMs,
                'order_db_save_ms' => $orderSaveMs,
                'order_preparation_total_ms' => $this->elapsedMilliseconds($orderStartedAt),
                'result' => 'error',
            ]);
            throw $exception;
        }

        Log::info('IELTS order preparation timing', [
            'correlation_id' => $correlationId,
            'enquiry_reference' => $enquiry->enquiry_reference,
            'db_lock_and_lookup_ms' => $lockWaitMs,
            'razorpay_order_create_ms' => $razorpayApiMs,
            'order_db_save_ms' => $orderSaveMs,
            'order_preparation_total_ms' => $this->elapsedMilliseconds($orderStartedAt),
            'order_reused' => $razorpayApiMs === 0.0,
        ]);

        return $this->checkoutPayload($enquiry, $retryToken);
    }

    private function checkoutPayload(IeltsCourseEnquiry $enquiry, string $retryToken): array
    {
        return [
            'key_id' => config('ielts_courses.razorpay.key_id'),
            'order_id' => $enquiry->razorpay_order_id,
            'amount' => $enquiry->amount * 100,
            'currency' => $enquiry->currency,
            'name' => $enquiry->name,
            'email' => $enquiry->email,
            'phone' => $enquiry->phone,
            'plan_name' => $enquiry->plan_name,
            'enquiry_reference' => $enquiry->enquiry_reference,
            'retry_token' => $retryToken,
        ];
    }

    private function reconcilePaymentStatus(
        IeltsCourseEnquiry $enquiry,
        string $correlationId,
        ?string $paymentId = null
    ): array
    {
        $enquiry = $enquiry->fresh();
        if ($enquiry->payment_status === 'paid') {
            return [
                'payment_status' => 'paid',
                'order_ready' => (bool) $enquiry->razorpay_order_id,
                'payment_state_uncertain' => false,
                'can_retry' => false,
            ];
        }

        if (!$enquiry->razorpay_order_id) {
            return [
                'payment_status' => $enquiry->payment_status,
                'order_ready' => false,
                'payment_state_uncertain' => false,
                'can_retry' => true,
            ];
        }

        $startedAt = hrtime(true);
        if ($paymentId) {
            $payments = [$this->razorpay->fetchPayment($paymentId)];
        } else {
            $collection = $this->razorpay->fetchOrderPayments($enquiry->razorpay_order_id);
            $payments = data_get($collection, 'items', []);
        }
        $capturedPayment = null;
        $latestFailure = null;
        $hasUnresolvedPayment = false;

        foreach ($payments as $payment) {
            $paymentStatus = data_get($payment, 'status');
            if ($paymentStatus === 'captured') {
                $capturedPayment = $payment;
                break;
            }
            if (in_array($paymentStatus, ['created', 'authorized'], true)) {
                $hasUnresolvedPayment = true;
            } elseif ($paymentStatus === 'failed') {
                $latestFailure = $payment;
            }
        }

        if ($capturedPayment) {
            $this->applyCapturedPayment($enquiry, $capturedPayment);
            $this->deferNotifications($enquiry->id, 'payment', $correlationId);
        } elseif ($latestFailure && !$hasUnresolvedPayment) {
            $this->applyFailedPayment($enquiry, $latestFailure);
        }

        $enquiry = $enquiry->fresh();
        Log::info('IELTS payment status check timing', [
            'correlation_id' => $correlationId,
            'enquiry_reference' => $enquiry->enquiry_reference,
            'razorpay_order_payments_ms' => $this->elapsedMilliseconds($startedAt),
            'payment_status' => $enquiry->payment_status,
            'payments_returned' => count($payments),
        ]);

        $isPaid = $enquiry->payment_status === 'paid';
        return [
            'payment_status' => $enquiry->payment_status,
            'order_ready' => true,
            'payment_state_uncertain' => !$isPaid && $hasUnresolvedPayment,
            'can_retry' => !$isPaid && !$hasUnresolvedPayment,
        ];
    }

    private function applyCapturedPayment(IeltsCourseEnquiry $enquiry, $payment): void
    {
        DB::transaction(function () use ($enquiry, $payment) {
            $locked = IeltsCourseEnquiry::whereKey($enquiry->id)->lockForUpdate()->firstOrFail();
            $paymentId = data_get($payment, 'id');
            $orderId = data_get($payment, 'order_id');
            $amount = (int) data_get($payment, 'amount');
            $currency = data_get($payment, 'currency');
            $gatewayTimestamp = (int) data_get($payment, 'created_at');

            if (
                !$paymentId ||
                $orderId !== $locked->razorpay_order_id ||
                $amount !== $locked->amount * 100 ||
                $currency !== 'INR' ||
                data_get($payment, 'status') !== 'captured'
            ) {
                throw new RuntimeException('Razorpay payment details do not match this enquiry.');
            }
            if ($locked->payment_status === 'paid' && $locked->razorpay_payment_id !== $paymentId) {
                throw new RuntimeException('A different payment is already recorded for this enquiry.');
            }

            IeltsCoursePaymentAttempt::updateOrCreate(
                ['razorpay_payment_id' => $paymentId],
                [
                    'ielts_course_enquiry_id' => $locked->id,
                    'razorpay_order_id' => $orderId,
                    'amount' => $locked->amount,
                    'currency' => $currency,
                    'payment_method' => data_get($payment, 'method'),
                    'status' => 'captured',
                    'verified_at' => now(),
                ]
            );

            $locked->payment_status = 'paid';
            $locked->razorpay_payment_id = $paymentId;
            $locked->payment_verified = true;
            $locked->payment_date = $gatewayTimestamp ? Carbon::createFromTimestamp($gatewayTimestamp) : now();
            $locked->save();
        });
    }

    private function applyFailedPayment(IeltsCourseEnquiry $enquiry, $payment): void
    {
        DB::transaction(function () use ($enquiry, $payment) {
            $locked = IeltsCourseEnquiry::whereKey($enquiry->id)->lockForUpdate()->firstOrFail();
            $paymentId = data_get($payment, 'id');
            $orderId = data_get($payment, 'order_id');
            $amount = (int) data_get($payment, 'amount');

            if (
                !$paymentId ||
                $orderId !== $locked->razorpay_order_id ||
                $amount !== $locked->amount * 100 ||
                data_get($payment, 'currency') !== 'INR' ||
                data_get($payment, 'status') !== 'failed'
            ) {
                throw new RuntimeException('Razorpay failed payment does not match this enquiry.');
            }

            IeltsCoursePaymentAttempt::updateOrCreate(
                ['razorpay_payment_id' => $paymentId],
                [
                    'ielts_course_enquiry_id' => $locked->id,
                    'razorpay_order_id' => $orderId,
                    'amount' => $locked->amount,
                    'currency' => 'INR',
                    'payment_method' => data_get($payment, 'method'),
                    'status' => 'failed',
                    'verified_at' => null,
                ]
            );

            if ($locked->payment_status !== 'paid') {
                $locked->payment_status = 'failed';
                $locked->razorpay_payment_id = $paymentId;
                $locked->payment_verified = false;
            }
            $locked->save();
        });
    }

    private function findAuthorizedEnquiry(string $reference, string $retryToken): ?IeltsCourseEnquiry
    {
        $enquiry = IeltsCourseEnquiry::where('enquiry_reference', $reference)->first();
        if (!$enquiry || !hash_equals($enquiry->retry_token_hash, hash('sha256', $retryToken))) {
            return null;
        }

        return $enquiry;
    }

    private function deferNotifications(int $enquiryId, string $event, string $correlationId): void
    {
        app()->terminating(function () use ($enquiryId, $event, $correlationId) {
            $startedAt = hrtime(true);
            try {
                $enquiry = IeltsCourseEnquiry::find($enquiryId);
                if ($enquiry) {
                    if ($event === 'payment') {
                        $this->sendPaymentNotifications($enquiry);
                    } else {
                        $this->sendInitialNotifications($enquiry);
                    }
                }
            } catch (Throwable $exception) {
                Log::warning('IELTS deferred email processing failed.', [
                    'correlation_id' => $correlationId,
                    'enquiry_id' => $enquiryId,
                    'event' => $event,
                    'exception_type' => get_class($exception),
                    'exception_code' => $exception->getCode(),
                ]);
            }

            Log::info('IELTS deferred email timing', [
                'correlation_id' => $correlationId,
                'enquiry_id' => $enquiryId,
                'event' => $event,
                'duration_ms' => $this->elapsedMilliseconds($startedAt),
            ]);
        });
    }

    private function sendInitialNotifications(IeltsCourseEnquiry $enquiry): void
    {
        $this->sendNotification(
            $enquiry->id,
            'initial_admin_email_sent_at',
            'enquiry',
            'admin',
            config('ielts_courses.admin_email')
        );
        $this->sendNotification(
            $enquiry->id,
            'initial_student_email_sent_at',
            'enquiry',
            'student',
            $enquiry->email
        );
    }

    private function sendPaymentNotifications(IeltsCourseEnquiry $enquiry): void
    {
        $this->sendNotification(
            $enquiry->id,
            'payment_admin_email_sent_at',
            'payment',
            'admin',
            config('ielts_courses.admin_email')
        );
        $this->sendNotification(
            $enquiry->id,
            'payment_student_email_sent_at',
            'payment',
            'student',
            $enquiry->email
        );
    }

    private function sendNotification(int $enquiryId, string $sentField, string $event, string $audience, string $recipient): void
    {
        try {
            DB::transaction(function () use ($enquiryId, $sentField, $event, $audience, $recipient) {
                $enquiry = IeltsCourseEnquiry::whereKey($enquiryId)->lockForUpdate()->firstOrFail();
                if ($enquiry->{$sentField}) {
                    return;
                }

                Mail::to($recipient)->send(new IeltsCourseMail($enquiry, $event, $audience));
                $enquiry->{$sentField} = now();
                $enquiry->save();
            });
        } catch (Throwable $exception) {
            Log::warning('IELTS course email could not be sent.', [
                'enquiry_id' => $enquiryId,
                'event' => $event,
                'audience' => $audience,
            ]);
        }
    }

    private function logOrderFailure(string $message, IeltsCourseEnquiry $enquiry, Throwable $exception, string $correlationId): void
    {
        $keyIdConfigured = filled(config('ielts_courses.razorpay.key_id'));
        $keySecretConfigured = filled(config('ielts_courses.razorpay.key_secret'));

        Log::warning($message, [
            'correlation_id' => $correlationId,
            'enquiry_reference' => $enquiry->enquiry_reference,
            'exception_type' => get_class($exception),
            'exception_code' => $exception->getCode(),
            'credentials_configured' => $keyIdConfigured && $keySecretConfigured,
            'failure_reason' => $keyIdConfigured && $keySecretConfigured
                ? 'razorpay_api_or_network_error'
                : 'credentials_missing',
        ]);
    }

    private function correlationId(Request $request): string
    {
        $correlationId = $request->header('X-Correlation-ID');

        return is_string($correlationId) && Str::isUuid($correlationId)
            ? $correlationId
            : (string) Str::uuid();
    }

    private function elapsedMilliseconds(int $startedAt): float
    {
        return round((hrtime(true) - $startedAt) / 1_000_000, 2);
    }
}
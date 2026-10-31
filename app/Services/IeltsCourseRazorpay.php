<?php

namespace App\Services;

use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class IeltsCourseRazorpay
{
    public function createOrder(string $reference, int $amount, string $planName): string
    {
        $api = $this->api();
        try {
            $order = $api->order->create([
                'receipt' => $reference,
                'amount' => $amount * 100,
                'currency' => 'INR',
                'notes' => [
                    'enquiry_reference' => $reference,
                    'plan_name' => $planName,
                ],
            ]);

            return $order['id'];
        } catch (\Throwable $exception) {
            try {
                $orders = $api->order->all(['receipt' => $reference, 'count' => 10]);
                foreach (data_get($orders, 'items', []) as $existingOrder) {
                    if (
                        data_get($existingOrder, 'receipt') === $reference &&
                        (int) data_get($existingOrder, 'amount') === $amount * 100 &&
                        data_get($existingOrder, 'currency') === 'INR' &&
                        data_get($existingOrder, 'id')
                    ) {
                        return data_get($existingOrder, 'id');
                    }
                }
            } catch (\Throwable) {
            }

            throw $exception;
        }
    }

    public function verifyPayment(array $response, ?string $correlationId = null)
    {
        $startedAt = hrtime(true);
        $signatureMs = null;
        $paymentFetchMs = null;
        $result = 'error';

        try {
            $signatureStartedAt = hrtime(true);
            $this->api()->utility->verifyPaymentSignature([
                'razorpay_order_id' => $response['razorpay_order_id'],
                'razorpay_payment_id' => $response['razorpay_payment_id'],
                'razorpay_signature' => $response['razorpay_signature'],
            ]);
            $signatureMs = round((hrtime(true) - $signatureStartedAt) / 1_000_000, 2);

            $paymentFetchStartedAt = hrtime(true);
            $payment = $this->fetchPayment($response['razorpay_payment_id']);
            $paymentFetchMs = round((hrtime(true) - $paymentFetchStartedAt) / 1_000_000, 2);
            $result = 'verified';

            return $payment;
        } finally {
            Log::info('IELTS payment signature and fetch timing', [
                'correlation_id' => $correlationId,
                'signature_verification_ms' => $signatureMs,
                'payment_fetch_ms' => $paymentFetchMs,
                'total_ms' => round((hrtime(true) - $startedAt) / 1_000_000, 2),
                'result' => $result,
            ]);
        }
    }

    public function fetchPayment(string $paymentId)
    {
        return $this->api()->payment->fetch($paymentId);
    }

    public function fetchOrderPayments(string $orderId)
    {
        return $this->api()->order->fetch($orderId)->payments();
    }

    private function api(): Api
    {
        $keyId = config('ielts_courses.razorpay.key_id');
        $keySecret = config('ielts_courses.razorpay.key_secret');

        if (!$keyId || !$keySecret) {
            throw new RuntimeException('IELTS Razorpay credentials are not configured.');
        }

        return new Api($keyId, $keySecret);
    }
}
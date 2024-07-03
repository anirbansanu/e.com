<?php

// app/Services/PaymentMethods/RazorpayPayment.php

namespace App\Services\PaymentMethods;

use App\Contracts\PaymentInterface;
use Razorpay\Api\Api;
use Exception;

class RazorpayPayment extends BasePayment
{
    protected $api;

    public function __construct()
    {
        $config = config('payments.gateways.razorpay');
        $this->api = new Api($config['key_id'], $config['key_secret']);
    }

    public function pay(float $amount)
    {
        try {
            $order = $this->api->order->create([
                'receipt' => uniqid(),
                'amount' => $amount * 100, // amount in paise
                'currency' => 'INR',
                'payment_capture' => 1 // auto capture
            ]);
            $this->storePaymentDetails(
                $order->id,
                'razorpay',
                $amount,
                'INR',
                'created',
                $order->toArray()
            );
            return $order;
        } catch (Exception $e) {
            throw new Exception("Error Processing Razorpay Payment: " . $e->getMessage());
        }
    }

    public function refund(string $transactionId)
    {
        try {
            $refund = $this->api->payment->fetch($transactionId)->refund();
            $this->storePaymentDetails(
                $transactionId,
                'razorpay',
                $refund->amount / 100,
                'INR',
                'refunded',
                $refund->toArray()
            );
            return $refund;
        } catch (Exception $e) {
            throw new Exception("Error Processing Razorpay Refund: " . $e->getMessage());
        }
    }

    public function getStatus(string $transactionId)
    {
        try {
            $payment = $this->api->payment->fetch($transactionId);
            return $payment->status;
        } catch (Exception $e) {
            throw new Exception("Error Fetching Razorpay Payment Status: " . $e->getMessage());
        }
    }

    public function getPaymentDetails(string $transactionId)
    {
        try {
            $payment = $this->api->payment->fetch($transactionId);
            return $payment;
        } catch (Exception $e) {
            throw new Exception("Error Fetching Razorpay Payment Details: " . $e->getMessage());
        }
    }

    public function preAuthorize(float $amount)
    {
        // Implement pre-authorization logic if supported
        throw new Exception("Razorpay does not support pre-authorization.");
    }

    public function capture(string $authorizationId, float $amount)
    {
        try {
            $payment = $this->api->payment->fetch($authorizationId)->capture(['amount' => $amount * 100]);
            return $payment;
        } catch (Exception $e) {
            throw new Exception("Error Capturing Razorpay Payment: " . $e->getMessage());
        }
    }

    public function void(string $authorizationId)
    {
        // Implement void logic if supported
        throw new Exception("Razorpay does not support voiding a pre-authorization.");
    }

    public function handleRecurring(float $amount, array $options)
    {
        try {
            $plan = $this->api->plan->create([
                'period' => $options['period'],
                'interval' => $options['interval'],
                'item' => [
                    'name' => $options['name'],
                    'amount' => $amount * 100,
                    'currency' => 'INR'
                ]
            ]);

            $subscription = $this->api->subscription->create([
                'plan_id' => $plan->id,
                'customer_notify' => 1,
                'total_count' => $options['total_count']
            ]);

            return $subscription;
        } catch (Exception $e) {
            throw new Exception("Error Creating Razorpay Recurring Payment: " . $e->getMessage());
        }
    }

    public function cancelRecurring(string $subscriptionId)
    {
        try {
            $subscription = $this->api->subscription->fetch($subscriptionId)->cancel();
            return $subscription;
        } catch (Exception $e) {
            throw new Exception("Error Cancelling Razorpay Recurring Payment: " . $e->getMessage());
        }
    }

    public function updateRecurring(string $subscriptionId, array $options)
    {
        try {
            $subscription = $this->api->subscription->fetch($subscriptionId);
            foreach ($options as $key => $value) {
                $subscription->{$key} = $value;
            }
            $subscription->save();

            return $subscription;
        } catch (Exception $e) {
            throw new Exception("Error Updating Razorpay Recurring Payment: " . $e->getMessage());
        }
    }
}


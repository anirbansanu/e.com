<?php

namespace App\Services\PaymentMethods;

use App\Contracts\PaymentInterface;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Refund;
use Stripe\PaymentIntent;

class StripePayment implements PaymentInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function pay(float $amount)
    {
        // Implement Stripe payment logic
    }

    public function refund(string $transactionId)
    {
        // Implement Stripe refund logic
    }

    public function getStatus(string $transactionId)
    {
        // Implement get status logic
    }

    public function getPaymentDetails(string $transactionId)
    {
        // Implement get payment details logic
    }

    public function preAuthorize(float $amount)
    {
        // Implement pre-authorization logic
    }

    public function capture(string $authorizationId, float $amount)
    {
        // Implement capture logic
    }

    public function void(string $authorizationId)
    {
        // Implement void logic
    }

    public function handleRecurring(float $amount, array $options)
    {
        // Implement recurring payment logic
    }

    public function cancelRecurring(string $subscriptionId)
    {
        // Implement cancel recurring payment logic
    }

    public function updateRecurring(string $subscriptionId, array $options)
    {
        // Implement update recurring payment logic
    }
}

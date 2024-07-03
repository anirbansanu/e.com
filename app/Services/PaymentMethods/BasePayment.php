<?php

// app/Services/PaymentMethods/BasePayment.php

namespace App\Services\PaymentMethods;

use App\Contracts\PaymentInterface;
use App\Models\Payment;

abstract class BasePayment implements PaymentInterface
{
    protected function storePaymentDetails($transactionId, $method, $amount, $currency, $status, $response)
    {
        Payment::create([
            'transaction_id' => $transactionId,
            'payment_method' => $method,
            'amount' => $amount,
            'currency' => $currency,
            'status' => $status,
            'response' => json_encode($response),
        ]);
    }
}

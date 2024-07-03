<?php
// config/payment_methods.php

return [
    'methods' => [
        'paypal' => [
            'name' => 'PayPal',
            'class' => App\Services\PaymentMethods\PayPalPayment::class,
        ],
        'stripe' => [
            'name' => 'Stripe',
            'class' => App\Services\PaymentMethods\StripePayment::class,
        ],
        // Add more payment methods as needed
    ],
];

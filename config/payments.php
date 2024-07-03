<?php
// This is configuration file config/payments.php, to manage the settings for all your payment methods.
return [
    'default' => env('PAYMENT_GATEWAY', 'stripe'),

    'gateways' => [
        'paypal' => [
            'name' => 'PayPal',
            'class' => App\Services\PaymentMethods\PayPalPayment::class,
            'client_id' => env('PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYPAL_CLIENT_SECRET'),
            'settings' => [
                'mode' => env('PAYPAL_MODE', 'sandbox'),
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path() . '/logs/paypal.log',
                'log.LogLevel' => 'ERROR'
            ],
        ],

        'stripe' => [
            'name' => 'Stripe',
            'class' => App\Services\PaymentMethods\StripePayment::class,
            'api_key' => env('STRIPE_API_KEY'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        ],
        'razorpay' => [
            'name' => 'Razorpay',
            'class' => App\Services\PaymentMethods\RazorpayPayment::class,
            'key_id' => env('RAZORPAY_KEY_ID'),
            'key_secret' => env('RAZORPAY_KEY_SECRET'),
        ],
        // Add more payment gateways as needed
    ],
];

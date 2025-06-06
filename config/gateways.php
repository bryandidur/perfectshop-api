<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gateway settings
    |--------------------------------------------------------------------------
    |
    | Here you may configure the payment gateway settings.
    |
    */

    'asaas' => [
        'base_url' => env('ASAAS_BASE_URL', 'https://api-sandbox.asaas.com/v3'),
        'api_key' => env('ASAAS_API_KEY'),
    ],

    // 'stripe' => [
    //     'base_url' => env('STRIPE_BASE_URL', 'https://api.stripe.com'),
    //     'api_key' => env('STRIPE_API_KEY'),
    // ],
];

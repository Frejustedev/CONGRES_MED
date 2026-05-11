<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mode de paiement global
    |--------------------------------------------------------------------------
    | mock : aucune intégration externe, auto-confirme (tests locaux)
    | live : appels API réels aux gateways configurés
    */
    'mode' => env('PAYMENT_MODE', 'mock'),

    /*
    |--------------------------------------------------------------------------
    | Gateways
    |--------------------------------------------------------------------------
    */
    'kkiapay' => [
        'public_key' => env('KKIAPAY_PUBLIC_KEY'),
        'private_key' => env('KKIAPAY_PRIVATE_KEY'),
        'secret' => env('KKIAPAY_SECRET'),
        'sandbox' => env('KKIAPAY_SANDBOX', true),
        'api_url' => env('KKIAPAY_SANDBOX', true)
            ? 'https://api-sandbox.kkiapay.me'
            : 'https://api.kkiapay.me',
        'widget_script' => env('KKIAPAY_SANDBOX', true)
            ? 'https://cdn.kkiapay.me/k.js'
            : 'https://cdn.kkiapay.me/k.js',
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Gateways disponibles côté UI
    |--------------------------------------------------------------------------
    */
    'available_gateways' => [
        'kkiapay' => [
            'label' => 'Mobile Money / Carte (UEMOA)',
            'description' => 'MTN Money, Moov Money, Wave, Orange Money + carte Visa/Mastercard',
            'icon' => 'smartphone',
            'enabled' => true,
            'currencies' => ['XOF'],
            'fee_estimate' => '~2,5 %',
        ],
        'stripe' => [
            'label' => 'Carte bancaire (international)',
            'description' => 'Visa, Mastercard, American Express - sécurisé 3D Secure',
            'icon' => 'credit-card',
            'enabled' => true,
            'currencies' => ['EUR', 'USD'],
            'fee_estimate' => '1,4 % + 0,25 €',
        ],
        'cash' => [
            'label' => 'Paiement sur place',
            'description' => "Réglez en espèces ou par chèque à l'accueil du congrès",
            'icon' => 'wallet',
            'enabled' => true,
            'currencies' => ['XOF', 'EUR', 'USD'],
            'fee_estimate' => 'Sans frais',
            'requires_validation' => true,
        ],
    ],
];

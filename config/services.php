<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Service
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'laravelpassport' => [
        'client_id' => '9acd578f-e3c4-4e5e-9556-78909eaa25bf',
        'client_secret' => 'I0e5wBsgOPyTaOmLBoSSlUg0RjjspbpNRt06wppM',
        'redirect' => 'https://codealive.ru/oauth/login/redirect',
        'host' => 'https://id.pautina.top'
    ]

];

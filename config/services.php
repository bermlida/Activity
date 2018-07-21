<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '1300993716649012',
        'client_secret' => '6f3e4abf05b2ce66923dea15d30b3bcf',
        'redirect' => 'http://activity.apps/social-auth/facebook/reply',
    ],

    'google' => [
        'client_id' => '543556594150-5gb2jddp31iudbp7j76pd4l9gei3n8ag.apps.googleusercontent.com',
        'client_secret' => 'CZ6M13XdGwAbZIqgcxOfgJgb',
        'redirect' => 'http://activity.apps/social-auth/google/reply',
    ],

    'mailgun' => [
        'domain' => 'sandbox9ebef659e197489989fb3166ad4f921c.mailgun.org',
        'secret' => 'key-6d2d641fd8d31f248dc2ac809ae138e0',
    ],

    'nexmo' => [
        'key' => '5d5fb54c',
        'secret' => 'a309e33dbc237da1',
        'sms_from' => '15556666666',
    ],
];

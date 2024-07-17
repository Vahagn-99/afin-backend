<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'amocrm' => [
        'client_domain' => env('AMOCRM_CLIENT_DOMAIN', 'afininvest.amocrm.ru'),
        'client_id' => env('AMOCRM_CLIENT_ID', '4443c2e9-0930-4397-972f-62dc4a90b88d'),
        'client_secret' => env('AMOCRM_CLIENT_SECRET', 'ts8LzkQGyUneGhExRmw2QJvLUqe13Uc7LlZnraUrRZ3iKWSOYUYzCfdzM6EkjzKA'),
        'redirect_url' => env('AMOCRM_REDIRECT_URL', 'https://widgets-api.dicitech.com/api/custom/amocrm/callback'),
        'contact_url' => env('AMOCRM_CONTACT_URL', 'https://afininvest.amocrm.ru/contacts/detail/%s'),
    ]

    //https://emerging-pumped-pheasant.ngrok-free.app/amocrm/webhook?client_id=&api_key=lsy50ax4Gb2jG97TV74a9I6Iryof4phI
];

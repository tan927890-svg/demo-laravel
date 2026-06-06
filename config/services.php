<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'groq' => [
        'key' => env('GROQ_API_KEY', ''),
    ],
'payment' => [
    'bank_id'      => env('PAYMENT_BANK_ID',      'MB'),
    'bank_account' => env('PAYMENT_BANK_ACCOUNT',  '0328078853'),
    'bank_name'    => env('PAYMENT_BANK_NAME',     'MB Bank'),
    'bank_owner'   => env('PAYMENT_BANK_OWNER',    'VO MINH TAN'),
    ],

];
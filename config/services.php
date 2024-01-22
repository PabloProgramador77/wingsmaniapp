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

    'firebase' => [

        'api_key' => "AIzaSyCfwO2i_u_kUhFfOS_HSWQI-RYsTf5Ny9k",
        'auth_domain' => "fcmlaravel-c8f4b.firebaseapp.com",
        'project_id' => "fcmlaravel-c8f4b",
        'storage_bucket' => "fcmlaravel-c8f4b.appspot.com",
        'messaging_sender_id' => "808595646536",
        'app_id' => "1:808595646536:web:c4baa60eaf4ccb8d0f507d",
        'measurement_id' => "G-H9V41V6KQF",

    ],

];

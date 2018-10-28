<?php

return [
    'config' => [
        'app_id' => env('FACEBOOK_APP_ID', null),
        'app_secret' => env('FACEBOOK_APP_SECRET', null),
        'persistent_data_handler'=>'session'
    ],
];
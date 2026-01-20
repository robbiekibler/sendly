<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sendly API Key
    |--------------------------------------------------------------------------
    |
    | Your Sendly API key. You can find this in your Sendly dashboard
    | under Settings > API Keys.
    |
    */
    'key' => env('SENDLY_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Default From Number
    |--------------------------------------------------------------------------
    |
    | The default phone number to send messages from. This can be overridden
    | on a per-message basis using the from() method.
    |
    */
    'from' => env('SENDLY_FROM_NUMBER'),
];

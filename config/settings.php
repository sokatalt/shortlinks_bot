<?php

return [
    /**
     * The ID of the bot admin
     *
     * To provide some additional functionality
     * only for the admin
     */
    'admin_id' => env('ADMIN_USER_ID'),

    /**
     * Default Destination form URL
     *
     */
    'default_destination' => env('DEFAULT_FORM_URL'),

    /**
     * Duration to wait in the loading page before redirection
     *
     */
    'loading_duration' => env('LOADING_DURATION'),
    'loading_duration2' => env('LOADING_DURATION2'),

    /**
     * Open Weather Map Token
     */
    'open_weather_map_token' => env('OPEN_WEATHER_MAP_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Default URLs
    |--------------------------------------------------------------------------
    |
    | Here you can override the default application base URL used to generate
    | the default short URL (default_short_url). To use your application's
    | "app.url" config value, set this field to null.
    |
    */
    'domains' => [
        env('APP_DOMAIN_1'),
        env('APP_DOMAIN_2', null),
        env('APP_DOMAIN_3', null),
    ],
    'langs'=>[
        // "xml file name" => languge name
        "arabic" => "العربيه",
        "english" => "english",
    ],
    'BotRedirectUrl' => env('BotRedirectUrl'),
    'Traffic_SourceID' => env('Traffic_SourceID'),
    'Binom_url' => env('Binom_url'),
    'Binom_url2' => env('Binom_url2'),
    'Binom_apiKey' => env('Binom_apiKey'),
    'default_destination' => env('Main_Destination'),
    'disable_destination' => env('Disable_destination'),
    'disable_user_destination' => env('Disable_user_destination'),
];

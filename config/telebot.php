<?php


return [
    /*-------------------------------------------------------------------------
    | Default Bot Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the bots you wish to use as
    | your default bot for regular use.
    |
    */

    'default' => 'bot',

    /*-------------------------------------------------------------------------
    | Your Telegram Bots
    |--------------------------------------------------------------------------
    | You may use multiple bots. Each bot that you own should be configured here.
    |
    | See the docs for parameters specification:
    | https://westacks.github.io/telebot/#/configuration
    |
    */

    'bots' => [
        'bot' => [
            'token'      => env('TELEGRAM_BOT_TOKEN'),
            'name'       => env('TELEGRAM_BOT_NAME', null),
            'api_url'    => env('TELEGRAM_API_URL', 'https://api.telegram.org/bot{TOKEN}/{METHOD}'),
            'exceptions' => true,
            'async'      => false,

            'webhook' => [
                'url'               => env('TELEGRAM_BOT_WEBHOOK_URL', env('APP_URL').'/telebot/webhook/bot/'.env('TELEGRAM_BOT_TOKEN')),
                // 'certificate'       => env('TELEGRAM_BOT_CERT_PATH', storage_path('app/ssl/public.pem')),
                // 'ip_address'        => '8.8.8.8',
                // 'max_connections'   => 40,
                // 'allowed_updates'   => ["message", "edited_channel_post", "callback_query"],
                // 'secret_token'      => env('TELEGRAM_KEY', null),
            ],

            'poll' => [
                // 'limit'             => 100,
                // 'timeout'           => 0,
                // 'allowed_updates'   => ["message", "edited_channel_post", "callback_query"]
            ],

            'handlers' => [
                \App\Services\Telegram\Base\BaseCommands::class,
                \App\Services\Telegram\Commands\StartCommand::class,
                \App\Services\Telegram\Commands\SubscribeCommand::class,
                \App\Services\Telegram\Commands\Admin\CheckKey::class,
                \App\Services\Telegram\Commands\ValidateCommand::class,
                \App\Services\Telegram\Commands\Admin\GenerateSubKey::class,
                \App\Services\Telegram\Handler\CallbackHandler::class,
                \App\Services\Telegram\RequestsInput\validateKeyInput::class,
                \App\Services\Telegram\Commands\shortLinks\generateForm::class,
                \App\Services\Telegram\Commands\shortLinks\showMyLeads::class,
                \App\Services\Telegram\Commands\shortLinks\showReports::class,
                \App\Services\Telegram\Commands\Admin\disableUser::class,
                \App\Services\Telegram\Commands\Admin\enableUser::class,
                \App\Services\Telegram\Commands\Admin\giveApprove::class,
                \App\Services\Telegram\Commands\Admin\rejectApprove::class,
                \App\Services\Telegram\Commands\Admin\showAllUsers::class,
                \App\Services\Telegram\Commands\Admin\showWaitingUsers::class,
            ],
        ],

        // 'second_bot' => [
        //     'token'         => env('TELEGRAM_BOT2_TOKEN', '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11'),
        // ],
    ],
];

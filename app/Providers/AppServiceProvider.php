<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('WeStacks\TeleBot\Handlers\RequestInputHandler', 'App\Helpers\RequestInputHandler');
        $loader->alias('AshAllenDesign\ShortURL\Classes\Builder', 'App\Helpers\Builder');
        $loader->alias('AshAllenDesign\ShortURL\Classes\KeyGenerator;', 'App\Helpers\KeyGenerator');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

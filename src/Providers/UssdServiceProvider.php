<?php

declare(strict_types=1);

namespace Aguva\Ussd\Providers;

use Illuminate\Support\ServiceProvider;

class UssdServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ussd-views');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config/ussd.php', 'ussd');
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath(),
        ], 'aguva-ussd-lang');
    }
}
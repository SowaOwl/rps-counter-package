<?php

namespace Amanat\RpsCounter;

use Illuminate\Support\ServiceProvider;
use Amanat\RpsCounter\Http\Middleware\RpsCounterMiddleware;

class RpsCounterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Публикация конфигурации
        $this->publishes([
            __DIR__.'/../config/rps-counter.php' => config_path('rps-counter.php'),
        ], 'rps-counter-config');

        // Публикация миграций
        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations'),
        ], 'rps-counter-migrations');

        // Загрузка миграций
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Регистрация middleware
        $this->app['router']->aliasMiddleware('rps.counter', RpsCounterMiddleware::class);
    }

    public function register()
    {
        // Слияние конфигурации
        $this->mergeConfigFrom(__DIR__.'/../config/rps-counter.php', 'rps-counter');

        // Регистрация RedisRepository
        $this->app->singleton(\Amanat\RpsCounter\Repositories\RedisRepository::class, function () {
            return new \Amanat\RpsCounter\Repositories\RedisRepository();
        });
    }
}
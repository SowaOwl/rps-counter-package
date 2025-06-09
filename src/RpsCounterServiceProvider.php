<?php

namespace Amanat\RpsCounter;

use Amanat\RpsCounter\Repositories\RedisRepository;
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
            __DIR__.'/../migrations/create_rps_counts_table.php' => database_path('migrations/'.now()->format('Y_m_d_His').'_create_rps_counts_table.php'),
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
        $this->app->singleton(RedisRepository::class, function ($app) {
            return new RedisRepository($app['redis']->connection());
        });
    }
}
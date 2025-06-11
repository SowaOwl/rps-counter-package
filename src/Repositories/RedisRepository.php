<?php

declare(strict_types=1);

namespace Amanat\RpsCounter\Repositories;

use Predis\Client;
use Throwable;

final class RedisRepository
{
    /** @var Client */
    private $redis;

    public function __construct()
    {
        $parameters = [
            'url' => config('database.redis.default.url'),
            'host' => config('database.redis.default.host', 'redis'),
            'password' => config('database.redis.default.password'),
            'port' => config('database.redis.default.port', '6379'),
            'database' => config('database.redis.default.database', '0'),
        ];
        $options = [
            'cluster' => config('database.redis.options.cluster'),
            'prefix' => config('rps-counter.redis_prefix'),
        ];

        $this->redis = new Client($parameters, $options);
    }

    public function getRpsCountSwitch(): bool
    {
        try {
            $response = $this->redis->get(config('rps-counter.redis_key'));

            if (empty($response)) {
                return false;
            }

            return boolval(json_decode(json_decode($response)->setting)->value);
        } catch (Throwable $ex) {
            return false;
        }
    }
}

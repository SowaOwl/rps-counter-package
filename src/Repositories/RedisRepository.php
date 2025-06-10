<?php

declare(strict_types=1);

namespace Amanat\RpsCounter\Repositories;

use Illuminate\Redis\Connections\Connection;
use Throwable;

final class RedisRepository
{
    private $redis;

    public function __construct(
        Connection $redis
    ) {
        $this->redis = $redis;
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

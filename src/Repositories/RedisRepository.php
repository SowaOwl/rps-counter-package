<?php

declare(strict_types=1);

namespace Amanat\RpsCounter\Repositories\Api;

use Illuminate\Redis\Connections\Connection;

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
        $response = $this->redis->get(config('rps-counter.redis_key'));

        return boolval(json_decode(json_decode($response)->setting)->value);
    }
}

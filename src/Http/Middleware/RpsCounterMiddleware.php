<?php

declare(strict_types=1);

namespace Amanat\RpsCounter\Http\Middleware;

use Amanat\RpsCounter\Models\RpsCount;
use Amanat\RpsCounter\Repositories\RedisRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RpsCounterMiddleware
{
    private $redisRepository;

    public function __construct(
        RedisRepository $redisRepository
    ) {
        $this->redisRepository = $redisRepository;
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->redisRepository->getRpsCountSwitch()) {
            return $next($request);
        }

        $body = [
            'url'  => $request->url(),
            'ip'   => $request->ip(),
            'type' => $request->method(),
        ];

        $rpsCount = RpsCount::create($body);

        $startTime = microtime(true);

        $response = $next($request);

        $endTime = microtime(true);

        $rpsCount->speed = round(($endTime - $startTime) * 1000, 2);
        $rpsCount->status_code = $response->getStatusCode();
        $rpsCount->save();

        return $response;
    }
}
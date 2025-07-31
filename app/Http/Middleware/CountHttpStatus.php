<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\MetricsController;

class CountHttpStatus
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $status = $response->getStatusCode();

        MetricsController::incCounter("http_responses_total_{$status}");

        $range = floor($status / 100) . "xx";
        MetricsController::incCounter("http_responses_total_{$range}");

        return $response;
    }
}

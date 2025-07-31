<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class MetricsController extends Controller
{
    public static function incCounter(string $name)
    {
        Cache::store('redis')->increment($name);
    }

    public function index()
    {
        // Métricas básicas
        $homeCount = Cache::store('redis')->get('home_requests_total', 0);
        $loginCount = Cache::store('redis')->get('login_requests_total', 0);

        // Faixas HTTP
        $status_codes = ['2xx', '3xx', '4xx', '5xx'];
        $httpMetrics = [];

        foreach ($status_codes as $code) {
            $count = Cache::store('redis')->get("http_responses_total_{$code}", 0);

            $httpMetrics[] = implode("\n", [
                '# HELP http_responses_total Número total de respostas HTTP por faixa de status',
                '# TYPE http_responses_total counter',
                "http_responses_total{code=\"$code\"} $count",
            ]);
        }

        $contentParts = [
            implode("\n", [
                '# HELP home_requests_total Número total de acessos à home',
                '# TYPE home_requests_total counter',
                "home_requests_total $homeCount",
            ]),
            implode("\n", [
                '# HELP login_requests_total Número total de acessos à login',
                '# TYPE login_requests_total counter',
                "login_requests_total $loginCount",
            ]),
            implode("\n", $httpMetrics),
        ];

        $content = implode("\n", $contentParts);

        return response($content, 200)->header('Content-Type', 'text/plain; version=0.0.4');
    }
}

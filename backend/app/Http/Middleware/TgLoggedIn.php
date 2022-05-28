<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Tg\TgApi;

class TgLoggedIn
{
    /**
     * Обработка входящего запроса.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tgApi = app(TgApi::class);

        if (!$tgApi->isLoggedIn())
        {
            throw new \Exception('Telegram не подключён');
        }
        return $next($request);
    }
}

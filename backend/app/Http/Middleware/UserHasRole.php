<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserHasRole
{
    /**
     * Обработка входящего запроса.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $userRoleName = Auth::check() ? Auth::user()->role->name : null;

        if ($userRoleName !== $role)
        {
            throw new AccessDeniedHttpException();
        }
        return $next($request);
    }
}

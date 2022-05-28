<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * unauthenticated
     *
     * @param  mixed $request
     * @param  array $guards
     * @return response
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException();
    }
}

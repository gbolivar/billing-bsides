<?php

namespace App\Http\Middleware;

use Closure;

use App\Services\Hash\GenerateTdxIdServices;
use Kris\LaravelFormBuilder\Filters\Collection\Uppercase;

class ChangePassTextToShaMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $passwd = $request->input('password');
        $request['password'] = hash('sha256', $passwd);
        return $next($request);
    }
}
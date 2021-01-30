<?php

namespace App\Http\Middleware;

use Closure;

use App\Services\Hash\GenerateTdxIdServices;
use Kris\LaravelFormBuilder\Filters\Collection\Uppercase;

class CreateTDXMiddleware
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
        // TDX-Id add cache
        $tdx = GenerateTdxIdServices::getInstance()->main();
        \Cache::put('TDX', $tdx);
        return $next($request);
    }
}
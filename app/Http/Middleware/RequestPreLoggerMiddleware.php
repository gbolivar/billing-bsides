<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Logger\LoggerEventsServices;
/**
 * Register Audit 
 */
class RequestPreLoggerMiddleware
{
    protected $auditLogger;

    public function __construct(LoggerEventsServices $auditLogger)
    {
        $this->auditLogger = $auditLogger;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        ($this->auditLogger)('notice', __METHOD__, ['Request'=>['Path'=>$request->path(), 'Request' => $request->all()??'--']]);
        return $next($request);
    }
}

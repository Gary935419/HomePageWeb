<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class ApplicatiionLog
{
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $array = [
            'params' => $request->all(),
            'header' => $request->header(),
            'method' => $request->method(),
        ];
        Log::info('Uri:' . $request->path(), $array);
        return $next($request);
    }
}

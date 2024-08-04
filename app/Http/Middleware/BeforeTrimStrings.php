<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BeforeTrimStrings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        if ($input) {
            array_walk_recursive($input, function (&$item, $key) {
                if ((is_numeric(trim($item)) || preg_match("/^[0-9]{4}(\-|\/)[0-9]{1,2}(\\1)[0-9]{1,2}(|\s+[0-9]{1,2}(|:[0-9]{1,2}(|:[0-9]{1,2})))$/",trim($item))) && !str_contains(strtolower($key), 'password')) {
                    $item = trim($item);
                }
            });
            $request->merge($input);
        }
        return $next($request);
    }
}

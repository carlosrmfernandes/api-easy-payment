<?php

namespace App\Http\Middleware;

use Closure;

class BlockRoute
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
        return response()->json(['data' => 'blocked route']);
        // return $next($request);
    }
}

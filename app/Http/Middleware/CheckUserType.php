<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserType
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
        if(!auth()->user()){
            return response()->json(['data' => 'user not found']);
        }
        if (auth()->user()->user_type_id == 2) {
            return response()->json(['data' => 'this user is not allowed to transfer money']);
        }

        return $next($request);
    }

}

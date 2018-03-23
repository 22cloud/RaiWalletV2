<?php

namespace App\Http\Middleware;

use Closure;

class CallbackFilter
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
        if(env('CALLBACK_KEY') !== false)
            if(env('CALLBACK_KEY') != $request->route('callback_key'))
                return response()->json(['Unauthorized!'],400);
        if(!in_array($request->ip(), explode('|', env('CALLBACK_ALLOWED_IPS'))))
            return response()->json(['Unauthorized!'],400);
        return $next($request);
    }
}
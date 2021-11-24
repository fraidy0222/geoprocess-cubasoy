<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Support\Facades\Auth;

class CheckIsAdmin
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
        if(Auth::user()->role->name === 'Administrator') {
           return $next($request);
        }
        else {
            return response()->json(['error' => 'No tienes los permisos necesarios'], 403);
        }
    }
}

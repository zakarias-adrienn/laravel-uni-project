<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
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
        if(Auth::guest() || Auth::user()->is_admin == '0') // is a user or a guest
        {
            return $next($request); // pass the user, guest
        }

        return redirect('/'); // not user, redirect
    }
}

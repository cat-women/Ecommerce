<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class User
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
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        //role 1 == admin 

        if (Auth::user()->role == 1) {
            return redirect()->route('dashbord');
        }
        //role 2 == user 
        if (Auth::user()->role == 2) {
            return $next($request);
        }
    }
}

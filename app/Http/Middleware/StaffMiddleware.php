<?php

namespace App\Http\Middleware;

use \App;
use \Auth;

use Closure;

class StaffMiddleware
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
        if (Auth::check() && Auth::user()->isStaff()) {
            return $next($request);
        }
        else {
            return App::abort(401);
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

use \Auth;
use \Config;
use \Session;

class LocaleMiddleware
{
    /**
     * Detect any locale change and apply it to
     * Laravel in every incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {        
        if (Session::has('newLocale')) {
            $userCustomLocale = Session::pull('newLocale');
            app()->setLocale($userCustomLocale);
        }
        
        return $next($request);
    }
}

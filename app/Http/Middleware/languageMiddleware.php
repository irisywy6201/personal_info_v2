<?php

namespace App\Http\Middleware;

use \App;
use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class languageMiddleware
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

	if($request->session()->has('locale')){
		$locale=$request->session()->get('locale');		

		if($locale=='en'){
			App::setLocale('en');
		}
		else if($locale=='zh_TW'){
			App::setLocale('zh_TW');
		}
	}

        return $next($request);
    }
}

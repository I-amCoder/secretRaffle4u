<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class Sessioncurrency
{
    public function handle($request, Closure $next)
    {
		if(!Session::get('currency')){
			session()->put('currency', 'THB');
			session()->put('currency_symbol', '฿');
		}
        return $next($request);
    }
}

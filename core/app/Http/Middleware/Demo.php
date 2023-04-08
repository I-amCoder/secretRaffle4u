<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class Demo
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
		if(!Session::get('currency')){
			session()->put('currency', 'THB');
			session()->put('currency_symbol', '฿');
		}
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE')){
            $notify[] = ['error', 'This is demo version.  You can not change any thing'];
            return back()->withNotify($notify);

        }
        return $next($request);
    }
}

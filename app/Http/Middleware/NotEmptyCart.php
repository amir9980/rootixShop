<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotEmptyCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (count($request->user()->cart) < 1) {
            return redirect()->route('home')->withErrors(['شما محصولی برای خرید انتخاب نکرده اید!']);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ThemeMiddleware
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
        if(session()->has('theme')) {
            // if defined in the session, we'll use it
            $theme = session()->get('theme');
        } else {
            $theme = config('app.theme');
        }

        // we save it in the session, and change the app status.
        session()->put('theme', $theme);
        
        return $next($request);
    }
}

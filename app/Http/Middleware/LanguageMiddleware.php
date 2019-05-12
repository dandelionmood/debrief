<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LanguageMiddleware
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
        if(session()->has('locale')) {
            // if defined in the session, we'll use it
            $locale = session()->get('locale');
        } else {
            // we try to read locale from request (header)
            $locale = $request->getPreferredLanguage(
                config('app.available_locales')
            );
            // last we resort to the app default locale
            if( !$locale ) {
                $locale = config('app.locale');
            }
        }

        // we save it in the session, and change the app status.
        session()->put('locale', $locale);
        app()->setLocale($locale);
        setlocale(LC_TIME, $locale.'_'.strtoupper($locale).'.utf8');
        
        return $next($request);
    }
}

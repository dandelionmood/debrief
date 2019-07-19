<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     *  Allow for locale switching.
     *  @param  string $locale Locale requested by user via the dashboard
     * @return \Illuminate\Http\Response
     */
    public function changeLocale($locale, Request $request)
    {
        $callback = $request->get('callback');

        if( in_array($locale, config('app.available_locales')) ) {
            session()->put('locale', $locale);
            // we want the following message to be already in the right language
            app()->setLocale($locale);
            $message = __('The language has been successfully changed.');
            if( $callback ) { // if there's a callback, we point back.
                return redirect($callback)
                    ->with('success', $message);
            }
            else { // default redirection 
                return redirect()
                    ->route('home')
                    ->with('success', $message);
            }
        }
        else {
            return redirect()
                ->route('home')
                ->with('error', __('This language is not yet supported.'));
        }
    }

    /**
     *  Allow for theme switching.
     *  @param  string $theme Theme requested by user via the dashboard
     * @return \Illuminate\Http\Response
     */
    public function changeTheme($theme, Request $request) 
    {
        $callback = $request->get('callback');

        if( in_array($theme, array_keys(config('app.available_themes'))) ) {
            session()->put('theme', $theme);
            
            $message = __('The theme has been successfully changed.');
            if( $callback ) { // if there's a callback, we point back.
                return redirect($callback)
                    ->with('success', $message);
            }
            else { // default redirection 
                return redirect()
                    ->route('home')
                    ->with('success', $message);
            }
        }
        else {
            return redirect()
                ->route('home')
                ->with('error', __('This theme does not exist.'));
        }
    }
}
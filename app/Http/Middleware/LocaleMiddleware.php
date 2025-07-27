<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check for language in URL parameter
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            if (in_array($locale, ['lat', 'cir'])) {
                Session::put('app_locale', $locale);
                App::setLocale($locale);
            }
        } 
        // Check session
        elseif (Session::has('app_locale')) {
            App::setLocale(Session::get('app_locale'));
        }
        // Default to latin
        else {
            Session::put('app_locale', 'lat');
            App::setLocale('lat');
        }

        return $next($request);
    }
}
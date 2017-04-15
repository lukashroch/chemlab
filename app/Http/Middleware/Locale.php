<?php

namespace ChemLab\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Locale
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('locale')) {
            $lang = Session::get('locale');
        } else {
            $lang = Auth::check() ? Auth::user()->getOptions('lang') : 'en';
            Session::put('locale', $lang);
        }

        if (app()->getLocale() != $lang) {
            app()->setLocale($lang);
            setlocale(LC_TIME, $lang);
        }

        return $next($request);
    }
}
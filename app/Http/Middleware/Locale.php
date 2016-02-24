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
        $lang = Auth::check() ? Auth::user()->lang : 'en';

        if (!Session::has('locale') || Session::get('locale') != $lang)
            Session::put('locale', $lang);

        app()->setLocale($lang);
        setlocale(LC_TIME, $lang);

        return $next($request);
    }
}
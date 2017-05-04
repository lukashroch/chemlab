<?php

namespace ChemLab\Http\Middleware;

use Closure;

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
        $session = session();

        if (!$session->has('locale')) {
            $lang = $session->get('locale');
        } else {
            $lang = auth()->check() ? auth()->user()->getOptions('lang') : 'en';
            $session->put('locale', $lang);
        }

        if (app()->getLocale() != $lang) {
            app()->setLocale($lang);
            setlocale(LC_TIME, $lang);
        }

        return $next($request);
    }
}
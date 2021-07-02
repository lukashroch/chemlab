<?php

namespace ChemLab\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $session = session();

        if ($session->has('locale')) {
            $lang = $session->get('locale');
        } else if (auth()->check()) {
            $lang = auth()->user()->getSettings('lang');
        } else {
            $header = explode(",", request()->header('accept-language'))[0];
            $lang = Str::before(Str::contains($header, ';') ? explode(";", $header)[0] : $header, '-');
        }

        $lang = in_array($lang, config('app.available_locale')) ? $lang : config('app.fallback_locale');
        $session->put('locale', $lang);

        if (app()->getLocale() != $lang) {
            app()->setLocale($lang);
            setlocale(LC_TIME, $lang);
        }

        Carbon::setLocale(app()->getLocale());

        return $next($request);
    }
}

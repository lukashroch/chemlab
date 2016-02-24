<?php

namespace ChemLab\Http\Middleware;

use Closure;

class Ajax
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }
        abort(404);
    }
}
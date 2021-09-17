<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
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
        $locale = ($request->hasHeader('app_locale')) ? $request->header('app_locale') : config('app.fallback_locale');
        App::setLocale($locale);

        return $next($request);
    }
}

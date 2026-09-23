<?php

namespace App\Http\Middleware;

use Closure;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = \Session::get('locale');

        if (!is_string($locale) || !in_array($locale, ['en', 'si', 'ar'])) {
            $locale = config('app.locale');
        }

        \App::setLocale($locale);

        return $next($request);
    }
}
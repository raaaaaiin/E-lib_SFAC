<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Session;

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
        $def_locale = Config::get('app.locale');
        if ($request->hasCookie("locale")) {
            $def_locale = $request->cookie('locale');
        }
        App::setLocale($def_locale);
        return $next($request);
    }
}

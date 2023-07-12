<?php

namespace App\Http\Middleware;

use App\Facades\Util;
use App\Models\VisitorTracking;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isInstanceOf;

class TraficTracker
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax()) {
            // Not logging in ajax request
            return $next($request);
        }
        if (!config('app.installed')) {
            return $next($request);
        }
        //if(!Util::checkIfSystemInstalled()){return $next($request);}
        $vs = new VisitorTracking();
        try {
            $vs->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER["HTTP_USER_AGENT"] : "Bot";
            if (Str::of($vs->user_agent)->contains("Bot")) {
                // Ignoring the bots from logging
                return $next($request);
            }
            $vs->refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER["HTTP_REFERER"] : "Direct";
            $vs->ip_address = $request->ip();
            $vs->path = isset($_SERVER['REQUEST_URI']) ? $_SERVER["REQUEST_URI"] : "N/A";
            if (Cookie::has('last_url') && Cookie::get('last_url') == $vs->path) {
                // Ignoring if same url is refreshed
                return $next($request);
            }
            if (Str::contains($vs->path, ["tracker", ".jpeg", ".css", ".jpg", ".js", ".png", "debugbar"])) {
                return $next($request);
            }
            $vs->username = "Visitor";
        } catch (\Exception $e) {
        }
        $response = $next($request);
        if (Auth::user()) {
            $vs->username = Auth::user()->email;
        }
        $vs->save();
        if ($response instanceof \Response) {
            return $response->withCookie(cookie()->forever('last_url', $vs->path));
        } else {
            return $response;
        }
    }
}

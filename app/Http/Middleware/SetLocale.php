<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $segment = $request->segment(1);

        if (in_array($segment, ['fa', 'en'])) {
            $locale = $segment;
            session(['locale' => $locale]);
        } else {
            $locale = session('locale', config('app.locale', 'fa'));
        }

        App::setLocale($locale);

        return $next($request);
    }
}

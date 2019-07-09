<?php

namespace App\Http\Middleware;

use Closure;

class CheckSessionExisted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$sessions)
    {
        foreach ($sessions as $session) {
            if (!($request->session()->has($session))) {
                return redirect('/403');
            }
        }

        return $next($request);
    }
}

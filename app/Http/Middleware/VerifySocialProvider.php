<?php

namespace App\Http\Middleware;

use Closure;

class VerifySocialProvider
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
        $social_provider = $request->route('social_provider');

        if (is_null(config('services.' . $social_provider))) {
            return redirect('/error');
        }

        return $next($request);
    }
}

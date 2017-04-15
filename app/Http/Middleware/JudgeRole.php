<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class JudgeRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::user()->role_id != $role) {
            return redirect('/error');
        }

        return $next($request);
    }
}

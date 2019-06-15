<?php

namespace App\Http\Middleware\ExistResource;

use Auth;
use Closure;

class OrganiseActivity
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
        $activity = $request->route('activity');

        $organizer = Auth::user()->profile;
        
        if (is_null($organizer->activities()->find($activity))) {
            return redirect('/404');
        }
        
        return $next($request);
    }
}

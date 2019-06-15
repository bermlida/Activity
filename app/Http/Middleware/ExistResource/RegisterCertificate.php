<?php

namespace App\Http\Middleware\ExistResource;

use Auth;
use Closure;

class RegisterCertificate
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
        
        $certificate = $request->route('certificate');

        $organizer = Auth::user()->profile;

        $organise_activity = $organizer->activities()->find($activity);

        if (is_null($organise_activity->orders()->where('serial_number', $certificate)->first())) {
            return redirect('/404');
        }

        return $next($request);
    }
}

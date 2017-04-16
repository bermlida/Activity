<?php

namespace App\Http\Middleware\ExistResource;

use Auth;
use Closure;

class ParticipateRecord
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
        $serial_number = $request->route('record');

        $user = Auth::user()->profile;
            
        if (is_null($user->orders()->where('serial_number', $serial_number)->first())) {
            return redirect('/error');
        }

        return $next($request);
    }
}

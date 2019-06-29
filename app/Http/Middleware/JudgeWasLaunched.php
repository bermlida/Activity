<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Activity;

class JudgeWasLaunched
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
        $activity = Activity::find($request->route('activity'));

        if ($activity->status != 1) {
            return redirect('/403');
        }

        return $next($request);
    }
}

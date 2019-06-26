<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

use App\Models\Activity;

class DuringApplyPeriod
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

        if (!(Carbon::now()->between($activity->apply_start_time, $activity->apply_end_time))) {
            return redirect('/403');
        }

        return $next($request);
    }
}

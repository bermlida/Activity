<?php

namespace App\Http\Middleware\ExistResource;

use Closure;

use App\Models\Activity as ActivityModel;

class Activity
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
        
        if (is_null(ActivityModel::find($activity))) {
            return redirect('/404');
        }

        return $next($request);
    }
}

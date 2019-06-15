<?php

namespace App\Http\Middleware\ExistResource;

use Closure;

use App\Models\Log as LogModel;

class Log
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
        $log = $request->route('log');
        
        if (is_null(LogModel::find($log))) {
            return redirect('/404');
        }

        return $next($request);
    }
}

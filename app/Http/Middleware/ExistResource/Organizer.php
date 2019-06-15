<?php

namespace App\Http\Middleware\ExistResource;

use Closure;

use App\Models\Organizer as OrganizerModel;

class Organizer
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
        $organizer = $request->route('organizer');

        if (is_null(OrganizerModel::find($organizer))) {
            return redirect('/404');
        }

        return $next($request);
    }
}

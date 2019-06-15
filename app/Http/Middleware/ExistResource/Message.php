<?php

namespace App\Http\Middleware\ExistResource;

use Closure;

use App\Models\Message as MessageModel;

class Message
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
        $message = $request->route('message');
        
        if (is_null(MessageModel::find($message))) {
            return redirect('/404');
        }

        return $next($request);
    }
}

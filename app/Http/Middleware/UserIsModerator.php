<?php

namespace App\Http\Middleware;

use Closure;

class UserIsModerator {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->isModerator()) {
            return $next($request);
        }
        abort(403, trans('site.no_permission'));
    }
}

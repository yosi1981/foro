<?php

namespace App\Http\Middleware\Moderation;

use Closure;

class BanUserMiddleware {

    /**
     * Check if the mod can ban users...
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->can('moderate-ban-user') && $request->user()->isModerator()) {
            return $next($request);
        }
        return abort(403);
    }
}

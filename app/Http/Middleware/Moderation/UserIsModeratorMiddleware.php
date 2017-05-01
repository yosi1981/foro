<?php

namespace App\Http\Middleware\Moderation;

use Closure;

class UserIsModeratorMiddleware {

    /**
     * Check if user is moderator
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
        abort(403);
    }
}

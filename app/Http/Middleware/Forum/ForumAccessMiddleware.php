<?php

namespace App\Http\Middleware\Forum;

use Auth;
use Closure;

class ForumAccessMiddleware {

    /**
     * Determine if user can access forum
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // If forum is not enabled but user is not an admin so they cannot view it anyway, abort
        if (!site('forum-enable')) {
            // If user is guest, exit
            if (auth()->guest()) {
                abort(403, trans('forum.not_enabled'));
            }
            // If user cannot access forum when disabled, exit
            if (user()->cannot('forum-access-when-disabled')) {
                abort(403, trans('forum.not_enabled'));
            }
        }

        // If user is guest and can access
        if (auth()->guest() && !site('forum-guests-can-access')) {
            abort(403, trans('forum.no_access'));
        }

        // If user cannot access form, abort
        if (user() && user()->cannot('forum-access')) {
            abort(403, trans('forum.no_access'));
        }

        return $next($request);
    }
}

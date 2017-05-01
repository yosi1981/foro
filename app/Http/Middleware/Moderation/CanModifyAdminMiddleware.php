<?php

namespace App\Http\Middleware\Moderation;

use Closure;

class CanModifyAdminMiddleware {

    /**
     * If user is admin, no one can modify the user unless the user is itself or admin
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->route('user');
        // If the requested user is an admin and the logged in user is not, don't let them go through.
        if ($user->isAdmin() && !$request->user()->isAdmin()) {
          if (request()->ajax()) {
                return response()->json(['error' => trans('user.cannot_modify')]);
            }
            abort(403, trans('user.cannot_modify'));
        }
        return $next($request);
    }
}

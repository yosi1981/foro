<?php

namespace App\Http\Middleware;

use Closure;

class UserIsAdminMiddleware
{
    /**
     * Check if user is an admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->isAdmin()) {
            return $next($request);
        }
        abort(403);
    }
}

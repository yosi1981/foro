<?php

namespace App\Http\Middleware\Admin;

use Closure;

class CanModifyPermissionMiddleware
{
    /**
     * If permission is system required, cannot modify that permission
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route('permission')->system_required) {
            flash()->error(trans('admin.permission.cannot_modify'));
            return redirect(route('admin.role.permission.index'));
        }
        return $next($request);
    }
}

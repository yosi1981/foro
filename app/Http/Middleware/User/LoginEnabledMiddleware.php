<?php

namespace App\Http\Middleware\User;

use Closure;

class LoginEnabledMiddleware {

    /**
     * Ensure that login has been enabled
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!site('enable-login')) {
            if ($request->ajax()) {
                return response(['error' => trans('user.login.disabled')]);
            }
            flash()->error(trans('user.login.disabled'));
            return redirect(url('/'));
        }
        return $next($request);
    }
}

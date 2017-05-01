<?php

namespace App\Http\Middleware\User;

use Closure;

class RegistrationEnabledMiddleware
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
        if (!site('enable-registration')) {
            if ($request->ajax()) {
                return response(['error' => trans('user.register.disabled')]);
            }
            flash()->error(trans('user.register.disabled'));
            return redirect(url('/'));
        }
        return $next($request);
    }
}

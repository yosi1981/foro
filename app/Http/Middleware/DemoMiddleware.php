<?php

namespace App\Http\Middleware;

use Closure;

class DemoMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $demo = true;
        $message = 'You cannot do that in this demo, sorry!';
        if ($demo) {
            if ($request->ajax()) {
                return response()->json(['error' => $message]);
            }
            abort(403, $message);
        }
        return $next($request);
    }
}

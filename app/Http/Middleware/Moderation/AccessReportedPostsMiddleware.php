<?php
/**
 * Created by Laracoderr.
 * Copyright 2016 - Laracoderr, All Rights Reserved
 * Licensed under CodeCanyon Standard Licenses
 * http://procoderr.tech
 */

namespace App\Http\Middleware\Moderation;

use Closure;

class AccessReportedPostsMiddleware {

    /**
     * If a mod can access the reported posts in moderation panel
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->can('forum-moderate-reported-post')) {
            return $next($request);
        }
        abort(403);
    }
}

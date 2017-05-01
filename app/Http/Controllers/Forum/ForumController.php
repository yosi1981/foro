<?php

namespace App\Http\Controllers\Forum;

use App\Forum\Forum;
use App\Http\Requests;
use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumController extends Controller {

    /**
     * The forum homepage.
     * Displays all available forums/subforums as well as threads.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $forum_id = $request->input('forum');
        if (!isset($forum_id)) {
            $forums = \App\Core\Cache::grab('forums');
            return view('forum.categories', compact('forums'));
        }

        $forum = Forum::where('id', $forum_id)->with('threads')->firstOrFail();

        $threads = $forum->latestThreads();
        return view('forum.index', compact('forum', 'threads'));
    }

}

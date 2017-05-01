<?php

namespace App\Http\Controllers\Admin;

use App\Core\Cache;
use App\Events\Admin\Forum\ForumWasDeleted;
use App\Events\Forum\ThreadWasJunked;
use App\Events\Forum\ThreadWasRestored;
use App\Exceptions\ForumDoesNotExistException;
use App\Forum\Forum;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ForumController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->middleware('demo', ['only' => ['destroy', 'deleteThreads', 'store']]);
    }


    /**
     * Show the Forum homepage
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ForumDoesNotExistException
     */
    public function index(Request $request)
    {
        $forum_id = $request->input('fid');
        if ($forum_id) {
            $forums = Forum::with('children')->whereId($forum_id)->orderBy('order')->get();
        } else {
            $forums = Cache::grab('forums');
        }
        if ($forums->isEmpty()) {
            flash()->info(trans('forum.not_found_create_one'));
            return redirect(route('admin.forum.create'));
        }
        return view('admin.forum.index', compact('forums'));
    }


    /**
     * Update a specific Forum
     *
     * @param Forum                          $forum
     * @param Requests\Admin\NewForumRequest $request
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Forum $forum, Requests\Admin\NewForumRequest $request)
    {
        $forum->saveForum($request);
        $forum->save();
        Cache::recache('forums');
        flash(trans('forum.update_success'));
        if ($request->ajax()) {
            return response()->json(['redirect' => route('admin.forum.index', ['fid' => $forum->id])]);
        }
        return back();
    }

    /**
     * Update the order of forums
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOrder(Request $request)
    {
        foreach ($request->input('order') as $forum_id => $order) {
            Forum::where('id', $forum_id)->update(['order' => $order]);
        }
        Cache::recache('forums');
        flash(trans('forum.order_updated_success'));
        return back();
    }

    /**
     * Create a new Forum
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.forum.create');
    }

    /**
     * Store the new Forum that was created
     *
     * @param Requests\Admin\NewForumRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store(Requests\Admin\NewForumRequest $request)
    {
        $forum = new Forum();
        $forum->saveForum($request);
        $forum->save();
        Cache::recache('forums');
        if ($request->ajax()) {
            return response()->json(['redirect' => route('admin.forum.index', ['fid' => $forum->id])]);
        }
        return redirect(route('admin.forum.index', ['fid' => $forum->id]));
    }


    /**
     * Show view to move threads
     * @param Forum $forum
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMoveThreads(Forum $forum)
    {
        return view('admin.forum.manage.move', compact('forum'));
    }

    /**
     * Move threads from one forum to another
     * @param Forum                             $forum
     * @param Requests\Admin\MoveThreadsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function moveThreads(Forum $forum, Requests\Admin\MoveThreadsRequest $request)
    {
        $forum->threads()->update(['forum_id' => $request->input('forum')]);
        Cache::recache('forums');
        flash(trans('forum.thread.move_success', ['threads' => $forum->threads->count()]));
        return redirect(route('admin.forum.index', ['fid' => $forum->id]));
    }

    /**
     * Junk all threads in a forum
     * @param Forum $forum
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function junkThreads(Forum $forum)
    {
        foreach ($forum->threads as $thread) {
            event(new ThreadWasJunked($thread));
            $thread->delete();
        }
        flash(trans('forum.thread.junk_success'));
        return redirect(route('admin.forum.index', ['fid' => $forum->id]));
    }

    /**
     * Restore all junked threads in a forum
     * @param Forum $forum
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restoreThreads(Forum $forum)
    {
        foreach ($forum->threads as $thread) {
            event(new ThreadWasRestored($thread));
            $thread->restore();
        }
        flash(trans('forum.thread.restore_success'));
        return redirect(route('admin.forum.index', ['fid' => $forum->id]));
    }

    /**
     * Delete all threads from a forum
     * @param Forum $forum
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteThreads(Forum $forum)
    {
        $forum->threads()->forceDelete();
        flash(trans('forum.thread.delete_success'));
        return redirect(route('admin.forum.index', ['fid' => $forum->id]));
    }

    /**
     * Delete a forum
     * @param Forum $forum
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function destroy(Forum $forum)
    {
        // Check if forum has threads
        if ($forum->hasThreads()) {
            flash()->warning(trans('forum.delete_warning_has_threads'));
            return view('admin.forum.manage.move', compact('forum'));
        }

        // Check if forum has subforums
        if ($forum->hasChildren()) {
            flash()->warning(trans('forum.delete_warning_has_subforums'));
            return redirect(route('admin.forum.index', ['fid' => $forum->id]));
        }

        event(new ForumWasDeleted($forum));

        // Delete the forum
        $forum->delete();
        Cache::recache('forums');
        flash(trans('forum.delete_success'));

        return redirect(route('admin.forum.index'));
    }
}

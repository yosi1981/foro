<?php

namespace App\Http\Controllers\Admin;

use App\Core\Core;
use App\Forum\Post;
use App\Forum\Thread;
use App\User\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller {

    /**
     * Show admin index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $info_boxes = $this->infoBoxes();
        $new_users = User::newUsers();
        $most_recent_stats = $this->mostRecentStats();
        $admin_note = Core::adminNote();
        return view('admin.index', compact('info_boxes', 'new_users', 'most_recent_stats', 'admin_note'));
    }

    /**
     * Update admin note from database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateNotes(Request $request)
    {
        Core::createAdminNote($request);
        if ($request->ajax()) {
            return response()->json();
        }
        flash(trans('admin.dashboard.note.update_success'));
        return redirect()->back();
    }

    /**
     * Get the most recent stats
     * @return array
     */
    public function mostRecentStats()
    {
        $latest_thread = Thread::latest()->first();
        $latest_post = Post::latest()->first();
        $stat = [];
        // Most recent thread
        if ($latest_thread) {
            $stat['latest_thread'] = [
                'name'  => trans('admin.dashboard.recent.thread'),
                'value' => $latest_thread->title,
                'url'   => $latest_thread->threadURL(),
            ];
        }
        // Most recent post
        if ($latest_post) {
            $stat['latest_post'] = [
                'name'  => trans('admin.dashboard.recent.post'),
                'value' => str_limit($latest_post->message, 50),
                'url'   => $latest_post->postURL(),
            ];
        }

        return $stat;
    }

    /**
     * Info box to be displayed in admin dashboard
     *
     * @return array
     */
    public function infoBoxes()
    {
        return [
            [
                'name'  => trans('user.total'),
                'icon'  => 'fa fa-users',
                'value' => Core::getStat('total_users'),
                'color' => 'bg-red',
            ],
            [
                'name'  => trans('user.new'),
                'icon'  => 'fa fa-user-plus',
                'value' => User::newUsers()->count(),
                'color' => 'bg-orange',
            ],
            [
                'name'  => trans('forum.thread.total'),
                'icon'  => 'fa fa-comment',
                'value' => Core::getStat('total_threads'),
                'color' => 'bg-aqua',
            ],
            [
                'name'  => trans('forum.post.total'),
                'icon'  => 'fa fa-comments',
                'value' => Core::getStat('total_posts'),
                'color' => 'bg-blue',
            ],
        ];
    }
}

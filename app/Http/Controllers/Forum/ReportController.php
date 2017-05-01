<?php

namespace App\Http\Controllers\Forum;

use App\Core\Cache;
use App\Forum\Post;
use App\Forum\ReportedPost;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller {

    /**
     * Report a post using AJAX
     *
     * @param Post                       $post
     * @param Requests\ReportPostRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Post $post, Requests\ReportPostRequest $request)
    {
        // If the user has selected "other", set the $reason to the text field
        $reason = $request->input('reason') == 'other' ? $request->input('other_reason') : $request->input('reason');

        // If a post cannot be reported more than once...
        if ($post->hasBeenReported()) {
            return response()->json(['error' => trans('forum.report.already_reported')], 422);
        }
        // Add report to database
        $this->createReport($post, $reason);

        return response()->json(['noAlert' => true]);
    }

    /**
     * Create a report and save to database
     *
     * @param $post
     * @param $reason
     */
    public function createReport($post, $reason)
    {
        ReportedPost::create([
            'user_id' => user()->id,
            'post_id' => $post->id,
            'reason'  => $reason,
        ]);

        Cache::recache('reported_posts_count');

    }

    /**
     * Return the report form
     *
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportForm(Post $post)
    {
        if (user()->cannot('forum-report-post')) {
            abort(403);
        }

        if ($post->hasBeenReportedByUser(user())) {
            $message = trans('forum.report.success');
        } else if ($post->hasBeenReported()) {
            $message = trans('forum.report.already_reported');
        }
        return view('forum.report._raw', compact('message'));
    }
}

<?php

namespace App\Http\Controllers\Mod;

use App\Core\Cache;
use App\Core\MassActions;
use App\Events\Forum\PostWasJunked;
use App\Forum\ReportedPost;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportedPostsController extends Controller {

    use MassActions;

    /**
     * Show homepage
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $show_all = false;
        if ($request->input('show') == 'all') {
            $show_all = true;
            $reports = ReportedPost::allReports()->paginate(15);
        } else {
            $reports = ReportedPost::newReports()->paginate(15);
        }
        return view('mod.reported_posts.index', compact('reports', 'show_all'));
    }

    /**
     * Report actions
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(Request $request)
    {
        $this->massActions($this, ReportedPost::class, $request);
        return redirect()->back();
    }

    /**
     * Mark one or more reports as resolved (read)
     *
     * @param ReportedPost $report
     * @return mixed
     */
    public function resolved(ReportedPost $report)
    {
        return $report->markAsResolved();
    }

    /**
     * Delete one or more reports
     *
     * @param ReportedPost $report
     * @return mixed
     */
    public function deleteReport(ReportedPost $report)
    {
        return $report->deleteReport();
    }

    /**
     * Delete the post the report is based on
     *
     * @param ReportedPost $report
     * @return mixed
     */
    public function deletePost(ReportedPost $report)
    {
        $report->markAsResolved();
        $report->post->delete();
        return event(new PostWasJunked($report->post));
    }

    /**
     * Delete all reports
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAll()
    {
        ReportedPost::truncate();
        Cache::recache('reported_posts_count');
        flash(trans('mod.report.delete_success'));
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Core\Cache;
use App\Forum\UserTitle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserTitleController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->middleware('demo', ['only' => ['update', 'store', 'destroy']]);
    }

    /**
     * Show all user titles
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $titles = Cache::grab('user_titles');
        return view('admin.user_title.index', compact('titles'));
    }

    /**
     * Edit a user title
     *
     * @param UserTitle $title
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(UserTitle $title)
    {
        return view('admin.user_title.edit', compact('title'));
    }

    /**
     * Update the edited title and save it to database
     *
     * @param UserTitle                       $title
     * @param Requests\Admin\UserTitleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UserTitle $title, Requests\Admin\UserTitleRequest $request)
    {
        $this->saveTitle($title, $request);
        Cache::recache('user_titles');

        flash(trans('admin.user.title.update_success'));

        return redirect(route('admin.title.index'));

    }

    /**
     *  Create a new user title
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user_title.create');
    }

    /**
     * Store the newly created title in database
     *
     * @param Requests\Admin\UserTitleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Requests\Admin\UserTitleRequest $request)
    {
        $title = new UserTitle();
        $this->saveTitle($title, $request);

        flash(trans('admin.user.title.create_success'));

        return redirect(route('admin.title.index'));
    }

    /**
     * Save title - used by both store() and update() methods
     * @param $title
     * @param $request
     */
    public function saveTitle($title, $request)
    {
        $title->title = $request->input('title');
        $title->posts = $request->input('posts');
        $title->stars = $request->input('stars');
        $title->save();
    }

    /**
     * Delete a user title
     * @param UserTitle $title
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(UserTitle $title)
    {
        $title->delete();
        Cache::recache('user_titles');

        flash(trans('admin.user.title.delete_success'));

        return redirect(route('admin.title.index'));
    }
}

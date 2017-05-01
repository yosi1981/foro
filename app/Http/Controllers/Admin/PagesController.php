<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\Pages\PageWasCreated;
use App\Events\Admin\Pages\PageWasDeleted;
use App\Events\Admin\Pages\PageWasUpdated;
use App\Page;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller {

    /**
     * Show the index page of all pages
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Edit a page
     *
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update a edited page
     *
     * @param Page                           $page
     * @param Requests\Admin\EditPageRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Page $page, Requests\Admin\EditPageRequest $request)
    {
        $this->savePage($page, $request);
        $page->save();
        event(new PageWasUpdated($page));
        flash(trans('admin.pages.update_success'));
        if ($request->ajax()) {
            return response()->json(['redirect' => route('admin.page.index')]);
        }
        return redirect(route('admin.page.index'));
    }

    /**
     * Show the view to create a new page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a new page to database
     *
     * @param Requests\Admin\NewPagerequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Requests\Admin\NewPagerequest $request)
    {
        $page = new page;
        $this->savePage($page, $request);
        $page->user_id = user()->id;
        $page->save();

        event(new PageWasCreated($page));
        flash(trans('admin.pages.create_success'));
        if ($request->ajax()) {
            return response()->json(['redirect' => route('admin.page.index')]);
        }
        return redirect(route('admin.page.index'));
    }

    /**
     * Save the page to the page model.
     * Used by both store and update methods
     *
     * @param $page
     * @param $request
     */
    public function savePage($page, $request)
    {
        $page->title = $request->input('title');
        $page->body = $request->input('body');
        $page->slug = $request->input('slug');
    }

    /**
     * Delete a page
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Page $page)
    {
        if ($page->system_required) {
            return back()->withErrors(trans('admin.pages.cannot_delete_system_required'));
        }
        $page->delete();
        event(new PageWasDeleted($page));
        return redirect(route('admin.page.index'));
    }
}

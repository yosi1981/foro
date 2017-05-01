<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Page;
use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if (site('default-homepage-forum')) {
           return redirect(route('forum.home'));
       }

        return view('home');
    }

    /**
     * Show a page
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPage($slug)
    {
        $page = Page::whereSlug($slug)->first();
        return view('pages.show', compact('page'));
    }

}

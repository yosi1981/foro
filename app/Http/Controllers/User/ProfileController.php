<?php

namespace App\Http\Controllers\User;

use App\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;

class ProfileController extends Controller {

    /**
     * View user profile
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        $posts = $user->posts()->orderBy('created_at', 'desc')->take(5)->with('thread')->get();
        return view('user.profile.view_user', ['member' => $user, 'posts' => $posts]);
    }

    /**
     * Show all posts by a user
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allPosts(User $user)
    {
        $member = $user;
        $posts = $user->posts()->orderBy('created_at', 'desc')->with('thread.user')->paginate(perPage('posts'));
        return view('user.profile.includes.all_posts', compact('posts', 'member'));
    }

    /**
     * Show all threads by a user
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allThreads(User $user)
    {
        $member = $user;
        $threads = $user->threads()->with('lastPost.thread', 'user', 'readThreads')->orderBy('created_at', 'desc')->paginate(perPage('threads'));

        return view('user.profile.includes.all_threads', compact('threads', 'member'));
    }

    /**
     * Show all registered users and enable search
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allUsers(Request $request)
    {
        if ($request->has('search')) {

            // If the user cannot search for other users
            if (user()->cannot('user-search-for-users')) {
                abort(403, trans('user.cannot_search'));
            }

            $search_term = $request->input('search');
            $users = User::where('username', 'LIKE', "%{$search_term}%")
                ->orWhere('id', 'LIKE', "%{$search_term}%")
                ->paginate(20);
        } else {
            $users = User::orderBy('username')->paginate(20);
        }

        return view('user.all', compact('users'));
    }
}

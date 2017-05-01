<?php

namespace App\Http\Controllers\Admin;

use App\Core;
use App\Events\Forum\PostWasDeleted;
use App\Events\Forum\PostWasJunked;
use App\Events\Forum\PostWasRestored;
use App\Events\Forum\ThreadWasDeleted;
use App\Events\Forum\ThreadWasJunked;
use App\Events\Forum\ThreadWasRestored;
use App\User\Role;
use App\User\User;
use App\Core\MassActions;
use App\Events\User\UserWasDeleted;
use App\Events\User\UserWasCreated;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    use MassActions;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('demo', ['except' => ['viewIPLogs', 'create', 'show', 'index']]);
    }

    /**
     * Show all users
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $search_term = $request->input('search');
        if ($request->has('search')) {
            $users = User::where('username', 'LIKE', "%{$search_term}%")
                ->orWhere('id', 'LIKE', "%{$search_term}%")
                ->orWhere('email', 'LIKE', "%{$search_term}%")
                ->paginate(20);
        } else {
            $users = User::orderBy('username')->paginate(20);
        }
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the user
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.user.show', ['member' => $user]);
    }

    /**
     * Update user settings
     *
     * @param User                               $user
     * @param Requests\Admin\UserSettingsRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, Requests\Admin\UserSettingsRequest $request)
    {
        $user->updateAccountSettings($request);
        $user->updateGeneralSettings($request);
        $user->updateAccountPrivileges($request);
        $user->updateForumSettings($request);
        $user->updatePrivateAnnouncement($request);
        $user->updateModSettings($request);

        // Verify user email
        if ($request->has('email_verify')) {
            $user->verifyEmail();
        }

        // Change password
        if ($request->has('password')) {
            $user->updatePassword($request);
        }

        $user->activated = $request->input('activate');
        $user->primary_role = $request->input('primary_role');

        $user->save();

        // Sync all selected roles
        $user->updateRole($request);

        flash(trans('user.save_success'));

        if ($request->ajax()) {
            return response()->json(['redirect' => route('admin.user.show', $user->info)]);
        }
        return redirect(route('admin.user.show', $user->info));
    }

    /**
     * Show a view to create a new user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store the user in database
     *
     * @param Requests\Admin\NewUserCreateSettingsRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Requests\Admin\NewUserCreateSettingsRequest $request)
    {
        $user = new User;
        $user->updateAccountSettings($request);
        $user->updatePassword($request);
        $user->primary_role = $request->input('primary_role');
        $user->registration_ip_address = $request->ip();
        $user->save();
        $user->updateRole($request);

        flash(trans('admin.user.created'));

        if ($request->ajax()) {
            return response()->json(['redirect' => route('admin.user.show', $user->info)]);
        }
        return redirect(route('admin.user.show', $user->info));
    }

    /**
     * Delete a user from database
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        event(new UserWasDeleted());

        flash(trans('admin.user.deleted'));
        return redirect(route('admin.user.index'));
    }

    /**
     * Handle mass-actions for multiple users
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actions(Request $request)
    {
        $this->massActions($this, User::class, $request, flash(trans('user.mass.success.applied')));
        return back();
    }

    /**
     * Activate a user
     *
     * @param User $user
     * @param bool $activate
     */
    public function activate(User $user, $activate = true)
    {
        $user->activated = $activate;
        $user->save();
    }

    /**
     * De-activate a user
     *
     * @param User $user
     */
    public function deactivate(User $user)
    {
        $this->activate($user, false);
    }

    /**
     * Junk a user's posts
     *
     * @param User $user
     */
    public function junk_posts(User $user)
    {
        foreach ($user->posts as $post) {
            event(new PostWasJunked($post));
            $post->delete();
        }
    }

    /**
     * Delete a user's posts
     *
     * @param User $user
     */
    public function delete_posts(User $user)
    {
        foreach ($user->posts as $post) {
            event(new PostWasDeleted($post));
            $post->forceDelete();
        }
    }

    /**
     * Restore junked-posts of a user
     *
     * @param User $user
     */
    public function restore_posts(User $user)
    {
        foreach ($user->posts()->withTrashed()->get() as $post) {
            event(new PostWasRestored($post));
            $post->restore();
        }
    }

    /**
     * Junk a user's threads
     *
     * @param User $user
     */
    public function junk_threads(User $user)
    {
        foreach ($user->threads as $thread) {
            event(new ThreadWasJunked($thread));
            $thread->delete();
        }
    }

    /**
     * Delete a user's threads
     *
     * @param User $user
     */
    public function delete_threads(User $user)
    {
        foreach ($user->threads as $thread) {
            event(new ThreadWasDeleted($thread));
            $thread->forceDelete();
        }
    }

    /**
     * Restore a user's junked threads
     *
     * @param User $user
     */
    public function restore_threads(User $user)
    {
        foreach ($user->threads()->withTrashed()->get() as $thread) {
            event(new ThreadWasRestored($thread));
            $thread->restore();
        }
    }

    public function viewIPLogs(User $user)
    {
        return view('admin.user.ip_logs')->with(['member' => $user]);
    }
}


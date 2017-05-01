<?php

namespace App\Http\Controllers\Mod;

use App\User\Banned;
use App\User\Role;
use App\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BannedUsersController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->middleware('mod.modify.admin', ['only' => ['show', 'edit', 'store', 'addToDatabase', 'destroy', 'update']]);
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Show banned index page - show all banned users
     */
    public function index()
    {
        $bans = Banned::orderBy('created_at', 'desc')->with('user', 'banner')->paginate(20);
        return view('mod.banned.index', compact('bans'));
    }

    /**
     * Show the ban-user page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('mod.banned.create');
    }

    /**
     * Show ban info
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show(User $user)
    {
        if (!$user->isBanned()) {
            return redirect(route('mod.banned.index'))->withErrors(trans('mod.banned.not_banned'));
        }
        return view('mod.banned.show', ['member' => $user]);
    }

    /**
     * Edit ban info
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        if (!$user->isBanned()) {
            return redirect(route('mod.banned.index'))->withErrors(trans('mod.banned.not_banned'));
        }
        return view('mod.banned.edit', ['member' => $user]);
    }

    /**
     * Get the user and return the form to user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function getForm(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
        ]);
        $member = User::whereInfo($request->input('username'))->firstOrFail();

        return response()->json(view('mod.banned.form', compact('member'))->render());
    }

    /**
     * Store the banned info in database
     *
     * @param User                        $user
     * @param Requests\Mod\BanUserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(User $user, Requests\Mod\BanUserRequest $request)
    {
        if ($user->isBanned()) {
            return response()->json(['error' => 'Already banned'], 422);
        }
        $this->addToDatabase($user, $request);

        // Change user's primary role to banned
        $user->primary_role = Role::getBannedRoleId();
        $user->save();

        return response()->json(['redirect' => route('mod.banned.show', $user->info)]);
    }

    /**
     * Calculate the ban length that the user input
     *
     * @param $request
     * @return static
     */
    private function calculateBanLength($request)
    {
        $length = $request->input('length');
        $expires = $length != '0' ? $length : 100000000;
        $custom = $expires == 'custom' ? true : false;
        return $custom ? Carbon::createFromTimestamp(strtotime($request->input('custom'))) : Carbon::now()->addMinutes($expires);
    }

    /**
     * Update a ban
     *
     * @param User                        $user
     * @param Requests\Mod\BanUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user, Requests\Mod\BanUserRequest $request)
    {
        if (!$user->isBanned()) {
            return redirect(route('mod.banned.index'))->withErrors(trans('mod.banned.not_banned'));
        }
        $banned = $user->ban;
        $this->saveBan($banned, $request);

        flash()->success(trans('mod.banned.update_success'));
        if ($request->ajax()) {
            return response()->json(['redirect' => route('mod.banned.show', $user->info)]);
        }
        return redirect(route('mod.banned.show', $user->info));
    }

    /**
     * Add ban to database
     *
     * @param User $user
     * @param      $request
     * @return Banned
     */
    public function addToDatabase(User $user, $request)
    {
        $banned = new Banned();
        $banned->user_id = $user->id;
        $banned->old_primary_user_id = $user->primaryRole->id;
        return $this->saveBan($banned, $request);
    }

    /**
     * Save a ban to database (can be used while updating and creating ban)
     *
     * @param $banned
     * @param $request
     * @return mixed
     */
    public function saveBan($banned, $request)
    {
        $banned->banned_by_user_id = user()->id;
        $banned->reason = $request->input('reason');
        $banned->expires_at = $this->calculateBanLength($request);;
        $banned->save();
        return $banned;
    }


    /**
     * Un-ban a user (destroy the row from database)
     *
     * @param User    $user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @internal param Banned $banned
     */
    public function destroy(User $user, Request $request)
    {
        if (!$user->isBanned()) {
            return redirect(route('mod.banned.index'))->withErrors(trans('mod.banned.not_banned'));
        }

        // Change the user's role back to the old primary ID.
        $user->ban->lift();

        flash()->success(trans('mod.banned.delete_success'));

        if ($request->ajax()) {
            return response()->json(['redirect' => route('mod.banned.index')]);
        }
        return redirect(route('mod.banned.index'));
    }

}

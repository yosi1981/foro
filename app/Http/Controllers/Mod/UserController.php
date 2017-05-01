<?php

namespace App\Http\Controllers\Mod;

use App\User\User;
use Illuminate\Http\Request;
use App\Http\Requests\Mod\UserSettingsRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->middleware('mod.modify.admin', ['except' => ['index']]);
    }

    /**
     * Show the index view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('mod.user.index');
    }

    /**
     * Show a specific user
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('mod.user.show', ['member' => $user]);
    }

    /**
     * Edit a user
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('mod.user.edit', ['member' => $user]);
    }

    /**
     * Update a user
     * @param User                $user
     * @param UserSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, UserSettingsRequest $request)
    {
        if (user()->can('moderateEditAccountInfo', user())) {
            $user->updateAccountSettings($request);
        }
        if (user()->can('moderateEditGeneralInfo', user())) {
            $user->updateGeneralSettings($request);
        }
        if (user()->can('moderateSuspendPrivileges', user())) {
            $user->updateAccountPrivileges($request);
        }
        if (user()->can('moderateEditForumInfo', user())) {
            $user->updateForumSettings($request);
        }
        if (user()->can('moderateEditPrivateAnnouncement', user())) {
            $user->updatePrivateAnnouncement($request);
        }
        $user->updateModSettings($request);

        $user->save();
        return redirect(route('mod.user.show', $user->info));
    }
}

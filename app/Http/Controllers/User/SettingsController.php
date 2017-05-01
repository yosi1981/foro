<?php

namespace App\Http\Controllers\User;

use App\Timezone;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AccountSettingsRequest;
use App\Http\Requests\User\GeneralSettingsRequest;

class SettingsController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->middleware('demo', ['only' => ['saveAccount', 'changePassword']]);
    }

    /**
     * Show the user settings page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('user.account.settings');
    }

    /**
     * Save general settings to database
     *
     * @param GeneralSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveGeneral(GeneralSettingsRequest $request)
    {

        $user = $request->user();
        if ($user->can('user-edit-about-me')) {
            $user->about_me = $request->input('about_me');
        }
        $user->avatar = $request->input('avatar');
        //$user->avatar = $request->input('avatar');
        $user->timezone = $request->input('timezone');
        $user->save();
        if ($request->ajax()) {
            return response()->json(['success' => trans('user.save_success')]);
        }
        flash(trans('user.save_success'));
        return redirect(route('user.settings.index'));
    }

    /**
     * Update account settings
     *
     * @param AccountSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAccount(AccountSettingsRequest $request)
    {
        $user = $request->user();

        if ($user->can('editUsername', $user)) {
            $user->username = $request->input('username');
        }
        if ($user->can('editEmail', $user)) {
            $user->email = $request->input('email');
        }

        flash()->success(trans('user.save_success'));

        if ($request->has('password')) {
            if ($user->passwordMatchesCurrent($request->input('current_password'))) {
                $user->updatePassword($$request);
            } else {
                return flash()->error(trans('user.password.incorrect'));
            }
        }

        $user->save();

        return redirect(route('user.settings.index') . '#account');
    }

    /**
     * Change user's password
     *
     * @param $request
     * @return bool
     */
    public function changePassword($user, $request)
    {
        if (\Hash::check($request->input('current_password'), $user->password)) {
            $user->updatePassword($$request);
            return true;
        }
        return flash()->error(trans('user.password.incorrect'));
    }

    /**
     * Save forum settings
     * @param Requests\User\ForumSettingsRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveForum(Requests\User\ForumSettingsRequest $request)
    {
        $user = $request->user();
        $user->updateForumSettings($request);
        $user->save();

        if ($request->ajax()) {
            return response()->json(['success' => trans('user.save_success')]);
        }
        flash(trans('user.save_success'));
        return redirect(route('user.settings.index'));
    }

}

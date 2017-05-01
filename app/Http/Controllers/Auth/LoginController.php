<?php

namespace App\Http\Controllers\Auth;

use App\Events\User\UserHasLoggedIn;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends AuthController {

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.login.enabled');
    }

    /**
     * Login a user
     * @param Requests\Auth\LoginUserRequest $request
     * @return $this|LoginController|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function loginUser(Requests\Auth\LoginUserRequest $request)
    {
        return $this->checkCredentials($request);
    }

    /**
     * Check the user's credentials
     * @param $request
     * @return $this|LoginController|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function checkCredentials($request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember');

        if (Auth::attempt(['username' => $username, 'password' => $password], $remember)
            || Auth::attempt(['email' => $username, 'password' => $password], $remember)
        ) {
            return $this->checkUserAccountStatus();
        }

        if ($request->ajax()) {
            return response()->json(['error' => trans('user.login.invalid_credentials')]);
        }

        return $this->userCannotLogin(trans('user.login.invalid_credentials'));
    }

    /**
     * This method is called when the user has been successfully authenticated
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function userWasAuthenticated()
    {
        event(new UserHasLoggedIn(user()));

        if (request()->ajax()) {
            return response()->json(['redirect' => redirect()->intended()->getTargetUrl()]);
        }

        return redirect()->intended();
    }

    /**
     * Check if user is able to log in
     */
    public function checkUserAccountStatus()
    {
        $user = Auth::user();

        // If user has been banned and banned users cannot log in
        if ($user->isBanned() && !site('banned-users-can-login')) {
            $error = trans('user.alert.banned', ['date' => $user->ban->expires_at]);
            $error .= '<br>' . trans('user.alert.ban_reason') . ': ' . $user->ban->reason;
            return $this->userCannotLogin($error);
        }

        // If user has not had their email verified
        if (!$user->emailVerified() && site('confirm-email-on-registration')) {
            $error = trans('user.login.email_not_verified');
            return $this->userCannotLogin($error);
        }

        // If user is not activated
        if (!$user->activated) {
            $error = trans('user.login.deactivated');
            return $this->userCannotLogin($error);
        }

        return $this->userWasAuthenticated();

    }

    /**
     * When a user cannot log in, show them an error
     *
     * @param $error
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function userCannotLogin($error)
    {
        if (isset($error)) {
            Auth::logout();
            if (request()->ajax()) {
                return response()->json(['error' => $error]);
            }
            return redirect(route('auth.login'))->withInput()->withErrors($error);
        }
        return redirect(route('auth.login'));
    }

    /**
     * Load the ajax login form
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function loadAjaxLoginForm()
    {
        return response()->json(
            [
                'title' => trans('site.auth.login'),
                'view'  => view('auth.includes.login_form')->render(),
            ]
        );
    }
}

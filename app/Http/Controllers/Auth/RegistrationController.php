<?php

namespace App\Http\Controllers\Auth;

use App\Core\Core;
use App\Events\User\UserWasCreated;
use App\User\EmailVerification;
use App\User\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class RegistrationController extends AuthController {

    /**
     * RegistrationController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.registration.enabled', ['except' => 'verifyEmail']);
    }

    public function addUser(Requests\Auth\RegisterUserRequest $request)
    {
        // Add user to database
        $user = new User;
        $user->updateAccountSettings($request);
        $user->updatePassword($request);
        $user->timezone = $request->input('timezone');
        $user->primary_role = Core::defaultRole();
        $user->registration_ip_address = $request->ip();
        $user->activated = true;
        $user->save();

        $user->roles()->attach(Core::defaultRole());

        // Fire off an event
        event(new UserWasCreated($user));

        if (site('confirm-email-on-registration')) {
            $message = trans('user.register.success_confirm_email');
        } else {
            $message = trans('user.register.success');
            \Auth::loginUsingId($user->id);
        }

        flash($message);

        if ($request->ajax()) {
            return response()->json(['redirect' => route('home')]);
        }

        return redirect(route('home'));

    }

    /**
     * Verify a user's email
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyEmail($token)
    {
        $verification = EmailVerification::whereToken($token)->firstOrFail();

        $verification->user->verifyEmail();

        flash(trans('user.register.verified_success'));
        return redirect(route('auth.login'));
    }
}

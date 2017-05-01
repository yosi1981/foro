<?php

namespace App\Http\Controllers;

use Auth;
use App\Core\SelectInput;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController {

    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        try {
            if (Auth::check()) {
                $this->checkIfUserAccountIsActive();
            }
            $this->shareViews();
        } catch (\Exception $ex) {
            flash()->overlay('ProChaterr is experiencing some issues with getting Users from the users table. Are you sure that Prochaterr has been installed correctly? If it is, are you sure that the users table exists in database?', 'warning');
        }
    }

    /**
     * Share variables to all views
     */
    public function shareViews()
    {
        view()->share('signed_in', Auth::check());

        if (Auth::guest()) {
            view()->share('user', Auth::user());
        } else {
            view()->share('user', Auth::user());
        }

        view()->share('select_input', new SelectInput());
    }

    /**
     * Check if user is not banned or if is still active.
     * If not, log out.
     */
    public function checkIfUserAccountIsActive()
    {
        if (user()->isBanned() && !site('banned-users-can-login')) {
            Auth::logout();
        }

        if (!user()->activated) {
            Auth::logout();
        }
    }
}

<?php

namespace App\Http\Controllers\Mod;

use App\Core\Core;
use App\User\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ModController extends Controller {


    /**
     * Show the mod dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $mod_note = Core::moderationNote();
        return view('mod.index', compact('mod_note'));
    }

    /**
     * Search a specific user and show their info
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function searchUser(Request $request)
    {
        $member = User::whereInfo($request->input('username'))->firstOrFail();
        // If user is admin and the logged in user is not, abort
        if ($member->isAdmin() && !user()->can('searchAdmin', $member)) {
            return response()->json(['error' => trans('user.cannot_modify')]);
        }
        return response()->json(view('mod.includes.user_info', compact('member'))->render());
    }

    /**
     * Create/update the moderation note
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function notes(Request $request)
    {
        Core::createModNote($request);
        if ($request->ajax()) {
            return response()->json();
        }
        flash(trans('mod.note.updated'));
        return redirect()->back();
    }

}

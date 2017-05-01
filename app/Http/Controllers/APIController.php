<?php

namespace App\Http\Controllers;

use App\Forum\Post;
use App\User\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class APIController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Search a user using ajax
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchUser(Request $request)
    {
        $term = $request->input('term');

        $users = User::where('username', 'LIKE', "%{$term}%")
            ->orWhere('id', 'LIKE', "%{$term}%")
            ->take(5)->get();

        $results = array();

        foreach ($users as $user) {
            $results[] = [
                'id'       => $user->id,
                'username' => $user->username,
                'info'     => $user->info,
                'value'    => 'ID: ' . $user->id . ' – ' . $user->username];
        }

        return response()->json($results);
    }
}

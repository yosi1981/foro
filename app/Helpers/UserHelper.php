<?php

use App\User\User;

/**
 * Return the user object (or a different user)
 *
 * @param null $user_id
 * @return \App\User\User|null
 */
function user($user_id = null)
{
    if (!$user_id) {
        return Auth::user();
    }
    return User::where('id', $user_id)->first();
}


/**
 * Get the per-page number from each user as each user may set their own per-page pagination from account
 *
 * @param null $type
 * @return bool|int|mixed
 */
function perPage($type = null)
{
    try {
        switch ($type) {
            case('threads'):
                $per_page = user()->per_page_threads;
                break;
            case('posts'):
                $per_page = user()->per_page_posts;
                break;
        }
    } catch (Exception $ex) {
        return site('pagination-per-page');
    }
    return $per_page ?: site('pagination-per-page');
}

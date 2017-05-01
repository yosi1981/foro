<?php

namespace App\Policies\Forum;

use App\Forum\Forum;
use App\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
{
    use HandlesAuthorization;

    /**
     * If users can create a new thread in a forum
     * @param User  $user
     * @param Forum $forum
     * @return bool
     */
    public function createThread(User $user, Forum $forum)
    {
        if ($user->can('forum-create-thread') && !$forum->closed && $forum->allow_new_threads) {
            if ($user->suspend_threads) {
                return false;
            }
            return true;
        }
        return false;
    }
}

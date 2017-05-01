<?php

namespace App\Policies\Forum;

use App\User\User;
use App\Forum\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy {

    use HandlesAuthorization;

    /**
     * A user can see a thread
     *
     * @param User   $user
     * @param Thread $thread
     * @return bool|void
     */
    public function show(User $user, Thread $thread)
    {

        // If user can view thread or user owns the thread
        if ($user->can('forum-view-thread') || $user->owns($thread)) {
            if ($thread->trashed() && $user->cannot('forum-moderate-junked-thread')) {
                return false;
            }
            return true;
        }
        return abort(403, trans('messages.forum.thread.cannot_view'));
    }

    /**
     * A user can lock a thread
     *
     * @param User   $user
     * @param Thread $thread
     * @return bool
     */
    public function lock(User $user, Thread $thread)
    {
        // If thread was hard locked and not created by user
        if ($thread->hardLocked() && !$user->can('forum-moderate-hard-lock-thread')) {
            return false;
        }

        // If user is moderator and can moderate lock thread
        if ($user->can('forum-moderate-thread') || $user->can('forum-moderate-lock-thread')) {
            return true;
        }

        // If user has permission and they created a thread
        if ($user->can('forum-lock-thread')) {
            return $user->owns($thread);
        }

        return false;
    }

    /**
     * A user can pin a thread
     *
     * @param User   $user
     * @param Thread $thread
     * @return bool
     */
    public function pin(User $user, Thread $thread)
    {
        // If thread was hard pinned and not created the the user
        if ($thread->hardPinned() && !$user->can('forum-moderate-hard-pin-thread')) {
            return false;
        }

        // If user can moderate pinned threads
        if ($user->can('forum-moderate-thread') || $user->can('forum-moderate-pin-thread')) {
            return true;
        }

        // If user can pin threads and user owns thread
        if ($user->can('forum-pin-thread')) {
            return $user->owns($thread);
        }

        return false;
    }

    /**
     * A user can reply to a thread
     *
     * @param User   $user
     * @param Thread $thread
     * @return bool
     */
    public function postReply(User $user, Thread $thread)
    {
        // If the forum is closed
        if ($thread->forum->closed) {
            return false;
        }

        // If the user's post privileges are suspended
        if ($user->suspend_posts) {
            return false;
        }

        // If the thread is locked and the user can still reply
        if ($thread->locked) {
            if ($user->can('lock', $thread)) {
                return true;
            }
            return false;
        }

        return $user->can('forum-reply');
    }

    /**
     * User can junk a thread
     *
     * @param User   $user
     * @param Thread $thread
     * @return bool
     */
    public function junkThread(User $user, Thread $thread)
    {
        // If user is moderator and can junk other's thread return true
        if ($user->can('forum-moderate-junk-thread') || $user->can('forum-moderate-thread')) {
            return true;
        }
        // If user owns the thread and can junk their own thread return true
        if ($user->owns($thread) && $user->can('forum-junk-thread')) {
            return true;
        }

        return false;
    }

    /**
     * User can delete a thread
     *
     * @param User   $user
     * @param Thread $thread
     * @return bool
     */
    public function deleteThread(User $user, Thread $thread)
    {
        // If user can delete other's thread and user is moderator
        if ($user->can('forum-moderate-delete-thread')) {
            return true;
        }

        // If user can delete their own thread and they own the thread
        if ($user->owns($thread) && $user->can('forum-delete-thread')) {
            return true;
        }

        return false;
    }

    /**
     * User can restore a junked thread
     *
     * @param User   $user
     * @param Thread $thread
     * @return bool
     */
    public function restoreJunkedThread(User $user, Thread $thread)
    {
        return $user->can('forum-moderate-junked-thread') ? true : false;
    }

    /**
     * uer can edit thread
     *
     * @param User   $user
     * @param Thread $thread
     * @return bool
     */
    public function editThread(User $user, Thread $thread)
    {
        if (($user->can('forum-edit-thread') && $user->owns($thread)) || $user->can('forum-moderate-thread')) {
            return true;
        }
        return false;
    }


}

<?php

namespace App\Policies\Forum;

use App\Exceptions\PostDoesNotExistException;
use App\Forum\Post;
use App\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy {

    use HandlesAuthorization;

    /**
     * If a user can edit a post
     *
     * @param User $user
     * @param Post $post
     * @return bool
     * @throws PostDoesNotExistException
     */
    public function editPost(User $user, Post $post)
    {
        if ($post->trashed() && $user->cannot('forum-moderate-junked-post')) {
            return false;
        }

        if ($post->thread->locked) {
            return false;
        }

        // If user owns the post and...
        if ($user->owns($post)) {
            // the post is the first post and the user user can edit thread
            if ($post->isFirstPost() && $user->can('forum-edit-thread')) {
                return true;
            }
            // the user can edit post
            if ($user->can('forum-edit-post')) {
                return true;
            }
        }
        return false;
    }

    /**
     * User can junk a post
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function junkPost(User $user, Post $post)
    {
        if ($user->can('forum-moderate-junk-post')) return true;
        // If user owns the post
        if ($user->owns($post)) {
            // If the user is junking first post, check if they can junk thread
            if ($post->isFirstPost() && $user->can('forum-junk-thread')) {
                return true;
            }
            if ($user->can('forum-junk-post')) {
                // If the thread is locked and user cannot junk posts when thread is locked, return false;
                if ($post->thread->locked && !$user->can('forum-junk-post-when-thread-locked')) {
                    return false;
                }
                return true;
            }
        }
        return false;
    }

    /**
     * User can restore a junked post
     *
     * @param User $user
     * @return bool
     */
    public function restorePost(User $user)
    {
        return $user->can('forum-moderate-junked-post') ? true : false;
    }


    /**
     * User can delete a post
     *
     * @param User $user
     * @return bool
     */
    public function deletePost(User $user)
    {
        return $user->can('forum-moderate-delete-post') ? true : false;
    }
}

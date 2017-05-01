<?php

namespace App\Listeners\Forum;

use App\Events\Forum\PostWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkThreadAsUnread
{

    /**
     * Handle the event.
     *
     * Mark a thread as unread for all users in a specific thread except the one who recently updated the post.
     * For instance, when a user replies with a post on a thread,
     * all users who have seen the thread before the user replied should have their status as "read".
     * It will make that status "unread" so they know that there is a new reply.
     *
     * @param  PostWasCreated  $event
     * @return void
     */
    public function handle(PostWasCreated $event)
    {
        $event->post->thread->markAsUnread();
    }
}

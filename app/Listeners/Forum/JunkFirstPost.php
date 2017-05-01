<?php

namespace App\Listeners\Forum;

use App\Events\Forum\PostWasJunked;
use App\Events\Forum\PostWasRestored;
use App\Events\Forum\ThreadWasJunked;
use App\Events\Forum\ThreadWasRestored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class JunkFirstPost {

    /**
     * Junk the first post only if the first post is trashed. This is to prevent a endless loop because
     * event JunkThreadIfFirstPost.php also calls this method if a thread is junked.
     *
     * @param  ThreadWasJunked $event
     * @return void
     */
    public function junk(ThreadWasJunked $event)
    {
        if ($event->thread->firstPost && !$event->thread->firstPost->trashed()) {
            $event->thread->firstPost->delete();
            event(new PostWasJunked($event->thread->firstPost));
        }
    }

    /**
     * Restore the first post
     *
     * @param ThreadWasRestored $event
     */
    public function restore(ThreadWasRestored $event)
    {
        if ($event->thread->firstPost ) {
            $event->thread->firstPost->restore();
            event(new PostWasRestored($event->thread->firstPost));
        }
    }
}

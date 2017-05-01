<?php

namespace App\Listeners\Forum;

use App\Events\Forum\PostWasJunked;
use App\Events\Forum\ThreadWasJunked;
use App\Events\Forum\ThreadWasRestored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class JunkThreadIfFirstPost
{

    /**
     * Restore thread if the post is first post. The "$event->thread->trashed()" is there to prevent
     * an endless loop that can occur as JunkIfPost.php also calls this method
     * @param $event
     */
    public function restore($event)
    {
        if ($event->post->isFirstPost() && $event->thread->trashed()) {
            $event->thread->restore();
            event(new ThreadWasRestored($event->thread));
        }
    }

    /**
     * Junk thread if the post is first post
     * @param $event
     */
    public function junk($event)
    {
        if ($event->post->isFirstPost() && !$event->thread->trashed()) {
            $event->thread->delete();
            event(new ThreadWasJunked($event->thread));
        }
    }
}

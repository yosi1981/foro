<?php

namespace App\Listeners\Forum;

use App\Events\Forum\ThreadWasRead;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkThreadAsRead {

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadWasRead $event
     * @return void
     */
    public function handle(ThreadWasRead $event)
    {
        if (!$event->thread->hasBeenReadBy(user()))
            $event->thread->markAsRead();
    }
}

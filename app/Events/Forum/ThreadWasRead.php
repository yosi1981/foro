<?php

namespace App\Events\Forum;

use App\Events\Event;
use App\Forum\Thread;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ThreadWasRead extends Event
{
    use SerializesModels;

    public $thread;

    /**
     * Create a new event instance.
     * @param $thread
     */
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}

<?php

namespace App\Events\Forum;

use App\Events\Event;
use App\Forum\Post;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostWasCreated extends Event
{
    use SerializesModels;

    public $post;
    public $thread;

    /**
     * Create a new event instance.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->thread = $this->post->thread;
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

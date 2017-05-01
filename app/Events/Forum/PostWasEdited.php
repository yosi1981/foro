<?php

namespace App\Events\Forum;

use App\Events\Event;
use App\Forum\Post;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Request;

class PostWasEdited extends Event
{
    use SerializesModels;

    public $post;
    public $request;

    /**
     * Create a new event instance.
     * @param Post    $post
     * @param Request $request
     */
    public function __construct(Post $post, $request)
    {
        $this->post = $post;
        $this->request = $request;
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

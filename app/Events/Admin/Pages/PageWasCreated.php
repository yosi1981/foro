<?php

namespace App\Events\Admin\Pages;

use App\Events\Event;
use App\Page;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PageWasCreated extends Event
{
    use SerializesModels;

    public $page;

    /**
     * Create a new event instance.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
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

<?php

namespace App\Listeners\Forum;

use App\Events\Forum\PostWasEdited;
use App\Forum\EditedPost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateEditedRecord {

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * Create a new record for editing a post
     * @param  PostWasEdited $event
     * @return void
     */
    public function handle(PostWasEdited $event)
    {
        $edited = new EditedPost();
        $edited->user_id = user()->id;
        $edited->post_id = $event->post->id;
        $edited->save();
    }
}

<?php

namespace App\Listeners\Pages;

use App\Events\Admin\Pages\PageWasUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePagesCache
{

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PageWasUpdated  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}

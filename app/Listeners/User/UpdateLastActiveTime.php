<?php

namespace App\Listeners\User;

use App\Events\User\UserHasLoggedIn;
use App\User\User;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLastActiveTime
{

    /**
     * Update hte last active time
     *
     * @param  UserHasLoggedIn  $event
     * @return void
     */
    public function handle(UserHasLoggedIn $event)
    {
        $event->user->active_at = Carbon::now();
        $event->user->save();
    }
}

<?php

namespace App\Listeners\Core;

use App\Core\Core;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Stats
{

    protected $total_users;

    public function __construct()
    {
        $this->total_users = Core::whereName('total_users')->first();
    }

    /**
     * Add 1 to the current total number of users on site
     */
    public function addUser()
    {
        $this->total_users->value++;
        $this->total_users->save();
        $this->updateCache();
    }

    /*
     * Subtract 1 from the total number of users on site
     */
    public function subtractUser()
    {
        $this->total_users->value--;
        $this->total_users->save();
        $this->updateCache();
    }


    /**
     * Update the site's cache after making changes to the stats
     */
    public function updateCache()
    {

        \Cache::rememberForever('total_users', function() {
            return $this->total_users;
        });
    }
}

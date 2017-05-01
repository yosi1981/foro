<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use DateParser;

    /**
     * Check if a page has been updated
     * @return bool
     */
    public function getIsUpdatedAttribute()
    {
        return $this->updated_at != $this->created_at;
    }
}

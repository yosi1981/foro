<?php

namespace App\User;

use App\DateParser;
use Illuminate\Database\Eloquent\Model;

class Banned extends Model
{

    protected $table = 'banned_users';
    protected $dates = ['updated_at', 'expires_at', 'created_at'];
    use DateParser;

    /**
     * A ban belongs to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A banned user has a user who banned the user
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function banner()
    {
        return $this->hasOne(User::class, 'id', 'banned_by_user_id');
    }

    /**
     * Get the banned date
     * @param $date
     * @return string
     */
    public function getExpiresAtAttribute($date)
    {
       return $date . " ({$this->parseDate($date)})";
    }

    /**
     * Get the old primary user ID the user had before they were banned.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function oldPrimaryRole()
    {
        return $this->hasOne(Role::class, 'id', 'old_primary_user_id');
    }


    /**
     * Lift a user's ban
     */
    public function lift()
    {
        $user = $this->user;
        $user->primary_role = $this->oldPrimaryRole->id;
        $user->save();
        $this->delete();
    }
}

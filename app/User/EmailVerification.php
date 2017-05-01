<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{

    protected $fillable = ['token', 'email'];

    /**
     * An email verification record belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

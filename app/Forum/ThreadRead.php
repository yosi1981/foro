<?php

namespace App\Forum;

use App\User\User;
use Illuminate\Database\Eloquent\Model;

class ThreadRead extends Model {

    protected $table = 'forum_threads_read';
    protected $fillable = ['user_id', 'thread_id'];

    /**
     * A thread is read by a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The record of a thread being read belongs to a thread
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}

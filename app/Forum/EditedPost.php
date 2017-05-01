<?php

namespace App\Forum;

use App\DateParser;
use App\User\User;
use Illuminate\Database\Eloquent\Model;

class EditedPost extends Model {

    use DateParser;

    protected $table = 'forum_edited_posts';

    /**
     * An edited post record belongs to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * And edit post record belongs to a post
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

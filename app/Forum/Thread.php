<?php

namespace App\Forum;

use App\DateParser;
use App\Events\Forum\ThreadWasEdited;
use App\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thread extends Model {

    use SoftDeletes;
    use DateParser;

    protected $dates = ['deleted_at'];
    protected $table = 'forum_threads';
    protected $fillable = ['title', 'locked', 'locked_by_user_id', 'pinned', 'pinned_by_user_id', 'first_post_id', 'total_posts'];

    /**
     * A thread belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A thread belongs to a forum
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    /**
     * A thread has many read threads as it has been read by many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function readThreads()
    {
        return $this->hasMany(ThreadRead::class);
    }

    /**
     * Check to see if a thread has been read by a specific user
     *
     * @param $user
     * @return mixed
     */
    public function hasBeenReadBy($user)
    {
        return $this->readThreads->where('user_id', $user->id)->first();
    }

    /**
     * Get the last post of a thread - relationship so it can be eager loaded to reduce the # of queries
     *
     * @return mixed
     */
    public function lastPost()
    {
        if (user() && (user()->can('forum-moderate-junked-post') || user()->can('forum-moderate-junked-thread'))) {
            return $this->hasOne(Post::class)->orderBy('id', 'desc')->with('user')->withTrashed();
        }
        return $this->hasOne(Post::class)->orderBy('id', 'desc')->with('user');
    }

    /**
     * A thread has one first post - Get the first post of a thread
     *
     * @return mixed
     */
    public function firstPost()
    {
        return $this->hasOne(Post::class, 'id', 'first_post_id')->withTrashed();
    }

    /**
     * A thread is locked by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lockedByUser()
    {
        return $this->hasOne(User::class, 'id', 'locked_by_user_id');
    }

    /**
     * Check if thread is hard-locked (cannot be unlocked unless user can unlock hard-locked threads)
     *
     * @return mixed
     */
    public function hardLocked()
    {
        if ($this->locked) {
            return $this->lockedByUser->can('forum-moderate-hard-lock-thread');
        }
    }

    /**
     * A thread is pinned by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pinnedByUser()
    {
        return $this->hasOne(User::class, 'id', 'pinned_by_user_id');
    }

    /**
     * Check if thread is hard-pinned (cannot be unpinned unless user can unpin hard-pinned threads)
     *
     * @return mixed
     */
    public function hardPinned()
    {
        return $this->pinned ? $this->pinnedByUser->can('forum-moderate-hard-pin-thread') : false;
    }

    /**
     * A thread has many posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        if (user() && (user()->can('forum-moderate-junked-post') || user()->can('forum-moderate-junked-thread'))) {
            return $this->hasMany(Post::class)->withTrashed();
        }

        return $this->hasMany(Post::class);
    }


    /**
     * Create a new thread
     *
     * @param $request
     * @return Thread
     */
    public static function createThread($request)
    {
        $thread = new Thread;
        $thread->forum_id = $request->input('forum');
        $thread->user_id = user()->id;
        $thread->title = $request->input('title');
        $thread->save();
        return $thread;
    }

    /**
     * Lock a thread
     *
     * @param bool $lock
     * @return bool|int
     */
    public function lock($lock = true)
    {
        $this->timestamps = false;
        $user_id = $lock ? user()->id : false;
        return $this->update(['locked' => $lock, 'locked_by_user_id' => $user_id]);
    }

    /**
     * Unlock a thread
     *
     * @return bool|int
     */
    public function unlock()
    {
        return $this->lock(false);
    }

    /**
     * Pin a thread
     *
     * @param bool $pin
     * @return bool|int
     */
    public function pin($pin = true)
    {
        $this->timestamps = false;
        $user_id = $pin ? user()->id : false;
        return $this->update(['pinned' => $pin, 'pinned_by_user_id' => $user_id]);
    }

    /**
     * Unpin a thread
     *
     * @return bool|int
     */
    public function unpin()
    {
        return $this->pin(false);
    }

    /**
     * Get the total number of post a thread has minus 1; the owner's first post does not count.
     *
     * @return mixed
     */
    public function totalPosts()
    {
        return $this->posts()->count() - 1;
    }

    /**
     * Mark a thread as read
     */
    public function markAsRead()
    {
        if (user()) {
            ThreadRead::firstOrCreate(['user_id' => user()->id, 'thread_id' => $this->id]);
        }
    }

    /**
     * Mark a thread as unread
     */
    public function markAsUnread()
    {
        if (user()) {
            ThreadRead::where('user_id', '!=', user()->id)->where('thread_id', $this->id)->delete();
        }
    }

    /**
     * Determine the icon of a thread
     *
     * @return mixed
     */
    public function icon()
    {
        if ($this->locked && $this->pinned) {
            $image = site('forum-thread-icon-locked-pinned');
        } elseif ($this->locked) {
            $image = site('forum-thread-icon-locked');
        } elseif ($this->pinned) {
            $image = site('forum-thread-icon-pinned');
        } else {
            $image = site('forum-thread-icon');
        }
        return url($image);
    }


    /**
     * Update the thread title
     *
     * @param $request
     */
    public function updateTitle($request)
    {
        if (user()->can('editThread', $this)) {
            $this->timestamps = false;
            $this->title = $request->input('title');
            $this->save();

            event(new ThreadWasEdited);
        }
    }

    /**
     * Get the URL of a thread
     *
     * @return string
     */
    public function threadURL()
    {
        return route('forum.thread', [$this->id, str_slug($this->title)]);
    }

    /**
     * Return if thread is older than the set number of days to mark the thread as read
     *
     * @return bool
     */
    public function canMarkAsRead()
    {
        if (!site('forum-mark-thread-as-read')) {
            return false;
        }
        $date = $this->getOriginal('created_at');
        $old_days = Carbon::now()->subDays(site('forum-mark-thread-as-read-max-days'));
        return $date > $old_days;
    }
}

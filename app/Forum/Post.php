<?php

namespace App\Forum;

use App\User\User;
use App\DateParser;
use App\Http\Requests\Request;
use App\Events\Forum\PostWasCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

    use SoftDeletes;
    use DateParser;

    protected $table = 'forum_posts';
    protected $fillable = ['message', 'signature'];
    protected $dates = ['deleted_at'];

    /**
     * A post belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A post belongs to a thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        if (user() && user()->can('forum-moderate-junked-thread')) {
            return $this->belongsTo(Thread::class)->withTrashed();
        }
        return $this->belongsTo(Thread::class);
    }

    /**
     * A post can have many edits (can be edited by many users if they have permission to edit others' post AND can be
     * edited many times)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function edits()
    {
        return $this->hasMany(EditedPost::class);
    }

    /**
     * The last edit of a post relationship
     *
     * @return mixed
     */
    public function lastEdit()
    {
        return $this->hasOne(EditedPost::class)->orderBy('created_at', 'desc')->with('user');
    }

    /**
     * A post has many reports
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(ReportedPost::class);
    }

    /**
     * Check if a post has been reported by a specific user
     *
     * @param $user
     * @return bool
     */
    public function hasBeenReportedByUser($user)
    {
        return !!$this->reports()->where('user_id', $user->id)->first();
    }


    /**
     * Check if the post has already been reported
     *
     * @return bool
     */
    public function hasBeenReported()
    {
        return !!!$this->reports->isEmpty() && !site('forum-report-post-more-than-once');
    }

    /**
     * Check if post is the first post of a thread
     *
     * @return bool
     */
    public function isFirstPost()
    {
        return $this->thread->first_post_id === $this->id;
    }

    /**
     * Create a new post and save to database
     *
     * @param Thread  $thread
     * @param Request $request
     * @return Post
     */
    public static function addPost(Thread $thread, Request $request)
    {

        $post = new Post;
        $post->thread_id = $thread->id;
        $post->user_id = user()->id;
        $post->message = $request->input('message');
        $post->updateSignature($request);
        $post->save();

        event(new PostWasCreated($post));

        $thread->touch();

        // Lock/Pin thread
        if (user()->can('pin', $thread)) {
            $request->input('pin') ? $thread->pin() : $thread->unpin();
        }
        if (user()->can('lock', $thread)) {
            $request->input('lock') ? $thread->lock() : $thread->unlock();
        }

        return $post;
    }

    /**
     * Change post's signature
     *
     * @param Request $request
     */
    public function updateSignature(Request $request)
    {
        if (user()->can('forum-use-signature') && $request->input('signature')) {
            $this->signature = 1;
        } else {
            $this->signature = 0;
        }
    }

    /**
     * Update a post
     *
     * @param $request
     */
    public function updatePost($request)
    {
        $this->message = $request->input('message');
        $this->updateSignature($request);
        $this->save();
    }


    /**
     * Find page in which the post is located in.
     * In a paginated result or posts, a post can be in any page of the posts.
     * This function figures out which page the post is on in pagination
     *
     * @return float
     */
    public function findPage()
    {
        $counter = 0;
        foreach ($this->thread->posts as $post) {
            $counter++;
            if ($post->id == $this->id) break;
        }
        return ceil($counter / perPage('posts'));
    }

    /**
     * Build the complete URL (find what page the post is in and everything)
     *
     * @return string
     */
    public function buildURL()
    {
        return $this->thread->threadURL() . "?page={$this->findPage()}" . "#post-$this->id";
    }

    /**
     * Simply generate the Post URL (do not apply any logic)
     */
    public function postURL()
    {
        //return route('forum.thread', $this->thread->id) . '/asdf';
        return $this->thread->threadURL() . "?post={$this->id}#post-{$this->id}";
    }

    /**
     * The order number of a specific post in a thread.
     * All posts are arranged numerically.
     * For example: Post #1, Post #2, Post #2
     *
     * @param $posts
     * @param $key
     * @return mixed
     */
    public function orderNumber($posts, $key)
    {
        return (($posts->currentPage() - 1) * $posts->perPage()) + $key + 1;
    }

}

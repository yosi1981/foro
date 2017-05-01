<?php

namespace App\Forum;

use App\User\User;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model {

    use NodeTrait;
    protected $table = 'forum_forums';
    protected $fillable = ['name', 'description', 'total_threads', 'total_posts', 'last_post_user_id', 'last_post_id', 'order'];

    /**
     * A forum has many threads
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        if (user() && user()->can('forum-moderate-junked-thread')) {
            return $this->hasMany(Thread::class)->withTrashed();
        }
        return $this->hasMany(Thread::class);
    }

    /**
     * Get the rules attribute
     *
     * @param $rules
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function getRulesTitleAttribute($rules)
    {
        if (isset($rules) && $rules != '') {
            return $rules;
        }
        return trans('forum.rules.label');
    }

    /**
     * Check if a forum has rules
     *
     * @param null $place
     * @return bool
     */
    public function hasRules($place = null)
    {
        $config = $place == 'create' ? 'forum-rules-show-while-creating-post' : 'forum-rules-show-index';
        return $this->enable_rules && site($config);
    }

    /**
     * Check if a forum has a subforum
     *
     * @return bool
     */
    public function hasChildren()
    {
        return $this->children->isEmpty() ? false : true;
    }

    /**
     * Check if a forum has threads
     *
     * @return bool
     */
    public function hasThreads()
    {
        return $this->threads->isEmpty() ? false : true;
    }

    /**
     * Return all normal, non-pinned threads in a forum
     *
     * @return mixed
     */
    public function latestThreads()
    {
        return $this->threads()->with('lastPost.thread', 'user', 'readThreads')->orderBy('pinned', 'desc')->orderBy('updated_at', 'desc')->paginate(perPage('threads'));
    }

    /**
     * Return all forum stats like total posts and threads.
     *
     * @return string
     */
    public function stats()
    {
        $threads = $this->total_threads;
        $posts = $this->total_posts;
        return sprintf("$threads %s – $posts %s", trans_choice('forum.thread.label', $threads), trans_choice('forum.post.label', $posts));
    }


    /**
     * Get the last thread in any given forum
     * If it has subforums and one of the subforums has a latest thread, it will return that one
     *
     * @return mixed
     */
    public function lastPost()
    {
        return $this->hasOne(Post::class, 'id', 'last_post_id')->with('thread');
    }

    /**
     * A forum has one last thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastThread()
    {
        return $this->hasOne(Thread::class, 'id', 'last_thread_id');
    }

    /**
     * A forum has one user who created the last post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastPostUser()
    {
        return $this->hasOne(User::class, 'id', 'last_post_user_id');
    }

    /**
     * Get the last thread by actually getting it from database, instead of using a column name like lastThread()
     *
     * @return mixed
     */
    public function rawLastThread()
    {
        $forums = $this->descendants->lists('id');
        $forums[] = $this->getKey();
        return Thread::whereIn('forum_id', $forums)->orderBy('updated_at', 'desc')->first();
    }

    /**
     * Scope to eager-load their children, last post, last post user and the last thread
     *
     * @param $query
     * @return mixed
     */
    public function scopeSubforums($query)
    {
        return $query->with('children', 'lastPost', 'lastPostUser', 'lastThread');
    }

    /**
     * Return the forum URL.
     * You can parse it however you wish. All URL's that link to a specific forum are generated using this method
     *
     * @return string
     */
    public function forumURL()
    {
        return route('forum.home', ['forum' => $this->id]);
    }


    /**
     * Save a forum to database (used by both create and update forum in admin panel)
     * @param $request
     */
    public function saveForum($request)
    {
        $this->name = $request->input('name');
        $this->description = $request->input('description');
        $this->enable_rules = $request->input('enable_rules');
        $this->rules_title = $request->input('rules_title');
        $this->rules_description = $request->input('rules_description');
        $this->allow_new_threads = $request->input('allow_new_threads');
        $this->closed = $request->input('closed');
        $this->parent_id = $request->input('parent_forum');
    }
}

<?php

namespace App\Listeners\Forum;

use App\Events\Forum\ThreadWasCreated;
use App\Forum\Thread;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/*
 * This class updates the total thread/post count that is saved in each forum record in database.
 * Everything a thread/post has been created/updated, it recounts all threads/posts in that specific forum.
 * It also counts all posts in a thread for faster performance and to reduce the number of queries that take place.
 */
class UpdateTotalCount {

    public $event;
    /**
     * Count all threads
     *
     * @param $event
     */
    public function handleTotalThreadCount($event)
    {
        $this->event = $event;
        $ancestors = $this->ancestors();
        foreach ($ancestors as $ancestor) {
            $this->updateLastPostInfo($ancestor);
            $forums = $this->forums($ancestor);
            $count = Thread::whereIn('forum_id', $forums)->count();
            $ancestor->total_threads = $count;
            $ancestor->save();
        }
    }

    /**
     * Handle the post total method and add/subtract 1 from forums/thread
     *
     * @param $event
     * @return int
     */
    public function handleTotalPostCount($event)
    {
        $this->event = $event;
        $ancestors = $this->ancestors();
        foreach ($ancestors as $ancestor) {
            $this->updateLastPostInfo($ancestor);
            $forums = $this->forums($ancestor);
            $threads = Thread::whereIn('forum_id', $forums)->with('posts')->get();
            $posts = 0;
            foreach ($threads as $thread) {
                $total_posts = $thread->posts()->whereNull('deleted_at')->count();
                $posts += $total_posts;
                $thread->update(['total_posts' => $total_posts]);
            }
            $ancestor->update(['total_posts' => $posts]);
        }
    }

    /**
     * Get all ancestor forums and self
     * @return mixed
     */
    public function ancestors()
    {
        $ancestors = $this->event->thread->forum->ancestors()->get();
        return $ancestors->merge([$this->event->thread->forum]);
    }
    /**
     * Get all forums in ancestor forums
     * @param $ancestor
     * @return array
     */
    public function forums($ancestor)
    {
        $forums = $ancestor->descendants->lists('id');
        $forums[] = $ancestor->getKey();
        return $forums;
    }

    /**
     * Update the last post information:
     * - Last post user's ID
     * - Last post ID
     * - Last thread ID
     *
     * @param $ancestor
     */
    public function updateLastPostInfo($ancestor)
    {
        if ($ancestor->rawLastThread()) {
            $lastPost = $ancestor->rawLastThread()->lastPost;
            if ($lastPost) {
                $ancestor->last_post_id = $lastPost->id;
                $ancestor->last_post_user_id = $lastPost->user_id;
                $ancestor->last_thread_id = $ancestor->rawLastThread()->id;
            }
        }
    }
}

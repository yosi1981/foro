<?php

namespace App\Http\Controllers\Forum;

use App\Core\MassActions;
use App\Events\Forum\ThreadWasCreated;
use App\Events\Forum\ThreadWasDeleted;
use App\Events\Forum\ThreadWasJunked;
use App\Events\Forum\ThreadWasRestored;
use App\Exceptions\ThreadDoesNotExistException;
use App\Forum\Post;
use App\Forum\Forum;
use App\Forum\Thread;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Events\Forum\ThreadWasRead;
use App\Http\Controllers\Controller;

class ThreadController extends Controller {

    use MassActions;


    /**
     * Show a thread
     *
     * @param Thread  $thread
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws ThreadDoesNotExistException
     */
    public function show(Thread $thread, Request $request)
    {
        // If the first post is trashed while the thread is not trashed, restore the first post...
        if ($thread->firstPost->trashed() && !$thread->trashed()) {
            $thread->firstPost()->restore();
        }

        // If user is not guest & guests cannot read thread, ensure that the current logged in use can.
        if (auth()->guest()) {
            if (!site('forum-guests-can-read-threads') || $thread->trashed()) {
                throw new ThreadDoesNotExistException;
            }
        } else {
            // If user is logged in, authorize the thread and ensure that they can see it
            $this->authorize($thread);
        }

        // If input has post and page, find the page for the post
        if ($request->input('post') && !$request->input('page')) {
            return $this->findPageForPost($request->input('post'));
        }

        // Load up the posts
        $posts = $thread->posts()->with('user', 'thread', 'lastEdit')->paginate(perPage('posts'));

        // If user is logged in, then show them the appropriate flash messages and mark the thread as read
        if (user()) {
            if ($thread->trashed()) {
                flash()->overlay(trans('mod.thread.junked'), 'danger');
            }
            if ($request->user() && $thread->canMarkAsRead()) {
                event(new ThreadWasRead($thread));
            }
        }

        // Finally, show the thread
        return view('forum.thread.show', compact('thread', 'posts'));
    }

    /**
     * Show the "Create New Thread" form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreateForm(Request $request)
    {
        $forum = Forum::findorFail($request->input('forum'));
        $this->authorize('createThread', $forum);
        return view('forum.thread.create', compact('forum'));
    }

    /**
     * Store the new thread in database
     *
     * @param Requests\Forum\NewThreadRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Requests\Forum\NewThreadRequest $request)
    {

        $thread = Thread::createThread($request);
        $post = Post::addPost($thread, $request);

        $thread->update(['first_post_id' => $post->id]);

        event(new ThreadWasCreated($thread));

        if ($request->ajax()) {
            return response()->json(['redirect' => $thread->threadURL()]);
        }
        return redirect($thread->threadURL());
    }

    /**
     * Lock one or more threads.
     *
     * @param Thread $thread
     * @return bool
     */
    public function lock(Thread $thread)
    {
        $this->authorize($thread);
        return $thread->lock();
    }

    /**
     * Unlock one or more threads.
     *
     * @param $thread
     * @return boolean
     */
    public function unlock(Thread $thread)
    {
        $this->authorize('lock', $thread);
        return $thread->unlock();
    }


    /**
     * Pin one or more threads
     *
     * @param Thread $thread
     * @return bool|int
     */
    public function pin(Thread $thread)
    {
        $this->authorize($thread);
        return $thread->pin();
    }

    /**
     * Unpin one or more threads
     *
     * @param Thread $thread
     * @return bool|int
     */
    public function unpin(Thread $thread)
    {
        $this->authorize('pin', $thread);
        return $thread->unpin();
    }

    /**
     * Moderator actions that can be accessed by users with appropriate permission.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actions(Request $request)
    {
        $this->massActions($this, Thread::class, $request);
        return redirect()->back();
    }

    /**
     * Junk (soft delete) a thread
     *
     * @param Thread $thread
     * @return bool|null
     * @throws \Exception
     */
    public function junk(Thread $thread)
    {
        $this->authorize('junkThread', $thread);
        event(new ThreadWasJunked($thread));
        return $thread->delete();
    }

    /**
     * Restore a junked thread
     *
     * @param Thread $thread
     * @return mixed
     */
    public function restore(Thread $thread)
    {
        $this->authorize('restoreJunkedThread', $thread);
        event(new ThreadWasRestored($thread));
        return $thread->restore();
    }

    /**
     * Permanently delete a thread
     *
     * @param Thread $thread
     * @return bool|null
     */
    public function delete(Thread $thread)
    {
        $this->authorize('deleteThread', $thread);
        event(new ThreadWasDeleted($thread));
        return $thread->forceDelete();
    }


    /**
     * Find the page in which the thread belongs to
     *
     * @param $post_id
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function findPageForPost($post_id)
    {
        $post = Post::find($post_id);
        if (!$post) {
            return false;
        }
        return redirect($post->buildURL());
    }

}
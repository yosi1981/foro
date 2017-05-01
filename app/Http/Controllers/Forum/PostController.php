<?php

namespace App\Http\Controllers\Forum;

use App\Core\MassActions;
use App\Events\Forum\PostWasDeleted;
use App\Events\Forum\PostWasEdited;
use App\Events\Forum\PostWasJunked;
use App\Events\Forum\PostWasRestored;
use App\Forum\Post;
use App\Forum\Thread;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostController extends Controller {

    use MassActions;

    /**
     * Show the reply form (Full Editor) to reply to a thread
     *
     * @param Thread  $thread
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReplyForm(Thread $thread, Request $request)
    {
        $this->authorize('postReply', $thread);
        $quotePost = Post::where('id', $request->input('quote'))->first();
        if ($quotePost) {
            $quote = sprintf('[quote="%s"]%s[/quote]', $quotePost->user->info, $quotePost->message);
        }
        return view('forum.post.reply', compact('thread', 'quote'));
    }

    /**
     * Save the reply to database and redirect user back to their post on thread.
     *
     * @param                                 $thread
     * @param Requests\Forum\PostReplyRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Thread $thread, Requests\Forum\PostReplyRequest $request)
    {
        $post = Post::addPost($thread, $request);
        return redirect($post->postURL());
    }


    /**
     * Show the edit form to edit a thread/post
     *
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditForm(Post $post)
    {
        $this->authorize('editPost', $post);
        return view('forum.post.edit', compact('post'));
    }


    /**
     * Update a post or a thread (if the thread is a first post, update the title of the thread also)
     *
     * @param Post                           $post
     * @param Requests\Forum\EditPostRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Post $post, Requests\Forum\EditPostRequest $request)
    {
        if ($post->isFirstPost()) {
            $post->thread->updateTitle($request);
        }
        $post->updatePost($request);
        event(new PostWasEdited($post, $request));

        if ($request->ajax()) {
            return response()->json(['redirect' => $post->postURL()]);
        }

        return redirect($post->postURL());
    }

    /**
     * Junk (soft delete) a post
     *
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function junk(Post $post)
    {
        $this->authorize('junkPost', $post);
        $post->delete();
        event(new PostWasJunked($post));
        return redirect()->back();
    }

    /**
     * Permanently delete a post
     *
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Post $post)
    {
        $this->authorize('deletePost', $post);
        $post->forceDelete();
        event(new PostWasDeleted($post));
        return redirect()->back();
    }

    /**
     * Restore a junked post
     *
     * @param Post $post
     * @return bool|null
     */
    public function restore(Post $post)
    {
        $this->authorize('restorePost', $post);
        $post->restore();
        return event(new PostWasRestored($post));
    }

    /**
     * Hide signature in a post
     *
     * @param Post $post
     * @return bool|int
     */
    public function hideSignature(Post $post)
    {
        $this->authorize('forum-moderate-thread');
        return $post->update(['signature' => false]);
    }

    /**
     * Show signature in a post
     *
     * @param Post $post
     * @return bool|int
     */
    public function showSignature(Post $post)
    {
        $this->authorize('forum-moderate-thread');
        return $post->update(['signature' => true]);
    }

    /**
     * Inline moderation actions that can be accessed by users with appropriate permission.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actions(Request $request)
    {
        $this->massActions($this, Post::class, $request);
        return redirect()->back();
    }

}

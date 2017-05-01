<?php

namespace App\Exceptions;

use App\Exceptions\ThreadDoesNotExistException;
use App\Forum\Forum;
use App\Forum\Post;
use App\Forum\ReportedPost;
use App\Forum\Thread;
use App\User\EmailVerification;
use App\User\User;
use Exception;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // If the thread does not exist, redirect to forum homepage.
        if ($e instanceof ThreadDoesNotExistException) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('forum.thread.not_found')], 404);
            }
            abort(404, trans('forum.thread.not_found'));
        }
        //if ($e instanceof )
        if ($e instanceof ModelNotFoundException) {
            if ($e->getModel() == Post::class) {
                if ($request->ajax()) {
                    return response()->json(['error' => trans('forum.post.not_found')], 404);
                }
                abort(404, trans('forum.post.not_found'));
            }
            if ($e->getModel() == ReportedPost::class) {
                abort(404, trans('mod.report.not_found'));
            }
            if ($e->getModel() == Thread::class) {
                abort(404, trans('forum.thread.not_found'));
            }
            if ($e->getModel() == User::class) {
                if ($request->ajax()) {
                    return response()->json(['error' => trans('user.not_found')], 404);
                }
               abort(404, trans('user.not_found'));
            }
            if ($e->getModel() == Forum::class) {
                if ($request->ajax()) {
                    return response()->json(['error' => trans('forum.not_found')], 404);
                }
              abort(404, trans('forum.not_found'));
            }
            if ($e->getModel() == EmailVerification::class) {
                return redirect(route('auth.login'))->withErrors(trans('user.register.incorrect_token'));
            }
            if ($request->server("HTTP_REFERER")) {
                return back();
            }
        }

        if ($e instanceof ForumDoesNotExistException) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('forum.not_found')]);
            }
            abort(404, trans('forum.not_found'));
        }

        if ($e instanceof TokenMismatchException) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('site.errors.csrf_token_expired')]);
            }
            abort(500, trans('site.errors.csrf_token_expired'));
        }

        return parent::render($request, $e);
    }
}

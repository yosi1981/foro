<div class="list-group-item {{ !$thread->trashed() ?:  'list-group-item-danger'  }}">
    <div class="row">
        <div class="col-xs-11 col-sm-9">
            <div class="media">
                <div class="media-left padding-right-0">
                    <div class="{{ $signed_in && $user->canModerateThread($thread) ? 'thread-icons-mod' : 'thread-icons' }} padding-top-5">
                        @if ($signed_in && $user->canModerateThread($thread))
                            <div class="col-xs-1 margin-right-15 padding-0 padding-top-5">
                                <input title="select" class="mod-checkbox-select-result" name="thread[{{ $thread->id }}]" value="{{ $thread->id }}" type="checkbox">
                            </div>
                        @endif
                        <div>
                            @include('forum.includes.partials.thread_icon')
                        </div>
                    </div>
                </div>
                <div class="media-body">
                    <i class="fa fa-bar-chart visible-xs pull-right" data-toggle="tooltip" data-placement="left" title="{{ $thread->total_posts }} {{ trans_choice('forum.thread.reply.label', $thread->total_posts) }} "></i>
                    <a class="@if ($signed_in && $thread->canMarkAsRead()) {{ $thread->hasBeenReadBy($user) ?: 'bold' }}  @endif" href="{{ $thread->threadURL() }}">{{ $thread->title }}</a>
                    <div class="small text-muted">
                        <a href="{{ $thread->user->profileURL() }}">
                            <span class="text-muted"> {{ trans('site.created.by') }}  </span>
                            {{ $thread->user->info }}
                        </a>
                        – {{ $thread->created_at }}
                        @if ($thread->trashed())
                            <br>  {{ trans('mod.junked') .' '. $thread->deleted_at }}
                        @endif
                        <div class="visible-xs">
                            @include('forum.includes.partials.forum_last_post_user')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden-xs col-sm-1 text-center overflow-ellipsis">
            <a href="{{ $thread->threadURL() }}"> {{ $thread->total_posts }}</a>
        </div>
        <div class="forum-last-post-info text-right col-sm-2  hidden-xs overflow-ellipsis">
            <small>
                @include('forum.includes.partials.forum_last_post_user')
            </small>
        </div>
    </div>
</div>
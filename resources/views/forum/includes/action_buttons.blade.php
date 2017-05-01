@if ($signed_in && ($user->canModeratePost() || $user->canModerateThread($thread)))
    <div class="padding-bottom-20">
        <div class="row margin-0">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if ($user->canModeratePost())
                        <div class="col-md-5 col-xs-12 col-sm-12">
                            <span class="text-muted">{{ trans('mod.post.with_selected') }}</span>
                            @include('forum.includes.partials.action_post')
                        </div>
                    @endif
                    @if ($user->canModerateThread($thread))
                        <div class="col-md-5 col-xs-12 pull-right col-sm-12">
                            <span class="text-muted">{{ trans('mod.thread.with_thread') }}</span>
                            @include('forum.includes.partials.action_thread')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
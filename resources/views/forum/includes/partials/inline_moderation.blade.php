{{--Moderation Options--}}
@if ($user && $user->canModerateThread($thread))
    <div class="panel panel-body">
        <div class="col-sm-6">
            <span class="text-muted">{{ trans('mod.thread.with_selected') }}</span>
            <form method="POST" action="{{ route('forum.actions') }}">

                {!! csrf_field() !!}

                {{-- Hidden field--}}
                <input type="hidden" class="mod-selected-results" name="model-input" value="">

                {{--Thread Moderation Options--}}
                <div class="col-xs-7 col-sm-8 padding-0 margin-0">
                    @include('forum.includes.partials.action_thread_options')
                </div>

                {{-- Thread Proceed Button --}}
                <div class="col-xs-4 col-sm-3 padding-0 margin-right-5">
                    @include('forum.includes.partials.proceed_button')
                </div>
            </form>
        </div>
        <div class="col-sm-6 text-right">
            {!! $threads->appends(['forum' => @$forum->id])->render() !!}
        </div>
    </div>
@endif

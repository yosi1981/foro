<div class="box box-solid">
    {!! csrf_field() !!}
    <div class="box-header with-border">
        <h3 class="box-title">{{ $title }}</h3>
    </div>
    <div class="box-body">

        @include('errors.alert')

        @if (!isset($thread) && !isset($post))
            @include('forum.includes.rules')
        @endif

        <span class="help-block">
            {{ trans('user.username.label') }}: {{ $user->info }}
            (<a href="{{ url('logout') }}">{{ trans('site.logout')  }}</a>)
        </span>

        @if ((!isset($post) || $post->isFirstPost()) && !isset($thread) )
            <div class="form-group">
                <input value="{{ old('title', isset($post->thread->title) ? $post->thread->title : null) }}" name="title" id="title" placeholder="{{ trans('forum.thread.title') }}" type="text" class="form-control"/>
            </div>
        @endif

        <textarea rows="20" name="message" id="bb_editor" placeholder="{{ trans('forum.thread.message') }}">@if (isset($quote)){{ $quote }}@endif{{ old('message', isset($post->message) ? $post->message : '' ) }}</textarea>

        {{-- Thread and Moderation Options --}}
        @if ($user->canUseReplyOptions())
            <div class="row padding-left-10 padding-top-10">
                @can('forum-use-signature')
                    <div class="col-sm-6">
                        <span class="help-block">{{ trans('site.options') }}</span>
                        @include('forum.includes.partials.signature_checkbox')
                    </div>
                @endcan
                @if (!isset($post))
                    @can('forum-moderate-thread')
                    <div class="col-sm-6">
                        <span class="help-block">{{ trans('mod.options') }}</span>
                        @include('forum.includes.partials.lock_checkbox')
                        @include('forum.includes.partials.pin_checkbox')
                    </div>
                    @endcan
                @endif
            </div>
        @endif
    </div>
    <div class="box-footer">
        <div class="text-center">
            <button type="submit" class="btn btn-default"><i class="fa fa-check"></i> {{ $button }}</button>
        </div>
    </div>
</div>
@include('includes.bb_editor')
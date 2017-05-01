<form method="post" action="{{ route('forum.reply', $thread->id) }}">
    {!! csrf_field() !!}
    <div class="alert-field"></div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-9">
                <span class="help-block">{{ trans('forum.thread.reply.to_thread') }}</span>
                <textarea title="{{ trans('forum.thread.reply.to_thread') }}" name="message" rows="10" id="bb_editor"></textarea>
            </div>
            <div class="col-md-3">

                <span class="help-block">{{ trans('site.bbcode_supported') }}</span>

                @if ($user->canUseReplyOptions())
                    <div class="well">

                        {{-- Signature Option--}}
                        @can('forum-use-signature')
                            <span class="help-block">{{ trans('site.options') }}</span>
                            @include('forum.includes.partials.signature_checkbox')
                        @endcan
                        {{--  Forum Moderate option--}}
                        @can('forum-moderate-thread')
                            <span class="help-block">{{ trans('mod.options') }}</span>
                            @include('forum.includes.partials.lock_checkbox')
                            @include('forum.includes.partials.pin_checkbox')
                        @endcan
                    </div>
                @endif
                    <span class="help-block text-right">
                        <a href="{{ route('forum.reply', $thread->id) }}" class="btn btn-default">{{ trans('forum.full_editor') }}</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i>  {{ trans_choice('forum.thread.reply.label', 1) }}</button>
                </span>
            </div>
        </div>
    </div>
</form>

@include('includes.bb_editor')
{{--@push('scripts')--}}
{{--<script>--}}
{{--            $(data.responseText).hide().insertBefore('#shit').slideDown();
--}}
    {{--$('#shit').submit(function (e) {--}}
        {{--var alertElement = $('.alert-field');--}}
         {{--ajaxRequest($(this), alertElement, e);--}}
    {{--});--}}

{{--</script>--}}
{{--@endpush--}}
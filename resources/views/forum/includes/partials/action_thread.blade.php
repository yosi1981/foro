<form method="POST" class="form-horizontal" action="{{ route('forum.actions') }}">

    {!! csrf_field() !!}
    <input type="hidden" name="model-input" value="{{ $thread->id }}">

    {{--
    SELECT input field.
    DO NOT CHANGE THE VALUE OF OPTIONS WITHOUT APPLYING THE SAME CHANGES TO THE METHOD IN Forum\ThreadController.php
    --}}
    <div class="col-xs-9 padding-0 margin-0">
        @include('forum.includes.partials.action_thread_options')
    </div>

    {{-- Proceed Button --}}
    <div class="btn-group margin-0 padding-left-5 col-xs-3">
        <button type="submit" name="ays-confirm" class="btn btn-default">
            {{ trans('site.proceed')  }}
            <i class="fa fa-angle-right"></i>
        </button>
    </div>
</form>
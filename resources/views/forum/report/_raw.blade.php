{!! csrf_field() !!}

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">{{ trans('forum.report.label') }}</h4>
</div>

<div class="modal-body">

    {{-- Alert --}}
    <div id="report-alert-field"></div>
    @if(isset($message))
        <div class="alert alert-info">{{ $message }}</div>
    @else

        <div class="form-group">
            <span class="help-block">{{ trans('forum.report.give_reason') }}</span>

            {{-- Reasons --}}
            <select class="form-control" title="{{ trans('forum.report.label') }}" name="reason" id="reason-report-post">
                @foreach (\App\Forum\ReportedPost::reasons() as $key => $reason)
                    <option value="{{ $key }}">{{ $reason }}</option>
                @endforeach
            </select>
        </div>

        {{-- If "other" is selected --}}
        <div id="other-selected">
            <textarea class="form-control" name="other_reason" id="other-reason-report" placeholder="{{ trans('forum.report.give_reason') }}" rows="2"></textarea>
        </div>
    @endif
</div>

<div class="modal-footer">
    <button id="cancel-button" type="button" class="btn btn-default" data-dismiss="modal">{{ isset($message) ? trans('site.close') : trans('site.cancel') }}</button>
    @unless (isset($message))
        <button id="report-button" type="submit" class="btn btn-success">
            {{ trans('forum.report.label') }}
        </button>
    @endunless
</div>

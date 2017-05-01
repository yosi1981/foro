<div class="form-group">
    <label class="control-label" for="note">{{ $note_title }}</label>
    <div>
        <textarea rows="3" name="note" id="note" class="form-control">{{ old('note', $note->value) }}</textarea>
        <span class="help-block pull-right">{{ trans('site.updated.last') }} {{ $note->updated_at }}</span>
        <span class="help-block">{{ $note_helper }}</span>
    </div>
</div>
<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ trans('site.save') }}</button>

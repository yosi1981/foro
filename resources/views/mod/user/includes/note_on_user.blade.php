<div class="form-group">
    <label class="col-sm-2 control-label" for="note_on_user">{{ trans('mod.user.note_on_user.label') }}</label>
    <div class="col-sm-10">
        <textarea rows="2" name="note_on_user" id="note_on_user" placeholder="{{ trans('mod.user.note_on_user.label') }}" class="form-control">{{ old('note_on_user', $member->note_on_user) }}</textarea>
        <span class="help-block">{{ trans('mod.user.note_on_user.desc') }}</span>
    </div>
</div>
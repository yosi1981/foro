<div class="form-group">
    <label class="col-sm-2 control-label" for="private_announcement">{{ trans('mod.user.private_announcement.label') }}</label>
    <div class="col-sm-10">
        <textarea rows="2" name="private_announcement" id="private_announcement" placeholder="{{ trans('mod.user.private_announcement.label') }}" class="form-control">{{ old('private_announcement', $member->private_announcement) }}</textarea>
        <span class="help-block">{{ trans('mod.user.private_announcement.desc') }}</span>
    </div>
</div>
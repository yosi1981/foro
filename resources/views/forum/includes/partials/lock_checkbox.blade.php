<div class="checkbox">
    <label>
        <input type="hidden" name="lock" value="0">
        <input name="lock" type="checkbox" value="1" {{ (old('lock') || @$post->thread->locked) ? 'checked' : '' }}>
        {{ trans_choice('mod.thread.lock', 1) }} {{ trans('mod.after_posting') }}
    </label>
</div>
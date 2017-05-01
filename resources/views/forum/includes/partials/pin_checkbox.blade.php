<div class="checkbox">
    <label>
        <input type="hidden" name="pin" value="0">
        <input name="pin" type="checkbox" value="1" {{ (old('pin') || @$post->thread->pinned) ? 'checked' : '' }}>
        {{ trans_choice('mod.thread.pin', 1) }} {{ trans('mod.after_posting') }}
    </label>
</div>
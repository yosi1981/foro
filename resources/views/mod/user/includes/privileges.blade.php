<div class="checkbox">
    <label for="suspend_posts">
        <input type="hidden" name="suspend_posts" value="0">
        <input {{ (old('suspend_posts') || $member->suspend_posts) ? 'checked' : '' }} id="suspend_posts" name="suspend_posts" value="1" type="checkbox">
        {{ trans('mod.user.suspend_posts') }}
    </label>
</div>
<div class="checkbox">
    <label for="suspend_threads">
        <input type="hidden" name="suspend_threads" value="0">
        <input {{ (old('suspend_threads') || $member->suspend_threads) ? 'checked' : '' }} id="suspend_threads" name="suspend_threads" value="1" type="checkbox">
        {{ trans('mod.user.suspend_threads') }}
    </label>
</div>
<div class="checkbox">
    <label for="suspend_signature">
        <input type="hidden" name="suspend_signature" value="0">
        <input {{ (old('suspend_signature') || $member->suspend_signature) ? 'checked' : '' }} id="suspend_signature" name="suspend_signature" value="1" type="checkbox">
        {{ trans('mod.user.suspend_signature') }}
    </label>
</div>
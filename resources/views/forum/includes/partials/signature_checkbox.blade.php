<div class="checkbox">
    <label>
        <input type="hidden" name="signature" value="0">
        <input type="checkbox" name="signature" @unless (isset($post->signature) && !$post->signature) checked="checked" @endunless value="1">
        {{ trans('forum.signature.show') }}
    </label>
</div>
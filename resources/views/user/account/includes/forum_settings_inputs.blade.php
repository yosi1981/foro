@can('editSignature', $member)
    <div class="form-group">
        <label class="col-sm-2 control-label" for="bb_editor">{{ trans('user.signature.label') }}</label>
        <div class="col-sm-10">
            <textarea class="form-control" maxlength="{{ site('signature-max-characters') }}" style="width: 100%" title="{{ trans('user.signature.label') }}" name="signature" rows="2">{{ old('signature', @$member->signature) }}</textarea>
            <span class="help-block">{{ trans('site.bbcode_supported') }}</span>
        </div>
    </div>
@endcan
<div class="form-group">
    <label class="col-sm-2 control-label" for="per_page_threads">{{ trans('site.per_page.threads') }}</label>
    <div class="col-sm-10">
        <select class="form-control" name="per_page_threads" id="per_page_threads">
            @include('includes.api.per_page_items_form', ['label' => trans_choice('forum.thread.label', 2), 'selected' => $member->per_page_threads])
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="per_page_posts">{{ trans('site.per_page.posts') }}</label>
    <div class="col-sm-10">
        <select class="form-control" name="per_page_posts" id="per_page_posts">
            @include('includes.api.per_page_items_form', ['label' => trans_choice('forum.post.label', 2), 'selected' => $member->per_page_posts])
        </select>
    </div>
</div>
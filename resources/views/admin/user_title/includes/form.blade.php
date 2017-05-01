<div class="form-group">
    <label for="title">{{ trans('admin.user.title.form.title') }}</label>
    <input value="{{ old('title', @$title->title) }}" name="title" id="title" placeholder="{{ trans('admin.user.title.form.title') }}" type="text" class="form-control"/>
</div>
<div class="form-group">
    <label for="posts">{{ trans('admin.user.title.form.posts_required') }}</label>
    <input value="{{ old('title', @$title->posts) }}" name="posts" id="posts" placeholder="{{ trans('admin.user.title.form.posts_required') }}" class="form-control"/>
    <span class="help-block">{{ trans('admin.user.title.form.post_required_desc') }}</span>
</div>
<div class="form-group">
    <label for="stars">{{ trans('admin.user.title.form.stars') }}</label>
    <input value="{{ old('stars', @$title->stars) }}" name="stars" id="stars" placeholder="{{ trans('admin.user.title.form.stars') }}" class="form-control"/>
    <span class="help-block">{{ trans('admin.user.title.form.stars_desc') }}</span>
</div>
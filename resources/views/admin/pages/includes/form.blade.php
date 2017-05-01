<div class="form-group">
    <label for="title">{{ trans('admin.pages.name') }}</label>
    <input value="{{ old('title', @$page->title) }}" name="title" id="title" placeholder="{{ trans('admin.pages.name') }}" type="text" class="form-control"/>
</div>
<div class="form-group">
    <label for="slug">{{ trans('admin.pages.slug') }}</label>
    <input value="{{ old('title', @$page->slug) }}" name="slug" id="slug" placeholder="{{ trans('admin.pages.slug') }}" type="text" class="form-control"/>
    <span style="display:none" id="page-preview" class="help-block">{{ trans('admin.pages.slug_helper') }}
        <span>{{ route('pages.show', '') }}/<code id="page-preview-url"></code></span>
    </span>
</div>

<div class="form-group">
    <label for="body">{{ trans('admin.pages.body') }}</label>
    <textarea name="body" id="body">{{ @$page->body }}</textarea>
</div>

@push('scripts')

    <link rel="stylesheet" href="{{ asset('css/dist/summernote.css') }}">
    <script src="{{ asset('js/summernote.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#body').summernote({
                height: 300,
            });

            var previewURL = $('#page-preview-url');
            var slug = $('#slug');
            slug.keyup(function () {
                $('#page-preview').show();
                previewURL.html(slug.val());
            });
        });
    </script>

@endpush
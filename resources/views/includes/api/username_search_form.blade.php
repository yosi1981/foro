<span id="username-search">
    <input type="hidden" id="username-api-url" value="{{ route('api.search.user') }}">
    <input value="{{ Request::input('user') }}" name="username" id="username" placeholder="{{ trans('user.username_id') }}" type="text" class="form-control"/>
    <span id="no-user-found" style="display: none" class="help-block">{{ trans('user.no_results') }}</span>
</span>


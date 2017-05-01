{{--Username field--}}
<div class="form-group">
    <label class="col-sm-2 control-label" for="username">{{ trans('user.username.label') }}</label>
    <div class="col-sm-10">
        @can('editUsername', @$member)
            <input value="{{ old('username', @$member->username) }}" name="username" id="username" placeholder="{{ trans('user.username.desc') }}" type="text" class="form-control"/>
        @else
            <input title="username" class="form-control" type="text" value="{{ @$member->username }}" disabled>
            <span class="help-block">{{ trans('user.username.cannot_change') }}</span>
        @endcan
    </div>
</div>

{{--Email field--}}
<div class="form-group">
    <label class="col-sm-2 control-label" for="email">{{ trans('user.email.label') }}</label>
    <div class="col-sm-10">
        @can('editEmail', @$member)
            <input value="{{ old('email', @$member->email) }}" name="email" id="email" placeholder="{{ trans('user.email.desc') }}" type="email" class="form-control"/>
        @else
            <input title="email" class="form-control" type="text" value="{{ @$member->email }}" disabled>
            <span class="help-block">{{ trans('user.email.cannot_change') }}</span>
        @endcan
    </div>
</div>
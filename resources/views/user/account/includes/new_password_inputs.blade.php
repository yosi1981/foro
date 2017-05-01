{{--New password field--}}
<div class="form-group">
    <label class="col-sm-2 control-label" for="password">{{ trans('user.password.new') }}</label>
    <div class="col-sm-10">
        <input name="password" id="password" placeholder="{{ trans('user.password.new') }}" type="password" class="form-control"/>
    </div>
</div>

{{--Password confirm field--}}
<div class="form-group">
    <label class="col-sm-2 control-label" for="password_confirmation">{{ trans('user.password.confirm') }}</label>
    <div class="col-sm-10">
        <input name="password_confirmation" id="password_confirmation" placeholder="{{ trans('user.password.confirm') }}" type="password" class="form-control"/>
    </div>
</div>
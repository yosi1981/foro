@include('errors.alert')
{{ csrf_field() }}
<div class="form-group">
    <label class="col-md-2 control-label" for="name">{{ trans('site.name') }}</label>
    <div class="col-md-5">
        <input value="{{ old('name', @$permission->name) }}" name="name" id="name" placeholder="{{ trans('site.name') }}" type="text" class="form-control"/>
        <span class="help-block">This is the permission name which must be unique.</span>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label" for="display_name">{{ trans('admin.permission.display_name') }}</label>
    <div class="col-md-5">
        <input value="{{ old('display_name', @$permission->display_name) }}" name="display_name" id="display_name" placeholder="{{ trans('admin.permission.display_name') }}" type="text" class="form-control"/>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label" for="description">{{ trans('site.description') }}</label>
    <div class="col-md-5">
        <textarea rows="2" name="description" id="description" placeholder="{{ trans('site.description') }}" class="form-control">{{ old('description', @$permission->description) }}</textarea>
    </div>
</div>
<hr>
<div class="form-group">
    <label class="col-md-2 control-label" for="order">{{ trans('site.order') }}</label>
    <div class="col-md-5">
        <input value="{{ old('order', @$permission->order) }}" name="order" id="order" placeholder="{{ trans('site.order') }}" type="number" class="form-control"/>
    </div>
</div>

<div class="form-group">
    <label for="permission_parent" class="col-md-2 control-label">{{ trans('admin.permission.parent') }}</label>
    <div class="col-md-5">
        {!! $select_input->name('permission_settings_id')->selected(@$permission->permission_settings_id)->permissionSettings()->get() !!}
        <span class="help-block">
            {{ trans('admin.permission.parent_description') }}
        </span>
    </div>
</div>
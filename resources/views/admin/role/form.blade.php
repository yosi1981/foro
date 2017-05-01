{{ csrf_field() }}
<div class="form-group">
    <label class="col-sm-2 control-label" for="display_name">{{ trans('admin.role.display_name') }}</label>
    <div class="col-sm-8 col-md-4">
        <input value="{{ old('display_name', @$role->display_name) }}" name="display_name" id="display_name" placeholder="{{ trans('admin.role.display_name') }}" type="text" class="form-control"/>
        <span class="help-block">{{ trans('admin.role.display_name_helper') }}</span>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="name">{{ trans('admin.role.name') }}</label>
    <div class="col-sm-8 col-md-4">
        <input value="{{ old('name', @$role->name) }}" name="name" id="name" placeholder="Name" type="text" class="form-control"/>
        <span class="help-block">
            {{ trans('admin.role.name_helper') }}
        </span>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="description">{{ trans('site.description') }}</label>
    <div class="col-sm-8 col-md-4">
        <textarea maxlength="150" name="description" id="description" placeholder="{{ trans('forum.description') }}" class="form-control">{{ old('description', @$role->description) }}</textarea>
    </div>
</div>
<div class="form-group">
    <label for="copy" class="col-sm-2 control-label">
       {{ trans('admin.permission.copy') }}
    </label>
    <div class="col-sm-8 col-md-4">
        {!! $select_input->allowNone()->name('copy_permissions_role')->roles()->get() !!}
        <span class="help-block">{{ trans('admin.permission.copy_description') }}</span>
    </div>
</div>
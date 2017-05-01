<div class="form-group">
    <label class="col-sm-2 control-label" for="primary_role">{{ trans('user.role.primary') }}</label>
    <div class="col-sm-10">
        {!! $select_input->selected(@$member->primary_role)->roles()->name('primary_role')->get() !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="roles">{{ trans('user.role.additional') }}</label>
    <div class="col-sm-10">
        {!! $select_input->selected(@$member->rolesList)->roles()->name('roles')->multiple()->get() !!}
        <span class="help-block">{{ trans('user.role.additional_desc') }}</span>
    </div>
</div>
@extends('layouts.admin')
@section('title', trans('admin.role.edit_permission', ['role' => $role->display_name]))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.role.permission.role.edit', $role) !!}
@stop
@section('content')
    @include('errors.alert')
    <form method="post" action="{{ route('admin.role.permission.role.update', $role->name) }}">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @foreach ($setting_groups as $key => $setting_group)
                    <li {{ $key == 0 ? 'class=active' : '' }}>
                        <a href="#{{ $setting_group->id }}" data-toggle="tab" aria-expanded="false">{{ $setting_group->name }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                {{ csrf_field() }}
                {{ method_field('patch') }}
                @foreach ($setting_groups as $key => $setting_group)
                    <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="{{ $setting_group->id }}">
                        @if ($setting_group->description)
                            <div> {!! $setting_group->description !!}</div>
                        @endif
                        @foreach ($setting_group->subPermissions as $sub_permission)
                            <div class="bold">{{ $sub_permission->name }}</div>
                            <div>
                                @foreach ($sub_permission->settings as $settings)
                                    <div class="checkbox"><label>
                                            <input type="checkbox" @if($role->hasPermission($settings)) checked="checked" @endif value="1" name="permission[{{ $settings->id }}]">
                                            {{ $settings->display_name }}
                                            @if ($settings->description)
                                                <br>
                                                <span class="text-muted">
                                                    {{ $settings->description }}
                                                </span>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="box box-body box-flat text-center">
            <a href="{{ route('admin.role.show', $role->name) }}" class="btn btn-default">
                <i class="fa fa-times"></i> {{ trans('site.cancel') }}</a>
            @include('includes.buttons.save')
        </div>
    </form>

@stop
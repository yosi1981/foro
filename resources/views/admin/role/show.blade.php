@extends('layouts.admin')
@section('title', $role->display_name)
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.role.show', $role) !!}
@stop
@section('box')
    
    @if ($role->system_required)
        <p class="text-danger">
            <b>{{ trans('site.please_note') }}</b> {{ trans('admin.role.system_required_description') }}
        </p>
    @endif
    
    
    
    <div class="row">
        <div class="col-md-6 border-right">
            <p class="lead">{{ trans('site.overview') }}</p>
            <table class="table">
                <tbody>
                <tr>
                    <th width="30%">{{ trans('user.users') }}</th>
                    <td>{{ $role->users->count() }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin.role.system_required') }}</th>
                    <td class="bold">
                        @if ($role->system_required)
                            {{ trans('site.yes') }}
                        @else
                            {{ trans('site.no') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>{{ trans('site.description') }}</th>
                    <td>{{ $role->description == '' ? trans('site.none') : $role->descrition }}</td>
                </tr>
                @unless ($role->system_required)
                    <tr>
                        <th>{{ trans('site.created.at') }}</th>
                        <td>{{ $role->created_at }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('site.updated.at') }}</th>
                        <td>{{ $role->updated_at }}</td>
                    </tr>
                @endunless
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <p class="lead">{{ trans('mod.actions') }}</p>
            <a href="{{ route('admin.role.users', $role->name) }}" class="btn btn-app">
                <i class="fa fa-users"></i>
                {{ trans('user.view_users') }}
            </a>
            <a href="{{ route('admin.role.edit', $role->name) }}" class="btn btn-app">
                <i class="fa fa-shield"></i>
                {{ trans('admin.role.edit') }}
            </a>
            <a href="{{ route('admin.role.permission.role.edit', $role->name) }}" class="btn btn-app">
                <i class="fa fa-circle-o"></i>
                {{ trans_choice('admin.permission.edit', 2) }}
            </a>
            @unless($role->system_required)
                <form action="{{ route('admin.role.destroy', $role->name) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button type="submit" name="ays-confirm" class="btn btn-app">
                        <i class="fa fa-trash"></i>
                        <span class="bold text-danger">
                            {{ trans('admin.role.delete') }}
                        </span>
                    </button>
                </form>
            @endunless
        </div>
    </div>

@stop
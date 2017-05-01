@extends('layouts.admin')
@section('title', trans('admin.permission.title'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.permission.index') !!}
@stop
@section('box')
    @include('errors.alert')
    <a href="{{ route('admin.role.permission.create') }}" class="btn pull-right btn-sm btn-default"><i class="fa fa-plus"></i> {{ trans('admin.permission.add') }}</a>
    <span class="help-block">{{ trans('admin.permission.system_required_cannot_be_edited') }}</span>
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>{{ trans('site.name') }}</th>
            <th>{{ trans('admin.role.display_name') }}</th>
            <th>{{ trans('site.description') }}</th>
            <th>{{ trans('mod.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($permissions as $permission)
            <tr>
                <td width="200px">{{ $permission->name }}</td>
                <td>{{ $permission->display_name }}</td>
                <td width="550px">{{ $permission->description }}</td>
                <td>
                    @if(!$permission->system_required)
                        <div class="dropdown">
                            <a class="dropdown-toggle btn btn-default" data-toggle="dropdown" href="#" aria-expanded="true">
                                {{ trans('site.options') }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ route('admin.role.permission.edit', $permission->id) }}">
                                        {{ trans_choice('admin.permission.edit', 1) }}
                                    </a>
                                </li>
                                <li role="presentation">
                                    <form method="post" action="{{ route('admin.role.permission.destroy', $permission->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button class="s" type="submit" name="ays-confirm" role="menuitem" tabindex="-1" href="{{ route('admin.role.permission.destroy', $permission->id) }}">
                                            {{ trans('site.delete') }}
                                        </button>
                                        <style>
                                            .s {
                                                display: block;
                                                padding: 3px 20px;
                                                clear: both;
                                                font-weight: 400;
                                                line-height: 1.42857143;
                                                background: none;
                                                white-space: nowrap;
                                                outline: none;
                                                color: #333;
                                                border: none;
                                                text-decoration: none;
                                            }
                                            .s:hover {
                                                background-color: #e1e3e9;
                                                color: #333;
                                            }
                                        </style>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
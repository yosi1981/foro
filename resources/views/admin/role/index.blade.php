@extends('layouts.admin')
@section('title', trans('admin.role.index'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.role.index') !!}
@stop
@section('content')
    @include('errors.alert')
    <div class="box box-flat">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin.role.all') }}</h3>
        </div>
        <div class="box-body">
            <table class="table no-margin vertical-align">
                <thead>
                <tr>
                    <th width="75%">{{ trans('admin.role.name') }}</th>
                    <th>{{ trans('user.users') }}</th>
                    <th>{{ trans('mod.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>
                            <a href="{{ route('admin.role.show', $role->name) }}">{{ $role->display_name }}</a>
                            @if ($role->description)
                                <span class="help-block">
                                    {{ $role->description }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $role->users->count() }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="dropdown-toggle btn btn-default" data-toggle="dropdown" href="#" aria-expanded="true">
                                    {{ trans('site.options') }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="{{ route('admin.role.show', $role->name) }}">
                                            {{ trans('admin.role.view') }}
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="{{ route('admin.role.users', $role->name) }}">
                                            {{ trans('user.view_users') }}
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="{{ route('admin.role.permission.role.edit', $role->name) }}">
                                            {{ trans_choice('admin.permission.edit', 2) }}
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="{{ route('admin.role.edit', $role->name) }}">
                                            {{ trans('admin.role.edit') }}
                                        </a>
                                    </li>
                                    @unless($role->system_required)
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation">
                                            <form action="{{ route('admin.role.destroy', $role->name) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button name="ays-confirm" type="submit" role="menuitem" tabindex="-1" href="">
                                                    {{ trans('admin.role.delete') }}
                                                </button>
                                            </form>
                                        </li>
                                    @endunless
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer clearfix">
            <b>{{ trans('site.please_note') }}</b> {{ trans('admin.role.note') }}
        </div>
    </div>
@stop
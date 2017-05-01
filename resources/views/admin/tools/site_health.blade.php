@extends('layouts.admin')
@section('title', trans('admin.tools.health.site'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.tools.site.health') !!}
@stop

@section('box')
    @include('errors.alert')

    <div class="row">
        <div class="col-xs-6">
            <div class="description-block border-right">
                <span class="description-percentage text-green"><i class="fa fa-2x fa-database"></i></span>
                <h5 class="description-header">{{ $database_size }} {{ trans('site.size.mb') }}</h5>
                <span class="description-text">
                    <a href="{{ route('admin.tools.database.rebuild') }}">{{ trans('admin.tools.health.database_size') }}</a>
                </span>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="description-block border-right">
                <span class="description-percentage text-yellow"><i class="fa fa-2x fa-floppy-o"></i></span>
                <h5 class="description-header">{{ $items_cached }}</h5>
                <span class="description-text">
                    <a href="{{ route('admin.tools.cache.manager') }}">{{ trans('admin.tools.health.items_cached') }}</a>
                </span>
            </div>
        </div>
    </div>
    
    <div class="text-center">
        <form method="post" action="{{ route('admin.tools.site.optimize') }}" class="use-ajax">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-fighter-jet"></i>
                {{ trans('admin.tools.health.optimize') }}
            </button>
        </form>
        <form method="post" action="{{ route('admin.tools.site.fix') }}" class="use-ajax">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-wrench"></i>
                {{ trans('admin.tools.health.fix') }}
            </button>
            <span class="help-block">{!! trans('admin.tools.health.fix_desc') !!} </span>
        </form>
    </div>

    <hr>
    <h4>{{ trans('admin.permission.title') }}</h4>
    <div class="margin-top-10">
        <table class="table table-hover">
            <thead>
            <tr>
                <th width="80%">{{ trans('admin.tools.health.directory') }}</th>
                <th>{{ trans('site.current') }}</th>
                <th>{{ trans('site.recommended') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($file_permissions as $permission)
                <tr>
                    <td>{{ $permission['directory'] }}</td>
                    <td>
                        @if ($permission['permission'] == $permission['recommended'])
                            <span class="bold text-success">
                                <i class="fa fa-check-circle"></i>
                                {{ $permission['permission'] }}
                            </span>
                        @else
                            <span class="bold text-danger">
                                <i class="fa fa-times-circle"></i>
                                {{ $permission['permission'] }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $permission['recommended'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
    </div>
@stop
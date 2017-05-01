@extends('layouts.admin')
@section('title', trans('admin.permission.edit_permission', ['permission' => $permission->name]))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.permission.edit', $permission) !!}
@stop
@section('box')
    <form method="POST" class="form-horizontal" action="{{ route('admin.role.permission.update', $permission->id) }}">
        {{ method_field('PATCH') }}
        @include('admin.role.permissions.form')
        <div class="col-md-offset-2">
            @include('includes.buttons.save')
        </div>
    </form>
@stop
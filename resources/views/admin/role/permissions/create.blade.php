@extends('layouts.admin')
@section('title', trans('admin.permission.add'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.permission.create') !!}
@stop
@section('box')
    <form method="POST" class="form-horizontal" action="{{ route('admin.role.permission.store') }}">
        @include('admin.role.permissions.form')
        <div class="col-md-offset-2">
            <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> {{ trans('admin.permission.add') }}</button>
        </div>
    </form>
@stop
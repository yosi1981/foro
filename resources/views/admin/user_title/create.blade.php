@extends('layouts.admin')
@section('title', trans('admin.user.title.new'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('user_title.create') !!}
@stop
@section('box')
    @include('errors.alert')

    <form method="POST" action="{{ route('admin.title.store') }}">
        {{ csrf_field() }}
        <div class="col-md-4">
            @include('admin.user_title.includes.form')
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check"></i> {{ trans('admin.user.title.create') }}
            </button>
        </div>
    </form>
@stop
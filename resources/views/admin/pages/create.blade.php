@extends('layouts.admin')
@section('title', trans('admin.pages.create'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.pages.create') !!}
@stop
@section('box')

    @include('errors.alert')

    <form class="use-ajax" method="POST" action="{{ route('admin.page.store') }}">

        {{ csrf_field() }}

        @include('admin.pages.includes.form')

        <div class="form-group">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-plus"></i>
                {{ trans('admin.pages.create_short') }}
            </button>
        </div>

    </form>
@stop
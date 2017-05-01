@extends('layouts.admin')
@section('title', trans('forum.add'))
@section('breadcrumbs')
        {!! Breadcrumbs::render('admin.forum.create') !!}
@stop
@section('box')
    @include('errors.alert')

    <form id="add-new-forum-form" method="POST" class="form-horizontal use-ajax" action="{{ route('admin.forum.store') }}">
        {{ csrf_field() }}
        @include('admin.forum.form')
        <div class="col-sm-offset-2 col-md-offset-1">
            @include('includes.buttons.save')
        </div>
    </form>

@stop
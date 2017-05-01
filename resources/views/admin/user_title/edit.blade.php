@extends('layouts.admin')
@section('title', $title->title)
@section('breadcrumbs')
    {!! Breadcrumbs::render('user_title.edit', $title) !!}
@stop
@section('box')
    @include('errors.alert')

    <form method="POST" action="{{ route('admin.title.update', $title->id) }}">
        {{ csrf_field() }}
        {{ method_field('patch') }}
        <div class="col-md-4">
            @include('admin.user_title.includes.form')
            @include('includes.buttons.save')
        </div>
    </form>
@stop
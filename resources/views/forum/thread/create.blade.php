@extends('layouts.main')
@section('title', trans('forum.thread.create'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('thread.create', $forum) !!}
@stop

@section('content')
    <form method="POST" action="{{ route('forum.store', ['forum' => $forum->id]) }}">
        @include('forum.includes.form', ['title' => trans('forum.thread.create_in', ['forum' => $forum->name]), 'button' => trans('forum.thread.create')])
    </form>
@stop
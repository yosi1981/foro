@extends('layouts.main')
@section('title', trans('forum.post.edit'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('post.edit', $post) !!}
@stop

@section('content')
    <form method="POST" action="{{ route('forum.edit.post', $post->id) }}">
        <input type="hidden" name="_method" value="PATCH">
        @include('forum.includes.form', ['title' => trans('forum.post.edit_in', ['thread' => $post->thread->title]),'button' => trans('forum.post.edit'),])
    </form>
@stop
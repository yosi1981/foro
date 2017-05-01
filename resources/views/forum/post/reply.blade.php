@extends('layouts.main')
@section('title', trans('forum.thread.reply.to', ['thread' => $thread->title]))

@section('breadcrumbs')
    {!! Breadcrumbs::render('thread.reply', $thread) !!}
@stop

@section('content')
    <form method="post" action="{{ route('forum.reply.post', $thread->id) }}">
        @include('forum.includes.form', ['title' => trans('forum.thread.reply.to', ['thread' => $thread->title]),'button' => trans_choice('forum.thread.reply.label', 1),'forum' => $thread->forum])
    </form>
@stop
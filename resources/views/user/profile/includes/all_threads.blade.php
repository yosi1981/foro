@extends('layouts.main')
@section('title', trans('user.profile.showing_threads', ['member' => $member->info]))
@section('breadcrumbs')
        {!! Breadcrumbs::render('user.profile.all.threads', $member) !!}
@stop
@section('content')

    @if (!$threads->isEmpty())
        @include('forum.includes.threads')
        @include('forum.includes.partials.inline_moderation', ['thread' => $threads->first()])

    @else
        <div class="panel panel-body text-center"> {{ trans('forum.thread.no_results') }}</div>
    @endif

@stop

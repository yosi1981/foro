@extends('layouts.main')
@section('title', $forum->name)
@section('description', $forum->description)
@section('breadcrumbs')
    {!! Breadcrumbs::render('forum.subforum', $forum) !!}
@stop
@section('content')

    {{-- Show all forum/categories --}}
    @include('forum.includes.forums')

    @if ($forum->hasRules())
        <div class="panel panel-body rules">
            @include('forum.includes.rules')
        </div>
    @endif

    <div class="row padding-bottom-10">
        @can('createThread', $forum)
            <div class="col-sm-6 pull-left">
                <a href="{{ route('forum.create', ['forum' => $forum->id]) }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> {{ trans('forum.thread.new') }}
                </a>
            </div>
        @endcan
    </div>

    {{-- Show all threads in the forum --}}
    @if (!$threads->isEmpty())
        @include('forum.includes.threads')
        {{-- Show the inline moderation options -
        Get any first thread so that the Select option for moderation has something to work with --}}
        @include('forum.includes.partials.inline_moderation', ['thread' => $forum->threads->first()])

    @else
        <div class="panel panel-body text-center">
            @if ($forum->closed)
                {{ trans('forum.closed') }}
            @else
                {{ trans('forum.thread.no_results') }}
            @endif
        </div>
    @endif

@stop
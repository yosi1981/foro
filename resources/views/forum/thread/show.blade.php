@extends('layouts.main')
@section('title', $thread->title)
@section('description', str_limit($thread->posts->first()->message, 60))

@section('breadcrumbs')
    {!! Breadcrumbs::render('thread', $thread) !!}
    @if ($thread->locked)
        <span class="help-block">{{ trans('forum.thread.locked') }} </span>
    @endif
@stop

@section('content')
    @include('errors.alert')

    @can('postReply', $thread)
        <p class="text-right">
            <a href="{{ route('forum.reply', $thread->id) }}" class="btn btn-default">
                <i class="fa fa-comment-o"></i> {{ trans('forum.thread.reply.new') }}
            </a>
        </p>
    @endcan
    {{-- Report post modal --}}
    @can('forum-report-post')
        @include('forum.report.form')
    @endif

    {{-- Show posts --}}
    @foreach ($posts as $key => $post)
        @include('forum.post.includes.single_post')
    @endforeach

    {{-- If user can reply to the thread, show reply form --}}
    @can('postReply', $thread)
        @include('forum.includes.short_reply_form')
    @else
        @if ($signed_in)
            <span class="help-block">{{ trans('forum.thread.cannot_reply') }}</span>
        @else
            @if (site('enable-login'))
                <a class="showAjaxModal" data-size="modal-sm" data-toggle="modal" data-url="{{ route('auth.login.ajax.form') }}" href="#">
                    {{ trans('forum.thread.login_to_reply') }}
                </a>
            @endif
        @endif
    @endcan

    {{-- Pagination --}}
    <div class="text-right"> {!! $posts->links() !!}</div>

    {{--Moderation Options (footer) --}}
    @include("forum.includes.action_buttons")

@stop
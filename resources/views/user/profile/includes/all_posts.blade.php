@extends('layouts.main')
@section('title', trans('user.profile.showing_posts', ['member' => $member->info]))
@section('breadcrumbs')
    {!! Breadcrumbs::render('user.profile.all.posts', $member) !!}
@stop
@section('content')
    <div class="box box-flat">
        <div class="box-body">
            @if (count($posts))
                @include('user.profile.includes.posts')
            @else
                {{ trans('forum.post.none') }}
            @endif
        </div>
    </div>
    {!! $posts->links() !!}
@stop

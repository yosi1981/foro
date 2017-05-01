@extends('layouts.main')
@section('content')
    @foreach ($forums as $forum)
        <div class="panel panel-primary">
            <div class="panel-heading padding-bottom-0">
                <div class="row">
                    <div class="col-xs-12 col-sm-8">
                        <h3 class="panel-title">
                            {{ $forum->name }}
                        </h3>
                        <span class="small">{{ $forum->description }}</span>
                    </div>
                    <div class="hidden-xs col-sm-1 text-center text-nowrap">
                        <i class="fa fa-comments visible-xs visible-sm"></i>
                        <span class="hidden-xs hidden-sm">{{ trans_choice('forum/general.threads', 2) }}</span>
                    </div>
                    <div class="hidden-xs col-sm-1 text-center text-nowrap">
                        <i class="fa fa-comment visible-xs visible-sm"></i>
                        <span class="hidden-xs hidden-sm">{{ trans_choice('forum/general.posts', 2) }}</span>
                    </div>
                    <div class="hidden-xs text-right col-sm-2 text-nowrap">
                        <i class="fa fa-clock-o visible-sm"></i>
                        <span class="hidden-sm">{{ trans('forum/post.last_post') }}</span>
                    </div>
                </div>
            </div>
            <div class="list-group" style="" id="cat_1_e">
                @foreach ($forum->children()->with('descendants', 'children')->get() as $subforum)
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-12 margin-0 col-sm-8">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="/" class="forum_status text-primary">

                                        </a>
                                    </div>
                                    <div class="media-body">
                                        {{--<i class="fa fa-bar-chart visible-xs pull-right" data-toggle="tooltip" data-placement="left" data-html="true" title="" data-original-title="{{ $subforum->stats() }}"></i>--}}

                                        <strong class="flow">
                                            <a href="{{ route('forum.home', ['forum' => $subforum->id]) }}">{{ $subforum->name }}</a>
                                        </strong>

                                        <div class="hidden-xs forum-description small">{{ $subforum->description }}</div>

                                        <ul class="list-inline margin-bottom-0">
                                            {{--@if ($subforum->hasSubforum())--}}
                                            @foreach ($subforum->children as $children)
                                                <li>
                                                    <div title="Forum Contains No New Posts"></div>
                                                    <a href="{{ route('forum.home', ['forum' => $children->id]) }}" title="{{ $children->name }}">
                                                        <i class="fa fa-comments"></i> {{ $children->name }}</a>
                                                </li>
                                            @endforeach
                                            {{--@endif--}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden-xs col-sm-1 overflow-ellipsis text-center text-nowrap">
                                <span class="number-friendly">{{ $subforum->countThreads() }}</span>
                            </div>
                            <div class="hidden-xs col-sm-1 overflow-ellipsis text-center text-nowrap">
                            <span class="number-friendly">
                                {{ $subforum->countPosts() }}
                                <small class="hidden-xs"></small></span>
                            </div>
                            <div class="forum-last-post-info hidden-xs text-muted text-nowrap overflow-ellipsis text-right col-sm-2">
                                @if ($subforum->lastThread())
                                    @include('forum.includes.partials.forum_last_post', ['last_thread' => $subforum->lastThread()])
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@stop
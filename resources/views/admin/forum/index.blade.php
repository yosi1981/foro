@extends('layouts.admin')
@section('title', trans('forum.manage'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.forum.index', $forums) !!}
@stop
@section('content')
    @include('errors.alert')
    <div class="box box-flat">
        <div class="box-header with-border">
            <h3 class="box-title">@yield('title')</h3>
            <span class="pull-right"><a href="{{ route('admin.forum.create') }}">
                    <i class="fa fa-plus"></i> {{ trans('forum.add') }}</a></span>
        </div>
        <form method="POST" class="use-ajax" action="{{ route('admin.forum.update.order') }}">
            <div class="box-body">
                {{ csrf_field() }}
                {{ method_field('patch') }}
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="80%">{{ trans('forum.title') }}</th>
                        <th>{{ trans('site.order') }}</th>
                        <th>{{ trans_choice('forum.thread.label', 2) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($forums as $forum)
                        <tr>
                            <td><a href="{{ route('admin.forum.index', ['fid' => $forum->id]) }}">{{ $forum->name }}</a>
                            </td>
                            <td>
                                <input name="order[{{ $forum->id }}]]" title="{{ trans('site.order') }}" type="text" value="{{ $forum->order }}" class="form-control">
                            </td>
                            <td>{{ $forum->total_threads }}</td>
                        </tr>
                        @if ($forum->hasChildren())
                            @foreach ($forum->children as $children)
                                <tr>
                                    <td class="padding-left-30">
                                        <a href="{{ route('admin.forum.index', ['fid' => $children->id]) }}"> {{ $children->name }}</a>
                                        @if ($children->hasChildren())
                                            <div class="text-muted">
                                                {{ trans_choice('forum.subforums', 2) }}:
                                                @foreach ($children->children as $subforum)
                                                    <a class="padding-left-5" href="{{ route('admin.forum.index', ['fid' => $subforum->id]) }}">{{ $subforum->name }}</a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <input name="order[{{ $children->id }}]]" title="{{ trans('site.order') }}" type="text" value="{{ $children->order }}" class="form-control">
                                    </td>
                                    <td>{{ $children->total_threads }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    <tr>
                        <td></td>
                        <td>
                            <button style="width:100%" class="btn btn-default">
                                <i class="fa fa-check"></i> {{ trans('site.order_save') }}
                            </button>
                        </td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    @include('admin.forum.includes.forum_stats')

    @include('admin.forum.includes.edit')

    @include('admin.forum.includes.forum_actions')

@stop
@extends('layouts.mod')
@section('title', trans('mod.report.reported'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('mod.report.index', $show_all) !!}
@stop
@section('mod-content')
    @if (count($reports) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    @if (!$show_all)
                        <th>
                            <input type="checkbox" id="select-all" class="mod-checkbox-select-all-results">
                        </th>
                    @endif
                    <th width="30%">{{ trans('site.content') }}</th>
                    <th width="40%">{{ trans('forum.report.reason') }}</th>
                    <th width="10" class="text-center">{{ trans_choice('forum.report.title', 2) }}</th>
                    <th width="20%" class="text-right">{{ trans('mod.report.last_report') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($reports as $report)
                    <tr>
                        @if (!$show_all)
                            <td>
                                <input id="report[{{ $report->id }}]" class="mod-checkbox-select-result" name="post[{{ $report->id }}]" value="{{ $report->id }}" type="checkbox">
                            </td>
                        @endif
                        <td class="overflow-ellipsis text-nowrap sm-max-width-100-px">
                            {{-- Post URL --}}
                            <a href="{{ $report->post->postURL() }}">{{ trans_choice('forum.post.label', 1) }}</a>
                            <span class="text-muted"> {{ lcfirst(trans('site.created.by')) }}</span>

                            {{-- User URL and Info --}}
                            <a href="{{ $report->user->profileURL() }}">{{ $report->user->info }}</a>
                            <br>
                            <span class="text-muted"> {{ trans('site.in') }}</span>

                            {{-- Thread URL --}}
                            <a href="{{ $report->post->thread->threadURL() }}">
                                {{ str_limit($report->post->thread->title, 50) }}
                            </a>
                        </td>

                        {{-- Reason --}}
                        <td>{{ $report->reason }}</td>

                        {{-- Times Reported--}}
                        <td class="text-center">{{ $report->post->reports->count() }}</td>

                        {{-- Created by and time info --}}
                        <td class="text-right overflow-ellipsis text-nowrap sm-max-width-100-px">{{ $report->created_at }}
                            <br>
                            <span class="text-muted">{{ trans('site.by') }}</span>
                            <a href="{{ $report->user->profileURL() }}">
                                {{ $report->user->info }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-6 padding-top-20">
                @if(!$show_all)
                    <form id="report-form" method="post" action="{{ route('mod.reported.action') }}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" id="report-action">
                        <input type="hidden" name="model-input" class="mod-selected-results">
                        <span class="text-muted">{{ trans('mod.with_selected') }}</span>
                        @include('mod.reported_posts.action')
                    </form>
                @endif
            </div>
            <div class="col-md-6 text-right">
                @if($show_all)
                    {!! $reports->appends(['show' => 'all'])->links() !!}
                @else
                    {!! $reports->links() !!}
                @endif
            </div>
        </div>
    @else
        <p class="text-muted">{{ trans('mod.report.no_results') }}</p>
    @endif

@stop

@section('mod-footer')
    <div class="row">
        @if($show_all)
            <div class="text-left col-sm-6">
                <a href="{{ route('mod.reported.index') }}">{{ trans('mod.report.view_new') }}</a>
            </div>
        @else
            <div class="col-sm-6">
                <a href="{{ route('mod.reported.index', ['show' => 'all']) }}">{{ trans('mod.report.view_all') }}</a>
            </div>
        @endif
        <div class="text-right col-sm-6">
            <form method="POST" class="inline" action="{{ route('mod.reported.delete_all') }}">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <button type="submit" name="ays-confirm" class="btn btn-link padding-0 text-danger">
                    {{ trans('mod.report.delete_all') }}
                </button>
            </form>
        </div>
    </div>
@stop
@extends('layouts.admin')
@section('title', trans('admin.tools.stats.title'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.tools.stats.recount') !!}
@stop
@section('box')

    @include('errors.alert')
    {{ trans('admin.tools.stats.desc') }}
    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{ trans('site.name') }}</th>
            <th>{{ trans('site.value') }}</th>
            <th>{{ trans('admin.tools.stats.recount') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stats as $stat)
            <tr id="{{ $stat->name }}">
                <td width="80%">{{ ucwords(str_replace('_', ' ', $stat->name)) }}</td>
                <td width="10%">
                    <span id="{{ $stat->name }}-value">{{ number_format($stat->value) }}</span>
                </td>
                <td>
                    <form class="stat-recount" method="POST" action="{{ route('admin.tools.stats.update', $stat->name) }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-refresh"></i> {{ trans('admin.tools.stats.recount') }}
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @push('scripts')
    <script>
        $('.stat-recount').submit(function (e) {
            var alertElement = $('#alert-field');
            ajaxRequest($(this), alertElement, e, adminUpdateSiteStats);
        });
        function adminUpdateSiteStats(data) {
            $('#' + data.stat_name).effect("highlight", {}, 1500);
            $('#' + data.stat_name + '-value').text(data.stat_value);
        }
    </script>
    @endpush
@stop
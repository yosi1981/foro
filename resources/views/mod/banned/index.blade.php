@extends('layouts.mod')
@section('title', trans('mod.banned.all'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('mod.banned') !!}
@stop
@section('mod-title')
    <div class="box-tools">
        <a href="{{ route('mod.banned.create') }}" class="btn btn-default btn-sm">{{ trans('mod.banned.create') }}</a>
    </div>
@stop
@section('mod-content')
    @if (count($bans) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{{ trans('user.label') }}</th>
                    <th width="10%">{{ trans('mod.banned.by') }}</th>
                    <th width="30%">{{ trans('mod.banned.expiry') }}</th>
                    <th width="40%">{{ trans('mod.banned.reason') }}</th>
                    <th width="15%" class="text-right">{{ trans('mod.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($bans as $ban)
                    <tr>
                        <td><a href="{{ $ban->user->profileURL() }}">{{ $ban->user->info }}</a></td>
                        <td><a href="{{ $ban->banner->profileURL() }}">{{ $ban->banner->info }}</a></td>
                        <td>{{ $ban->expires_at }}</td>
                        <td>{{ $ban->reason }}</td>
                        <td class="text-right">
                            <a href="{{ route('mod.banned.edit', $ban->user->info) }}">{{ trans('site.edit') }}</a>
                            •
                            <a href="{{ route('mod.banned.show', $ban->user->info) }}">{{ trans('site.view') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {!! $bans->links() !!}
    @else
        {{ trans('mod.banned.none') }}
    @endif
@stop
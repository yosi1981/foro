@extends('layouts.mod')
@section('title', $member->info)
@section('breadcrumbs')
    {!! Breadcrumbs::render('mod.banned.show', $member) !!}
@stop
@section('mod-content')
    @if ($member->isBanned())
        <div class="row">
            <div class="col-sm-2 bold">{{ trans('user.label') }}</div>
            <div class="col-sm-10"><a href="{{ $member->profileURL() }}">{{ $member->info }}</a></div>
        </div>
        <div class="row">
            <div class="col-sm-2 bold">{{ trans('mod.banned.expiry') }}</div>
            <div class="col-sm-10">{{ $member->ban->expires_at }}</div>
        </div>
        <div class="row">
            <div class="col-sm-2 bold">{{ trans('mod.banned.reason') }}</div>
            <div class="col-sm-10">{{ $member->ban->reason }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-2 bold">{{ trans('mod.banned.by') }}</div>
            <div class="col-sm-10"><a href="{{ $member->ban->banner->profileURL() }}">{{ $member->ban->banner->info }}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 bold">{{ trans('mod.banned.on') }}</div>
            <div class="col-sm-10">{{ $member->ban->getOriginal('created_at') . " ({$member->ban->created_at})" }}</div>
        </div>
        @if ($member->ban->created_at != $member->ban->updated_at)
            <div class="row">
                <div class="col-sm-2 bold">{{ trans('mod.banned.updated') }}</div>
                <div class="col-sm-10">{{ $member->ban->getOriginal('updated_at') . " ({$member->ban->updated_at})" }}</div>
            </div>
        @endif
        <hr>
        <form id="banned-delete-form" action="{{ route('mod.banned.destroy', $member->info) }}" method="POST">
            {!! method_field('DELETE') !!}
            {!! csrf_field() !!}
            <div id="alert-field"></div>
            <button type="submit" name="ays-confirm" class="col-sm-offset-2 btn btn-danger"><i class="fa fa-remove"></i>
                {{ trans('mod.banned.delete') }}
            </button>
            <a href="{{ route('mod.banned.edit', $member->info) }}" class="btn btn-default">
                <i class="fa fa-pencil"></i>
                {{ trans('mod.banned.edit') }}
            </a>
        </form>
    @else
        <span class="help-block">{{ trans('mod.banned.not_banned') }}</span>
    @endif
@stop
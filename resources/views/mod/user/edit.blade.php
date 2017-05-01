@extends('layouts.mod')
@section('title', trans('mod.user.edit', ['user' => $member->info]))
@section('breadcrumbs')
    {!! Breadcrumbs::render('mod.user.edit', $member) !!}
@stop
@section('mod-content')
    <form method="POST" class="form-horizontal" action="{{ route('mod.user.update', $member->info) }}">
        {{ csrf_field() }}
        {{ method_field('patch') }}

        @can('moderateEditAccountInfo', Auth::user())
            @include('user.account.includes.account_settings_inputs')
        @endcan
        @can('moderateEditGeneralInfo', Auth::User())
            @include('user.account.includes.general_settings_inputs')
        @endcan
        <hr>
        @include('mod.user.includes.note_on_user')
        @can('moderateEditPrivateAnnouncement', Auth::User())
            @include('mod.user.includes.private_announcement')
        @endcan
        @can('moderateSuspendPrivileges', Auth::user())
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    @include('mod.user.includes.privileges')
                </div>
            </div>
        @endcan
        <div class="clearfix"></div>
        <hr>
        <div class="col-sm-10 col-sm-offset-2">
            <a href="{{ route('mod.user.show', $member->info) }}" class="btn btn-default">
                <i class="fa fa-times"></i>
                {{ trans('site.cancel') }}
            </a>
            @include('includes.buttons.save')
            <a class="btn btn-danger" href="{{ route('mod.banned.create', ['user' => $member->info]) }}">
                <i class="fa fa-ban"></i>
                {{ trans('mod.banned.ban') }}
            </a>
        </div>
    </form>
@stop
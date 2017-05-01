@extends('layouts.admin')
@section('title', trans('admin.user.ip.view_log'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.user.ip.logs', $member) !!}
@stop
@section('box')
    <h3>{{ trans('admin.user.ip.registration') }}:
        <code>{{ $member->registration_ip_address }}</code>
    </h3>
@stop
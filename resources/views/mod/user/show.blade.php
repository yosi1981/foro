@extends('layouts.mod')
@section('title', trans('mod.user.view', ['user' => $user->info]))
@section('breadcrumbs')
    {!! Breadcrumbs::render('mod.user.show', $user) !!}
@stop
@section('mod-content')
    @include('mod.includes.user_info')
@stop
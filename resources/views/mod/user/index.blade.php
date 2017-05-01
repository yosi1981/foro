@extends('layouts.mod')
@section('title', trans('mod.user.title'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('mod.user.index') !!}
@stop
@section('mod-content')
    <span class="help-block">{{ trans('mod.user.search') }}</span>
    <div class="row">
        <form method="post" id="mod-dashboard-user-search-form" action="{{ route('mod.search.user') }}">
            {!! csrf_field() !!}
            <div class="col-sm-5 col-xs-8"> @include('includes.api.username_search_form')</div>
            <div class="col-sm-3 col-xs-2">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-search"></i> {{ trans('site.search') }}</button>
            </div>
        </form>
    </div>
    <div id="user-info"></div>
@stop
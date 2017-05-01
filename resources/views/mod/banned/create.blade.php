@extends('layouts.mod')
@section('title', trans('mod.banned.create'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('mod.banned.create') !!}
@stop
@section('mod-content')

    <form id="ban-user" method="POST" class="form-horizontal" action="{{ route('mod.banned.user') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-6 form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="username">{{ trans('user.username_id') }}</label>
                    <div class="col-sm-8">
                        @include('includes.api.username_search_form')
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-default">{{ trans('mod.banned.search_ban') }}</button>
            </div>
        </div>
    </form>
    <div id="banned"></div>
@stop
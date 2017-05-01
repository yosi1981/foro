@extends('layouts.main')
@section('top_section')
    <div class="row margin-top-20">
        <div class="col-md-2">
            <div class="nav-tabs-custom">
                <ul class="nav nav-pills nav-stacked">
                    <li {{ setActive(route('mod.dashboard')) }} >
                        <a href="{{ route('mod.dashboard') }}">{{ trans('mod.dashboard') }}</a>
                    </li>
                    <li {{ setActive(route('mod.reported.index')) }}>
                        <a href="{{ route('mod.reported.index') }}">{{ trans('mod.report.reported') }}</a>
                    </li>
                    <li {{ setActive()->all(route('mod.banned.index')) }}>
                        <a href="{{ route('mod.banned.index') }}">{{ trans('mod.banned.all') }}</a>
                    </li>
                    <li {{ setActive()->all(route('mod.user.index')) }}>
                        <a href="{{ route('mod.user.index') }}">{{ trans('user.users') }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-10">
            @include('errors.alert')
            <div class="box box-flat" id="pjax-shit">
                <div class="box-header with-border">
                    <h3 class="box-title">@yield('title')</h3>
                    @yield('mod-title')
                </div>
                <div class="box-body">@yield('mod-content')</div>
                @hasSection('mod-footer')
                    <div class="box-footer">@yield('mod-footer')</div>
                @endif
            </div>
        </div>
    </div>
@stop
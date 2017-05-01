@extends('layouts.admin')
@section('title', $member->info)
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.user.show', $member) !!}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-flat">
                @include('user.profile.includes.user_info_sidebar')
                <div class="box-footer">
                    <div class="text-center">
                        <a href="{{ route('mod.banned.create', ['user' => $member->info]) }}" class="btn btn-warning margin-bottom-10">
                            <i class="fa fa-ban"></i> {{ trans('mod.banned.ban_user') }}
                        </a>
                        <form method="POST" action="{{ route('admin.user.destroy', $member->info) }}">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button name="ays-confirm" class="btn btn-danger">
                                <i class="fa fa-user-times"></i> {{ trans('admin.user.delete') }}
                            </button>
                        </form>
                        <a href="{{ route('admin.user.ip.log', ['user' => $member->info]) }}">
                            {{ trans('admin.user.ip.view_log') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" id="user-edit-form-admin" class="form-horizontal" action="{{ route('admin.user.update', $member->info) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            <div class="col-md-9">
                @include('errors.alert')
                @include('admin.user.includes.account_alerts')
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @include('admin.user.includes.nav_tabs_header')
                    </ul>
                    
                    <div class="tab-content">

                        <div class="tab-pane active" id="activity">
                            @include('admin.user.includes.activity_tab')
                        </div>
                        
                        <div class="tab-pane" id="account">

                            @include('user.account.includes.account_settings_inputs')
                            <hr>
                            @include('mod.user.includes.user_roles')
                            <hr>
                            @include('user.account.includes.new_password_inputs')

                        </div>

                        <div class="tab-pane" id="general">

                            @include('user.account.includes.general_settings_inputs')

                        </div>
                        <div class="tab-pane" id="mod-options">

                            @include('mod.user.includes.note_on_user')
                            @include('mod.user.includes.private_announcement')
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    @include('mod.user.includes.privileges')
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="forum-options">

                            @include('user.account.includes.forum_settings_inputs')

                        </div>
                        
                        <hr>

                        <div class="text-center">
                            @include('includes.buttons.save')
                        </div>
                    
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    @push('scripts')
    <script>
        $('#user-edit-form-admin').submit(function (e) {
            var alertElement = $('#alert-field');
            ajaxRequest($(this), alertElement, e);
        });
    </script>
    @endpush
    @include('includes.bb_editor')
@stop

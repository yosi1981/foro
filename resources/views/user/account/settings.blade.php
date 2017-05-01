@extends('layouts.main')
@section('title', trans('site.settings'))
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="nav-tabs-custom">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active">
                        <a href="#general-pane" role="tab" data-toggle="tab">{{ trans('user.settings.general') }}</a>
                    </li>
                    <li>
                        <a href="#account-pane" role="tab" data-toggle="tab">{{ trans('user.settings.account') }}</a>
                    </li>
                    <li>
                        <a href="#forum-pane" role="tab" data-toggle="tab">{{ trans('user.settings.forum') }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            @include('errors.alert')
            <div class="box box-flat">
                <div class="tab-content">
                    <div class="active tab-pane fade in" id="general-pane">
                        <div class="box-header with-border">
                            {{-- General settings Tab--}}
                            <h3 class="box-title">{{ trans('user.settings.general') }}</h3>
                        </div>
                        {{-- Open a new Form--}}
                        <form method="POST" class="form-horizontal use-ajax" action="{{ route('user.settings.general') }}">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="box-body">
                                @include('user.account.includes.general_settings_inputs', ['member' => $user])
                            </div>
                            <div class="box-footer with-border">
                                {{--Save button--}}
                                <div class="col-sm-10 col-sm-offset-2">
                                    @include('includes.buttons.save')
                                </div>
                            </div>
                            {{-- Close the form --}}
                        </form>
                    </div>

                    <div class="tab-pane fade in" id="account-pane">
                        <div class="box-header with-border">
                            {{-- Account settings Tab --}}
                            <h3 class="box-title">{{ trans('user.settings.account') }}</h3>
                        </div>
                        <form method="POST" id="account-settings" class="form-horizontal" action="{{ route('user.settings.account') }}">
                            {{-- Form open --}}
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <div class="box-body">
                                @include('user.account.includes.account_settings_inputs', ['member' => $user])
                                <hr>
                                {{--Old password field--}}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="current_password">{{ trans('user.password.label') }}</label>
                                    <div class="col-sm-10">
                                        <input name="current_password" id="current_password" placeholder="{{ trans('user.password.desc') }}" type="password" class="form-control"/>
                                    </div>
                                </div>

                                @include('user.account.includes.new_password_inputs')
                            </div>
                            <div class="box-footer with-border">
                                {{--Save button--}}
                                <div class="col-sm-10 col-sm-offset-2">
                                    @include('includes.buttons.save')
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade in" id="forum-pane">
                        <div class="box-header with-border">
                            {{-- Account settings Tab --}}
                            <h3 class="box-title">{{ trans('user.settings.forum') }}</h3>
                        </div>
                        {{-- Form open --}}
                        <form method="POST" class="form-horizontal use-ajax" action="{{ route('user.settings.forum') }}">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            <div class="box-body">
                                @include('user.account.includes.forum_settings_inputs', ['member' => $user])
                            </div>
                            <div class="box-footer with-border">
                                {{--Save button--}}
                                <div class="col-sm-10 col-sm-offset-2">
                                    @include('includes.buttons.save')
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@extends('layouts.main')
@section('title', trans('site.auth.login'))
@section('content')
    <div class="login-box">

        <div class="box box-flat">
            <div class="box box-body">
                <span class="help-block">
                    Admin Credentials
                </span>
                Username: <code>admin</code>
                <br>
                Password: <code>admin</code>
                <hr>
                <span class="help-block">
                    User Credentials
                </span>
                Username: <code>member</code>
                <br>
                Password: <code>member</code>
                <hr>
                <span class="help-block">
                    Moderator Credentials
                </span>
                Username: <code>moderator</code>
                <br>
                Password: <code>moderator</code>
            </div>
        </div>

        @include('auth.includes.login_form')
    </div>

@endsection

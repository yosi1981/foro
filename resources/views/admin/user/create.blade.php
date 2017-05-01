@extends('layouts.admin')
@section('title', trans('admin.user.create'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.user.create') !!}
@endsection
@section('box')
    <form method="POST" id="user-create-form-admin" class="form-horizontal use-ajax" action="{{ route('admin.user.store') }}">
        {{ csrf_field() }}
        @include('errors.alert')
        <div class="col-md-10 col-lg-6">

            <p class="lead text-center">{{ trans('user.settings.account') }}</p>

            @include('user.account.includes.account_settings_inputs')

            @include('user.account.includes.new_password_inputs')

            <p class="lead text-center">{{ trans('user.role.full') }}</p>

            @include('mod.user.includes.user_roles')

            <hr>


            <div class="col-sm-10 col-sm-offset-2">
                <button class="btn btn-success" type="submit">
                    {{ trans('admin.user.create') }}</button>
            </div>
        </div>
    </form>
@endsection
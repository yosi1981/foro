@extends('vendor.installer.layouts.master')
@section('title', trans('messages.environment.title'))
@section('container')
    @if (session('message'))
        <p class="alert">{{ session('message') }}</p>
    @endif
    <small>
        Set up your environment file. The only required fields are the following:
        <br>
        DB_HOST = Your database host
        <br>
        DB_DATABASE = Your database name
        <br>
        DB_USERNAME = Your database user username
        <br>
        DB_PASSWORD = Your database user password
        <br><b>Please leave everything else...</b>
    </small>
    <form method="post" action="{{ route('LaravelInstaller::environmentSave') }}">
        <textarea class="textarea" name="envConfig">{{ $envConfig }}</textarea>
        {!! csrf_field() !!}
        <div class="buttons buttons--right">
            <button class="button button--light" type="submit">{{ trans('messages.environment.save') }}</button>
        </div>
    </form>
    @if(!isset($environment['errors']))
        <div class="buttons">
            <a class="button" href="{{ route('LaravelInstaller::requirements') }}">
                {{ trans('messages.next') }}
            </a>
        </div>
    @endif
@stop
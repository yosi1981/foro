@extends('layouts.main')
<title>{{ $error_title }}</title>
@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> {{ $error_code }}</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i>
                {{ $error_title }}
            </h3>
            <p class="bold">{{ $exception->getMessage() ?: $error_description }}</p>


            <div class="margin-top-20">
                <a href="{{ url('/') }}">{{ trans('site.home') }}</a>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 991px) {
            .error-page > .error-content {
                text-align: center;
            }
        }
    </style>
@stop

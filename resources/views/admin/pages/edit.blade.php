@extends('layouts.admin')
@section('title', trans('admin.pages.edit'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.pages.edit', $page) !!}
@stop
@section('box')

    @include('errors.alert')

    <form class="use-ajax" method="POST" action="{{ route('admin.page.update', $page->id) }}">
        {{ method_field('patch') }}
        {{ csrf_field() }}

        @include('admin.pages.includes.form')

        <div class="form-group">
            @include('includes.buttons.save')
        </div>

    </form>
@stop
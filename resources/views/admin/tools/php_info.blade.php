@extends('layouts.admin')
@section('title', trans('admin.tools.php.info') . ' - ' . trans('admin.tools.php.version', ['version' => phpversion()]))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.tools.php.info') !!}
@stop
@section('content')
    <iframe width="100%" height="100%" style="border:none" src="{{ route('admin.tools.php.info.raw') }}"></iframe>
@stop

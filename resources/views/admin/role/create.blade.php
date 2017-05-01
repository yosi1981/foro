@extends('layouts.admin')
@section('title', trans('admin.role.add'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.role.create') !!}
@stop
@section('box')
    @include('errors.alert')
    <form method="post" id="create-user-role" action="{{ route('admin.role.store') }}" class="form-horizontal">
        @include('admin.role.form')
        <div class="col-sm-offset-2">
            <button type="submit" class="btn btn-default"><i class="fa fa-plus"></i> {{ trans('admin.role.add') }}
            </button>
        </div>
    </form>
    @push('scripts')
    <script>
        $('#create-user-role').submit(function (e) {
            var alertElement = $('#alert-field');
            ajaxRequest($(this), alertElement, e);
        });
    </script>
    @endpush
@stop
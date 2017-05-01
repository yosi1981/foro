@extends('layouts.admin')
@section('title', trans('admin.role.edit_role', ['role' => $role->name]))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.role.edit', $role) !!}
@stop
@section('box')
    @include('errors.alert')
    <form method="post" id="update-user-role" action="{{ route('admin.role.update', $role->name) }}" class="form-horizontal">
        {{ method_field('patch') }}
        @include('admin.role.form')
        <div class="col-sm-offset-2">
            @include('includes.buttons.save')
        </div>
    </form>
    @push('scripts')
    <script>
        $('#update-user-role').submit(function (e) {
            var alertElement = $('#alert-field');
            ajaxRequest($(this), alertElement, e);
        });
    </script>
    @endpush
@stop
@extends('layouts.mod')
@section('title', trans('mod.banned.edit') . ' - '. $member->info)
@section('breadcrumbs')
    {!! Breadcrumbs::render('mod.banned.edit', $member) !!}
@stop
@section('mod-content')
    @include('mod.banned.form')

    {{-- Ban User Script --}}
    @push('scripts')
        <script>banUser()</script>
    @endpush
@stop
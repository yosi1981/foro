@extends('layouts.mod')
@section('title', trans('mod.dashboard'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('mod.dashboard') !!}
@stop
@section('mod-content')
        @include('errors.alert')
        <form class="use-ajax" method="post" action="{{ route('mod.notes')  }}">
            {!! csrf_field() !!}
            {{ method_field('patch') }}
            @include('mod.includes.dashboard_note', ['note_title' => trans('mod.note.title'), 'note' => $mod_note, 'note_helper' => trans('mod.note.visible_to_all_mods')])
        </form>
    @push('scripts')
    @endpush
@stop
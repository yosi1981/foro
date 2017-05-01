@extends('layouts.main')
@section('title', trans('forum.title'))
@section('description', trans('forum.title'))
@section('content')

    {{-- Show all forum/categories --}}
    @foreach ($forums as $forum)
        @include('forum.includes.forums')
    @endforeach

@stop

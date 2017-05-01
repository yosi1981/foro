@extends('layouts.main')
@section('title', $page->title)
@section('description', str_limit($page->body, 65))
@section('content')

    <div class="box box-flat">
        <div class="box-body padding-20">
            {!! $page->body !!}
        </div>
    </div>

@stop
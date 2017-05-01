@extends('layouts.admin')
@section('title', trans_choice('mod.thread.move', 2))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.forum.manage.move', $forum) !!}
@stop
@section('box')
    @include('errors.alert')
    <div>{!! trans('forum.thread.move_to_another', ['threads' => $forum->threads->count(), 'name' => $forum->name])!!} </div>
    <form method="post" action="{{ route('admin.forum.manage.move.post', $forum->id) }}">
        {{ csrf_field() }}
        <div class="row margin-top-10">
            <div class="col-md-4 col-sm-8"> {!! $select_input->name('forum')->forums()->get() !!}</div>
            <div class="col-md-3 col-sm-4">
                <button name="ays-confirm" type="submit" class="btn btn-primary">{{ trans_choice('mod.thread.move', 2) }} <i class="fa fa-arrow-right"></i></button>
            </div>
        </div>
    </form>
@stop
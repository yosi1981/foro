@extends('layouts.admin')
@section('title', trans('admin.user.title.title'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('user_title.index') !!}
@stop
@section('box')
    @include('errors.alert')

    <div class="row">
        <div class="text-warning col-md-9">
            {{ trans('admin.user.title.delete_all_will_disable') }}
        </div>
        <div class="text-right col-md-3">
            <a href="{{ route('admin.title.create') }}" class="btn btn-default">
                <i class="fa fa-plus"></i> {{ trans('admin.user.title.new') }}
            </a>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{ trans('admin.user.title.form.title') }}</th>
            <th>{{ trans('admin.user.title.form.stars') }}</th>
            <th>{{ trans('admin.user.title.form.posts_required') }}</th>
            <th>{{ trans('mod.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($titles as $title)
            <tr>
                <td width="60%">{{ $title->title }}</td>
                <td>{{ $title->stars }}</td>
                <td>{{ $title->posts }}</td>
                <td>
                    <div class="dropdown">
                        <a class="dropdown-toggle btn btn-default" data-toggle="dropdown" href="#" aria-expanded="true">
                            {{ trans('site.options') }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation">
                                <a href="{{ route('admin.title.edit', $title->id) }}">
                                    {{ trans('site.edit') }}
                                </a>
                            </li>
                            <li role="presentation">
                                <form method="POST" action="{{ route('admin.title.destroy', $title->id) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button name="ays-confirm" type="submit" role="menuitem" tabindex="-1" href="">
                                        {{ trans('site.delete') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    
    @if (!count($titles))
        {{ trans('admin.user.title.none') }}
    @endif
@stop
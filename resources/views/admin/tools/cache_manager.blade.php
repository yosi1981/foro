@extends('layouts.admin')
@section('title', trans('admin.tools.cache.manager'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.tools.cache.manager') !!}
@stop
@section('box')
    
    @include('errors.alert')
    <h4> {{ trans('admin.tools.cache.current_driver') }}: <code>{{ config('cache.default') }}</code></h4>
    <hr>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{ trans('admin.tools.cache.name') }}</th>
            <th>{{ trans('admin.tools.cache.identifier') }}</th>
            <th class="hidden-xs">{{ trans('site.description') }}</th>
            <th>{{ trans('mod.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach (App\Core\Cache::cacheNames() as $cache)
            <tr>
                <td>
                    <a class="showAjaxModal" data-toggle="modal" data-url="{{ route('admin.tools.cache.read', $cache['identifier']) }}" href="#">{{ $cache['name'] }}</a>
                </td>
                <td>
                    <code>{{ $cache['identifier'] }}</code>
                </td>
                <td class="hidden-xs">{{ $cache['description'] }}</td>
                <td>
                    @if (isset($cache['remove_only']))
                        <form class="use-ajax" method="POST" action="{{ route('admin.tools.cache.remove', $cache['identifier']) }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-trash"></i> {{ trans('site.clear') }}
                            </button>
                        </form>
                    @else
                        <form class="use-ajax" method="POST" action="{{ route('admin.tools.cache.recache', $cache['identifier']) }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-refresh"></i> {{ trans('admin.tools.cache.recache') }}
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
@extends('layouts.admin')
@section('title', trans('admin.tools.title'))
@section('box')

    <div class="row">
        <div class="col-md-6">{{ trans('admin.tools.desc') }}</div>
        <div class="col-md-6">
            @foreach ($tools as $tool)
                @if (count($tool) != count($tool, COUNT_RECURSIVE))
                    @foreach ($tool as $item)
                        <a href="{{ $item['url'] }}" class="btn btn-app">
                            <i class="{{ $item['icon'] }}"></i>
                            {{ $item['name'] }}
                        </a>
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>

@stop
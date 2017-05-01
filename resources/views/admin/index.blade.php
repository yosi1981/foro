@extends('layouts.admin')
@section('title', trans('admin.panel'))
@section('content')
    @include('errors.alert')
    <div class="row">
        @foreach ($info_boxes as $info_box)
            <div class="col-md-6 col-lg-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon {{ $info_box['color'] }}"><i class="{{ $info_box['icon'] }}"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ $info_box['name'] }}</span>
                        <span class="info-box-number">
                            {{ $info_box['value'] }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-8">
            {{-- Admin notes box--}}
            @include('admin.include.admin_notes')
        </div>
        <div class="col-md-8">
            <div class="row">
                {{-- New users box--}}
                @if (count($new_users))
                    <div class="col-md-6">@include('admin.include.new_users')</div>
                @endif
                {{-- Most recent stats box --}}
                @if ($most_recent_stats)
                    <div class="col-md-6">@include('admin.include.forum_stats')</div>
                @endif
            </div>
        </div>
    </div>
@stop
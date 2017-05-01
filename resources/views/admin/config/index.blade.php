@extends('layouts.admin')
@section('title', $settings_group->name)

@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.config.index', $settings_group) !!}
@stop

@section('content')
    @include('errors.alert')
    <form method="POST" class="form-horizontal" action="{{ route('admin.config.update', $settings_group->id) }}">
        {{ csrf_field() }}
        {{ method_field('patch') }}

        <div class="box box-flat">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach ($sub_groups as $key => $group)
                        <li {{ $key == 0 ? 'class=active' : '' }}>
                            <a href="#{{ $group->id }}" data-toggle="tab" aria-expanded="false">{{ $group->name }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @if ($settings_group->description)
                        <span class="help-block">{!! $settings_group->description  !!}</span>
                    @endif
                    @foreach ($sub_groups as $key => $group)

                        <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="{{ $group->id }}">
                            @if ($group->description)
                                <div class="callout callout-info"> {!! $group->description !!}</div>
                            @endif

                            @foreach ($group->settings as $setting)
                                <div class="form-group">
                                    <label class="col-sm-7 padding-top-5 col-md-8 text-normal padding-top-9" for="{{ $setting->name }}">
                                        {!! $setting->display_name !!}
                                    </label>
                                    <div class="col-sm-5 col-md-4">
                                        @include('admin.config.partials.input.'. $setting->settingType)
                                    </div>
                                </div>
                                <hr>
                            @endforeach

                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="box box-body box-flat text-center">
            <a href="" class="btn btn-default">
                <i class="fa fa-times"></i> {{ trans('site.cancel') }}</a>
            @include('includes.buttons.save')
        </div>
    </form>

@stop
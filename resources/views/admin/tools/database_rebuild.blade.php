@extends('layouts.admin')
@section('title', trans('admin.tools.database.title'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.tools.database.rebuild') !!}
@stop
@section('content')

    <div class="box box-flat">
        <div class="box-header with-border">
            <h3 class="box-title">@yield('title')</h3>
        </div>
        <div class="box-body">
            @include('errors.alert')
            <p>{{ trans('admin.tools.database.seed_desc') }}</p>
            <table class="table table-hover">
                <tbody>
                @foreach ($seeders as $seeder)
                    <tr>
                        <td width="90%">
                            <b>{{ $seeder['name'] }}</b>
                            <span class="text-muted">({{ $seeder['seeder'] }})</span>
                            <br>
                            <span class="text-muted">{{ $seeder['description'] }}</span>
                        </td>
                        <td>
                            <form class="padding-0 margin-0 use-ajax" method="POST" action="{{ route('admin.tools.database.seed', $seeder['seeder']) }}">
                                {{ csrf_field() }}
                                <button name="ays-confirm" type="submit" class="btn btn-primary">
                                    <i class="fa fa-wrench"></i> {{ trans('admin.tools.database.rebuild') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="box box-flat">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin.tools.database.sizes') }}</h3>
        </div>
        <div class="box-body">
            <p>{{ trans('admin.tools.database.sizes_desc') }}</p>
            <table class="table table-hover">
                <tbody>
                @foreach ($sizes as $size)
                    <tr>
                        <td width="90%">{{ $size->table }}</td>
                        <td>{{ $size->size }} {{ trans('site.size.mb') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @push('scripts')
    <script>
//        $('.database-seeder-rebuild').submit(function (e) {
//            var alertElement = $('#alert-field');
//            ajaxRequest($(this), alertElement, e);
//        });
    </script>
    @endpush
@stop
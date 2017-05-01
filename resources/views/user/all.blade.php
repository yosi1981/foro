@extends('layouts.main')
@section('title', trans('user.all'))
@section('content')

    @include('errors.alert')

    <div class="row margin-bottom-20">
        <form method="GET" action="{{ route('user.all') }}">
            @include('user.includes.search_form', ['placeholder' => trans('user.search_placeholder')])
        </form>
    </div>

    <div class="box box-flat">
        <div class="box-header">
            <h3 class="box-title">{{ trans('user.all') }}</h3>
        </div>

        <div class="box-body no-padding">
            <table class="table vertical-align table-hover">
                <tbody>
                <tr>
                    <th width="50px">{{ trans('user.avatar.label') }}</th>
                    <th>{{ trans('user.username.label') }}</th>
                    <th>{{ trans('user.email.label') }}</th>
                    <th class="hidden-xs">{{ trans('user.registered') }}</th>
                    @if ($user->can('viewLastActiveUser', $user))
                        <th  class="hidden-sm hidden-xs">{{ trans('user.last_active') }}</th>
                    @endif
                </tr>
                @foreach ($users as $member)
                    <tr>
                        <td>
                            <img width="40" height="40" class="img-responsive img-circle" src="{{ $member->avatar }}" alt="{{ trans('user.avatar.label') }}">
                        </td>
                        <td><a href="{{ $member->profileURL() }}">{{ $member->username }}</a></td>
                        <td>{{ $member->email }}</td>
                        <td class="hidden-xs">{{ $member->created_at }}</td>
                        @if ($user->can('viewLastActiveUser', $user))
                            <td class="hidden-sm hidden-xs">{{ $member->active_at }}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if (!$users->count())
                <div class="margin-10">
                    {{ trans('user.no_results') }}
                </div>
            @endif
        </div>

        <div class="box-footer">
            <div class="col-sm-4 margin-0"> {!! $users->links() !!}</div>
        </div>
    </div>
@stop
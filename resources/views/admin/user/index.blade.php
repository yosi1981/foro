@extends('layouts.admin')
@section('title', trans('user.all'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.user.index') !!}
@stop
@section('content')
    @include('errors.alert')

    <div class="row margin-bottom-20">
        <form method="GET" action="{{ route('admin.user.index') }}">
            @include('user.includes.search_form', ['placeholder' => trans('user.search_placeholder_admin')])
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
                    <th class="hidden-xs">{{ trans('user.email.label') }}</th>
                    <th class="hidden-sm hidden-xs">{{ trans('user.registered') }}</th>
                    <th class="hidden-sm hidden-xs">{{ trans('user.last_active') }}</th>
                    <th width="120px">{{ trans('mod.actions') }}</th>
                    <th>
                        <input title="{{ trans('site.select_all') }}" type="checkbox" class="mod-checkbox-select-all-results">
                    </th>
                </tr>
                @foreach ($users as $member)
                    <tr>
                        <td>
                            <img width="40" height="40" class="img-responsive img-circle" src="{{ $member->avatar }}" alt="{{ trans('user.avatar.label') }}">
                        </td>
                        <td>{{ $member->username }}</td>
                        <td class="hidden-xs">{{ $member->email }}</td>
                        <td class="hidden-sm hidden-xs">{{ $member->created_at }}</td>
                        <td class="hidden-sm hidden-xs">{{ $member->active_at }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="dropdown-toggle btn btn-default" data-toggle="dropdown" href="#" aria-expanded="true">
                                    {{ trans('site.options') }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" target="_blank" href="{{ $member->profileURL() }}">{{ trans('user.view_profile') }}</a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="{{ route('admin.user.show', $member->info) }}">{{ trans('user.edit') }}</a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="{{ route('mod.banned.create', ['user' => $member->info]) }}">{{ trans('mod.banned.ban_user') }}</a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="{{ route('admin.user.ip.log', ['user' => $member->info]) }}">{{ trans('admin.user.ip.view_log') }}</a>
                                    </li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="{{ route('admin.user.destroy', $member->info) }}">{{ trans('user.delete') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <input title="select" class="mod-checkbox-select-result" name="user[{{ $member->id }}]" value="{{ $member->id }}" type="checkbox">
                        </td>
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
            <div class="row">
                <div class="col-sm-4 margin-0"> {!! $users->links() !!}</div>
                <form method="post" action="{{ route('admin.user.actions') }}">
                    <div class="col-sm-offset-4 col-sm-4">
                        {{ csrf_field() }}
                        <input type="hidden" class="mod-selected-results" name="model-input" value="">
                        <div class="col-sm-8">
                            <select title="{{ trans('mod.actions') }}" name="action" id="action" class="form-control">
                                <optgroup label="Account">
                                    <option value="activate">{{ trans('user.mass.activate') }}</option>
                                    <option value="deactivate">{{ trans('user.mass.deactivate') }}</option>
                                    <option value="destroy">{{ trans('user.mass.delete') }}</option>
                                </optgroup>
                                <optgroup label="Forum">
                                    <option value="junk_posts">{{ trans('user.mass.junk_posts') }}</option>
                                    <option value="junk_threads">{{ trans('user.mass.junk_threads') }}</option>
                                    <option value="delete_posts">{{ trans('user.mass.delete_posts') }}</option>
                                    <option value="delete_threads">{{ trans('user.mass.delete_threads') }}</option>
                                    <option value="restore_posts">{{ trans('user.mass.restore_junked_posts') }}</option>
                                    <option value="restore_threads">{{ trans('user.mass.restore_junked_threads') }}</option>
                                </optgroup>
                            </select>
                        </div>
                        @include('forum.includes.partials.proceed_button')
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
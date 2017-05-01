@extends('layouts.admin')
@section('title', trans('admin.pages.title'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin.pages.index') !!}
@stop
@section('box')

    @include('errors.alert')

    @if (count($pages))
        <table class="table table-hover">
            <thead>
            <tr>
                <th width="70%">{{ trans('admin.pages.name') }}</th>
                <th width="20%">{{ trans('admin.pages.slug') }}</th>
                <th>{{ trans('mod.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pages as $page)
                <tr>
                    <td>{{ $page->title }}
                        {{-- Show creation time and updated time (if updated) --}}
                        <span class="help-block">
                            {{ trans('site.created.label') }} {{ $page->created_at }}
                            @if ($page->is_updated)
                                – {{ trans('site.updated.label') }} {{ $page->updated_at }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <code>{{ $page->slug }}</code>
                    </td>
                    <td>

                        <div class="dropdown">
                            <a class="dropdown-toggle btn btn-default" data-toggle="dropdown" href="#" aria-expanded="true">
                                {{ trans('site.options') }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="">
                                        {{ trans('site.view') }}
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ route('admin.page.edit', $page->id) }}">
                                        {{ trans('site.edit') }}
                                    </a>
                                </li>
                                @if (!$page->system_required)
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation">
                                        <form method="post" action="{{ route('admin.page.destroy', $page->id) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button name="ays-confirm" type="submit">
                                                {{ trans('site.delete') }}
                                            </button>
                                        </form>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        {{ trans('admin.pages.no_results') }}
    @endif

    <div class="text-right margin-top-20">
        <a href="{{ route('admin.page.create') }}">{{ trans('admin.pages.create_short') }}</a>
    </div>
@stop
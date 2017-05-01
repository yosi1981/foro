@extends('layouts.main')
@section('title', $member->info)
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-flat">
                @include('user.profile.includes.user_info_sidebar')
                <div class="box-footer text-center">

                    <p>
                        <a href="{{ route('user.all.threads', $member->info) }}" class="btn btn-primary">
                            <i class="fa fa-comment"></i> {{ trans('forum.thread.all') }}
                        </a>
                        <a href="{{ route('user.all.posts', $member->info) }}" class="btn btn-primary">
                            <i class="fa fa-comments"></i> {{ trans('forum.post.all') }}
                        </a>
                    </p>
                    
                    @if ($user->isAdmin())
                        <p>
                            <a href="{{ route('admin.user.show', $member->info) }}" class="btn btn-default">
                                {{ trans('admin.user.edit_in_panel') }}
                            </a>
                        </p>
                    @endif
                    @if ($user->isModerator() && !$member->isAdmin())
                        <p>
                            <a href="{{ route('mod.user.show', $member->info) }}" class="btn btn-default">
                                {{ trans('mod.user.edit_in_panel') }}
                            </a>
                        </p>
                    @endif
                </div>
            </div>
            @if($member->about_me)
                <div class="box box-flat">
                    <div class="box-body">
                        <span class="text-muted">{{ trans('user.about_me') }}:</span>
                        {{ $member->about_me }}
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">{{ trans('user.profile.activity') }}</a>
                    <li><a href="#general" data-toggle="tab">{{ trans('site.general') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        @if (count($posts))
                            @include('user.profile.includes.posts')
                        @else
                            {{ trans('user.no_recent_activity_found') }}
                        @endif
                    </div>

                    <div class="tab-pane fade" id="general">

                        @if ($member->can('forum-use-signature') && $member->hasSignature())
                            <h4>{{ trans('user.signature.label') }}</h4>
                            <div class="well">
                                <div {{ \App\Core\Core::signatureAttributes() }}>
                                    {!!   BBCode::parse($user->signature)  !!}
                                </div>
                            </div>
                            <hr>
                        @endif

                        <h4>{{ trans('user.role.full') }}</h4>
                        <b>{{ trans('user.role.primary') }}:</b> {{ @$member->primaryRole->display_name }}
                        <br>
                        @if(count($member->additionalRoles))
                            <b> {{ trans('user.role.additional') }}:</b>
                            <ul>
                                @foreach($member->additionalRoles as $role)
                                    <li>{{ $role->display_name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
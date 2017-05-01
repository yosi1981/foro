<div class="box-body box-profile">
    <img class="profile-user-img img-responsive img-circle" src="{{ $member->avatar }}" alt="{{ trans('user.avatar.label') }}">


    <h3 class="profile-username text-center">
        {{ $member->info }}
    </h3>
    @if ($member->forumTitle())
        <p class="text-center text-muted profile-stars">{!! $member->forumTitle()['stars'] !!}
            <br>
            {{ $member->forumTitle()['title'] }}
        </p>
    @endif

    @if ($member->primaryRole)
        <p class="text-muted text-center">
            {{ $member->primaryRole->display_name }}
        </p>
    @endif

    <ul class="list-group list-group-unbordered">
        <li class="list-group-item">
            <b>{{ trans_choice('user.id', 2) }}</b>
            <a class="pull-right">#{{ $member->id }}</a>
        </li>
        <li class="list-group-item">
            <b>{{ trans_choice('forum.thread.label', 2) }}</b>
            <a class="pull-right">{{ $member->threads->count() }}</a>
        </li>
        <li class="list-group-item">
            <b>{{ trans_choice('forum.post.label', 2) }}</b>
            <a class="pull-right">{{ $member->posts->count() }}</a>
        </li>
        <li class="list-group-item">
            <b>{{ trans('user.registered') }}</b>
            <a class="pull-right">{{ $member->created_at }}</a>
        </li>
        @if($user->can('viewLastActiveUser', $user))
            <li class="list-group-item">
                <b>{{ trans('user.last_active') }}</b>
                <a class="pull-right">{{ $member->active_at }}</a>
            </li>
        @endif
    </ul>
</div>
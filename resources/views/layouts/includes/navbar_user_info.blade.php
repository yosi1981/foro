<li class="dropdown user user-menu">
    <!-- Menu Toggle Button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <!-- The user image in the navbar-->
        <img src="{{ $user->avatar }}" class="user-image" alt="User Image">
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs">{{ $user->info }}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header">
            <img src="{{ $user->avatar }}" class="img-circle" alt="{{ trans('user.avatar.label') }}">

            <p>
                {{ $user->info }}
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="row">
                <div class="col-xs-4 text-center">
                    <a href="{{ route('user.all.threads', $user->info) }}">{{ trans_choice('forum.thread.label', 2) }}</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="{{ route('user.all.posts', $user->info) }}">{{ trans_choice('forum.post.label', 2) }}</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="{{ route('user.settings.index') }}">{{ trans('site.settings') }}</a>
                </div>
            </div>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="{{ $user->profileURL() }}" class="btn btn-default btn-flat">{{ trans('user.view_profile') }}</a>
            </div>
            <div class="pull-right">
                <a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat">{{ trans('site.logout') }}</a>
            </div>
        </li>
    </ul>
</li>
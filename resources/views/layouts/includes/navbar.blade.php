<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ url('/') }}" class="navbar-brand"><b>{{ site('site-name') }}</b></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li {{ setActive('/') }}>
                        <a href="/">{{ trans('site.home') }}</a>
                    </li>

                    <li {{ setActive(route('forum.home')) }}>
                        <a href="{{ route('forum.home') }}">{{ trans('forum.title') }}</a>
                    </li>

                    <li {{ setActive(route('user.all')) }}>
                        <a href="{{ route('user.all') }}">{{ trans('user.all') }}</a>
                    </li>

                    @if (@$signed_in)

                        @if ($user->isModerator())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ trans('mod.title') }}
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('mod.dashboard') }}">{{ trans('mod.dashboard') }}</a>
                                    <li>
                                        <a href="{{ route('mod.reported.index') }}">{{ trans('mod.report.reported') }}
                                            @if (\App\Core\Cache::grab('reported_posts_count'))
                                                <span class="badge alert-success">{{ App\Core\Cache::grab('reported_posts_count') }}</span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if ($user->isAdmin())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ trans('admin.title') }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('admin.index') }}">{{ trans('admin.panel') }}</a>
                                </ul>
                            </li>
                        @endif
                    @else
                        <li><a href="{{ route('auth.login')  }}">{{ trans('site.auth.login') }}</a></li>
                        <li><a href="{{ route('auth.register') }}">{{ trans('site.auth.register') }}</a></li>
                    @endif

                </ul>
            </div>

            <!-- Navbar Right Menu -->
            @if (@$signed_in)
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @include('layouts.includes.navbar_user_info')
                    </ul>
                </div>
            @endif

        </div>
    </nav>
</header>
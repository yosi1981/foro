<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $user->avatar }}" class="img-circle" alt="{{ trans('user.avatar.label') }}">
            </div>
            <div class="pull-left info">
                <p>{{ $user->info }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu">
            {{-- All sidebar links come from Core/NavigationMenu.php --}}
            @foreach ($links as $link)
                @if (count($link) != count($link, COUNT_RECURSIVE))
                    <li {{ setActive()->all($link['url']) }}>
                        @include('layouts.includes.sidebar_menu')
                    </li>
                @else
                    <li {{ setActive($link['url']) }}>
                        @include('layouts.includes.sidebar_menu')
                    </li>
                @endif
            @endforeach
        </ul>
    </section>

</aside>
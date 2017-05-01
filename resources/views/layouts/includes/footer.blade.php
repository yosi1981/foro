<footer class="main-footer">
    <div class="container">
        <div class="pull-right hidden-xs">
            <a href="{{ route('pages.show', 'terms') }}">Terms and Conditions</a>
        </div>
        @if (@$signed_in && $user->isAdmin())
            This page took {{ (microtime(true) - LARAVEL_START) }} seconds to render.
        @endif
    </div>
</footer>
<h3 style="color: #40666a;">Dear {{ $user->info }},</h3>

@yield('content')

<p>
    {{ site('site-name') }}
    <br/>
    {{ url('/') }}
</p>
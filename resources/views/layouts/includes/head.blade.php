<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
    @hasSection('title')
    @yield('title') - {{ site('site-name') }} @else {{ site('site-name') }} @endif
</title>
<meta name="description" content="@yield('description')">
<meta property="og:url" content="{{ Request::url() }}">

<link rel="stylesheet" href="{{ url('css/core.css') }}">
<link href="{{ asset('fonts/font-awesome/font-awesome.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('/adminLTE/css/skins/skin-red-light.css') }}">
@stack('css')
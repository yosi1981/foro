<html>
<head>
    @include('layouts.includes.head')
</head>
<body class="hold-transition skin-red-light sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Logo -->
            <a href="index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">AP</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>{{ site('site-name') }}</b> {{ trans('admin.title') }}</span>
            </a>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @include('layouts.includes.navbar_user_info')
                    </ul>
                </div>
            </nav>
        </header>

        @include('layouts.includes.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    @hasSection('box')
                        &nbsp;
                    @else
                        @yield('title')
                    @endif
                </h1>
                @yield('breadcrumbs')
            </section>

            <section class="content">
                @yield('content')
                @hasSection('box')
                    <div class="box box-flat">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                {{-- If there is a header for the box, use the header or else use the default title --}}
                                @hasSection('box-header')
                                    @yield('box-header')
                                @else
                                    @yield('title')
                                @endif
                            </h3>
                        </div>
                        @hasSection('box')
                            <div class="box-body">
                                @yield('box')
                            </div>
                        @endif
                        {{-- If there is a footer for the box --}}
                        @hasSection('box-footer')
                            <div class="box-footer">
                                @yield('box-footer')
                            </div>
                        @endif
                    </div>
                @endif
            </section>

        </div>
        @include('layouts.includes.footer')

    </div>
    @include('layouts.includes.scripts')
    <script src="{{ url('adminLTE/js/app.js') }}"></script>

</body>
</html>

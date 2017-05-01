<html>
<head>
    @include('layouts.includes.head')
</head>
<body class="skin-red-light layout-top-nav">
    <div class="wrapper">
        @include('layouts.includes.navbar')
        <div class="content-wrapper">
            <div class="container">
                {{-- Display account alerts --}}
                @include('errors.account_alerts')

                <section class="content-header">
                    <h1>
                        @yield('title')
                    </h1>
                    @yield('breadcrumbs')
                </section>

                <!-- Main content -->
                @yield('top_section')
                <section class="content">
                    @yield('content')
                </section>

            </div>

        </div>
        @include('layouts.includes.footer')
    </div>
    @include('layouts.includes.scripts')
</body>
</html>
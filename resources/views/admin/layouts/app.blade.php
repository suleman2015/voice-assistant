<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="utf-8" />
    <title>@yield('title') | Onc Brothers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ setting_image_url('favicon') }}" type="image/x-icon">

    <!-- plugin css -->
    <link href="{{ asset('assets/admin/dist/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/preloader.min.css') }}" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/admin/dist/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/admin/dist/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/admin/dist/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- alertifyjs Css -->
    <link href="{{ asset('assets/admin/dist/libs/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/admin/dist/libs/alertifyjs/build/css/themes/default.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/custom.css') }}" type="text/css" />
    @stack('styles')

    <style>
        :root {
            --primary-color: {{ setting('primary_color') ?? '#4e73df' }};
        }

        .pace .pace-activity {
            background: var(--primary-color);
        }

        .nav-tabs-custom .nav-item .nav-link {
            color: var(--primary-color);
        }

        .nav-tabs-custom .nav-item .nav-link.active {
            color: var(--primary-color);
        }

        .nav-tabs-custom .nav-item .nav-link::after {
            background: var(--primary-color);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 4px 10px 0 color-mix(in srgb, var(--primary-color), transparent 50%);

        }

        .btn-primary:hover {
            background-color: var(--primary-color) !important;
            box-shadow: 0 6px 14px 0 color-mix(in srgb, var(--primary-color), transparent 40%);
        }

        .mm-active .active i,
        .mm-active .active,
        #sidebar-menu ul li a:hover,
        .mm-active>a i {
            color: var(--primary-color) !important;
        }

        #sidebar-menu ul li a:hover * {
            color: var(--primary-color) !important;
        }

        .mm-active>a {
            color: var(--primary-color) !important;
        }

        .active>.page-link,
        .page-link.active {
            color: #fff !important;
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .page-link {
            color: var(--primary-color) !important;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        div.dataTables_processing>div:last-child>div {
            background: var(--primary-color) !important;
        }

        .view_website:hover {
            background: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background-color: var(--primary-color) !important;
        }

        .nav-pills .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .nav-pills .nav-link.active:hover {
            color: #fff !important;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 4px 10px 0 color-mix(in srgb, var(--primary-color), transparent 50%);
        }
    </style>

</head>

<body>
    <!-- <body data-layout="horizontal"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.components._header')

        @include('admin.components._left_sidebar')
        <div class="main-content">
            @yield('content')
            @include('admin.components._footer')
        </div>
    </div>
    <!-- END layout-wrapper -->

    @include('admin.components._right_sidebar')

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/admin/dist/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/feather-icons/feather.min.js') }}"></script>
    <!-- pace js -->
    <script src="{{ asset('assets/admin/dist/libs/pace-js/pace.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('assets/admin/dist/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('assets/admin/dist/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/admin/dist/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>
    <!-- dashboard init -->
    {{-- <script src="{{ asset('assets/admin/dist/js/pages/dashboard.init.js') }}"></script> --}}
    <script src="{{ asset('assets/admin/dist/js/app.js') }}"></script>
    <!-- alertifyjs js -->
    <script src="{{ asset('assets/admin/dist/libs/alertifyjs/build/alertify.min.js') }}"></script>
    @if (session('success'))
        <script>
            alertify.success('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            alertify.error('{{ session('error') }}');
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                alertify.error('{{ $error }}');
            </script>
        @endforeach
    @endif

    @stack('scripts')
</body>

</html>

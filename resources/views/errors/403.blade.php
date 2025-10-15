<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Minia - Minimal Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/src/images/favicon.ico') }}">

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
    @stack('styles')

</head>

<body>
    <!-- <body data-layout="horizontal"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        <div id="layout-wrapper">
            <div class="my-5 pt-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mb-5">
                                <h1 class="display-1 fw-semibold">4<span class="text-danger mx-2">0</span>3</h1>
                                <h4 class="text-uppercase">Forbidden. You don't have permission to access this page.</h4>
                                <div class="mt-5 text-center">
                                    <a class="btn btn-danger waves-effect waves-light"
                                        href="javascript:window.history.back()">Go
                                        Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-xl-8">
                            <div>
                                <img src="{{ asset('assets/admin/src/images/error-img.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END layout-wrapper -->


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
    <script src="{{ asset('assets/admin/dist/js/pages/dashboard.init.js') }}"></script>
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

<!DOCTYPE html>
@php
    $currentLang = \Modules\Language\Models\Language::where('short_code', app()->getLocale())->first();
@endphp
<html lang="{{ $currentLang ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Release Me - I Make My Chances')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="shortcut icon" href="{{ asset('assets/frontend/img/logo.png') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:slnt,wght@-10..0,100..900&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/frontend/img/logo.png') }}" type="image/png">
    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/lib/animate/animate.min.css') }}" />
    <link href="{{ asset('assets/frontend/lib/lightbox/css/lightbox.min.css" rel="stylesheet') }}">
    <link href="{{ asset('assets/frontend/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet') }}">
    <link href="{{ asset('assets/frontend/lib/owlcarousel/assets/owl.theme.default.css" rel="stylesheet') }}">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/frontend/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/frontend/css/style.css?time=' . time()) }}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/css/custom.css?time=' . time()) }}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/css/rtl.css?time=' . time()) }}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/css/mobile.css?time=' . time()) }}" rel="stylesheet">
    @yield('css')
</head>

<body class="{{ $currentLang && $currentLang->is_rtl ? 'rtl-body' : '' }}">
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->
    @foreach ($components as $component)
        @php
            $locale = app()->getLocale();
            $content = json_decode($component->content, true)[$locale] ?? [];
        @endphp

        @includeIf('pagebuilder::layouts.components._' . $component->section, [
            'content' => $content,
            'component' => $component,
        ])
    @endforeach
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/frontend/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
    <script src="{{ asset('assets/frontend/lib/lightbox/js/lightbox.min.js') }}"></script>

   

</body>

</html>

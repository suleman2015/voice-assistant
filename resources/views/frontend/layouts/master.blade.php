<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {{-- {!! TwitterCard::generate() !!} --}}
    {!! JsonLd::generate() !!}
    <link rel="shortcut icon" href="{{ setting_image_url('favicon') }}" type="image/x-icon">
    {{-- <link rel="shortcut icon" href="{{ asset('assets/frontend/img/logo.png') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css"
        integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css' . '?' . time()) }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/swiper/swiper-bundle.min.css' . '?' . time()) }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css' . '?' . time()) }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/page.css' . '?' . time()) }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css' . '?' . time()) }}" />

    @yield('css')

</head>

<body>

    <x-header />

    @yield('content')

    @include('frontend.components._footer')

    <!-- Scroll to top and cookie popup -->
    <div class="scroll-to-top show"><button>↑</button></div>
    {{-- <div class="cookie-popup">
        <p>This website uses <a href="cookie-policy.html" class="text-link-primary" target="_blank">Cookies</a> to
            ensure
            you receive the best experience.</p>
        <div class="cookie-buttons">
            <button class="accept-btn">I Agree</button>
            <button class="decline-btn">No Thanks</button>
        </div>
    </div> --}}


    @yield('scripts')
    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/scripts.js') }}"></script>

    <script>

        // Category sliders initialization
        [1, 2, 3].forEach(function(i) {
            new Swiper('.category-swiper-' + i, {
                spaceBetween: 5,
                slidesPerView: 'auto',
                slidesPerGroup: 2,
                breakpoints: {
                    320: {
                        slidesPerView: 3
                    },
                    480: {
                        slidesPerView: 3
                    },
                    768: {
                        slidesPerView: 4
                    },
                    1024: {
                        slidesPerView: 5
                    },
                    1280: {
                        slidesPerView: 6
                    }
                },
                navigation: {
                    nextEl: '.category-next-' + i,
                    prevEl: '.category-prev-' + i
                },
                pagination: {
                    el: '.category-pagination-' + i,
                    clickable: true
                }
            });
        });
    </script>

</body>

</html>

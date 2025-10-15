@extends('frontend.layouts.master')
@section('title', 'Live Events | oncbrothers.com')

@section('content')
    {{-- Hero Section --}}
    <div class="home_banner general-banner position-relative"
        style="background-image: url('{{ asset('assets/images/event-bg.webp') }}'); background-size:cover; background-position:center; min-height:360px;">
        <div class="top_bg2"></div>
        <div class="home_banner__inner position-relative">
            <div class="container">
                <h1 class="text-center banner-h fw-bold">Live Events</h1>
            </div>
        </div>
    </div>

    {{-- Page Content --}}
    <div class="container py-5">
        <div class="row">
            @include('frontend.live-events.item_list')
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal-overlay" style="display:none;">
        <div class="modal-content event-modal p-3 rounded shadow bg-white position-relative text-center">
            <button class="close-btn position-absolute top-0 end-0 m-3 border-0 bg-transparent fs-3 text-dark" type="button">
                <i class="ri-close-line"></i>
            </button>
            <h5 class="event-title mb-4 fw-bold"></h5>
            <img src="" alt="" class="event-img img-fluid mb-3 rounded">
            <a href="" target="_blank" class="btn btn-lg btn-outline-primary blu-outline rounded-pill event-link">
                Register Now
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/scripts.js') }}"></script>

    <script>
        $(function() {
            // ✅ OPEN modal when clicking any .media_link
            $(document).on('click', '.media_link', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let title = $(this).data('title') || $(this).closest('.col-md-4').find('.title-event').text().trim();
                let imgUrl = $(this).data('image');
                let linkUrl = $(this).data('link') || '#';

                $('.modal-overlay .event-title').text(title);
                $('.modal-overlay .event-img').attr('src', imgUrl).attr('alt', title);
                $('.modal-overlay .event-link').attr('href', linkUrl);

                $('.modal-overlay').fadeIn(200);
                $('body').css('overflow', 'hidden');
            });

            // ✅ CLOSE modal when clicking overlay or close button
            $(document).on('click', '.modal-overlay, .close-btn, .close-btn i', function(e) {
                $('.modal-overlay').fadeOut(200);
                $('body').css('overflow', 'auto');
            });

            // ✅ Prevent closing when clicking inside modal content
            $(document).on('click', '.modal-content', function(e) {
                e.stopPropagation();
            });
        });
    </script>
@endsection

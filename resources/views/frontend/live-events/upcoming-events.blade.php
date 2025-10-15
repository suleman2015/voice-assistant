@extends('frontend.layouts.master')

@section('content')
{{-- Hero Section --}}
<div class="home_banner general-banner position-relative"
    style="background-image: url('{{ asset('assets/images/event-bg.webp') }}'); background-size:cover; background-position:center; min-height:360px;">
    <div class="top_bg2"></div>
    <div class="home_banner__inner position-relative">
        <div class="container">
            <h1 class="text-center banner-h fw-bold">Upcoming Events</h1>
        </div>
    </div>
</div>

{{-- Upcoming Events --}}
<div class="container py-5">
    <div class="row g-4 justify-content-center">
        @forelse ($upcomingEvents as $event)
            <div class="col-md-6 text-center">
                <div class="event-card position-relative shadow-sm rounded overflow-hidden">
                    <h6 class="text-start px-3 pt-2 fw-semibold">
                        {{ $event->title ?? 'Untitled Event' }}
                    </h6>

                    {{-- Event Images --}}
                    @if ($event->images && $event->images->count() > 1)
                        {{-- Swiper Slider for multiple images --}}
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                @foreach ($event->images as $img)
                                    <div class="swiper-slide">
                                        <a href="javascript:void(0);" 
                                           class="media_link d-block" 
                                           data-title="{{ $event->title ?? 'Untitled Event' }}"
                                           data-image="{{ imageOrPlaceholder($img->image_url ?? null, 'assets/frontend/images/placeholder.jpg') }}" 
                                           data-link="{{ $event->register_link ?? '#' }}">
                                            <img src="{{ imageOrPlaceholder($img->image_url ?? null, 'assets/frontend/images/placeholder.jpg') }}" 
                                                 alt="{{ $event->title }}" 
                                                 class="img-fluid rounded-3 event-image w-100">
                                            @if($event->is_live)
                                                <span class="live-badge position-absolute top-0 end-0 m-2 badge bg-danger">LIVE EVENT</span>
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    @else
                        {{-- Single Image --}}
                        <a href="javascript:void(0);" 
                           class="media_link d-block" 
                           data-title="{{ $event->title ?? 'Untitled Event' }}"
                           data-image="{{ imageOrPlaceholder(optional($event->images->first())->image_url ?? ($event->image_url ?? null), 'assets/frontend/images/placeholder.jpg') }}" 
                           data-link="{{ $event->register_link ?? '#' }}">
                            <img src="{{ imageOrPlaceholder(optional($event->images->first())->image_url ?? ($event->image_url ?? null), 'assets/frontend/images/placeholder.jpg') }}" 
                                 alt="{{ $event->title }}" 
                                 class="img-fluid rounded-3 event-image w-100">
                            @if($event->is_live)
                                <span class="live-badge position-absolute top-0 end-0 m-2 badge bg-danger">LIVE EVENT</span>
                            @endif
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">No upcoming events at the moment.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Modal --}}
<div class="modal-overlay" style="display:none;">
    <div class="modal-content event-modal ">
        <button class="close-btn ">
            <i class="ri-close-line"></i>
        </button>
        <h5 class="event-title text-start mb-4 fw-normal"></h5>
        <img src="" alt="" class="event-img img-fluid mb-3 rounded">
        <div class="text-center">
            <a href="" target="_blank" class="btn btn-outline-primary blu-outline rounded-pill contact-button width-fix-content text-center" style="border: 1px solid rgb(36, 69, 110);">
                Register Now
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .event-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        .live-badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
            border-radius: 20px;
        }
        .modal-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex; align-items: center; justify-content: center;
            z-index: 9999;
        }
        .event-modal {
            max-width: 700px;
            width: 90%;
            background: #fff;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
@endpush

@section('scripts')
    {{-- Swiper JS --}}
    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Swiper JS -->
    <script src="{{ asset('assets/frontend/swiper/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('assets/frontend/js/scripts.js') }}"></script>
    <script>
        $(function() {
            // Initialize Swiper for each instance
            document.querySelectorAll(".mySwiper").forEach((swiperEl) => {
                new Swiper(swiperEl, {
                    loop: true,
                    pagination: { el: swiperEl.querySelector(".swiper-pagination"), clickable: true },
                    autoplay: { delay: 4000 },
                });
            });

            // OPEN modal when clicking .media_link
            $(document).on('click', '.media_link', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let title = $(this).data('title');
                let imgUrl = $(this).data('image');
                let linkUrl = $(this).data('link');

                $('.modal-overlay .event-title').text(title);
                $('.modal-overlay .event-img').attr('src', imgUrl).attr('alt', title);
                $('.modal-overlay .event-link').attr('href', linkUrl);

                $('.modal-overlay').fadeIn(200);
                $('body').css('overflow', 'hidden');
            });

            // CLOSE modal (overlay or button)
            $(document).on('click', '.modal-overlay, .close-btn', function(e) {
                if ($(e.target).is('.modal-overlay, .close-btn, i')) {
                    $('.modal-overlay').fadeOut(200);
                    $('body').css('overflow', 'auto');
                }
            });

            // Prevent modal close when clicking inside content
            $(document).on('click', '.modal-content', function(e) {
                e.stopPropagation();
            });
        });
    </script>
@endsection

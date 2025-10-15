@section('title', __('Cancer News: Hematology Oncology Advancements & Treatments'))
@extends('frontend.layouts.master')

@section('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/swiper/swiper-bundle.min.css') }}">
    <style>
        /* small tweaks for modal slider images */
        .modal .swiper-slide img {
            width: 100%;
            height: auto;
            object-fit: contain;
            max-height: 70vh;
        }

        .slide-item-card .event-image {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-radius: 6px;
        }

        /* ensure modal nav buttons look OK */
        .modal .swiper-button-prev,
        .modal .swiper-button-next {
            color: #fff;
        }

        /* Search Results section styling */
        #search-results {
            display: none;
            background: #f9f9f9;
            border-top: 1px solid #ddd;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="home_banner search_banner position-relative w-100" style="">
        <img src="assets/frontend/images/banner-bg.webp" alt="OncBrothers Banner" class="position-absolute w-100 h-100"
            style="object-fit:cover;z-index:0;" />
        <div class="top_bg2"></div>
        <div class="home_banner__inner position-relative">
            <div class="container">
                <h1 class="text-center banner-h mb-4">Discussions on Current &amp; New Treatments of Cancer</h1>
                <!-- Podcasts Section -->
                <div class="podcast-list text-center d-flex align-items-center justify-content-center my-4">
                    <h2 class="podcast-text me-3 mb-0">Podcasts: <span class="live-icon ms-2"><i
                                class="ri-volume-up-fill"></i></span>
                    </h2>
                    <ul class="pod-ul d-flex align-items-center mb-0">
                        <li>
                            <a href="https://podcasts.apple.com/us/podcast/oncology-brothers-practice-changing-cancer-discussions/id1653340966"
                                target="_blank" rel="nofollow noopener" class="pod-link d-flex align-items-center">
                                <img src="assets/frontend/images/apple-podcast.png" class="img-fluid pod-icon me-2"
                                    width="24" height="24" alt="apple-podcast" />
                                <span class="textprimary pod-title ms-1 text-uppercase">APPLE</span><i
                                    class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://podcasters.spotify.com/pod/show/oncology-brothers" target="_blank"
                                rel="nofollow noopener" class="pod-link d-flex align-items-center">
                                <img src="assets/frontend/images/spotify.png" class="img-fluid pod-icon me-2" width="24"
                                    height="24" alt="spotify-podcast" />
                                <span class="textprimary pod-title ms-1 text-uppercase">SPOTIFY</span><i
                                    class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/@oncologybrothers" target="_blank" rel="nofollow noopener"
                                class="pod-link d-flex align-items-center">
                                <img src="assets/frontend/images/youtube.png" class="img-fluid pod-icon me-2" width="26"
                                    height="25" alt="youtube-podcast" />
                                <span class="textprimary pod-title ms-1 text-uppercase">YOUTUBE</span><i
                                    class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://music.amazon.com/podcasts/c16f13ce-de1a-46ff-974a-fecb06fdbcbb/oncology-brothers"
                                target="_blank" rel="nofollow noopener" class="pod-link d-flex align-items-center">
                                <img src="assets/frontend/images/amazon-music.png" class="img-fluid pod-icon me-2"
                                    width="24" height="24" alt="amazon-music-podcast" />
                                <span class="textprimary pod-title ms-1 text-uppercase">AMAZON</span><i
                                    class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://infoaj7.podbean.com/" target="_blank" rel="nofollow noopener"
                                class="pod-link d-flex align-items-center">
                                <img src="assets/frontend/images/podbean.png" class="img-fluid pod-icon me-2"
                                    style="width: 24px; height: 24px;" alt="podbean-podcast" />
                                <span class="textprimary pod-title ms-1 text-uppercase">PODBEAN</span><i
                                    class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <form class="position-relative w-100" id="podcastSearchForm">
                    <div class="pocast-search-wraper d-flex text-center">
                        <div class="form-group position-relative form-floating-box me-md-3">
                            <input type="search" class="podcast_search form-control" placeholder="Search Podcast..."
                                autocomplete="off" />
                            <label class="form-floating-label">Search Podcast...</label>
                            <ul class="dropdown-menu sugestion-list w-100" style="display:none;"></ul>
                        </div>
                        <button type="button" class="search-btn btn btn-primary px-4">
                            <span class="search-text">Search</span>
                            <span><i class="ri-arrow-right-s-line"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 🔍 Search Results Section (hidden until AJAX loads) -->
    <div id="searchResultsContainer"></div>
    <!-- Upcoming Events Section -->
    @if ($upcomingEvents->count() > 0)
        <section class="slider-main-wrapper py-5 border-bar">
            <div class="container-fluid">
                <div class="category-slider">
                    <div class="category-block mb-5">
                        <div class="blog-title-wrapper d-flex align-items-center mb-md-3 mb-1">
                            <h2 class="mb-0">Upcoming Events</h2>
                            <span class="exp-all">
                                <a href="{{ route('upcomingEvents') }}" class="text-decoration-none">
                                    Explore All <i class="ri-arrow-right-s-line"></i>
                                </a>
                            </span>
                        </div>

                        <div class="slider-wrapper">
                            <div class="custom-swiper upcoming-swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($upcomingEvents as $event)
                                        <div class="swiper-slide">
                                            <div class="slide-item-card">
                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#eventModal{{ $event->id }}">
                                                    <img src="{{ imageOrPlaceholder(optional($event->images->first())->image_url ?? ($event->image_url ?? null), 'assets/frontend/images/placeholder.jpg') }}"
                                                        alt="{{ $event->title }}" class="event-image img-fluid">
                                                    <div class="post-title">
                                                        <h6 class="text-white small text-truncate">
                                                            {{ $event->title }}
                                                        </h6>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="swiper-button-prev upcoming-prev"></div>
                                <div class="swiper-button-next upcoming-next"></div>
                                <div class="swiper-pagination upcoming-pagination d-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Past Events Section (kept hidden if you want) -->
    @if ($pastEvents->count() > 0)
        <section class="slider-main-wrapper py-5 border-bar d-none">
            <div class="container-fluid d-none">
                <div class="category-slider">
                    <div class="category-block mb-5">
                        <div class="blog-title-wrapper d-flex align-items-center mb-md-3 mb-1">
                            <h2 class="mb-0">Past Events</h2>
                            <span class="exp-all">
                                <a href="" class="text-decoration-none">
                                    Explore All <i class="ri-arrow-right-s-line"></i>
                                </a>
                            </span>
                        </div>

                        <div class="slider-wrapper">
                            <div class="custom-swiper past-swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($pastEvents as $event)
                                        <div class="swiper-slide">
                                            <div class="slide-item-card">
                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#eventModal{{ $event->id }}">
                                                    <img src="{{ imageOrPlaceholder(optional($event->images->first())->image_url ?? ($event->image_url ?? null), 'assets/frontend/images/placeholder.jpg') }}"
                                                        alt="{{ $event->title }}" class="event-image img-fluid">
                                                    <div class="post-title">
                                                        <h6 class="text-white small text-truncate">
                                                            {{ $event->title }}
                                                        </h6>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="swiper-button-prev past-prev"></div>
                                <div class="swiper-button-next past-next"></div>
                                <div class="swiper-pagination past-pagination d-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Event Modals for Upcoming Events -->
    @foreach ($upcomingEvents as $event)
        <div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1"
            aria-labelledby="eventModalLabel{{ $event->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel{{ $event->id }}">
                            {{ $event->title }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Swiper slider for event images -->
                        <div id="modal-swiper-{{ $event->id }}" class="swiper modal-swiper"
                            data-event-id="{{ $event->id }}">
                            <div class="swiper-wrapper">
                                @if (!empty($event->image_url))
                                    <div class="swiper-slide">
                                        <img src="{{ imageOrPlaceholder($event->image_url, 'assets/frontend/images/placeholder.jpg') }}"
                                            class="img-fluid rounded mb-3" alt="{{ $event->title }}">
                                    </div>
                                @endif

                                @foreach ($event->images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ imageOrPlaceholder($image->image_url, 'assets/frontend/images/placeholder.jpg') }}"
                                            class="img-fluid rounded mb-3" alt="{{ $event->title }}">
                                    </div>
                                @endforeach

                                @if (empty($event->image_url) && $event->images->count() == 0)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('assets/frontend/images/placeholder.jpg') }}"
                                            class="img-fluid rounded mb-3" alt="{{ $event->title }}">
                                    </div>
                                @endif
                            </div>

                            <!-- navigation (unique per modal) -->
                            <div class="swiper-button-prev modal-prev-{{ $event->id }}"></div>
                            <div class="swiper-button-next modal-next-{{ $event->id }}"></div>
                            <div class="swiper-pagination modal-pagination-{{ $event->id }}"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="pod_btn">
                            @if ($event->event_date == null)
                                @foreach ($event->eventDates as $eventDate)
                                    @if (\Carbon\Carbon::parse($eventDate->date)->gte(now()))
                                        <a target="_blank" href="{{ $eventDate->link }}"
                                            class="btn btn-outline-primary blu-outline rounded-pill contact-button"
                                            style="border: 1px solid #24456e;">
                                            Register Now for {{ $eventDate->name ?? '' }}
                                        </a>
                                    @endif
                                @endforeach
                            @else
                                <a target="_blank" href="{{ $event->link }}"
                                    class="btn btn-outline-primary blu-outline rounded-pill contact-button"
                                    style="border: 1px solid #24456e;">
                                    Register Now
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Event Modals for Past Events -->
    @foreach ($pastEvents as $event)
        <div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1"
            aria-labelledby="eventModalLabel{{ $event->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel{{ $event->id }}">
                            {{ $event->title }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Swiper slider for past event images -->
                        <div id="modal-swiper-{{ $event->id }}" class="swiper modal-swiper"
                            data-event-id="{{ $event->id }}">
                            <div class="swiper-wrapper">
                                @if (!empty($event->image_url))
                                    <div class="swiper-slide">
                                        <img src="{{ imageOrPlaceholder($event->image_url, 'assets/frontend/images/placeholder.jpg') }}"
                                            class="img-fluid rounded mb-3" alt="{{ $event->title }}">
                                    </div>
                                @endif

                                @foreach ($event->images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ imageOrPlaceholder($image->image_url, 'assets/frontend/images/placeholder.jpg') }}"
                                            class="img-fluid rounded mb-3" alt="{{ $event->title }}">
                                    </div>
                                @endforeach

                                @if (empty($event->image_url) && $event->images->count() == 0)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('assets/frontend/images/placeholder.jpg') }}"
                                            class="img-fluid rounded mb-3" alt="{{ $event->title }}">
                                    </div>
                                @endif
                            </div>

                            <!-- navigation (unique per modal) -->
                            <div class="swiper-button-prev modal-prev-{{ $event->id }}"></div>
                            <div class="swiper-button-next modal-next-{{ $event->id }}"></div>
                            <div class="swiper-pagination modal-pagination-{{ $event->id }}"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <span class="text-muted small">This event has already taken place.</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Podcast Categories Slider -->
    <section class="slider-main-wrapper py-3 border-bar">
        <div class="container-fluid">
            <div class="category-slider">

                @foreach ($categories as $index => $category)
                    <div class="category-block mb-5">
                        <div class="blog-title-wrapper d-flex align-items-center mb-md-3 mb-1">
                            <h2 class="mb-0">{{ $category->name }}</h2>
                            <span class="exp-all">
                                <a href="{{ route('categoryPage', $category->slug) }}" class="text-decoration-none">
                                    Explore All <i class="ri-arrow-right-s-line"></i>
                                </a>
                            </span>
                        </div>

                        @if ($category->posts->count() > 0)
                            <div class="slider-wrapper">
                                <div class="custom-swiper category-swiper-{{ $index + 1 }}">
                                    <div class="swiper-wrapper">
                                        @foreach ($category->posts as $post)
                                            <div class="swiper-slide">
                                                <div class="slide-item-card">
                                                    <a href="{{ route('postPage', $post->slug) }}">
                                                        <img src="{{ imageOrPlaceholder($post->image, 'assets/frontend/images/placeholder.jpg') }}"
                                                            alt="{{ $post->name }}" class="event-image img-fluid">

                                                        <div class="post-title">
                                                            <h6 class="text-white small text-truncate">
                                                                {{ str_replace('&amp;', '&', $post->name) ?? '' }}
                                                            </h6>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="swiper-button-prev category-prev-{{ $index + 1 }}"></div>
                                    <div class="swiper-button-next category-next-{{ $index + 1 }}"></div>
                                    <div class="swiper-pagination category-pagination-{{ $index + 1 }} d-none"></div>
                                </div>
                            </div>
                        @else
                            <p class="text-muted small">No posts available in this category.</p>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about_section">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto mb-4">
                    <h2 class="goal-title">Oncology <br /> Brother’s Goal?</h2>
                    <p class="goal-content">Bridge the gap between academic research and community oncology practice. We
                        believe that everyone deserves access to the latest advancements and developments in cancer
                        treatment. Through our platform, we aim to share our insights on groundbreaking oncology news and
                        innovations, offering a comprehensive understanding of this ever-evolving field, so our patients can
                        get the best care close to home.</p>
                </div>
                <div class="col-md-6 hover-up-2 transition-normal">
                    <a href="{{ route('rohitGosainMd') }}" class="bio-link">
                        <div class="info-card m-lg-3 mb-4 shadow-lg">
                            <div class="profile-img">
                                <img src="assets/frontend/images/rohit.png" class="img-fluid" width="207"
                                    height="232" alt="Rohit Gosain" />
                            </div>
                            <div class="profile_text">
                                <h2 class="text-white">Rohit Gosain, <br /> MD</h2>
                                <p class="text-white mb-0">Rohit is Medical Director of Roswell Park Network Care in
                                    Southtowns.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 hover-up-2 transition-normal">
                    <a href="{{ route('rahulGosainMd') }}" class="bio-link">
                        <div class="info-card m-lg-3 shadow-lg">
                            <div class="profile-img">
                                <img src="assets/frontend/images/rahul.png" class="img-fluid" width="207"
                                    height="232" alt="Rahul Gosain" />
                            </div>
                            <div class="profile_text">
                                <h2 class="text-white">Rahul Gosain, <br /> MD, MBA</h2>
                                <p class="text-white mb-0">Rahul is a Medical Director of Wilmot Cancer Institute at
                                    Webster, Director of Wilmot Cancer Institute Regional Infusion services.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Swiper JS -->
    <script src="{{ asset('assets/frontend/swiper/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('assets/frontend/js/scripts.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Upcoming Events Slider
            new Swiper('.upcoming-swiper', {
                spaceBetween: 8,
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
                    nextEl: '.upcoming-next',
                    prevEl: '.upcoming-prev'
                },
                pagination: {
                    el: '.upcoming-pagination',
                    clickable: true
                }
            });

            // Past Events Slider (if visible)
            new Swiper('.past-swiper', {
                spaceBetween: 8,
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
                    nextEl: '.past-next',
                    prevEl: '.past-prev'
                },
                pagination: {
                    el: '.past-pagination',
                    clickable: true
                }
            });

            // Category sliders: create one per category
            var totalCategories = {{ $categories->count() }};
            for (var i = 1; i <= totalCategories; i++) {
                new Swiper('.category-swiper-' + i, {
                    spaceBetween: 8,
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
            }

            // Initialize modal Swipers dynamically (one Swiper instance per modal)
            document.querySelectorAll('.modal-swiper').forEach(function(swiperEl) {
                var eventId = swiperEl.getAttribute('data-event-id');

                // use class names specific to this modal for navigation/pagination
                var prevSelector = '.modal-prev-' + eventId;
                var nextSelector = '.modal-next-' + eventId;
                var pagSelector = '.modal-pagination-' + eventId;

                // create Swiper instance for modal
                new Swiper('#modal-swiper-' + eventId, {
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: pagSelector,
                        clickable: true
                    },
                    navigation: {
                        prevEl: prevSelector,
                        nextEl: nextSelector
                    },
                    slidesPerView: 1,
                    spaceBetween: 10
                });

                // ensure when modal opens, Swiper is updated/resized (use bootstrap shown)
                var modalSelector = '#eventModal' + eventId;
                var modalNode = document.querySelector(modalSelector);
                if (modalNode) {
                    modalNode.addEventListener('shown.bs.modal', function() {
                        // find swiper instance and update (Swiper automatically attaches to DOM id)
                        // trigger resize by dispatching resize event
                        setTimeout(function() {
                            window.dispatchEvent(new Event('resize'));
                        }, 100);
                    });
                }
            });

            // ============================================
            // NEW: Search suggestions dropdown (API-driven)
            // ============================================
            (function($) {
                const $input = $('.podcast_search');
                const $menu = $('.sugestion-list');
                const $btn = $('.search-btn');

                const SUGGEST_URL_TMPL = @json(route('api.get_suggestions', ['keywords' => '___QUERY___']));

                let debounceTimer = null;
                let activeIndex = -1;
                let pendingXHR = null;
                let suppressInput = false; // ✅ flag to stop retrigger after selection

                function showMenu(html) {
                    $menu.html(html)
                        .addClass('show')
                        .css('display', 'block');
                    activeIndex = -1;
                }

                function hideMenu() {
                    $menu.removeClass('show').hide().empty();
                    activeIndex = -1;
                }

                function fetchSuggestions(q) {
                    const url = SUGGEST_URL_TMPL.replace('___QUERY___', encodeURIComponent(q));
                    if (pendingXHR && typeof pendingXHR.abort === 'function') {
                        pendingXHR.abort();
                    }

                    pendingXHR = $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'json'
                    }).done(function(resp) {
                        if (resp && resp.view) {
                            showMenu(resp.view);
                        } else {
                            hideMenu();
                        }
                    }).fail(function(xhr, status) {
                        if (status !== 'abort') {
                            hideMenu();
                        }
                    }).always(function() {
                        pendingXHR = null;
                    });
                }

                function debounce(fn, wait) {
                    return function(...args) {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => fn.apply(this, args), wait);
                    }
                }

                // ✅ Debounced live search, skip if suppressed
                $input.on('input', debounce(function() {
                    if (suppressInput) {
                        suppressInput = false; // reset flag
                        return;
                    }

                    const q = $input.val().trim();
                    if (q.length < 2) {
                        hideMenu();
                        return;
                    }
                    fetchSuggestions(q);
                }, 250));

                // Focus -> show again if data already exists
                $input.on('focus', function() {
                    const q = $input.val().trim();
                    if (q.length >= 2 && $menu.children().length) {
                        $menu.addClass('show').css('display', 'block');
                    }
                });

                // Click outside -> hide
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.form-group').length) {
                        hideMenu();
                    }
                });

                // Keep menu open when interacting inside
                $menu.on('mousedown', function(e) {
                    e.preventDefault();
                });

                // ✅ Click suggestion -> fill input without retriggering API
                $(document).on('click', '.sugestion-list .dropdown-item', function() {
                    const text = $(this).text().trim();
                    if (text) {
                        suppressInput = true; // block next input trigger
                        $input.val(text);
                    }
                    hideMenu();
                });

                // Keyboard navigation
                $input.on('keydown', function(e) {
                    const $items = $menu.find('.dropdown-item');
                    if (!$items.length) return;

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        activeIndex = (activeIndex + 1) % $items.length;
                        $items.removeClass('active');
                        $items.eq(activeIndex).addClass('active')[0].scrollIntoView({
                            block: 'nearest'
                        });
                    }

                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        activeIndex = (activeIndex - 1 + $items.length) % $items.length;
                        $items.removeClass('active');
                        $items.eq(activeIndex).addClass('active')[0].scrollIntoView({
                            block: 'nearest'
                        });
                    }

                    if (e.key === 'Enter') {
                        if (activeIndex >= 0 && activeIndex < $items.length) {
                            e.preventDefault();
                            $items.eq(activeIndex).trigger('click');
                        } else {
                            hideMenu();
                        }
                    }

                    if (e.key === 'Escape') hideMenu();
                });
            })(jQuery);


            // ============================================
            // 🔍 AJAX Blog Search
            // ============================================
            (function($) {
                const $input = $('.podcast_search');
                const $resultsContainer = $('#searchResultsContainer');

                const BLOG_SEARCH_URL_TMPL = @json(route('api.get_blogs', ['keywords' => '___QUERY___']));
                let pendingXHR = null;

                function fetchBlogs(q) {
                    const url = BLOG_SEARCH_URL_TMPL.replace('___QUERY___', encodeURIComponent(q));
                    if (pendingXHR && typeof pendingXHR.abort === 'function') pendingXHR.abort();

                    pendingXHR = $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $resultsContainer.html(
                                '<p class="text-center py-5 mb-0">Loading...</p>');
                        }
                    }).done(function(resp) {
                        if (resp && resp.view) {
                            $resultsContainer.html(resp.view);
                        } else {
                            $resultsContainer.html(
                                '<p class="text-center py-5 mb-0">No results found.</p>');
                        }
                    }).fail(function() {
                        $resultsContainer.html(
                            '<p class="text-center py-5 mb-0 text-danger">Error loading results.</p>'
                        );
                    }).always(() => pendingXHR = null);
                }

                // ✅ Handle main search submit
                $('.search-btn').on('click', function() {
                    const q = $input.val().trim();
                    if (q.length > 1) fetchBlogs(q);
                });

            })(jQuery);
        });
    </script>
@endsection

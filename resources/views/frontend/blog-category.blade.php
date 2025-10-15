@section('title', __('Algorithms'))
@extends('frontend.layouts.master')
@section('content')
    <div class="home_banner general-banner position-relative"
        style="background-image: url('assets/frontend/images/banner-bg.webp'); background-size:cover; background-position:center; ">
        <div class="top_bg2"></div>
        <div class="home_banner__inner position-relative">
            <div class="container">
                <h1 class="text-center banner-h fw-bold">Algorithms</h1>
            </div>
        </div>
    </div>
    <section class="slider-main-wrapper py-5">
        <div class="container-fluid">
            <div class="blog-title-wrapper d-flex align-items-center mb-md-3 mb-1">
                <h3 class="mb-0 fw-bold">Algorithms</h3>
            </div>
            <div class="slider-wrapper">
                <div class="custom-swiper category-posts-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="blog-details.html" class="text-decoration-none">
                                <div class="slide-item-card">
                                    <img src="assets/frontend/images/agenda.webp" alt="Post Title 1"
                                        class="event-image img-fluid">
                                    <div class="post-title">
                                        <h6 class="text-white small text-truncate">Understanding the Basics</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="blog-details.html" class="text-decoration-none">
                                <div class="slide-item-card">
                                    <img src="assets/frontend/images/banner2.webp" alt="Post Title 2"
                                        class="event-image img-fluid">
                                    <div class="post-title">
                                        <h6 class="text-white small text-truncate">Key Algorithms in Practice</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="blog-details.html" class="text-decoration-none">
                                <div class="slide-item-card">
                                    <img src="assets/frontend/images/article.webp" alt="Post Title 3"
                                        class="event-image img-fluid">
                                    <div class="post-title">
                                        <h6 class="text-white small text-truncate">Recent Advances</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="blog-details.html" class="text-decoration-none">
                                <div class="slide-item-card">
                                    <img src="assets/frontend/images/post.webp" alt="Post Title 4"
                                        class="event-image img-fluid">
                                    <div class="post-title">
                                        <h6 class="text-white small text-truncate">Case Studies</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-button-prev posts-prev"></div>
                    <div class="swiper-button-next posts-next"></div>
                    <div class="swiper-pagination posts-pagination d-none"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var postsSwiper = new Swiper('.category-posts-swiper', {
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
                nextEl: '.posts-next',
                prevEl: '.posts-prev'
            },
            pagination: {
                el: '.posts-pagination',
                clickable: true
            }
        });
    </script>
@endsection

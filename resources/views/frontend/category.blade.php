@section('title', $category->name . ' — Cancer News & Oncology Insights')
@extends('frontend.layouts.master')

@section('content')
    <style>
        .breadcrumb-item a,
        .breadcrumb-item.active {
            color: #fff !important;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: #fff !important;
        }
    </style>
    <!-- Hero Section -->
    <div class="home_banner cat_banner position-relative w-100">
        @php
            $imageFolder = 'blogs/categories/images';
            $imagePath = $category->image ? public_path($imageFolder . '/' . $category->image) : null;
            $categoryImage =
                $category->image && file_exists($imagePath)
                    ? asset($imageFolder . '/' . $category->image)
                    : asset('assets/frontend/images/banner-bg.webp');
        @endphp

        <img src="{{ $categoryImage }}" alt="{{ $category->name }}" class="position-absolute w-100 h-100"
            style="object-fit:cover;z-index:0;" />

        <div class="top_bg2"></div>
        <div class="home_banner__inner cat_banner__inner position-relative text-center py-5">
            <div class="container">
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">{{ __('Home') }}</a>
                        </li>

                        @php
                            // ✅ Recursive function to display parent hierarchy
                            function renderParentBreadcrumbs($category)
                            {
                                if ($category->parent) {
                                    renderParentBreadcrumbs($category->parent);
                                    echo '<li class="breadcrumb-item ">
                              <a href="' .
                                        route('categoryPage', $category->parent->slug) .
                                        '">' .
                                        e($category->parent->name) .
                                        '</a>
                          </li>';
                                }
                            }

                            // Call recursive breadcrumb rendering
                            renderParentBreadcrumbs($category);
                        @endphp

                        <li class="breadcrumb-item text-white active" aria-current="page">{{ $category->name }}</li>
                    </ol>
                </nav>


                <!-- Category Title -->
                <h1 class="text-white fw-bold mb-0">
                    {{ $category->name }}
                </h1>
                @if ($category->description)
                    <p class="text-white-50 mt-2 w-75 mx-auto">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Category Content -->
    <section class="slider-main-wrapper py-3 border-bar">
        <div class="container-fluid">
            <div class="category-slider">

                {{-- ✅ Case 1: Show subcategories --}}
                @forelse ($category->childrenRecursive as $index => $subcategory)
                    @if ($subcategory->posts->count() > 0)
                        <div class="category-block mb-5">
                            <div class="blog-title-wrapper d-flex align-items-center mb-md-3 mb-1">
                                <h2 class="mb-0">{{ $subcategory->name }}</h2>
                                <span class="exp-all">
                                    <a href="{{ route('categoryPage', $subcategory->slug) }}" class="text-decoration-none">
                                        Explore All <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </span>
                            </div>

                            <div class="slider-wrapper">
                                <div class="custom-swiper category-swiper-{{ $index + 1 }}">
                                    <div class="swiper-wrapper">
                                        @foreach ($subcategory->posts as $post)
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
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- ✅ Case 2: No subcategories — show posts directly --}}
                @empty
                    @if ($category->posts->count() > 0)
                        <div class="category-block mb-5">
                            <div class="blog-title-wrapper d-flex align-items-center mb-md-3 mb-1">
                                <h2 class="mb-0">{{ $category->name }}</h2>
                                <span class="exp-all">
                                    <a href="{{ route('categoryPage', $category->slug) }}" class="text-decoration-none">
                                        Explore All <i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </span>
                            </div>

                            <div class="slider-wrapper">
                                <div class="custom-swiper category-swiper-main">
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

                                    <div class="swiper-button-prev category-prev-main"></div>
                                    <div class="swiper-button-next category-next-main"></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <h5 class="text-muted">No posts available in this category.</h5>
                        </div>
                    @endif
                @endforelse

            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/frontend/swiper/swiper-bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let total = {{ $category->childrenRecursive->count() }};

            if (total > 0) {
                for (let i = 1; i <= total; i++) {
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
                        }
                    });
                }
            } else if (document.querySelector('.category-swiper-main')) {
                new Swiper('.category-swiper-main', {
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
                        nextEl: '.category-next-main',
                        prevEl: '.category-prev-main'
                    }
                });
            }
        });
    </script>
@endsection

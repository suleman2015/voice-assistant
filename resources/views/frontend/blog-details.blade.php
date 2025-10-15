@section('title', $post->seoMeta->seo_data['seo_title'] ?? $post->name)
@extends('frontend.layouts.master')

@section('content')

    <!-- Hero -->
    <div class="home_banner general-banner position-relative"
        style="background-image: url('assets/frontend/images/banner-bg.webp'); background-size:cover; background-position:center;">
        <div class="top_bg2"></div>
        <div class="home_banner__inner position-relative">
            <div class="container">
                <h1 class="text-center banner-h fw-bold">{{ $post->name }}</h1>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container py-4">

        <div class="row">
            <div class="col-md-12">
                <!-- Meta Info -->
                <div class="d-flex justify-content-between text-secondary align-items-center small fw-semibold my-4">
                    <div class="kp_date">
                        <i class="ri-calendar-2-line"></i> {{ $post->created_at->format('F j, Y') }}
                    </div>
                    <div class="d-md-none">
                        @foreach ($post->categories as $cat)
                            <span class="kp_badge me-2 text-white">{{ $cat->name }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Categories & Share -->
                <div class="d-flex justify-content-between align-items-center my-md-3 my-2 kp-badge-share-wrapper mb-2">
                    <div class="d-none d-md-block">
                        @foreach ($post->categories as $cat)
                            <span class="kp_badge me-2">{{ $cat->name }}</span>
                        @endforeach
                    </div>
                    <div class="d-flex align-items-center gap-md-3 gap-2 text-secondary small fw-semibold mb-3">
                        <span class="kp_date">Share This:</span>
                        <div class="kp-share-icons d-flex gap-3">
                            @php
                                $shareUrl = urlencode(url()->current());
                                $shareText = urlencode($post->name);
                            @endphp
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank"><i
                                    class="ri-facebook-fill"></i></a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
                                target="_blank"><i class="ri-linkedin-box-fill"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}"
                                target="_blank"><i class="ri-twitter-x-line"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mt-0">

        <!-- Key Points & Doctor -->
        <div class="row mb-4 mb-md-5">
            <!-- ✅ If doctor image is missing, expand key points full width -->
            <div class="{{ $post->dr_image ? 'col-md-9' : 'col-md-12' }}">
                @if (!empty($post->key_points))
                    <h3 class="title_head mb-4">Key Points</h3>
                    <div class="kp-list list-unstyled mb-4 small">
                        @foreach ($post->key_points as $point)
                            <div class="mb-3 d-flex align-items-start position-relative ps-4">
                                <span>{{ $point }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Doctor Profile (only if image exists) -->
            @if ($post->dr_image)
                <div class="col-md-3 d-flex justify-content-center flex-column">
                    <div class="author_name">
                        <i class="ri-user-fill"></i>
                        By {{ $post->author_name ?? ($post->author->name ?? 'Admin') }}
                    </div>

                    <div class="kp-profile-card text-center shadow-sm" style="background:#2c3e50;">
                        <img src="{{ asset($post->dr_image) }}" class="img-fluid rounded mb-2"
                            alt="{{ $post->dr_name ?? 'Profile' }}">
                    </div>

                    @if ($post->dr_name)
                        <div class="text-center text-white small">{{ $post->dr_name }}</div>
                    @endif
                </div>
            @endif
        </div>

        <!-- YouTube or Podcast Section -->
        @if ($post->yt_link || $post->spotify_link || $post->apple_link)
            <div class="kp-video-container shadow-sm mb-5">
                @if ($post->yt_link)
                    @php
                        // Convert short YouTube URL (youtu.be/abc) to embed form
                        $youtubeLink = $post->yt_link;

                        if (Str::contains($youtubeLink, 'youtu.be')) {
                            $videoId = Str::afterLast($youtubeLink, '/');
                            $youtubeLink = 'https://www.youtube.com/embed/' . $videoId;
                        } elseif (Str::contains($youtubeLink, 'watch?v=')) {
                            $videoId = Str::after($youtubeLink, 'watch?v=');
                            $youtubeLink = 'https://www.youtube.com/embed/' . $videoId;
                        }
                    @endphp
                    <div class="ratio ratio-16x9 mb-4">
                        <iframe width="560" height="315" src="{{ $youtubeLink }}" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                @endif

                @if ($post->spotify_link || $post->apple_link)
                    <div class="kp-footer">
                        <div class="kp-footer-text">Listen Podcast On Your Favorite Platform:</div>
                        <div class="d-flex gap-3 flex-wrap">
                            @if ($post->spotify_link)
                                <a target="_blank" rel="noopener noreferrer" href="{{ $post->spotify_link }}"
                                    class="podcast_btn spotify d-flex align-items-center text-white shadow">
                                    <img alt="Spotify" width="37" class="me-2"
                                        src="{{ asset('assets/frontend/images/spotify.svg') }}">
                                    <span>Listen On <br> <strong>Spotify</strong> Podcasts</span>
                                </a>
                            @endif
                            @if ($post->apple_link)
                                <a target="_blank" rel="noopener noreferrer" href="{{ $post->apple_link }}"
                                    class="podcast_btn apple d-flex align-items-center text-white shadow">
                                    <img alt="Apple" width="37" class="me-2"
                                        src="{{ asset('assets/frontend/images/apple-podcast.svg') }}">
                                    <span>Listen On <br> <strong>Apple</strong> Podcasts</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Blog Content -->
        <article class="blog-content text-white mb-4">
            {!! $post->content !!}
        </article>

        <!-- Tags -->
        @if ($post->tags->count())
            <div class="mb-5">
                <h6 class="text-white fw-bold mb-2">Tags:</h6>
                <div>
                    @foreach ($post->tags as $tag)
                        <a href="javascript:void(0);" class="text-white text-decoration-underline me-2">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Related Posts -->
    <div class="container pb-5">
        @php $relatedPosts = $post->relatedPosts(); @endphp
        @if ($relatedPosts->count())
            <h3 class="mb-4 text-uppercase fw-bold text-white border-bottom pb-2">Related Posts</h3>
            @foreach ($relatedPosts as $related)
                <div class="row align-items-center mb-4">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <a href="{{ route('postPage', $related->slug) }}" class="d-block rounded overflow-hidden"
                            style="background-image: url('{{ imageOrPlaceholder($related->image, 'assets/frontend/images/placeholder.jpg') }}'); background-size: cover; background-position: center; height: 180px;"></a>
                    </div>
                    <div class="col-md-9">
                        <div class="text-white small mb-1">
                            @foreach ($related->categories as $cat)
                                <span class="me-2">{{ $cat->name }}</span>
                            @endforeach
                            <span class="text-white">{{ $related->created_at->format('F j, Y') }}</span>
                        </div>
                        <h5 class="fw-bold text-white">
                            <a href="{{ route('postPage', $related->slug) }}" class="text-white text-decoration-none">
                                {{ $related->name }}
                            </a>
                        </h5>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection

@section('scripts')
@endsection

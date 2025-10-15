<!-- Header Start -->
<div class="container-fluid bg-breadcrumb"
    style="background-image: url('{{ asset($content['background_image']['value'] ?? 'assets/frontend/img/default.png') }}');">
    <div class="container text-center py-5 backdrop_filter3" style="max-width: 900px;">
        <h4 class="text-warning h-shadow display-4 wow fadeInUp" data-wow-delay="0.1s">
            {{ $content['title']['value'] ?? '' }}
        </h4>
        <p class="wow fadeInUp page_tagline" data-wow-delay="0.2s">
            {{ $content['subtitle']['value'] ?? '' }}
        </p>
        <a href="{{ $content['button_link']['value'] ?? '#' }}"
           class="btn btn-warning rounded-pill py-2 px-4 ms-3 white-space-nowrap flex-shrink-0">
            {{ $content['button_text']['value'] ?? 'Read more' }} <i class="fa fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>
<!-- Header End -->

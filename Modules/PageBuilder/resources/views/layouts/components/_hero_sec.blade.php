<div class="hero-section bg-primary py-md-5 py-0"
    style="background-image: url({{ asset($content['background']['value']) }});">
    <div class="container">
        <div class="row g-4 align-items-center justify-content-center">
            <div class="col-lg-8 col-12 text-center text-white z-index-2">
                <h4 class="text-uppercase fw-bold mb-4 text-white wow fadeInUp" data-wow-delay="0.1s">
                    {{ $content['subtitle']['value'] }}
                </h4>
                <h1 class="display-2 mb-4 text-warning h-shadow wow fadeInUp" data-wow-delay="0.2s">
                    {{ $content['title']['value'] }}
                </h1>
                <p class="mb-5 fs-5 wow fadeInUp" data-wow-delay="0.3s">
                    {{ $content['description']['value'] }}
                </p>
                <div class="d-flex justify-content-center flex-shrink-0 mb-4 wow fadeInUp" data-wow-delay="0.5s">
                    <a class="btn btn-warning mobile__btns border-2 rounded-pill py-3 px-4 px-md-5 me-2"
                        href="{{ url($content['primary_button_url']['value']) }}">
                        {{ $content['primary_button_label']['value'] }}
                    </a>
                    <a class="btn btn-outline-warning rounded-pill mobile__btns border-2 py-3 px-4 px-md-5 ms-2"
                        href="{{ url($content['secondary_button_url']['value']) }}">
                        {{ $content['secondary_button_label']['value'] }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

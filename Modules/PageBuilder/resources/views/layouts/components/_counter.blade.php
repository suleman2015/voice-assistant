<section class="impact-section text-center"
    style="background-image: url({{ asset('assets/' . $content['background']['value'] ?? 'assets/frontend/img/counter-bg.jpg') }});">
    <div class="container impact-content py-5 ">
        <h2 class="impact-title wow fadeInUp" data-wow-delay="0.2s">
            {{ $content['section_title']['value'] ?? '' }}
        </h2>

        <div class="row justify-content-center text-white">
            {{-- Stat 1 --}}
            <div class="col-12 col-md-4 mb-4 mb-md-0">
                <span class="impact-stat" data-toggle="counter-up">
                    {{ $content['stat_1_number']['value'] ?? '' }}
                </span>
                <span class="dt-icon fw-bold text-white">
                    {{ $content['stat_1_suffix']['value'] ?? '' }}
                </span>
                <div class="impact-label">
                    {{ $content['stat_1_label']['value'] ?? '' }}
                </div>
            </div>

            {{-- Stat 2 --}}
            <div class="col-12 col-md-4 mb-4 mb-md-0">
                <span class="impact-stat" data-toggle="counter-up">
                    {{ $content['stat_2_number']['value'] ?? '' }}
                </span>
                <span class="dt-icon fw-bold text-white">
                    {{ $content['stat_2_suffix']['value'] ?? '' }}
                </span>
                <div class="impact-label">
                    {{ $content['stat_2_label']['value'] ?? '' }}
                </div>
            </div>

            {{-- Stat 3 --}}
            <div class="col-12 col-md-4">
                <span class="impact-stat" data-toggle="counter-up">
                    {{ $content['stat_3_number']['value'] ?? '' }}
                </span>
                <span class="dt-icon fw-bold text-white">
                    {{ $content['stat_3_suffix']['value'] ?? '' }}
                </span>
                <div class="impact-label">
                    {{ $content['stat_3_label']['value'] ?? '' }}
                </div>
            </div>
        </div>
    </div>
</section>

{{-- @php
    $content = $component['content'][app()->getLocale()] ?? [];
@endphp --}}

<!-- About Start -->
<div class="container-fluid about pt-3">
    <div class="container py-5">
        <div class="text-center mx-auto pb-md-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h1 class="display-4 mb-4 text-primary">
                {{ $content['section_title']['value'] ?? '' }}
            </h1>
        </div>

        <div class="wow fadeInUp" data-wow-delay="0.3s">
            <div class="row g-md-5 g-2 justify-content-center">

                {{-- Card 1: Vision --}}
                <div class="col-sm-4 mb-3 mb-xl-0">
                    <div class="counter-item card_style1 h-100">
                        <div class="card-top {{ $content['card_1_bg']['value'] ?? '' }}">
                            <span class="icon-primary">
                                <i class="{{ $content['card_1_icon']['value'] ?? '' }}"></i>
                            </span>
                            <div class="counter-counting">
                                <span class="fs-2 fw-bold">{{ $content['card_1_title']['value'] ?? '' }}</span>
                            </div>
                        </div>
                        <div class="card_body">
                            <p class="mb-0">{{ $content['card_1_description']['value'] ?? '' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Mission --}}
                <div class="col-sm-4 mb-3 mb-xl-0">
                    <div class="counter-item card_style1 h-100">
                        <div class="card-top {{ $content['card_2_bg']['value'] ?? '' }}">
                            <span class="icon-primary">
                                <i class="{{ $content['card_2_icon']['value'] ?? '' }}"></i>
                            </span>
                            <div class="counter-counting">
                                <span class="fs-2 fw-bold">{{ $content['card_2_title']['value'] ?? '' }}</span>
                            </div>
                        </div>
                        <div class="card_body">
                            <p class="mb-0">{{ $content['card_2_description']['value'] ?? '' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Values --}}
                <div class="col-sm-4">
                    <div class="counter-item card_style1 h-100">
                        <div class="card-top {{ $content['card_3_bg']['value'] ?? '' }}">
                            <span class="icon-primary">
                                <i class="{{ $content['card_3_icon']['value'] ?? '' }}"></i>
                            </span>
                            <div class="counter-counting">
                                <span class="fs-2 fw-bold">{{ $content['card_3_title']['value'] ?? '' }}</span>
                            </div>
                        </div>
                        <div class="card_body">
                            <ul>
                                @for ($i = 1; $i <= 4; $i++)
                                    @php $key = 'card_3_list_' . $i; @endphp
                                    @if (!empty($content[$key]['value']))
                                        <li>{{ $content[$key]['value'] }}</li>
                                    @endif
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Our Story --}}
                <div class="col-md-12">
                    <div class="our_story card_style1">
                        <div class="col-content pad_40">
                            <h3 class="mb-md-4 mb-3 fw-900 text-primary">
                                {{ $content['story_heading']['value'] ?? '' }}
                            </h3>
                            <p class="mb-4">{{ $content['story_body']['value'] ?? '' }}</p>

                            <div class="qoute_card">
                                <div class="qoute_icon">
                                    <i class="fas fa-quote-left"></i>
                                </div>
                                <p class="qoute_text mb-0">{{ $content['story_quote']['value'] ?? '' }}</p>
                            </div>

                            <div class="custom-card-footer">
                                <a href="{{ $content['read_more_link']['value'] ?? '#' }}"
                                    class="gradient-style-btn theme-style-btn rounded-pill">
                                    {{ $content['read_more_text']['value'] ?? 'Read More' }} <i
                                        class="fa fa-arrow-right ms-2"></i>
                                </a>
                                <a href="{{ $content['watch_story_link']['value'] ?? '#' }}"
                                    class="outline-style-btn theme-style-btn rounded-pill">
                                    {{ $content['watch_story_text']['value'] ?? 'Watch Story' }} <i
                                        class="fa fa-play ms-2"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-image"
                            style="background-image: url('{{ asset('assets/' . $content['story_image']['value'] ?? 'assets/frontend/img/default.jpg') }}');">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- About End -->

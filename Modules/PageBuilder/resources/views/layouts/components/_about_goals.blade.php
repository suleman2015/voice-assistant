<!-- Goal Start -->
<div class="container-fluid about pt-3">
    <div class="container py-md-5">
        <div class="text-center mx-auto pb-md-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h1 class="display-4 mb-4 text-primary">{{ $content['section_title']['value'] ?? 'Our Goals' }}</h1>
        </div>
        <div class="wow fadeInUp" data-wow-delay="0.3s">
            <div class="row g-5 justify-content-center">
                @for ($i = 1; $i <= 5; $i++)
                    @php
                        $titleKey = "goal_{$i}_title";
                        $descKey = "goal_{$i}_description";
                        $iconKey = "goal_{$i}_icon";
                        $bgKey = "goal_{$i}_bg";

                        $title = $content[$titleKey]['value'] ?? '';
                        $desc = $content[$descKey]['value'] ?? '';
                        $icon = $content[$iconKey]['value'] ?? '';
                        $bgColor = $content[$bgKey]['value'] ?? '#ccc'; // fallback
                    @endphp

                    <div class="col-sm-{{ $i > 3 ? 6 : 4 }} mb-3 mb-xl-0">
                        <div class="counter-item card_style1 h-100">
                            <div class="card-top" style="background: {{ $bgColor }};">
                                <span class="icon-primary"><i class="{{ $icon }}"></i></span>
                                <div class="counter-counting">
                                    <span class="goal-title">{{ $title }}</span>
                                </div>
                            </div>
                            <div class="card_body">
                                <p class="mb-0">{{ $desc }}</p>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
<!-- Goal End -->

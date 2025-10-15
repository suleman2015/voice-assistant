<section class="py-md-5">
    <div class="container py-md-5">
        <h2 class="section-title mb-5">
            {{ $content['section_title']['value'] ?? 'Our valued partners' }}
        </h2>

        <div class="brand-sections">
            <div class="brand_image">
                <img src="{{ asset('assets/frontend/img/brand-1.png') }}" alt="" class="img-fluid">
            </div>
            <div class="brand_image">
                <img src="{{ asset('assets/frontend/img/brand-2.png') }}" alt="" class="img-fluid">
            </div>
            <div class="brand_image">
                <img src="{{ asset('assets/frontend/img/brand-3.png') }}" alt="" class="img-fluid">
            </div>
            <div class="brand_image">
                <img src="{{ asset('assets/frontend/img/brand-4.png') }}" alt="" class="img-fluid">
            </div>
        </div>

        <div class="text-center">
            <div class="btn btn-primary my-5 py-3 px-5 rounded-pill">
                {{ $content['button_text']['value'] ?? 'Become a partner' }}
                <i class="fas fa-handshake ms-2"></i>
            </div>
        </div>
    </div>
</section>

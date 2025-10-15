@php
    // Collect slides from the flat JSON structure
    $slides = [];
    for ($i = 1; $i <= 3; $i++) {
        $slides[] = [
            'image' => $content["slide_{$i}_image"]['value'],
            'alt' => $content["slide_{$i}_alt"]['value'],
            'title' => $content["slide_{$i}_title"]['value'],
            'description' => $content["slide_{$i}_description"]['value'],
        ];
    }
@endphp

<div id="carouselExampleCaptions" class="carousel slide" style="height: calc(100vh - 140px);">
    <div class="carousel-indicators">
        @foreach ($slides as $index => $slide)
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}"
                class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                aria-label="Slide {{ $index + 1 }}">
            </button>
        @endforeach
    </div>
    <div class="carousel-inner h-100">
        @foreach ($slides as $index => $slide)
            <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset($slide['image']) }}" class="d-block w-100" alt="{{ $slide['alt'] }}">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="display-2 mb-4 text-warning h-shadow">{{ $slide['title'] }}</h5>
                    <p class="mb-5 fs-5">{{ $slide['description'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb"
    style="background-image: url('{{ asset($content['header_background']['value'] ?? 'assets/frontend/img/default-bg.png') }}');">
    <div class="container text-center py-5 backdrop_filter3" style="max-width: 900px;">
        <h4 class="text-warning h-shadow display-4 wow fadeInDown" data-wow-delay="0.1s">
            {{ $content['header_title']['value'] ?? 'Default Title' }}
        </h4>
    </div>
</div>

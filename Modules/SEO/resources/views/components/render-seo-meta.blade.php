@props(['model'])

@php
    $seo = $model?->seoMeta?->seo_data ?? [];
@endphp

@if (!empty($seo))
    @if (!empty($seo['seo_title']))
        <title>{{ $seo['seo_title'] }}</title>
    @endif

    @if (!empty($seo['seo_description']))
        <meta name="description" content="{{ $seo['seo_description'] }}">
    @endif

    @if (!empty($seo['meta_keywords']) && is_array($seo['meta_keywords']))
        <meta name="keywords" content="{{ implode(',', $seo['meta_keywords']) }}">
    @endif

    @if (!empty($seo['og_title']))
        <meta property="og:title" content="{{ $seo['og_title'] }}">
    @endif

    @if (!empty($seo['twitter_title']))
        <meta name="twitter:title" content="{{ $seo['twitter_title'] }}">
    @endif

    @if (!empty($seo['schema']) && is_array($seo['schema']))
        <script type="application/ld+json">
            {!! json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endif
@endif

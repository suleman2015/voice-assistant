@php
    // small helpers for active states
    $isActive = function($url) {
        if (! $url || $url === '#') return false;
        return request()->fullUrlIs($url) || str_starts_with(url()->current(), rtrim($url,'/'));
    };
@endphp

<ul class="navbar-nav ms-auto align-items-lg-center main-nav">
    @foreach($menu->items as $item)
        @include('menu::frontend.partials.li', ['item' => $item, 'isActive' => $isActive])
    @endforeach
</ul>

@push('styles')
<style>
/* desktop hover dropdowns */
@media (min-width: 992px) {
  .navbar .dropdown:hover > .dropdown-menu { display:block; margin-top:0; }
  .navbar .dropdown-toggle::after { margin-inline-start:.35rem; }
  .dropdown-menu-end { right:0; left:auto; }
}

/* support RTL (optional) */
html[dir="rtl"] .dropdown-menu { text-align:right; }
html[dir="rtl"] .dropdown-toggle::after { margin-inline-start:0; margin-inline-end:.35rem; }

/* highlight active link */
.main-nav .nav-link.active { color: var(--bs-primary) !important; font-weight: 600; }
</style>
@endpush

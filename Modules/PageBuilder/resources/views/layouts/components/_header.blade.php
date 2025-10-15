<!-- Navbar & Hero Start -->
<div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="{{ url('/') }}" class="navbar-brand p-0">
                <img src="{{ asset($content['logo']['value']) }}" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-0 mx-lg-auto">
                    @for ($i = 1; $i <= 7; $i++)
                        @php
                            $labelKey = 'menu_' . $i . '_label';
                            $urlKey = 'menu_' . $i . '_url';
                            $url = $content[$urlKey]['value'] ?? '#';
                            $label = $content[$labelKey]['value'] ?? '';
                        @endphp

                        <a href="{{ url($url) }}"
                           class="nav-item nav-link {{ request()->is(ltrim($url, '/')) ? 'active' : '' }}">
                            {{ $label }}
                        </a>
                    @endfor

                    <!-- Mobile View Join Us -->
                    <a href="{{ url($content['join_url']['value']) }}"
                       class="nav-item nav-link d-block d-lg-none {{ request()->is(ltrim($content['join_url']['value'], '/')) ? 'active' : '' }}">
                        {{ $content['join_label']['value'] }}
                    </a>
                </div>

                <!-- Desktop View Join Us Button -->
                <div class="nav-btn px-3 d-none d-md-block">
                    <a href="{{ url($content['join_url']['value']) }}"
                       class="btn btn-warning rounded-pill py-2 px-4 ms-3 white-space-nowrap flex-shrink-0">
                        {{ $content['join_label']['value'] }}
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar & Hero End -->

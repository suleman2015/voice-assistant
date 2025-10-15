<header class="main-header">
    <div class="container-fluid px-4">
        <!-- DESKTOP NAV -->
        <nav class="navbar navbar-header desktop-header">
            <div class="d-flex align-items-center">
                <a href="{{ route('home') }}" class="me-5">
                    <img src="{{ asset('assets/frontend/images/logo.webp') }}" class="img-fluid logo-img" width="115" height="32" alt="logo">
                </a>

                @if($menu && $menu->items->count())
                    <ul class="navlist">
                        @foreach($menu->items as $item)
                            @php
                                $itemUrl = '#';
                                if ($item->url) {
                                    $itemUrl = $item->url;
                                } elseif ($item->reference && $item->reference->slug) {
                                    $itemUrl = $item->type === 'category'
                                        ? url('/blogs/'.$item->reference->slug)
                                        : url('/'.$item->reference->slug);
                                }
                            @endphp

                            @if($item->children->count())
                                <li class="list_item dropdown">
                                    <a href="{{ $itemUrl }}" class="nav_link">
                                        {{ $item->title }}
                                        <i class="ri-arrow-down-s-line"></i>
                                    </a>
                                    <ul class="dropdown-menu-box">
                                        @foreach($item->children as $child)
                                            @php
                                                $childUrl = '#';
                                                if ($child->url) {
                                                    $childUrl = $child->url;
                                                } elseif ($child->reference && $child->reference->slug) {
                                                    $childUrl = $child->type === 'category'
                                                        ? url('/blogs/'.$child->reference->slug)
                                                        : url('/'.$child->reference->slug);
                                                }
                                            @endphp
                                            <li class="dropdown-item dropdown">
                                                <a href="{{ $childUrl }}">
                                                    <span>{{ $child->title }}</span>
                                                    @if($child->children->count())
                                                        <i class="ri-arrow-right-s-line"></i>
                                                    @endif
                                                </a>
                                                @if($child->children->count())
                                                    <ul class="submenu">
                                                        @foreach($child->children as $subchild)
                                                            @php
                                                                $subUrl = '#';
                                                                if ($subchild->url) {
                                                                    $subUrl = $subchild->url;
                                                                } elseif ($subchild->reference && $subchild->reference->slug) {
                                                                    $subUrl = $subchild->type === 'category'
                                                                        ? url('/blogs/'.$subchild->reference->slug)
                                                                        : url('/'.$subchild->reference->slug);
                                                                }
                                                            @endphp
                                                            <li>
                                                                <a href="{{ $subUrl }}">{{ $subchild->title }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="list_item">
                                    <a href="{{ $itemUrl }}" class="nav_link" @if($item->is_new_tab) target="_blank" @endif>
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>

            <ul class="social_linklist">
                <li><a href="https://twitter.com/oncbrothers" target="_blank" class="social_icon twitter"><i class="ri-twitter-x-line"></i></a></li>
                <li class="mx-2"><a href="https://www.youtube.com/@oncologybrothers" target="_blank" class="social_icon youtube"><i class="ri-youtube-fill"></i></a></li>
                <li><a href="https://www.instagram.com/oncbrothers/" target="_blank" class="social_icon instagram"><i class="ri-instagram-fill"></i></a></li>
            </ul>
        </nav>

        <!-- MOBILE NAV BAR -->
        <nav class="navbar navbar-header pt-2 mobile-header">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/frontend/images/logo.webp') }}" class="img-fluid logo-img" width="115" height="32" alt="logo">
            </a>
            <p class="mobile-toggle mb-0" style="padding:10px;cursor:pointer;">☰ Menu</p>
        </nav>

        <!-- MOBILE MENU -->
        <div class="mobile_menu">
            <ul class="mobile-ul">
                <li class="list_item"><a href="{{ route('home') }}" class="nav_link">Home</a></li>

                @if($menu && $menu->items->count())
                    @foreach($menu->items as $item)
                        @php
                            $itemUrl = '#';
                            if ($item->url) {
                                $itemUrl = $item->url;
                            } elseif ($item->reference && $item->reference->slug) {
                                $itemUrl = $item->type === 'category'
                                    ? url('/blogs/'.$item->reference->slug)
                                    : url('/'.$item->reference->slug);
                            }
                        @endphp

                        @if($item->children->count())
                            <li class="list_item dropdown">
                                <div class="menu-item-wrapper">
                                    <a href="{{ $itemUrl }}" class="nav_link">{{ $item->title }}</a>
                                    <button class="dropdown-toggle-btn">+</button>
                                </div>
                                <ul class="dropdown-menu-box closed">
                                    @foreach($item->children as $child)
                                        @php
                                            $childUrl = '#';
                                            if ($child->url) {
                                                $childUrl = $child->url;
                                            } elseif ($child->reference && $child->reference->slug) {
                                                $childUrl = $child->type === 'category'
                                                    ? url('/blogs/'.$child->reference->slug)
                                                    : url('/'.$child->reference->slug);
                                            }
                                        @endphp
                                        <li><a href="{{ $childUrl }}">{{ $child->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="list_item">
                                <a href="{{ $itemUrl }}" class="nav_link">{{ $item->title }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>

            <ul class="social_linklist">
                <li><a href="https://twitter.com/oncbrothers" target="_blank" class="social_icon twitter"><i class="ri-twitter-x-line"></i></a></li>
                <li class="mx-2"><a href="https://www.youtube.com/@oncologybrothers" target="_blank" class="social_icon youtube"><i class="ri-youtube-fill"></i></a></li>
                <li><a href="https://www.instagram.com/oncbrothers/" target="_blank" class="social_icon instagram"><i class="ri-instagram-fill"></i></a></li>
            </ul>
        </div>
    </div>
</header>

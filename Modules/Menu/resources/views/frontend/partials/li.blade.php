@php
    $hasChildren = $item->children && $item->children->count();
    $url = menu_url($item);
    $active = $isActive($url);
@endphp

<li class="nav-item {{ $hasChildren ? 'dropdown' : '' }}">
    <a
        @if($hasChildren)
            class="nav-link dropdown-toggle {{ $active ? 'active' : '' }}"
            href="#" id="m{{ $item->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false"
        @else
            class="nav-link {{ $active ? 'active' : '' }}"
            href="{{ $url }}" {!! $item->is_new_tab ? 'target="_blank" rel="noopener"' : '' !!}
        @endif
    >
        {{ $item->title }}
    </a>

    @if($hasChildren)
        <ul class="dropdown-menu" aria-labelledby="m{{ $item->id }}">
            @foreach($item->children as $child)
                @php
                    $childHas = $child->children && $child->children->count();
                    $childUrl = menu_url($child);
                    $childActive = $isActive($childUrl);
                @endphp

                <li class="{{ $childHas ? 'dropend' : '' }}">
                    @if($childHas)
                        <a class="dropdown-item dropdown-toggle {{ $childActive ? 'active' : '' }}" href="#" id="m{{ $child->id }}" data-bs-toggle="dropdown">
                            {{ $child->title }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="m{{ $child->id }}">
                            @foreach($child->children as $gchild)
                                <li>
                                    <a class="dropdown-item {{ $isActive(menu_url($gchild)) ? 'active' : '' }}"
                                       href="{{ menu_url($gchild) }}" {!! $gchild->is_new_tab ? 'target="_blank" rel="noopener"' : '' !!}>
                                        {{ $gchild->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <a class="dropdown-item {{ $childActive ? 'active' : '' }}"
                           href="{{ $childUrl }}" {!! $child->is_new_tab ? 'target="_blank" rel="noopener"' : '' !!}>
                            {{ $child->title }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</li>

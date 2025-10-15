@php
    $hasChildren = $item->children && $item->children->count();
    $url = menu_url($item);
    $cid = "mm-{$item->id}";
@endphp

<div class="list-group-item px-0">
    <div class="d-flex align-items-center justify-content-between">
        <a class="text-decoration-none flex-grow-1 py-2" href="{{ $hasChildren ? '#' : $url }}"
           {!! $item->is_new_tab ? 'target="_blank" rel="noopener"' : '' !!}>
            {{ $item->title }}
        </a>

        @if($hasChildren)
            <button class="btn btn-sm btn-outline-secondary ms-2" type="button"
                    data-bs-toggle="collapse" data-bs-target="#{{ $cid }}" aria-expanded="false" aria-controls="{{ $cid }}">
                <i class="bi bi-chevron-down"></i>
            </button>
        @endif
    </div>

    @if($hasChildren)
        <div class="collapse mt-1" id="{{ $cid }}">
            <div class="list-group list-group-flush ms-3">
                @foreach($item->children as $child)
                    @include('menu::frontend.partials.mobile-item', ['item' => $child])
                @endforeach
            </div>
        </div>
    @endif
</div>

<div class="suggestion-menu">
    @php
        $hasTags = $tags->count() > 0;
        $hasPosts = $suggestion->count() > 0;
    @endphp

    @if ($hasTags || $hasPosts)
        <div class="list-autocomplete" role="menu" aria-label="Search Suggestions">
            @if ($hasTags)
                <h6 class="dropdown-header text-uppercase small fw-semibold px-3">Tags</h6>
                @foreach ($tags as $tag)
                    <button type="button" class="dropdown-item" data-type="tag" data-value="{{ $tag->name }}">
                        {{ $tag->name ?? '' }}
                    </button>
                @endforeach
            @endif

            @if ($hasTags && $hasPosts)
                <div class="dropdown-divider"></div>
            @endif

            @if ($hasPosts)
                <h6 class="dropdown-header text-uppercase small fw-semibold px-3">Posts</h6>
                @foreach ($suggestion as $item)
                    <button type="button" class="dropdown-item" data-type="post" data-value="{{ $item->name }}">
                        {{ $item->name ?? '' }}
                    </button>
                @endforeach
            @endif
        </div>
    @else
        <i class="hasNoResults">No matching results</i>
    @endif
</div>

@foreach ($componentsAvailable as $component)
    <div class="item" draggable="true" data-index="{{ $component->id }}">
        <input type="hidden" name="component[]" value="{{ $component->id }}">
        <div class="details">
            <img src="{{ asset('assets/' . ($component->icon ?? 'images/placeholder-image.jpg')) }}">
            <span>{{ $component->name }}</span>
        </div>

        <span class="component-manage me-3" title="{{ __('Manage Component') }}" data-bs-toggle="tooltip"
            data-bs-placement="top">
            <a href="{{ route('components.edit', ['component' => $component->id, 'page' => $page->id ?? $pageId]) }}"
                target="_blank"> <i class="bi bi-tools fs-5"></i> </a>
        </span>

        <span class="manage-drag" title="{{ __('Add to Page') }}" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="bi bi-node-plus text-primary fs-3"></i>
        </span>
    </div>
@endforeach

@if ($componentsAvailable->isEmpty())
    <h4 class="text-center text-muted h5">{{ __('No Component Available') }}</h4>
@endif

<div class="row g-3">
    @foreach ($sections as $section)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card h-100 shadow-sm border border-dark">
                <div class="card-preview bg-light d-flex align-items-center justify-content-center"
                    style="height: 150px; overflow: hidden;">
                    {{-- <img src="{{ asset('assets/' . $section->preview) }}" class="img-fluid mh-100"
                        style="max-width: 100%; object-fit: contain;" alt="{{ $section->name }}"> --}}
                </div>

                <div class="card-body d-flex flex-column p-3">
                    <div class="mb-0">
                        <span class="badge bg-info text-white mb-0">
                            <a href="{{ route('components.index', ['component_display' => $currentDisplay, 'component_category' => $section->category]) }}"
                                class="text-white text-decoration-none">
                                {{ ucfirst($section->category) }}
                            </a>
                        </span>
                        <h6 class="card-title m-0">{{ $section->name }}</h6>
                    </div>

                    <div class="mt-auto d-flex flex-wrap gap-0">
                        <a class="btn btn-primary btn-sm py-1"
                            href="{{ route('components.edit', ['component' => $section, 'component_display' => $currentDisplay, 'component_category' => $currentCategory]) }}">
                            {{ __('Manage') }}
                        </a>
                        @if ($section->type === 'dynamic')
                            <button type="button" class="delete-btn btn btn-danger btn-sm py-1"
                                data-id="{{ $section->id }}" data-name="{{ $section->name }}">
                                <i class="bi bi-trash3-fill"></i> Delete
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

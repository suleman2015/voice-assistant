<div class="table-responsive">
    <table class="table user-table table-hover align-items-center">
        <thead>
            <tr>
                <th class="border-bottom">{{ __('Icon') }}</th>
                <th class="border-bottom">{{ __('Name') }}</th>
                <th class="border-bottom">{{ __('Category') }}</th>
                <th class="border-bottom">{{ __('Type') }}</th>
                <th class="border-bottom">{{ __('Status') }}</th>
                <th class="border-bottom">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sections as $section)
                <tr>
                    <td class=""><img src="{{ asset('assets/' . $section->preview) }}" class="avatar"
                            alt="Avatar">
                    </td>
                    <td><span class="fw-bold">{{ $section->name }}</span></td>
                    <td><span class="fw-bold "> <a
                                href="{{ route('components.index', ['component_display' => $currentDisplay, 'component_category' => $section->category]) }}">
                                {{ ucfirst($section->category) }} </a></span></td>
                    <td><span class="fw-bold">{{ ucwords($section->type) }}</span></td>
                    <td><span
                            class="fw-bold text-{{ $section->status ? 'success' : 'danger' }}">{{ $section->status ? 'Active' : 'Inactive' }}</span>
                    </td>
                    <td>
                        <a
                            href="{{ route('components.edit', ['component' => $section, 'component_display' => $currentDisplay, 'component_category' => $currentCategory]) }}">
                            <i class="bi bi-pencil-fill text-primary"></i>
                        </a>
                        @if ($section->type === 'dynamic')
                            <button type="button" class="delete-btn btn btn-link p-0 m-0 border-0"
                                data-id="{{ $section->id }}" data-name="{{ $section->name }}">
                                <i class="bi bi-trash3-fill text-danger"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

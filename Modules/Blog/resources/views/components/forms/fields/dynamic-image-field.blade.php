@php
    use Illuminate\Support\Str;

    $inputId = $inputId ?? ($name . 'Input');
    $previewId = $previewId ?? ($name . 'Preview');
    $value = $value ?? old($name, '');
    $hasValue = !empty($value);

    if ($hasValue) {
        // Case 1: Full URL (http/https)
        if (Str::startsWith($value, ['http://', 'https://'])) {
            $imagePath = $value;
        }
        // Case 2: Already inside /uploads or any public path
        elseif (Str::startsWith($value, ['uploads/', 'storage/', 'blogs/', 'images/'])) {
            $imagePath = asset($value);
        }
        // Case 3: Plain filename (prepend provided $path if set)
        elseif (!empty($path ?? '')) {
            $imagePath = asset(trim($path, '/') . '/' . ltrim($value, '/'));
        }
        // Case 4: Fallback to value itself
        else {
            $imagePath = asset($value);
        }
    } else {
        // Default placeholder
        $imagePath = asset('images/placeholder-image.jpg');
    }
@endphp

<div class="mb-3">
    <label class="form-label d-block">{{ $label }}</label>

    <div class="d-inline-block mb-2" style="cursor: pointer;"
        onclick="openMediaModal('{{ $inputId }}', '{{ $previewId }}')">
        <img id="{{ $previewId }}" src="{{ $imagePath }}"
            style="width: 170px; height: 170px; object-fit: cover;" class="img-thumbnail" />
    </div>

    <input type="text" id="{{ $inputId }}" name="{{ $name }}" class="form-control d-none"
        value="{{ $value }}" />

    @include('components.media-file-selector', [
        'folders' => $folders ?? [],
        'files' => $files ?? [],
        'currentFolder' => $currentFolder ?? '',
    ])
</div>

@push('scripts')
    <script>
        let selectedInputId = null;
        let selectedPreviewId = null;

        function openMediaModal(inputId, previewId) {
            selectedInputId = inputId;
            selectedPreviewId = previewId;

            const modal = new bootstrap.Modal(document.getElementById('mediaModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const mediaTrigger = document.getElementById('media-trigger');
                if (mediaTrigger) {
                    mediaTrigger.classList.add('d-none');
                }
            }, 1000);
        });
    </script>
@endpush

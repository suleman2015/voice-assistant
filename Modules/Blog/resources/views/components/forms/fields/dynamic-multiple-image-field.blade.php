@php
    $inputId = $name . 'Input';
    $previewId = $name . 'Preview';

    $valueArray = [];
    if (!empty($values)) {
        if (is_array($values)) {
            $valueArray = $values;
        } elseif (is_string($values)) {
            $decoded = json_decode($values, true);
            $valueArray = is_array($decoded) ? $decoded : [];
        }
    }
@endphp

<div class="mb-3">
    <label class="form-label d-block">{{ $label }}</label>

    <div class="d-flex flex-wrap gap-2 border rounded p-2 align-items-center justify-content-start"
        id="{{ $previewId }}" style="min-height: 120px; cursor: pointer;"
        onclick="openMultipleMediaModal('{{ $inputId }}', '{{ $previewId }}', {{ $multiple ? 'true' : 'false' }})">

        @if ($multiple && !empty($valueArray))
            @foreach ($valueArray as $img)
                <div class="position-relative me-2 mb-2">
                    <img src="{{ asset($img) }}" style="width: 100px; height: 100px; object-fit: cover;"
                        class="img-thumbnail" />
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image-btn"
                        onclick="event.stopPropagation(); removeImageFromField('{{ $inputId }}', '{{ $previewId }}', '{{ $img }}')">×</button>
                </div>
            @endforeach
        @else
            <div class="text-muted" style="font-size: 14px;">Click to upload/select images</div>
        @endif
    </div>

    <input type="hidden" id="{{ $inputId }}" name="{{ $name }}"
        value="{{ $multiple ? json_encode($valueArray) : $valueArray[0] ?? '' }}" />

    {{-- File Manager Modal --}}
    @include('components.multiple-media-file-selector', [
        'folders' => $folders ?? [],
        'files' => $files ?? [],
        'currentFolder' => $currentFolder ?? '',
    ])
</div>

@php
    $inputId = $name . 'Input';
    $previewId = $name . 'Preview';
    $wrapperId = $name . 'Wrapper';
    $hasValue = !empty($value);
    $basePath = $path ?? 'blogs/posts/images/';
    $imagePath = $hasValue ? asset($basePath . $value) : asset('images/placeholder-image.jpg');
@endphp

<div class="mb-3">
    <div class="card">
        <div class="card-header">
            <label class="form-label d-block">{{ $label }}</label>
        </div>

        <div class="card-body">
            <div id="{{ $wrapperId }}" class="position-relative d-inline-block mb-2"
                style="width: 130px; height: 130px; cursor: pointer;" onclick="triggerUpload{{ ucfirst($name) }}()">

                <img id="{{ $previewId }}" src="{{ $imagePath }}" class="img-thumbnail rounded"
                    style="width: 130px; height: 130px; object-fit: contain; background: #f9f9f9;" />

                <button type="button" class="btn btn-sm btn-light position-absolute top-0 end-0"
                    onclick="remove{{ ucfirst($name) }}Image(event)" style="border-radius: 50%; z-index: 2;">
                    &times;
                </button>
            </div>

            <input type="file" name="{{ $name }}" id="{{ $inputId }}" accept="image/*"
                class="form-control mb-1" onchange="preview{{ ucfirst($name) }}Image(event)">

            <a href="#" onclick="promptImageUrl{{ ucfirst($name) }}(); return false;">Add from URL</a>
        </div>
    </div>
</div>


@once
    @push('scripts')
        <script>
            function triggerUpload{{ ucfirst($name) }}() {
                const input = document.getElementById('{{ $inputId }}');
                input.click();
            }

            function preview{{ ucfirst($name) }}Image(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    document.getElementById('{{ $previewId }}').src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }

            function remove{{ ucfirst($name) }}Image(e) {
                e.stopPropagation(); // prevent triggering upload
                document.getElementById('{{ $previewId }}').src = '{{ asset('images/placeholder-image.jpg') }}';
                document.getElementById('{{ $inputId }}').value = '';
            }

            function promptImageUrl{{ ucfirst($name) }}() {
                const url = prompt("Enter image URL:");
                if (url) {
                    document.getElementById('{{ $previewId }}').src = url;
                    document.getElementById('{{ $inputId }}').value = '';
                }
            }
        </script>
    @endpush
@endonce

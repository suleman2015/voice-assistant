@php
    $id = $name . '-editor';
    $currentValue = old($name, $value ?? '');
@endphp

<!-- TinyMCE CSS (optional skin) -->
<style>
    .tox .tox-toolbar,
    .tox .tox-toolbar__primary {
        border-radius: 4px 4px 0 0;
    }

    .tox .tox-edit-area {
        min-height: 400px !important;
    }
</style>

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}{{ $required ? ' *' : '' }}</label>

    <textarea id="{{ $id }}" name="{{ $name }}"
        class="form-control tinymce-editor @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}>{{ $currentValue }}</textarea>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- TinyMCE 6 CDN -->
<script src="https://cdn.tiny.cloud/1/53lqpps1bve7au7hhkojzvu5hfhv3hkb96qpvyhr5y7pf0fy/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            height: 500,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: [
                'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor |',
                'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table |',
                'charmap code fullscreen preview | removeformat help'
            ],
            image_advtab: true,
            relative_urls: false,
            remove_script_host: false,
            document_base_url: '/',
            branding: false,
            toolbar_mode: 'sliding',
        });
    });
</script>

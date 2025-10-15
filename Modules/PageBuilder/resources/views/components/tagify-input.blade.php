@pushOnce('styles')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />
@endPushOnce

<div class="{{ $wrapperClass }}">
    <div class="form-group">
        <label for="{{ $id }}">{{ __($label) }}</label>
        <input
            class="{{ $class }}"
            name="{{ $name }}"
            id="{{ $id }}"
            type="text"
            value="{{ old($name, $value) }}"
        >
    </div>
</div>

@pushOnce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
@endPushOnce

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.tags-evs').forEach(function (input) {
                if (!input._tagify) {
                    input._tagify = new Tagify(input);
                }
            });
        });
    </script>
@endpush

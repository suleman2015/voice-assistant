<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}{{ $required ? ' *' : '' }}
    </label>
    <input type="text"
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        data-slug-model="{{ $modelClass }}"
        data-slug-id="{{ $id }}"
        data-force-slug="{{ old($name, $value) ? '0' : '1' }}">
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-generate-slug]').forEach(source => {
        const targetSelector = source.getAttribute('data-generate-slug');
        const target = document.querySelector(targetSelector);
        if (!target) return;

        // Track manual edits
        let manuallyEdited = false;
        target.addEventListener('input', () => manuallyEdited = true);

        source.addEventListener('input', function () {
            // Only auto-generate slug if field is empty or not manually edited
            if (manuallyEdited || (target.value && target.dataset.forceSlug === '0')) return;

            let baseSlug = source.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');

            const model = target.dataset.slugModel;
            const id = target.dataset.slugId;

            if (!model) {
                target.value = baseSlug;
                return;
            }

            fetch(`/slug/check?slug=${baseSlug}&model=${encodeURIComponent(model)}&id=${id}`)
                .then(res => res.json())
                .then(data => target.value = data.slug)
                .catch(err => console.error('Slug fetch error:', err));
        });
    });
});
</script>
@endpush

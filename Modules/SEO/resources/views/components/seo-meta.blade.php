@props(['model' => null])

@php
    $seo = $model?->seoMeta?->seo_data ?? [];
    $hasSeo = !empty(array_filter($seo));
    $seoImage = $seo['seo_image'] ?? null;
@endphp

<div class="card mt-4 seo-meta-box">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">SEO Options</h5>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#seoMetaBox">
            <i class="fas fa-chevron-{{ $hasSeo ? 'up' : 'down' }}"></i>
        </button>
    </div>

    <div id="seoMetaBox" class="collapse {{ $hasSeo ? 'show' : '' }}">
        <div class="card-body">
            <div class="form-group mb-3">
                <label>SEO Title</label>
                <input type="text" name="seo[seo_title]" class="form-control"
                    value="{{ old('seo.seo_title', $seo['seo_title'] ?? '') }}">
            </div>

            <div class="form-group mb-3">
                <label>SEO Description</label>
                <textarea name="seo[seo_description]" class="form-control" rows="3">{{ old('seo.seo_description', $seo['seo_description'] ?? '') }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label>SEO Keywords</label>
                <input type="text" name="seo[meta_keywords]" id="seo-meta-keywords" class="form-control tags-evs"
                    value="{{ old('seo.meta_keywords', is_array($seo['meta_keywords'] ?? null) ? implode(',', $seo['meta_keywords']) : '') }}">
            </div>

            <div class="form-group mb-3">
                <label>SEO Schema Markup (JSON)</label>
                <textarea name="seo[schema]" class="form-control" rows="4">{{ old('seo.schema', is_array($seo['schema'] ?? null) ? json_encode($seo['schema'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : ($seo['schema'] ?? '')) }}</textarea>
            </div>

            {{-- ✅ SEO IMAGE UPLOAD --}}
            <div class="form-group mb-3">
                <label for="seoImageInput">SEO Image</label>
                <input type="file" id="seoImageInput" name="seo_image_file" accept="image/*" class="form-control mb-2">

                {{-- Hidden field to store image path after upload --}}
                <input type="hidden" name="seo[seo_image]" id="seoImagePath" value="{{ $seoImage }}">

                {{-- Image preview --}}
                <div id="seoImagePreviewWrapper" class="mt-2 {{ $seoImage ? '' : 'd-none' }}">
                    <img id="seoImagePreview"
                        src="{{ $seoImage ? asset($seoImage) : '' }}"
                        alt="SEO Image Preview"
                        style="max-height: 150px; border:1px solid #ddd; border-radius:5px; object-fit:contain;">
                    <button type="button" id="removeSeoImageBtn" class="btn btn-sm btn-danger mt-2 d-block">
                        <i class="fas fa-times"></i> Remove Image
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@pushOnce('styles')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />
@endPushOnce

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
@endPushOnce

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Tagify initialization
    document.querySelectorAll('.tags-evs').forEach(function (input) {
        if (!input._tagify) input._tagify = new Tagify(input);
    });

    // Collapse toggle icon
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(btn => {
        btn.addEventListener("click", () => {
            let icon = btn.querySelector("i");
            if (icon) icon.classList.toggle("fa-chevron-up"), icon.classList.toggle("fa-chevron-down");
        });
    });

    // ✅ SEO Image Preview + Remove
    const seoInput = document.getElementById("seoImageInput");
    const seoPreviewWrapper = document.getElementById("seoImagePreviewWrapper");
    const seoPreview = document.getElementById("seoImagePreview");
    const removeBtn = document.getElementById("removeSeoImageBtn");
    const hiddenPath = document.getElementById("seoImagePath");

    seoInput?.addEventListener("change", function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            seoPreview.src = e.target.result;
            seoPreviewWrapper.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
        // Clear hidden path (new image selected)
        hiddenPath.value = '';
    });

    removeBtn?.addEventListener("click", () => {
        seoInput.value = '';
        seoPreview.src = '';
        seoPreviewWrapper.classList.add("d-none");
        hiddenPath.value = '';
    });
});
</script>
@endpush

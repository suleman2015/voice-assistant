<div class="card">
    <div class="card-header bg-white">
        <h4 class="card-title mb-0">
            {{ isset($category) ? 'Edit Category' : 'Create New Category' }}
        </h4>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data"
            action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}">
            @csrf
            @if (isset($category))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $category->name ?? '') }}" data-generate-slug="#slug" required>
            </div>

            <x-slug-field name="slug" :value="old('slug', $category->slug ?? '')" :model="$category ?? null" :id="$category->id ?? null" :required="true" />

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category (Optional)</label>
                <select class="form-select" id="parent_id" name="parent_id">
                    <option value="">Select Parent Category</option>
                    @php
                        function renderCategoryOptions($categories, $prefix = '', $selected = null)
                        {
                            foreach ($categories as $cat) {
                                echo '<option value="' .
                                    $cat->id .
                                    '" ' .
                                    ($selected == $cat->id ? 'selected' : '') .
                                    '>' .
                                    $prefix .
                                    $cat->name .
                                    '</option>';
                                if ($cat->children->count()) {
                                    renderCategoryOptions($cat->children, $prefix . '— ', $selected);
                                }
                            }
                        }
                        renderCategoryOptions(
                            \Modules\Blog\Models\Category::with('children')
                                ->whereNull('parent_id')
                                ->orderBy('order')
                                ->get(),
                            '',
                            old('parent_id', $category->parent_id ?? ''),
                        );
                    @endphp
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="text" class="form-control" id="icon" name="icon"
                        value="{{ old('icon', $category->icon ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label for="order" class="form-label">Display Order</label>
                    <input type="number" class="form-control" id="order" name="order" min="0"
                        value="{{ old('order', $category->order ?? 0) }}">
                </div>
            </div>

            {{-- ✅ Image Upload + Preview --}}
            <div class="mb-3">
                <label for="image" class="form-label">Category Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*"
                    onchange="previewImage(event)">

                {{-- Preview Area --}}
                <div class="mt-3">
                    @php
                        $imageFolder = 'blogs/categories/images';
                        $imagePath =
                            isset($category) && $category->image
                                ? public_path($imageFolder . '/' . $category->image)
                                : null;

                        $previewUrl =
                            isset($category) && $category->image && file_exists($imagePath)
                                ? asset($imageFolder . '/' . $category->image)
                                : asset('assets/frontend/images/placeholder.jpg');
                    @endphp

                    <img id="imagePreview" src="{{ $previewUrl }}" alt="Category Image Preview" class="img-thumbnail"
                        style="max-width: 200px; height: auto;">
                </div>

                {{-- Remove checkbox (Edit mode only) --}}
                @if (isset($category) && $category->image)
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" value="1" id="remove_image"
                            name="remove_image">
                        <label class="form-check-label" for="remove_image">
                            Remove current image
                        </label>
                    </div>
                @endif
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="draft"
                            {{ old('status', $category->status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published"
                            {{ old('status', $category->status ?? '') === 'published' ? 'selected' : '' }}>Published
                        </option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                            value="1" {{ old('is_featured', $category->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Is Featured</label>
                    </div>
                </div>
            </div>

            <x-seo-meta :model="$category ?? null" />

            <div class="d-flex justify-content-end">
                <a href="{{ route('categories.index') }}" class="btn btn-light me-2">Reset</a>
                <button type="submit" class="btn btn-primary">Save Category</button>
            </div>
        </form>
    </div>
</div>

{{-- ✅ JavaScript for live preview --}}
@push('scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endpush

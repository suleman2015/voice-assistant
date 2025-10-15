@csrf
<input type="hidden" name="author_id" value="{{ auth()->id() }}">

<div class="row">
    <!-- Left Column (main content) -->
    <div class="col-md-9 border-end">
        <x-name-field name="name" label="Name" :value="old('name', $post->name ?? '')" :required="true" data-generate-slug="#slug" />
        <x-slug-field name="slug" :value="old('slug', $post->slug ?? '')" :model="$post ?? null" :id="$post->id ?? null" :required="true" />
        <x-text label="Apple Link" name="apple_link" value="{{ old('apple_link', $post->apple_link ?? '') }}"
            placeholder="Enter the apple link" />
        <x-text label="Spotify Link" name="spotify_link" value="{{ old('spotify_link', $post->spotify_link ?? '') }}"
            placeholder="Enter the spotify link" />
        <x-text label="Youtube Link" name="yt_link" value="{{ old('yt_link', $post->yt_link ?? '') }}"
            placeholder="Enter the youtube link" />
        <x-text label="Doctor Name" name="dr_name" value="{{ old('dr_name', $post->dr_name ?? '') }}"
            placeholder="Enter the doctor name" />
        <x-textarea-field label="Description" name="description" :value="old('description', $post->description ?? '')"
            placeholder="Write your description here..." :maxlength="1000" :required="false" />
        <x-editor-field label="Content" name="content" :value="old('content', $post->content ?? '')" />
        <x-repeater name="key_points" label="Key Points" :values="old('key_points', $post->key_points ?? [])" />

    </div>

    <!-- Right Column (sidebar settings) -->
    <div class="col-md-3">
        <x-status-select :selected="old('status', $post->status ?? 'draft')" />
        <x-type-select :selected="old('type', $post->type ?? 'post')" />
        <x-text-field label="Author Name" name="author_name" value="{{ old('author_name', $post->author_name ?? '') }}"
            placeholder="Enter the author's name" />
        <x-multi-checkbox-filter label="Categories" name="categories" :options="$categories" :selected="old('categories', $post?->categories?->pluck('id')->toArray() ?? [])" />
        <x-multi-select label="Post Tags" name="tags" :options="$tags->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name])->toArray()" :selected="old('tags', $post?->tags?->pluck('id')->toArray() ?? [])" />
        <x-multi-select label="Post Keywords" name="keywords" :options="$tags->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name])->toArray()" :selected="old('tags', $post?->keywords?->pluck('id')->toArray() ?? [])" />
        <div class="row">
            <div class="col-6">
                <x-dynamic-image-field label="Post Image" name="image" :value="$post->image ?? ''" path="blogs/posts/images"
                    input-id="imageInput" preview-id="imagePreview" />
            </div>
            <div class="col-6">
                <x-dynamic-image-field label="Doctor Image" name="dr_image" :value="$post->dr_image ?? ''" path="blogs/posts/images"
                    input-id="drImageInput" preview-id="drImagePreview" />
            </div>
        </div>


        <x-switch-field label="Featured Post" name="is_featured" :checked="$post->is_featured ?? false" value="1" />
        <x-switch-field label="Trending Onc Update" name="is_trending_onc_update" :checked="$post->is_trending_onc_update ?? false" value="1" />
    </div>
    <!-- SEO meta component -->
    <x-seo-meta :model="$post ?? null" />
</div>

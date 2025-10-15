@csrf
<input type="hidden" name="author_id" value="{{ auth()->id() }}">

<div class="row">
    <!-- Left Column (main content) -->
    <div class="col-md-9 border-end">
        <!-- Event Title -->
        <x-name-field name="title" label="Event Title" :value="old('title', $event->title ?? '')" :required="true" data-generate-slug="#slug"
            placeholder="Enter event title" />

        <!-- Slug -->
        <x-slug-field name="slug" :value="old('slug', $post->slug ?? '')" :model="$event ?? null" :id="$event->id ?? null" :required="true" />

        <!-- Description -->
        <x-textarea-field label="Description" name="description" :value="old('description', $event->description ?? '')"
            placeholder="Write your description here..." maxlength="400" />

        <!-- External Link -->
        <x-text label="External Link" name="link" value="{{ old('link', $event->link ?? '') }}"
            placeholder="Enter external link" />

        <x-dynamic-multiple-image-field label="Gallery Images" name="images" :values="old('images', isset($event) ? $event->images->pluck('image_url')->toArray() : [])" />

        <x-event-repeater name="event_dates" label="Event Dates" :values="old('event_dates', isset($event) ? $event->eventDates->toArray() : [])" />

    </div>

    <!-- Right Column (sidebar settings) -->
    <div class="col-md-3">
        <!-- Status -->
        <x-status-select :selected="old('status', $event->status ?? 'draft')" />
        <!-- Event Date -->
        <x-date-field label="Main Event Date" name="event_date"
            value="{{ old('event_date', $event->event_date ?? '') }}" required="true" />

        <!-- Event Images -->
        <x-dynamic-image-field label="Main Event Image" name="image_url" input-id="imageInput" preview-id="imagePreview"
            :value="old('image_url', $event->image_url ?? '')" />
    </div>

    <!-- SEO meta component -->
    <x-seo-meta :model="$event ?? null" />
</div>

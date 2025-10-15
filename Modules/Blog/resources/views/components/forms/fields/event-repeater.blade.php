@props(['name' => 'event_dates', 'label' => 'Event Dates', 'values' => []])

<div class="event-dates-repeater" data-name="{{ $name }}">
    @if ($label)
        <label class="form-label d-block">{{ $label }}</label>
    @endif

    <div class="event-dates-items">
        @forelse(old($name, $values) as $index => $date)
            <div class="row g-2 mb-2 event-dates-item">
                <div class="col-md-4">
                    <input type="text" name="{{ $name }}[{{ $index }}][name]" class="form-control"
                        value="{{ $date['name'] ?? '' }}" placeholder="Event Name">
                </div>
                <div class="col-md-5">
                    <input type="url" name="{{ $name }}[{{ $index }}][link]" class="form-control"
                        value="{{ $date['link'] ?? '' }}" placeholder="Event Link">
                </div>
                <div class="col-md-2">
                    <input type="date" name="{{ $name }}[{{ $index }}][date]" class="form-control"
                        value="{{ $date['date'] ?? '' }}" placeholder="Event Date">
                </div>
                <div class="col-md-1 d-flex">
                    <button type="button" class="btn btn-danger remove-event-date w-50">−</button>
                </div>
            </div>
        @empty
            <div class="row g-2 mb-2 event-dates-item">
                <div class="col-md-4">
                    <input type="text" name="{{ $name }}[0][name]" class="form-control"
                        placeholder="Event Name">
                </div>
                <div class="col-md-5">
                    <input type="url" name="{{ $name }}[0][link]" class="form-control"
                        placeholder="Event Link">
                </div>
                <div class="col-md-2">
                    <input type="date" name="{{ $name }}[0][date]" class="form-control"
                        placeholder="Event Date">
                </div>
                <div class="col-md-1 d-flex">
                    <button type="button" class="btn btn-danger remove-event-date w-50">−</button>
                </div>
            </div>
        @endforelse
    </div>

    <button type="button" class="btn btn-sm btn-primary add-event-date mt-2">+ Add Event Date</button>
</div>

@pushOnce('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".event-dates-repeater").forEach(wrapper => {
                const itemsWrapper = wrapper.querySelector(".event-dates-items");
                const baseName = wrapper.dataset.name;

                wrapper.querySelector(".add-event-date").addEventListener("click", () => {
                    const index = itemsWrapper.querySelectorAll(".event-dates-item").length;

                    const newItem = document.createElement("div");
                    newItem.classList.add("row", "g-2", "mb-2", "event-dates-item");
                    newItem.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="${baseName}[${index}][name]" class="form-control" placeholder="Event Name">
                </div>
                <div class="col-md-5">
                    <input type="url" name="${baseName}[${index}][link]" class="form-control" placeholder="Event Link">
                </div>
                <div class="col-md-2">
                    <input type="date" name="${baseName}[${index}][date]" class="form-control" placeholder="Event Date">
                </div>
                <div class="col-md-1 d-flex">
                    <button type="button" class="btn btn-danger remove-event-date w-50">−</button>
                </div>
            `;
                    itemsWrapper.appendChild(newItem);
                });

                itemsWrapper.addEventListener("click", e => {
                    if (e.target.classList.contains("remove-event-date")) {
                        e.target.closest(".event-dates-item").remove();
                    }
                });
            });
        });
    </script>
@endPushOnce

@props(['name', 'label' => '', 'values' => []])

<div class="repeater-field" data-name="{{ $name }}">
    @if ($label)
        <label class="form-label">{{ $label }}</label>
    @endif

    <div class="repeater-items">
        @forelse(old($name, $values) as $value)
            <div class="input-group mb-2 repeater-item">
                <input type="text" name="{{ $name }}[]" class="form-control" value="{{ $value }}"
                    placeholder="Enter {{ strtolower($label) }}">
                <button type="button" class="btn btn-danger remove-repeater">−</button>
            </div>
        @empty
            <div class="input-group mb-2 repeater-item">
                <input type="text" name="{{ $name }}[]" class="form-control"
                    placeholder="Enter {{ strtolower($label) }}">
                <button type="button" class="btn btn-danger remove-repeater">−</button>
            </div>
        @endforelse
    </div>

    <button type="button" class="btn btn-sm btn-primary add-repeater mt-2">+ Add</button>
</div>

@pushOnce('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".repeater-field").forEach(wrapper => {
                const itemsWrapper = wrapper.querySelector(".repeater-items");
                const name = wrapper.dataset.name;

                wrapper.querySelector(".add-repeater").addEventListener("click", () => {
                    const newItem = document.createElement("div");
                    newItem.classList.add("input-group", "mb-2", "repeater-item");
                    newItem.innerHTML = `
                <input type="text" name="${name}[]" class="form-control" placeholder="Enter ${name}">
                <button type="button" class="btn btn-danger remove-repeater">−</button>
            `;
                    itemsWrapper.appendChild(newItem);
                });

                itemsWrapper.addEventListener("click", e => {
                    if (e.target.classList.contains("remove-repeater")) {
                        e.target.closest(".repeater-item").remove();
                    }
                });
            });
        });
    </script>
@endPushOnce

<div class="card">
    <div class="card-header">
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    </div>
    <div class="card-body">
        <div class="tag-input" data-name="{{ $name }}">
            <div class="tags-container d-flex flex-wrap gap-2 p-2 border rounded">
                @foreach ($options as $option)
                    @php $isSelected = in_array($option['id'], $selected ?? []); @endphp
                    @if ($isSelected)
                        <span class="tag badge bg-primary d-flex align-items-center">
                            {{ $option['name'] }}
                            <button type="button" class="btn-close btn-close-white ms-2" aria-label="Remove"></button>
                            <input type="hidden" name="{{ $name }}[]" value="{{ $option['id'] }}">
                        </span>
                    @endif
                @endforeach
                <input type="text" class="tag-search border-0 flex-grow-1" placeholder="Type or select...">
            </div>

            {{-- Suggestion dropdown --}}
            <ul class="tag-suggestions list-group position-absolute w-100 d-none" style="z-index:1000"></ul>
        </div>
    </div>
</div>

@once
    @push('styles')
        <style>
            .tag-input { position: relative; }
            .tag-suggestions { max-height: 200px; overflow-y: auto; }
            .tag-suggestions li { cursor: pointer; }
            .tags-container .tag { padding: 0.4rem 0.6rem; font-size: 0.85rem; }
            .tags-container input.tag-search:focus { outline: none; box-shadow: none; }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll('.tag-input').forEach(function (wrapper) {
                    const input = wrapper.querySelector('.tag-search');
                    const container = wrapper.querySelector('.tags-container');
                    const suggestionsBox = wrapper.querySelector('.tag-suggestions');
                    const fieldName = wrapper.dataset.name;

                    // preload options from PHP
                    const existingTags = @json($options);

                    const addTag = (value, label) => {
                        if (!value) return;
                        // Prevent duplicate
                        const exists = container.querySelector(`input[value="${value}"]`);
                        if (exists) return;

                        const span = document.createElement('span');
                        span.className = "tag badge bg-primary d-flex align-items-center";
                        span.innerHTML = `
                            ${label}
                            <button type="button" class="btn-close btn-close-white ms-2" aria-label="Remove"></button>
                            <input type="hidden" name="${fieldName}[]" value="${value}">
                        `;
                        container.insertBefore(span, input);

                        span.querySelector('.btn-close').addEventListener('click', () => {
                            span.remove();
                        });
                    };

                    const showSuggestions = (search) => {
                        suggestionsBox.innerHTML = "";
                        const results = existingTags.filter(tag =>
                            tag.name.toLowerCase().includes(search.toLowerCase())
                        );
                        if (!results.length && search.trim() !== "") {
                            // option to create new
                            const li = document.createElement('li');
                            li.className = "list-group-item list-group-item-action";
                            li.textContent = `Add "${search}"`;
                            li.addEventListener('click', () => {
                                addTag(search, search); // value = label for new
                                input.value = "";
                                suggestionsBox.classList.add('d-none');
                            });
                            suggestionsBox.appendChild(li);
                        } else {
                            results.forEach(tag => {
                                const li = document.createElement('li');
                                li.className = "list-group-item list-group-item-action";
                                li.textContent = tag.name;
                                li.addEventListener('click', () => {
                                    addTag(tag.id, tag.name);
                                    input.value = "";
                                    suggestionsBox.classList.add('d-none');
                                });
                                suggestionsBox.appendChild(li);
                            });
                        }
                        suggestionsBox.classList.remove('d-none');
                    };

                    input.addEventListener('input', () => {
                        const val = input.value.trim();
                        if (val.length) {
                            showSuggestions(val);
                        } else {
                            suggestionsBox.classList.add('d-none');
                        }
                    });

                    input.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            const val = input.value.trim();
                            if (val) {
                                // Check if matches existing tag
                                const found = existingTags.find(t => t.name.toLowerCase() === val.toLowerCase());
                                if (found) {
                                    addTag(found.id, found.name);
                                } else {
                                    addTag(val, val); // new tag
                                }
                                input.value = "";
                                suggestionsBox.classList.add('d-none');
                            }
                        }
                    });

                    // click outside closes suggestions
                    document.addEventListener('click', (e) => {
                        if (!wrapper.contains(e.target)) {
                            suggestionsBox.classList.add('d-none');
                        }
                    });
                });
            });
        </script>
    @endpush
@endonce

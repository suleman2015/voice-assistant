<div class="card">
    <div class="card-header">
        <strong>{{ $label }}</strong>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Search..." oninput="filterCheckboxes(this)">
        </div>
        <div class="filter-checkbox-list" style="max-height: 300px; overflow-y: auto;">
            <ul class="list-unstyled ms-2">
                @foreach ($options as $category)
                    @php
                        $renderCategory = function ($cat, $name, $selected, $level = 0) use (&$renderCategory) {
                            echo "<li class='mb-1'>";
                                echo "<div class='d-flex align-items-center gap-2' style='margin-left:" . ($level * 20) . "px'>";
                                    // Checkbox
                                    echo "<div class='form-check mb-0'>";
                                        echo "<input class='form-check-input' type='checkbox' id='{$name}_{$cat->id}' 
                                                name='{$name}[]' value='{$cat->id}' " 
                                                . (in_array($cat->id, $selected ?? []) ? 'checked' : '') . ">";
                                        echo "<label class='form-check-label' for='{$name}_{$cat->id}'>
                                                {$cat->name}
                                              </label>";
                                    echo "</div>";
                                echo "</div>";
                                // Render children
                                if (!empty($cat->children)) {
                                    echo "<ul class='list-unstyled ms-3 collapse show mt-1' id='children-{$cat->id}'>";
                                        foreach ($cat->children as $child) {
                                            $renderCategory($child, $name, $selected, $level + 1);
                                        }
                                    echo "</ul>";
                                }
                            echo "</li>";
                        };
                    @endphp
                    {!! $renderCategory($category, $name, $selected ?? []) !!}
                @endforeach
            </ul>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            // Search filter
            function filterCheckboxes(input) {
                const filter = input.value.toLowerCase();
                const container = input.closest('.card-body');

                container.querySelectorAll('.form-check-label').forEach(label => {
                    const row = label.closest('li');
                    if (label.innerText.toLowerCase().includes(filter)) {
                        row.style.display = '';
                        // also show parent chain
                        let parent = row.parentElement.closest('li');
                        while (parent) {
                            parent.style.display = '';
                            parent = parent.parentElement.closest('li');
                        }
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        </script>
    @endpush
@endonce

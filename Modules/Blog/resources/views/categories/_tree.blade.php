<li class="list-group-item">
    <div class="d-flex align-items-center gap-2">
        {{-- Collapse/Expand Button (only if has children) --}}
        @if ($category->children->count())
            <button class="btn btn-sm bg-transparent px-1 py-0 toggle-children" 
                    data-bs-toggle="collapse"
                    data-bs-target="#children-{{ $category->id }}" 
                    aria-expanded="true"
                    aria-controls="children-{{ $category->id }}">
                <i class="fas fa-minus"></i>
            </button>
        @else
            <span class="ms-3"></span> {{-- spacing for alignment --}}
        @endif

        {{-- Category Name --}}
        <a href="{{ route('categories.edit', $category->id) }}" 
           class="text-dark fw-semibold">
            <i class="fas fa-folder text-warning me-1"></i> {{ $category->name }}
        </a>

        {{-- Delete Button --}}
        <form action="{{ route('categories.destroy', $category->id) }}" 
              method="POST" 
              class="delete-form d-inline ms-auto">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-0" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>

    {{-- Children (Collapsible) --}}
    @if ($category->children->count())
        <ul class="list-group list-group-flush collapse show mt-1" id="children-{{ $category->id }}">
            @foreach ($category->children as $child)
                @include('blog::categories._tree', ['category' => $child])
            @endforeach
        </ul>
    @endif

    {{-- Border-bottom only for top-level --}}
    @if (is_null($category->parent_id))
        <hr class="mt-2 mb-1">
    @endif
</li>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Toggle + / -
        document.querySelectorAll(".toggle-children").forEach(btn => {
            btn.addEventListener("click", () => {
                let icon = btn.querySelector("i");
                icon.classList.toggle("fa-minus");
                icon.classList.toggle("fa-plus");
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                alertify.confirm(
                    'Confirm Delete',
                    'Are you sure you want to delete this category?',
                    () => form.submit(),
                    () => alertify.error('Delete canceled')
                );
            });
        });
    });
</script>
@endpush

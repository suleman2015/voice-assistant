<div class="card shadow-sm border-0">
    <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 text-dark fw-bold">
            <i class="fas fa-folder-open me-2 text-primary"></i> Categories List
        </h5>
    </div>

    <div class="card-body p-0">
        <ul class="list-group list-group-flush category-tree">
            @foreach ($categories as $category)
                @include('blog::categories._tree', ['category' => $category])
            @endforeach
        </ul>
    </div>
</div>

@push('styles')
<style>
    .category-tree {
        font-size: 14px;
        max-height: 600px; /* Make it scrollable */
        overflow-y: auto; /* Allow scrolling if content overflows */
        padding-right: 10px; /* Add some right padding for smooth scroll */
    }

    .category-tree .list-group-item {
        background: transparent;
        border: none;
        padding: 4px 10px; /* Reduced padding for smaller spacing */
        transition: all 0.2s ease;
    }

    .category-tree .list-group-item:hover {
        background: #f8f9fa;
        border-radius: 6px;
    }

    .category-tree a {
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .category-tree a:hover {
        color: #0d6efd;
        text-decoration: underline;
    }

    .category-tree .toggle-children {
        border: none;
        color: #555;
    }

    .category-tree .toggle-children:hover {
        color: #0d6efd;
    }

    .category-tree .btn-outline-danger {
        border: none;
        color: #dc3545;
    }

    .category-tree .btn-outline-danger:hover {
        background: #dc3545;
        color: #fff;
    }

    /* Vertical connector line for nested children */
    .category-tree ul {
        position: relative;
        padding-left: 18px;
        margin-left: 10px;
        border-left: 1px dashed #ccc;
    }

    .category-tree ul li::before {
        content: "•";
        color: #0d6efd;
        position: absolute;
        margin-left: -15px;
        margin-top: 6px;
        font-size: 12px;
    }
</style>
@endpush

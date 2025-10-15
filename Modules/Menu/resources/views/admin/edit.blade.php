@extends('admin.layouts.app')
@section('title', 'Edit Menu')

@section('content')
    <div class="container-fluid px-2 pt-md-4">
         <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                   
                </div>
            </div>
        </div>
        <div class="row gx-2 gy-2 mt-5">

            {{-- LEFT PANELS --}}
            <div class="col-lg-4">
                <div class="menu-sticky">
                    <div class="menu-side-scroll">
                          {{-- Pages --}}
                        <div class="card mb-2">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Pages</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.menus.items.store', $menu->id) }}">
                                    @csrf
                                    <input type="hidden" name="type" value="page">
                                    <div class="border rounded p-2" style="max-height:300px;overflow:auto">
                                        @forelse($pages as $page)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="references[]"
                                                    value="{{ $page->id }}" id="pg{{ $page->id }}">
                                                <label class="form-check-label"
                                                    for="pg{{ $page->id }}">{{ $page->title }}</label>
                                            </div>
                                        @empty
                                            <p class="text-muted mb-0">No pages found.</p>
                                        @endforelse
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary mt-2">+ Add to menu</button>
                                </form>
                            </div>
                        </div>
                        {{-- Categories --}}
                     <div class="card mb-2">
    <div class="card-header">
        <h6 class="mb-0">Categories</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.menus.items.store', $menu->id) }}">
            @csrf
            <input type="hidden" name="type" value="category">
            <div class="border rounded p-2" style="max-height:300px;overflow:auto">
                @forelse($categories as $cat)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="references[]"
                               value="{{ $cat->id }}" id="cat{{ $cat->id }}">
                        <label class="form-check-label" for="cat{{ $cat->id }}">
                            {{ $cat->name }}
                        </label>

                        @if($cat->children->count() > 0)
                            <!-- Recursive call to display child categories -->
                            <div class="ms-3">
                                @foreach($cat->children as $child)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="references[]"
                                               value="{{ $child->id }}" id="cat{{ $child->id }}">
                                        <label class="form-check-label" for="cat{{ $child->id }}">
                                            {{ $child->name }}
                                        </label>

                                        @if($child->children->count() > 0)
                                            <!-- Recursively display children of this child -->
                                            <div class="ms-3">
                                                @foreach($child->children as $grandchild)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="references[]"
                                                               value="{{ $grandchild->id }}" id="cat{{ $grandchild->id }}">
                                                        <label class="form-check-label" for="cat{{ $grandchild->id }}">
                                                            {{ $grandchild->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-muted mb-0">No categories found.</p>
                @endforelse
            </div>
            <button class="btn btn-sm btn-outline-primary mt-2">+ Add to menu</button>
        </form>
    </div>
</div>


                        {{-- Custom link --}}
                        <div class="card mb-2">
                            <div class="card-header">
                                <h6 class="mb-0">Add link</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.menus.items.store', $menu->id) }}">
                                    @csrf
                                    <input type="hidden" name="type" value="custom">
                                    <div class="mb-2">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">URL</label>
                                        <input type="url" class="form-control" name="url"
                                            placeholder="https://example.com" required>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">+ Add link</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT PANEL (NAME + STRUCTURE) --}}
            <div class="col-lg-8">
                <div class="card menu-structure">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1">
                            <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST"
                                class="row g-2 align-items-center">
                                @csrf @method('PUT')
                                <div class="col-md-6">
                                    <label class="form-label mb-0 small">Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $menu->name) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label mb-0 small">Location</label>
                                    <input type="text" class="form-control" name="location"
                                        value="{{ old('location', $menu->location) }}" required>
                                </div>
                                <div class="col-md-2 text-md-end">
                                    <label class="form-label mb-0 small d-block">&nbsp;</label>
                                    <button class="btn btn-primary w-100">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body menu-structure-body">
                        <div class="alert alert-light border py-2 mb-2">
                            Rearrange menu items by dragging and dropping them to change their order or nest them as
                            submenus.
                        </div>

                        <div class="dd" id="menuTree" style="max-height: 500px; overflow-y: auto;">
                            <ol class="dd-list">
                                @foreach ($menu->items as $item)
                                    @include('menu::admin.partials.node', ['item' => $item])
                                @endforeach
                            </ol>
                        </div>

                        <div class="text-end mt-2">
                            <button id="saveTree" class="btn btn-success btn-sm">Save Order</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.css" />

    <style>
        .dd {
            margin-top: .25rem;
        }

        .dd-item>.menu-node {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: .375rem;
            padding: .5rem .5rem .5rem .25rem;
            transition: background .15s ease-in-out, border-color .15s;
        }

        .dd-item+.dd-item {
            margin-top: .4rem;
        }

        .menu-node:hover {
            background: #f9fafb;
            border-color: #dfe3e6;
        }

        .drag-handle {
            cursor: grab;
            color: #adb5bd;
            display: inline-flex;
            align-items: center;
        }

        .drag-handle:hover {
            color: #6c757d;
        }

        .node-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Indentation for children */
        .dd-list .dd-list {
            margin-left: 1.25rem;
        }

        /* Smaller buttons like Botble */
        .btn-group-sm>.btn {
            padding: .125rem .375rem;
        }

        /* Keep right column fill */
        .menu-structure {
            min-height: calc(100vh - 72px);
            display: flex;
            flex-direction: column;
        }

        .menu-structure-body {
            flex: 1 1 auto;
            overflow: auto;
        }
    </style>
    <style>
        /* Make the floating element while dragging clearly visible */
        .dd-dragel {
          position: absolute;      /* nestable sets this; we strengthen visuals */
          z-index: 2000;
          pointer-events: none;
          opacity: .98;
        }
        .dd-dragel .menu-node {
          background: #fff;
          border: 1px solid #cfd6dd;
          border-radius: .5rem;
          box-shadow: 0 10px 22px rgba(15, 23, 42, .15);
          padding: .5rem .5rem .5rem .25rem;
        }
      
        /* The placeholder where the item will land */
        .dd-placeholder {
          background: #eef5ff;
          border: 1px dashed #6ea8fe;
          height: 44px;            /* close to your item height */
          margin: .25rem 0;
          border-radius: .5rem;
        }
      
        /* The registered handle looks/behaves like a grip */
        .dd-handle.drag-handle {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          width: 18px;
          height: 18px;
          margin-right: 8px;
          cursor: grab;
          color: #94a3b8;
        }
        .dd-handle.drag-handle:hover { color:#64748b; }
      
        /* Indentation for children stays clean */
        .dd-list .dd-list { margin-left: 1.25rem; }
      </style>
@endpush


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js"></script>
    <script>
        $(function() {
            // Nestable
            $('#menuTree').nestable({
            maxDepth: 30,
            handleClass: 'dd-handle',   // <- use the grip only
            noDragClass: 'dd-nodrag',   // <- anything with this class won't drag
            expandBtnHTML: '',
            collapseBtnHTML: ''
            });
            // Save order (drag & drop)
            $('#saveTree').on('click', function() {
                const flattened = [];
                const walk = function($list, parentId = null) {
                    $list.children('li.dd-item').each(function(order) {
                        const id = $(this).data('id');
                        flattened.push({
                            id: id,
                            parent_id: parentId,
                            order: order
                        });
                        const $children = $(this).children('ol.dd-list');
                        if ($children.length) walk($children, id);
                    });
                };
                walk($('#menuTree > .dd-list'));

                $.post('{{ route('admin.menus.items.syncTree', $menu->id) }}', {
                    _token: '{{ csrf_token() }}',
                    tree: flattened
                }).done(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Menu order updated successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }).fail(function(xhr){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong while saving.'
                    });
                });
            });

            // Inline edit toggling
            $(document).on('click', '.js-edit', function() {
                const $node = $(this).closest('.menu-node');
                $node.find('.node-title').addClass('d-none');
                $node.find('.node-editor').removeClass('d-none');
                $node.find('.js-edit').addClass('d-none');
                $node.find('.js-save,.js-cancel').removeClass('d-none');
            });

            $(document).on('click', '.js-cancel', function() {
                const $node = $(this).closest('.menu-node');
                $node.find('.node-editor').addClass('d-none');
                $node.find('.node-title').removeClass('d-none');
                $node.find('.js-save,.js-cancel').addClass('d-none');
                $node.find('.js-edit').removeClass('d-none');
            });

            // Inline save (AJAX PUT)
            $(document).on('click', '.js-save', function() {
                const $nodeWrap = $(this).closest('.dd-item');
                const id = $nodeWrap.data('id');
                const $node = $(this).closest('.menu-node');
                const title = $node.find('.js-edit-title').val();
                const $urlInput = $node.find('.js-edit-url');
                const url = $urlInput.hasClass('d-none') ? null : $urlInput.val();

                $.ajax({
                    url: '{{ route('admin.menus.items.update', '__ID__') }}'.replace('__ID__', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        title: title,
                        url: url
                    },
                    success: function(resp) {
                        // Update text
                        const typeText = $node.find('.badge').text().trim();
                        $node.find('.node-title').html(
                            $('<div>').text(title).html() + ' <small class="text-muted">(' +
                            typeText + ')</small>'
                        );

                        // toggle back
                        $node.find('.node-editor').addClass('d-none');
                        $node.find('.node-title').removeClass('d-none');
                        $node.find('.js-save,.js-cancel').addClass('d-none');
                        $node.find('.js-edit').removeClass('d-none');
                    },
                    error: function(xhr) {
                        alert('Could not save. ' + (xhr.responseJSON?.message ?? ''));
                    }
                });
            });
            $(document).on('click', '.node-title', function(e) {
                // ignore if user clicked edit buttons inside
                if ($(e.target).closest('.btn-group').length) return;

                const $item = $(this).closest('.dd-item');
                const $sub = $item.children('ol.dd-list');
                if (!$sub.length) return;

                // toggle like botble: slide + class for state if you want to style arrows later
                $sub.slideToggle(120);
                $item.toggleClass('is-collapsed');
            });
        });
    </script>
@endpush

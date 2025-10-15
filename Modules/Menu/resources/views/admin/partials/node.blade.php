<li class="dd-item" data-id="{{ $item->id }}">
    <div class="menu-node dd-content d-flex align-items-center justify-content-between">
  
      <div class="d-flex align-items-center gap-2 flex-grow-1">
        {{-- drag handle (required by Nestable) --}}
        <span class="drag-handle dd-handle" title="Drag to reorder">
          <i class="bi bi-grip-vertical"></i>
        </span>
  
        {{-- read-only title (shown by default) --}}
        <span class="node-title fw-semibold">
          {{ $item->title }}
          <small class="text-muted">({{ $item->type }})</small>
        </span>
  
        {{-- inline editor (hidden by default; toggled by .js-edit / .js-cancel) --}}
        <div class="node-editor d-none w-100">
          <div class="row g-2 w-100">
            <div class="col-md-6">
              <input type="text"
                     class="form-control form-control-sm js-edit-title"
                     value="{{ $item->title }}"
                     placeholder="Title">
            </div>
  
            {{-- URL field only for custom links --}}
            <div class="col-md-6">
              <input type="url"
                     class="form-control form-control-sm js-edit-url {{ $item->type !== 'custom' ? 'd-none' : '' }}"
                     value="{{ $item->url }}"
                     placeholder="https://example.com">
            </div>
          </div>
        </div>
      </div>
  
      {{-- type badge --}}
      <span class="badge rounded-pill bg-light text-muted border me-2 text-capitalize">
        {{ $item->type }}
      </span>
  
      {{-- action buttons --}}
      <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-light js-edit" title="Edit">
          <i class="bi bi-pencil"></i>
        </button>
        <button type="button" class="btn btn-success d-none js-save" title="Save">
          <i class="bi bi-check"></i>
        </button>
        <button type="button" class="btn btn-secondary d-none js-cancel" title="Cancel">
          <i class="bi bi-x"></i>
        </button>
  
        <form action="{{ route('admin.menus.items.destroy', $item->id) }}"
              method="POST"
              onsubmit="return confirm('Delete this item?')">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger" type="submit" title="Delete">
            <i class="bi bi-trash"></i>
          </button>
        </form>
      </div>
    </div>
  
    @if($item->children->count())
      <ol class="dd-list">
        @foreach($item->children as $child)
          @include('menu::admin.partials.node', ['item' => $child])
        @endforeach
      </ol>
    @endif
  </li>
  
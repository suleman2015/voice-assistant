
  <div class="btn-group">
    <a href="{{ $editUrl }}" class="btn btn-sm btn-warning" title="Edit">
      <i class="bi bi-pencil-square"></i>
    </a>
  
    <a href="#" class="btn btn-sm btn-outline-secondary js-toggle"
       data-url="{{ $toggleUrl }}" title="Enable/Disable">
      <i class="bi bi-power"></i>
    </a>
  
    <a href="#" class="btn btn-sm btn-danger js-delete"
       data-name="{{ $a->name }}" data-url="{{ $deleteUrl }}" title="Delete">
      <i class="bi bi-trash"></i>
    </a>
  </div>
  
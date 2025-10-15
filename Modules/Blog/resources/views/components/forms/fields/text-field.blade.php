<div class="card">
    <div class="card-header">
        <strong>{{ $label }}</strong>
    </div>
    <div class="card-body">
        <input 
            type="text" 
            class="form-control" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ $value }}" 
            placeholder="{{ $placeholder }}"
        >
    </div>
</div>

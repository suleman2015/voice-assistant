<div class="card">
    <div class="card-header">
        <strong>{{ $label }}</strong>
    </div>
    <div class="card-body">
        <select class="form-select" name="{{ $name }}" id="{{ $name }}">
            <option value="published" {{ $selected === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ $selected === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="pending" {{ $selected === 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
    </div>
</div>
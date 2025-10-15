<div class="card">
    <div class="card-header">
        <strong>{{ $label }}</strong>
    </div>
    <div class="card-body">
        <select class="form-select" name="{{ $name }}" id="{{ $name }}">
            <option value="blog" {{ $selected === 'blog' ? 'selected' : '' }}>Post</option>
            <option value="article" {{ $selected === 'article' ? 'selected' : '' }}>Article</option>
        </select>
    </div>
</div>

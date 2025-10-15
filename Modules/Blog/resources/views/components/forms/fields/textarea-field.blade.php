@php
    $id = $name . '-textarea';
    $currentValue = old($name, $value ?? '');
@endphp

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}{{ $required ? ' *' : '' }}</label>

    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        rows="5"
        maxlength="{{ $maxlength }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
    >{{ $currentValue }}</textarea>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

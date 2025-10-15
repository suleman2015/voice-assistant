<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}{{ $required ? ' *' : '' }}</label>
    <input type="text" 
           name="{{ $name }}" 
           id="{{ $name }}" 
           class="form-control @error($name) is-invalid @enderror"
           value="{{ $resolvedValue() }}"
           placeholder="{{ $placeholder }}"
           {{ $required ? 'required' : '' }}
           {{-- Pass all extra attributes including data-generate-slug --}}
           {{ $attributes }}
    >
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

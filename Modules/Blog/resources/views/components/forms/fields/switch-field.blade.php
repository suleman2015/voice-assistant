<div class="mb-3 form-check form-switch">
    <!-- Hidden field ensures a value is always submitted -->
    <input type="hidden" name="{{ $name }}" value="0">

    <input class="form-check-input"
           type="checkbox"
           id="{{ $name }}"
           name="{{ $name }}"
           value="{{ $value }}"
           {{ old($name, $checked) ? 'checked' : '' }}
           {{ $disabled ? 'disabled' : '' }}>

    <label class="form-check-label" for="{{ $name }}">
        {{ $label }}
    </label>

    @if($help)
        <small class="text-muted d-block">{{ $help }}</small>
    @endif

    @error($name)
        <small class="text-danger d-block mt-2">{{ $message }}</small>
    @enderror
</div>

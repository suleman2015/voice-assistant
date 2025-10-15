<div class="card mb-3">
    <div class="card-header">
        <label for="{{ $name }}" class="form-label mb-0">{{ $label }}</label>
    </div>
    <div class="card-body">
        <input type="date" id="{{ $name }}" name="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror"
            value="{{ old($name, $value ? \Illuminate\Support\Carbon::parse($value)->format('Y-m-d') : '') }}"
            
            {{-- Disable past dates --}}
            @if($disablePast)
                min="{{ now()->format('Y-m-d') }}"
            @endif

            {{-- Min and Max dates --}}
            @if($min) min="{{ \Illuminate\Support\Carbon::parse($min)->format('Y-m-d') }}" @endif
            @if($max) max="{{ \Illuminate\Support\Carbon::parse($max)->format('Y-m-d') }}" @endif

            {{-- Other options --}}
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
        >

        {{-- Helper text --}}
        @if($help)
            <small class="text-muted d-block mt-1">{{ $help }}</small>
        @endif

        @error($name)
            <small class="text-danger d-block mt-2">{{ $message }}</small>
        @enderror
    </div>
</div>
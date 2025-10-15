@php
    $status = (bool) $status;
@endphp

<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" {{ $status ? 'checked' : '' }} disabled>
</div>

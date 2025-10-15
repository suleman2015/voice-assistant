@php
    $moduleStatuses = json_decode(file_get_contents(base_path('modules_statuses.json')), true);
    $savedSetting = $settings->where('key', 'modules')->first(); // proper usage
    $savedModules = $savedSetting ? json_decode($savedSetting->value, true) : [];
@endphp


<!-- Right Side - General Settings Form -->
<div class="col-md-8">
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="card-title mb-0">Modules Settings</h4>
        </div>
        <div class="card-body">
            <form id="setting-form" method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modules[Setting]" value="1">
                @foreach ($moduleStatuses as $module => $enabled)
                    @if ($module === 'Setting')
                        @continue
                    @endif
                    <div class="mb-3 form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="{{ $module }}" name="modules[{{ $module }}]" value="1"
                            {{ (!isset($savedModules[$module]) && $enabled === true) || (isset($savedModules[$module]) && $savedModules[$module] === true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $module }}">
                            {{ $module }}
                        </label>
                    </div>
                @endforeach
                <div class="d-flex justify-content-end">
                    <!-- <button type="reset" class="btn btn-light me-2">Reset</button> -->
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

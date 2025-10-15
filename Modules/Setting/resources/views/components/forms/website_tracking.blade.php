
<!-- Right Side - General Settings Form -->
<div class="col-md-8">
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="card-title mb-0">Website Tracking</h4>
        </div>
        <div class="card-body">
            <form id="setting-form" method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="gtm_script" class="form-label">GTM Script (Header)</label>
                    <textarea class="form-control" id="gtm_script" name="gtm_script" rows="4">{{ old('gtm_script', $settings->where('key', 'gtm_script')->first()->value ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="gtm_noscript" class="form-label">GTM Noscript (Body)</label>
                    <textarea class="form-control" id="gtm_noscript" name="gtm_noscript" rows="4">{{ old('gtm_noscript', $settings->where('key', 'gtm_noscript')->first()->value ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="cookie_consent" class="form-label">Cookies Consent Text</label>
                    <textarea class="form-control" id="cookie_consent" name="cookie_consent" rows="4">{{ old('cookie_consent', $settings->where('key', 'cookie_consent')->first()->value ?? '') }}</textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <!-- <button type="reset" class="btn btn-light me-2">Reset</button> -->
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

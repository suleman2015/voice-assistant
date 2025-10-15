@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<!-- Appearance Settings Form -->
<div class="col-md-8">
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="card-title mb-0">Site Appearance Settings</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('setting.update') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Primary Color</label>
                        <input type="color" class="form-control form-control-color" name="primary_color"
                            value="{{ setting('primary_color') ?? '#4e73df' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Secondary Color</label>
                        <input type="color" class="form-control form-control-color" name="secondary_color"
                            value="{{ setting('secondary_color') ?? '#1cc88a' }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Accent Color</label>
                        <input type="color" class="form-control form-control-color" name="accent_color"
                            value="{{ setting('accent_color') ?? '#f6c23e' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Background Color</label>
                        <input type="color" class="form-control form-control-color" name="background_color"
                            value="{{ setting('background_color') ?? '#ffffff' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Text Color</label>
                    <input type="color" class="form-control form-control-color" name="text_color"
                        value="{{ setting('text_color') ?? '#212529' }}">
                </div>


                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Button Style</label>
                        <select name="button_style" class="form-select">
                            <option value="rounded" {{ setting('button_style') == 'rounded' ? 'selected' : '' }}>
                                Rounded</option>
                            <option value="square" {{ setting('button_style') == 'square' ? 'selected' : '' }}>Square
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Border Radius</label>
                        <input type="text" class="form-control" name="border_radius"
                            value="{{ setting('border_radius') ?? '8px' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Theme Mode</label>
                    <select name="theme_mode" class="form-select">
                        <option value="light" {{ setting('theme_mode') == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="dark" {{ setting('theme_mode') == 'dark' ? 'selected' : '' }}>Dark</option>
                        <option value="auto" {{ setting('theme_mode') == 'auto' ? 'selected' : '' }}>Auto</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Custom CSS</label>
                    <textarea class="form-control" name="custom_css" rows="4" placeholder="Enter custom CSS here...">{{ setting('custom_css') }}</textarea>
                </div>

                <hr>
                <h3 class="text-center fw-bold">Font Settings</h3>

                <div class="mb-3">
                    <label for="google_fonts_api_key" class="form-label">Google Font Key</label>
                    <input type="text" class="form-control" name="google_fonts_api_key"
                        value="{{ setting('google_fonts_api_key') }}">
                </div>

                <div class="row mb-3">
                    <!-- English Fonts -->
                    <div class="col-md-6">
                        <label class="form-label">Heading Font (English)</label>
                        <select name="heading_font[]" class="form-select select2-font">
                            @foreach ($googleFonts as $font)
                                <option value="{{ $font }}"
                                    {{ collect(setting('heading_font', []))->contains($font) ? 'selected' : '' }}>
                                    {{ $font }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Body Font (English)</label>
                        <select name="body_font[]" class="form-select select2-font">
                            @foreach ($googleFonts as $font)
                                <option value="{{ $font }}"
                                    {{ collect(setting('body_font', []))->contains($font) ? 'selected' : '' }}>
                                    {{ $font }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Arabic Fonts -->
                    <div class="col-md-6">
                        <label class="form-label">Heading Font (Arabic RTL)</label>
                        <select name="heading_font_rtl[]" class="form-select select2-font">
                            @foreach ($googleFonts as $font)
                                <option value="{{ $font }}"
                                    {{ collect(setting('heading_font_rtl', []))->contains($font) ? 'selected' : '' }}>
                                    {{ $font }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Body Font (Arabic RTL)</label>
                        <select name="body_font_rtl[]" class="form-select select2-font">
                            @foreach ($googleFonts as $font)
                                <option value="{{ $font }}"
                                    {{ collect(setting('body_font_rtl', []))->contains($font) ? 'selected' : '' }}>
                                    {{ $font }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-light me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Save Appearance</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <!-- jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2-font').select2({
                width: '100%',
                templateResult: function(data) {
                    if (!data.id) return data.text;
                    return $('<span style="font-family:' + data.text + ', sans-serif;">' + data.text +
                        '</span>');
                },
                templateSelection: function(data) {
                    return $('<span style="font-family:' + data.text + ', sans-serif;">' + data.text +
                        '</span>');
                }
            });
        });
    </script>
@endpush

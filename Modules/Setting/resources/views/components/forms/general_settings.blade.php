<!-- Right Side - General Settings Form -->
<style>
    .setting-image-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .setting-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        overflow: hidden;
        background: #f5f5f7;
        border: 1px solid #e6e6e6;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .setting-thumb img {
        max-width: 100%;
        max-height: 100%;
        display: block;
    }

    .setting-thumb--empty {
        font-size: 12px;
        color: #888;
    }
</style>
<div class="col-md-8">
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="card-title mb-0">General Settings</h4>
        </div>
        <div class="card-body">
            <form id="setting-form" method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                @csrf

                {{-- BASIC INFO --}}
                <div class="mb-3">
                    <label for="site_name" class="form-label">Site Name</label>
                    <input type="text" class="form-control" name="site_name" value="{{ setting('site_name') }}">
                </div>

                <div class="mb-3">
                    <label for="site_description" class="form-label">Site Description</label>
                    <textarea class="form-control" name="site_description" rows="2">{{ setting('site_description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="seo_meta_keywords" class="form-label">Meta Keywords (comma separated)</label>
                    <input type="text" class="form-control" name="seo_meta_keywords"
                        value="{{ setting('seo_meta_keywords') }}">
                </div>
                <div class="mb-3">
                    <label for="seo_schema" class="form-label">Schema Markup (JSON-LD)</label>
                    <textarea class="form-control" name="seo_schema" rows="6" placeholder=''>{{ setting('seo_schema') }}</textarea>
                </div>


                {{-- OPEN GRAPH SETTINGS --}}

                <div class="mb-3">
                    <label class="form-label">OG Image</label>
                    <div class="setting-image-row">
                        <div class="setting-thumb">
                            @php $ogImageUrl = setting_image_url('og_image'); @endphp
                            @if ($ogImageUrl)
                                <img id="preview-og_image" src="{{ $ogImageUrl }}" alt="OG Image">
                            @else
                                <div class="setting-thumb--empty" id="preview-og_image">No img</div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <input type="file" class="form-control img-input" name="og_image"
                                data-preview="preview-og_image" accept="image/*">
                            @if (setting('og_image'))
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="og_image_remove"
                                        name="og_image_remove" value="1">
                                    <label class="form-check-label" for="og_image_remove">Remove current image</label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- IMAGES ROW 1 --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Favicon</label>
                        <div class="setting-image-row">
                            <div class="setting-thumb">
                                @php $faviconUrl = setting_image_url('favicon'); @endphp
                                @if ($faviconUrl)
                                    <img id="preview-favicon" src="{{ $faviconUrl }}" alt="Favicon">
                                @else
                                    <div class="setting-thumb--empty" id="preview-favicon">No img</div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" class="form-control img-input" name="favicon"
                                    data-preview="preview-favicon" accept="image/*">
                                @if (setting('favicon'))
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="favicon_remove"
                                            name="favicon_remove" value="1">
                                        <label class="form-check-label" for="favicon_remove">Remove current
                                            image</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Header Logo</label>
                        <div class="setting-image-row">
                            <div class="setting-thumb">
                                @php $headerUrl = setting_image_url('header_logo'); @endphp
                                @if ($headerUrl)
                                    <img id="preview-header_logo" src="{{ $headerUrl }}" alt="Header Logo">
                                @else
                                    <div class="setting-thumb--empty" id="preview-header_logo">No img</div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" class="form-control img-input" name="header_logo"
                                    data-preview="preview-header_logo" accept="image/*">
                                @if (setting('header_logo'))
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="header_logo_remove"
                                            name="header_logo_remove" value="1">
                                        <label class="form-check-label" for="header_logo_remove">Remove current
                                            image</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- IMAGES ROW 2 --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Footer Logo</label>
                        <div class="setting-image-row">
                            <div class="setting-thumb">
                                @php $footerUrl = setting_image_url('footer_logo'); @endphp
                                @if ($footerUrl)
                                    <img id="preview-footer_logo" src="{{ $footerUrl }}" alt="Footer Logo">
                                @else
                                    <div class="setting-thumb--empty" id="preview-footer_logo">No img</div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" class="form-control img-input" name="footer_logo"
                                    data-preview="preview-footer_logo" accept="image/*">
                                @if (setting('footer_logo'))
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="footer_logo_remove"
                                            name="footer_logo_remove" value="1">
                                        <label class="form-check-label" for="footer_logo_remove">Remove current
                                            image</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Dark Logo</label>
                        <div class="setting-image-row">
                            <div class="setting-thumb">
                                @php $darkUrl = setting_image_url('dark_logo'); @endphp
                                @if ($darkUrl)
                                    <img id="preview-dark_logo" src="{{ $darkUrl }}" alt="Dark Logo">
                                @else
                                    <div class="setting-thumb--empty" id="preview-dark_logo">No img</div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" class="form-control img-input" name="dark_logo"
                                    data-preview="preview-dark_logo" accept="image/*">
                                @if (setting('dark_logo'))
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="dark_logo_remove"
                                            name="dark_logo_remove" value="1">
                                        <label class="form-check-label" for="dark_logo_remove">Remove current
                                            image</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- IMAGE ROW 3 --}}
                <div class="mb-3">
                    <label class="form-label">Light Logo</label>
                    <div class="setting-image-row">
                        <div class="setting-thumb">
                            @php $lightUrl = setting_image_url('light_logo'); @endphp
                            @if ($lightUrl)
                                <img id="preview-light_logo" src="{{ $lightUrl }}" alt="Light Logo">
                            @else
                                <div class="setting-thumb--empty" id="preview-light_logo">No img</div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <input type="file" class="form-control img-input" name="light_logo"
                                data-preview="preview-light_logo" accept="image/*">
                            @if (setting('light_logo'))
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="light_logo_remove"
                                        name="light_logo_remove" value="1">
                                    <label class="form-check-label" for="light_logo_remove">Remove current
                                        image</label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ setting('email') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{ setting('phone') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" value="{{ setting('address') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Timezone</label>
                    <select class="form-select" name="timezone">
                        @foreach (timezone_identifiers_list() as $tz)
                            <option value="{{ $tz }}" {{ setting('timezone') == $tz ? 'selected' : '' }}>
                                {{ $tz }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Copyright Text</label>
                    <input type="text" class="form-control" name="copyright_text"
                        value="{{ setting('copyright_text') }}">
                </div>

                <div class="mb-3 form-check form-switch">
                    <input type="hidden" name="maintenance_mode" value="0">
                    <input type="checkbox" class="form-check-input" id="maintenance_mode" name="maintenance_mode"
                        value="1" {{ setting('maintenance_mode') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="maintenance_mode">
                        Maintenance Mode
                    </label>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-light me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.img-input').forEach(function(input) {
            input.addEventListener('change', function() {
                const file = this.files && this.files[0];
                const previewId = this.dataset.preview;
                const holder = document.getElementById(previewId);
                if (!previewId || !holder) return;
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    // if preview was a DIV placeholder, turn it into an IMG
                    if (holder.tagName.toLowerCase() !== 'img') {
                        const img = document.createElement('img');
                        img.id = previewId;
                        img.alt = 'Preview';
                        img.src = e.target.result;
                        holder.replaceWith(img);
                    } else {
                        holder.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            });
        });
    });
</script>

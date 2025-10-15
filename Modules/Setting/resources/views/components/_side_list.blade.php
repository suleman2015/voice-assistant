<div class="col-md-3">
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="card-title mb-0">Main Settings</h4>
            <div class="mt-2">
                <input type="text" id="search-settings" class="form-control" placeholder="Search...">
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column" id="settings-list">
                @can('setting.index')
                    <li class="nav-item border-bottom">
                        <a class="nav-link {{ request()->routeIs('setting.index') ? 'active' : '' }}"
                            href="{{ route('setting.index') }}">
                            <i class="fas fa-cog me-2"></i> General Settings
                        </a>
                    </li>
                @endcan
                @can('setting.smtp')
                    <li class="nav-item border-bottom">
                        <a class="nav-link {{ request()->routeIs('setting.smtp') ? 'active' : '' }}"
                            href="{{ route('setting.smtp') }}">
                            <i class="fas fa-envelope me-2"></i> SMTP Settings
                        </a>
                    </li>
                @endcan
                @can('setting.modules.setting')
                    <li class="nav-item border-bottom">
                        <a class="nav-link {{ request()->routeIs('setting.modules_setting') ? 'active' : '' }}"
                            href="{{ route('setting.modules_setting') }}">
                            <i class="fas fa-cog me-2"></i> Modules Settings
                        </a>
                    </li>
                @endcan
                @can('setting.website.tracking')
                    <li class="nav-item border-bottom">
                        <a class="nav-link {{ request()->routeIs('setting.website_tracking') ? 'active' : '' }}"
                            href="{{ route('setting.website_tracking') }}">
                            <i class="fas fa-chart-line me-2"></i> Website Tracking
                        </a>
                    </li>
                @endcan
                @can('setting.site.appearance')
                    <li class="nav-item border-bottom">
                        <a class="nav-link {{ request()->routeIs('site.appearance') ? 'active' : '' }}"
                            href="{{ route('site.appearance') }}">
                            <i class="fas fa-palette me-2"></i> Site Appearence
                        </a>
                    </li>
                @endcan
                @can('recaptcha.settings.index')
                    @if (is_module_enabled('Recaptcha'))
                        <li class="nav-item border-bottom">
                            <a class="nav-link {{ request()->routeIs('recaptcha.settings.index') ? 'active' : '' }}"
                                href="{{ route('recaptcha.settings.index') }}">
                                <i class="fas fa-shield-alt me-2"></i> reCAPTCHA Settings
                            </a>
                        </li>
                    @endif
                @endcan
            </ul>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $("#search-settings").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#settings-list li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endpush

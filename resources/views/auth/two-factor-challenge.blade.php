<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ __('Two-Factor Challenge') }} | Onc Brothers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Transformative Pathways" name="description" />
    <meta content="Onc Brothers Team" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/frontend/img/logo.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/preloader.min.css') }}">
    <link href="{{ asset('assets/admin/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/dist/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/dist/css/app.min.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="{{ url('/') }}" class="d-block auth-logo">
                                        <span class="logo-txt">{{ __('Onc Brothers') }}</span>
                                    </a>
                                </div>

                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <h5 class="mb-0">{{ __('Two-Factor Authentication') }}</h5>
                                        <p class="text-muted mt-2">{{ __('Enter the authentication code from your app to continue.') }}</p>
                                    </div>

                                    <form method="POST" action="{{ route('two-factor.verify') }}" class="mt-4 pt-2">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="code" class="form-label">{{ __('Authentication Code') }}</label>
                                            <input type="text" id="code" name="code" inputmode="numeric" pattern="[0-9]*"
                                                class="form-control" autofocus placeholder="123 456" autocomplete="one-time-code">
                                            <x-input-error :messages="$errors->get('code')" class="mt-2 text-danger" />
                                        </div>

                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100" type="submit">{{ __('Verify & Continue') }}</button>
                                        </div>
                                    </form>

                                    <div class="mt-4 text-center">
                                        <a class="text-muted d-inline-flex align-items-center gap-1" href="{{ route('login') }}">
                                            <i class="mdi mdi-arrow-left"></i> {{ __('Use a different account') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8 col-md-7">
                    <div class="auth-bg pt-md-5 p-4 d-flex">
                        <div class="bg-overlay bg-primary"></div>
                        <ul class="bg-bubbles">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/dist/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/feather-icons/feather.min.js') }}"></script>
</body>

</html>

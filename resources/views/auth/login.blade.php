<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Onc Brothers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Transformative Pathways" name="description" />
    <meta content="Onc Brothers Team" name="author" />
    <link rel="shortcut icon" href="{{ setting_image_url('favicon') }}" type="image/x-icon">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/preloader.min.css') }}">
    <link href="{{ asset('assets/admin/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/dist/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/dist/css/app.min.css') }}" rel="stylesheet" />
    <style>
        :root {
            --primary-color: {{ setting('primary_color') ?? '#4e73df' }};
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .pace .pace-activity {
            background: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 4px 10px 0 color-mix(in srgb, var(--primary-color), transparent 50%);
        }

        .auth-bg {
            background-image: url('assets/frontend/images/banner-bg.webp');
        }
    </style>
</head>

<body>
    <div class="auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <!-- Left Column -->
                <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="auth-full-page-content d-flex p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">

                                <!-- Logo -->
                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="{{ url('/') }}" class="d-block auth-logo">
                                        {{-- <img src="{{ asset('assets/frontend/img/logo.png') }}" alt=""
                                            height="28"> --}}
                                        <span class="logo-txt">{{ __('Onc Brothers') }}</span>
                                    </a>
                                </div>

                                <!-- Login Form -->
                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <h5 class="mb-0">{{ __('Welcome Back !') }}</h5>
                                        <p class="text-muted mt-2">{{ __('Sign in to continue.') }}</p>
                                    </div>

                                    <!-- Session Status -->
                                    <x-auth-session-status class="mb-4 text-success text-center" :status="session('status')" />

                                    <form method="POST" action="{{ route('login') }}" class="mt-4 pt-2">
                                        @csrf

                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ __('Email') }}</label>
                                            <input id="email" type="email" class="form-control" name="email"
                                                :value="old('email')" required autofocus autocomplete="username"
                                                placeholder="{{ __('Enter email') }}">
                                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label">{{ __('Password') }}</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input id="password" type="password" class="form-control"
                                                    name="password" autocomplete="current-password"
                                                    placeholder="{{ __('Enter password') }}">
                                                <button class="btn btn-light shadow-none ms-0" type="button"
                                                    id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                                        </div>

                                        <!-- Remember Me -->
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="remember_me"
                                                name="remember">
                                            <label class="form-check-label"
                                                for="remember_me">{{ __('Remember me') }}</label>
                                        </div>

                                        <!-- reCAPTCHA -->
                                        @if (config('recaptcha.enabled') && \Modules\Recaptcha\Models\RecaptchaForm::isEnabled('login_form'))
                                            <div class="mb-3">
                                                {!! NoCaptcha::display() !!}
                                                <x-input-error :messages="$errors->get('recaptcha')" class="mt-2 text-danger" />
                                            </div>
                                            @push('scripts')
                                                {!! NoCaptcha::renderJs() !!}
                                            @endpush
                                        @endif

                                        <!-- Submit -->
                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100"
                                                type="submit">{{ __('Log In') }}</button>
                                        </div>
                                    </form>

                                    {{-- <div class="mt-5 text-center">
                                        <p class="text-muted mb-0">Don't have an account? <a
                                                href="{{ route('register') }}" class="text-primary fw-semibold">Signup
                                                now</a></p>
                                    </div> --}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column Background -->
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
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-7">
                                <div class="p-0 p-sm-4 px-xl-0">
                                    <div class="container-fluid">
                                        <div class="section-div">
                                            <div class="testi-contain text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <!-- ✨ New Section Below Bubbles -->
                                                <div class="mt-5">
                                                    <h3 class="fw-semibold text-white">Oncology Knowledge. Empowered
                                                        Care.</h3>
                                                    <p class="text-white-50 mt-2 mb-0"
                                                        style="max-width: 600px; margin: 0 auto;">
                                                        Join the <strong>Onc Brothers</strong> community — bridging
                                                        research, treatment, and real stories
                                                        to empower oncology professionals and patients worldwide.
                                                    </p>
                                                    <hr class="border-light opacity-50 my-4"
                                                        style="width: 120px; margin: 1.5rem auto;">
                                                    <p class="small text-white-50 mb-0">
                                                        <span class="fw-semibold">#TogetherAgainstCancer</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                   
                                    </div>
                                    <!-- end review carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('assets/admin/dist/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/pace-js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/js/pages/pass-addon.init.js') }}"></script>

    <!-- Inject reCAPTCHA & others -->
    @stack('scripts')
</body>

</html>

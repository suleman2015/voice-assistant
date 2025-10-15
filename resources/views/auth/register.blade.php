<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register | Onc Brothers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Transformative Pathways" name="description" />
    <meta content="Onc Brothers Team" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/frontend/img/logo.png') }}">

    <!-- Styles -->
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
                                    <a href="index.html" class="d-block auth-logo">
                                        {{-- <img src="{{ asset('assets/frontend/img/logo.png') }}" alt=""
                                            height="28"> --}}
                                        <span class="logo-txt">{{ __('Onc Brothers') }}</span>
                                    </a>
                                </div>
                                <div class="auth-content my-auto">
                                    <form class="needs-validation mt-4 pt-2" method="POST"
                                        action="{{ route('register') }}">
                                        @csrf <!-- CSRF Token for security -->

                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" placeholder="Enter email" value="{{ old('email') }}"
                                                required>
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Username -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Username</label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                name="name" placeholder="Enter username" value="{{ old('name') }}"
                                                required>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" placeholder="Enter password" required>
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm
                                                Password</label>
                                            <input type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Confirm password" required>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Terms and Conditions -->
                                        <div class="mb-4">
                                            <p class="mb-0">By registering you agree to the Masarat <a href="#"
                                                    class="text-primary">Terms of Use</a></p>
                                        </div>

                                        <!-- reCAPTCHA -->
                                        @if (config('recaptcha.enabled') && \Modules\Recaptcha\Models\RecaptchaForm::isEnabled('register_form'))
                                            <div class="mb-3">
                                                {!! NoCaptcha::display() !!}
                                                <x-input-error :messages="$errors->get('recaptcha')" class="mt-2 text-danger" />
                                            </div>
                                            @push('scripts')
                                                {!! NoCaptcha::renderJs() !!}
                                            @endpush
                                        @endif

                                        <!-- Submit Button -->
                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type="submit">Register</button>
                                        </div>
                                    </form>

                                    <div class="mt-5 text-center">
                                        <p class="text-muted mb-0">Already have an account ? <a
                                                href="{{ route('login') }}" class="text-primary fw-semibold"> Login
                                            </a> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
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
                        <!-- end bubble effect -->
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-7">
                                <div class="p-0 p-sm-4 px-xl-0">
                                    <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                        <div
                                            class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                            <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                data-bs-slide-to="0" class="active" aria-current="true"
                                                aria-label="Slide 1"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                data-bs-slide-to="1" aria-label="Slide 2"></button>
                                            <button type="button" data-bs-target="#reviewcarouselIndicators"
                                                data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        </div>
                                        <!-- end carouselIndicators -->
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">“I feel confident
                                                        imposing change
                                                        on myself. It's a lot more progressing fun than looking back.
                                                        That's why
                                                        I ultricies enim
                                                        at malesuada nibh diam on tortor neaded to throw curve balls.”
                                                    </h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-1.jpg"
                                                                    class="avatar-md img-fluid rounded-circle"
                                                                    alt="...">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Richard Drews
                                                                </h5>
                                                                <p class="mb-0 text-white-50">Web Designer</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="carousel-item">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">“Our task must be to
                                                        free ourselves by widening our circle of compassion to embrace
                                                        all living
                                                        creatures and
                                                        the whole of quis consectetur nunc sit amet semper justo. nature
                                                        and its beauty.”</h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-shrink-0">
                                                                <img src="assets/images/users/avatar-2.jpg"
                                                                    class="avatar-md img-fluid rounded-circle"
                                                                    alt="...">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Rosanna French
                                                                </h5>
                                                                <p class="mb-0 text-white-50">Web Developer</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="carousel-item">
                                                <div class="testi-contain text-white">
                                                    <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                    <h4 class="mt-4 fw-medium lh-base text-white">“I've learned that
                                                        people will forget what you said, people will forget what you
                                                        did,
                                                        but people will never forget
                                                        how donec in efficitur lectus, nec lobortis metus you made them
                                                        feel.”</h4>
                                                    <div class="mt-4 pt-3 pb-5">
                                                        <div class="d-flex align-items-start">
                                                            <img src="{{ asset('assets/frontend/img/logo.png') }}"
                                                                class="avatar-md img-fluid rounded-circle"
                                                                alt="...">
                                                            <div class="flex-1 ms-3 mb-4">
                                                                <h5 class="font-size-18 text-white">Ilse R. Eaton</h5>
                                                                <p class="mb-0 text-white-50">Manager
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end carousel-inner -->
                                    </div>
                                    <!-- end review carousel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
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

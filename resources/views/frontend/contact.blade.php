{{-- @section('title', __('Contact Us | Oncology Brothers | Get in Touch')) --}}
@extends('frontend.layouts.master')

@section('content')
    <div class="home_banner general-banner position-relative"
         style="background-image: url('assets/frontend/images/contact-bg.webp'); background-size:cover; background-position:center; ">
        <div class="top_bg2"></div>
        <div class="home_banner__inner position-relative">
            <div class="container">
                <h1 class="text-center banner-h fw-bold">Contact Oncology Brothers</h1>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <p class="textlight mb-3 fs-4">Contact Us</p>
                <h4 class="textlight mb-3">We're Here to Help with Your Oncology Questions</h4>
                <h3 class="textlight mb-3">How Can We Assist You?</h3>

                <div class="contact-section">
                    <div class="contact-info">
                        <i class="ri-mail-fill"></i>
                        <span>
                            <a href="mailto:info@oncbrothers.com" class="text-white" rel="noopener">info@oncbrothers.com</a>
                        </span>
                    </div>
                </div>

                <div class="content-section">
                    <div class="content-box">
                        <h3>Customer Support</h3>
                        <p>Our support team is available around the clock to help you with any queries.</p>
                    </div>
                    <div class="content-box">
                        <h3>Feedback and Suggestions</h3>
                        <p>We value your feedback and are continuously working towards improving ourselves to help you better.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="contact-area pb-70">
                    <form id="contactForm" method="POST" action="{{ route('contact.submit') }}" novalidate autocomplete="off">
                        @csrf

                        @if (session('success'))
                            <div class="alert alert-success text-center" role="status" aria-live="polite">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Honeypot (hidden) --}}
                        <div class="hp-wrap" aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;overflow:hidden;">
                            <label for="_hp_website">Website</label>
                            <input type="text" name="_hp_website" id="_hp_website" tabindex="-1" autocomplete="off" />
                            <input type="hidden" name="_hp_time" value="{{ now()->timestamp }}">
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name"><i class="ri-user-3-fill"></i></label>
                                    <input id="name" name="name" placeholder="Name" class="form-control input-field"
                                           value="{{ old('name') }}" type="text" required maxlength="150"
                                           autocomplete="name" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email"><i class="ri-mail-fill"></i></label>
                                    <input id="email" name="email" placeholder="Email" class="form-control input-field"
                                           value="{{ old('email') }}" type="email" required maxlength="254"
                                           autocomplete="email" inputmode="email" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone"><i class="ri-phone-fill"></i></label>
                                    <input id="phone" name="phone" placeholder="Phone" class="form-control input-field"
                                           value="{{ old('phone') }}" type="tel" required maxlength="40"
                                           autocomplete="tel" inputmode="tel" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="address"><i class="ri-map-pin-fill"></i></label>
                                    <input id="address" name="address" placeholder="Address" class="form-control input-field"
                                           value="{{ old('address') }}" type="text" required maxlength="255"
                                           autocomplete="street-address" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="subject"><i class="ri-bookmark-fill"></i></label>
                                    <input id="subject" name="subject" placeholder="Subject" class="form-control input-field"
                                           value="{{ old('subject') }}" type="text" required maxlength="150" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="content"><i class="ri-edit-fill"></i></label>
                                    <textarea id="content" name="content" rows="6" placeholder="Write your Question/Concern"
                                              class="form-control input-field" required maxlength="5000"
                                              style="resize:vertical">{{ old('content') }}</textarea>
                                </div>
                            </div>

                            {{-- reCAPTCHA --}}
                            @if (config('recaptcha.enabled') && \Modules\Recaptcha\Models\RecaptchaForm::isEnabled('contact-form'))
                                <div class="mb-3">
                                    {!! NoCaptcha::display() !!}
                                    <x-input-error :messages="$errors->get('recaptcha')" class="mt-2 text-danger" />
                                </div>
                                @push('scripts')
                                    {!! NoCaptcha::renderJs() !!}
                                @endpush
                            @endif

                            <div class="col-lg-12 mt-3">
                                <button id="submitBtn" type="submit" class="theme_btn border-0 w-100">
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Google Recaptcha API (kept) --}}
    <script src="https://www.google.com/recaptcha/api.js?" async defer></script>

    {{-- Prevent double submit & add small UX guard --}}
    <script>
        (function () {
            const form = document.getElementById('contactForm');
            const btn  = document.getElementById('submitBtn');
            if (!form || !btn) return;

            form.addEventListener('submit', function () {
                btn.disabled = true;
                btn.textContent = 'Sending...';
                // Safety: re-enable after 10s in case of network issues
                setTimeout(() => { btn.disabled = false; btn.textContent = 'Send Message'; }, 10000);
            }, { passive: true });
        })();
    </script>
@endsection

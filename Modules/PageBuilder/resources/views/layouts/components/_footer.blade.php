<!-- Footer Start -->
<div class="container-fluid footer pt-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container pt-5">
        <div class="row g-5">
            <div class="col-xl-8">
                <div class="mb-5">
                    <div class="row g-4">
                        <!-- Logo and Socials -->
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInLeft" data-wow-delay="0.1s">
                            <div class="footer-item">
                                <a href="{{ url('/') }}" class="mb-4">
                                    <img src="{{ asset('assets/' . $content['logo']['value']) }}" width="100px" alt="Logo">
                                </a>
                                <div class="footer-btn d-flex">
                                    <a class="btn btn-md-square me-3" href="{{ $content['social_facebook']['value'] }}"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-md-square me-3" href="{{ $content['social_instagram']['value'] }}"><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-md-square me-3" href="{{ $content['social_twitter']['value'] }}"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-md-square me-0" href="{{ $content['social_linkedin']['value'] }}"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Useful Links -->
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInRight" data-wow-delay="0.3s">
                            <div class="footer-item">
                                <h4 class="text-white mb-4 footer-title">{{ $content['useful_links_title']['value'] }}</h4>
                                <ul class="list-unstyled">
                                    <li><a href="{{ url($content['about_us_url']['value']) }}" class="d-block mb-2">{{ $content['about_us_text']['value'] }}</a></li>
                                    <li><a href="{{ url($content['features_url']['value']) }}" class="d-block mb-2">{{ $content['features_text']['value'] }}</a></li>
                                    <li><a href="{{ url($content['services_url']['value']) }}" class="d-block mb-2">{{ $content['services_text']['value'] }}</a></li>
                                    <li><a href="{{ url($content['faqs_url']['value']) }}" class="d-block mb-2">{{ $content['faqs_text']['value'] }}</a></li>
                                    <li><a href="{{ url($content['blogs_url']['value']) }}" class="d-block mb-2">{{ $content['blogs_text']['value'] }}</a></li>
                                    <li><a href="{{ url($content['contact_url']['value']) }}" class="d-block">{{ $content['contact_text']['value'] }}</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInRight" data-wow-delay="0.5s">
                            <div class="footer-item">
                                <h4 class="mb-4 text-white footer-title">{{ $content['contact_title']['value'] }}</h4>
                                <div class="row">
                                    <a href="mailto:{{ $content['email']['value'] }}" class="text-light small"><i class="fas fa-envelope text-warning me-2"></i>{{ $content['email']['value'] }}</a>
                                    <a href="tel:{{ $content['phone']['value'] }}" class="text-light small"><i class="fas fa-phone-alt text-warning me-2"></i>{{ $content['phone']['value'] }}</a>
                                    <a href="#" class="text-light small"><i class="fas fa-map-marker-alt text-warning me-2"></i>{{ $content['address']['value'] }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Newsletter (static) -->
            <div class="col-xl-4 wow fadeInRight" data-wow-delay="0.7s">
                <div class="footer-item">
                    <h4 class="text-white mb-4 footer-title">{{ $content['newsletter_title']['value'] }}</h4>
                    <div class="position-relative rounded-pill mb-4">
                        <input class="form-control rounded-pill w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email">
                        <button type="button" class="btn btn-primary rounded-pill position-absolute signup_newsletter py-2 mt-2 me-2">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright py-md-4 py-3 text-white">
    <div class="container">
        <div class="row g-4 align-items-between">
            <div class="col-md-6 mb-md-0">
                <span class="text-white">
                    <a href="#" class="text-white">{{ $content['copyright_text']['value'] }}</a>
                </span>
            </div>
            <div class="col-md-6 text-md-end text-center">
                <a href="{{ url($content['privacy_policy_url']['value']) }}" class="text-white me-3">{{ $content['privacy_policy_text']['value'] }}</a>
                <a href="{{ url($content['terms_url']['value']) }}" class="text-white">{{ $content['terms_text']['value'] }}</a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->

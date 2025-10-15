<footer class="footer-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-lg-4 mb-md-0 mb-4">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/frontend/images/logo.webp') }}" class="img-fluid logo-footer" width="115"
                        height="32" alt="logo" />
                </a>
            </div>
            <div class="col-md-4 col-lg-3 mb-md-0 mb-3">
                <div class="widget-h mb-4">
                    <p class="mb-0">Quick Links</p>
                </div>
                <ul class="footer_nav">
                    <li><a href="https://twitter.com/oncbrothers?lang=en" target="_blank" title="X (Twitter)"
                            class="f_link">X (Twitter)</a></li>
                    <li><a href="https://www.youtube.com/@oncologybrothers" target="_blank" title="YouTube"
                            class="f_link">YouTube</a></li>
                    <li><a href="https://www.instagram.com/oncbrothers/" target="_blank" title="Instagram"
                            class="f_link">Instagram</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="widget-h mb-4">
                    <p class="mb-0">About us</p>
                </div>
                <ul class="footer_nav">
                    <li><a title="DR. RAHUL GOSAIN" class="f_link" href="{{ route('rohitGosainMd') }}">DR. RAHUL
                            GOSAIN</a></li>
                    <li><a title="DR. ROHIT GOSAIN" class="f_link" href="{{ route('rohitGosainMd') }}">DR. ROHIT
                            GOSAIN</a></li>
                    <li><a title="PRIVACY POLICY" class="f_link" href="{{ route('privacyPolicy') }}">PRIVACY POLICY</a>
                    </li>
                    <li><a title="TERMS AND CONDITIONS" class="f_link" href="{{ route('termsAndConditions') }}">TERMS AND
                            CONDITIONS</a></li>
                </ul>
            </div>

        </div>
        <div class="mini_footer">
            <ul class="social_linklist">
                <li><a href="https://twitter.com/oncbrothers?lang=en" target="_blank" class="social_icon twitter"
                        aria-label="Follow us on Twitter"><i class="ri-twitter-x-line"></i></a></li>
                <li class="mx-2"><a href="https://www.youtube.com/@oncologybrothers" target="_blank"
                        class="social_icon youtube" aria-label="Follow us on YouTube"><i
                            class="ri-youtube-fill"></i></a></li>
                <li><a href="https://www.instagram.com/oncbrothers/" target="_blank" class="social_icon instagram"
                        aria-label="Follow us on Instagram"><i class="ri-instagram-fill"></i></a></li>
            </ul>
            <p class="text-center mb-0">{{ setting('copyright_text') }}.</p>
        </div>
    </div>
</footer>

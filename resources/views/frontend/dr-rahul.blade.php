@section('title', __('Dr Rahul Gosain, MD, MBA'))
@extends('frontend.layouts.master')

@section('content')


    <div class="home_banner general-banner position-relative"
        style="background-image: url('assets/frontend/images/banner-bg.webp'); background-size:cover; background-position:center; ">
        <div class="top_bg2"></div>
        <div class="home_banner__inner position-relative">
            <div class="container">
                <h1 class="text-center banner-h fw-bold">Rahul Gosain, MD, MBA</h1>
            </div>
        </div>
    </div>
    <section class="profile-section py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 pt-0 sticky-profile">
                    <div class="profile-card p-4 shadow rounded-lg text-center">
                        <img src="assets/frontend/images/rahul-profiles.jpg" class="rounded-circle mb-4 profile-avatar"
                            alt="Rahul Gosain, MD, MBA">
                        <h3 class="mb-3 fw-bold">Rahul Gosain, MD, MBA</h3>
                        <p class="text-white">Medical Director, Wilmot Cancer Institute</p>
                        <hr>
                        <div class="specialties mb-4">
                            <h5 class="mb-3">Specialties</h5>
                            <span class="badge specialty-badge me-1 mb-2">Hematology</span>
                            <span class="badge specialty-badge me-1 mb-2">Oncology</span>
                            <span class="badge specialty-badge me-1 mb-2">Medical Technology</span>
                        </div>
                        <a href="{{ route('contact') }}" class="btn btn-lg w-100 btn_pro">Contact <i
                                class="ri-arrow-right-line ms-2"></i></a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="profile-content p-md-5 p-2 shadow rounded-lg">
                        <h2 class="mb-4 border-bottom pb-3 fw-bold">About</h2>
                        <div class="bio-section mb-5">

                            <p class="lead">Rahul Gosain is a Medical Director of Wilmot Cancer Institute at Webster,
                                Director of Wilmot Cancer Institute Regional Infusion services, and a clinician specializing
                                in a wide variety of solid and hematologic malignancies.</p>
                            <p>His insight facilitates some of the most technologically advanced cancer treatments, sharing
                                his developments with his patients in the community. He is a valued member of the University
                                of Rochester Medicine–Strong Memorial Hospital, contributing his extensive knowledge of
                                technology and professional oncology experience to the clinic.</p>
                            <p>Rahul is well‑known in both the online sphere and the medical community, spearheading
                                campaigns to both raise the bar and close the gap in oncology advancements.</p>

                        </div>
                        <div class="education-section mb-5">
                            <h3 class="mb-4"><i class="ri-graduation-cap-line me-2"></i>Education &amp; Training</h3>
                            <ul class="timeline">

                                <li class="timeline-item mb-4">
                                    <h5 class="fw-bold">MBA in Healthcare</h5>
                                    <p class="text-white mb-1">Johns Hopkins University – Carey Business School</p>
                                    <small class="text-white">Current</small>
                                </li>

                                <li class="timeline-item mb-4">
                                    <h5 class="fw-bold">Oncology & Hematology Fellowship</h5>
                                    <p class="text-white mb-1">University of Louisville School of Medicine</p>
                                    <small class="text-white">Chief Fellow | 2018</small>
                                </li>

                                <li class="timeline-item mb-4">
                                    <h5 class="fw-bold">Internal Medicine Residency</h5>
                                    <p class="text-white mb-1">Johns Hopkins University Sinai Hospital</p>
                                    <small class="text-white">Multiple Awards | 2015</small>
                                </li>

                                <li class="timeline-item mb-4">
                                    <h5 class="fw-bold">MD</h5>
                                    <p class="text-white mb-1">University of Medicine and Health Sciences</p>
                                    <small class="text-white">Highest Honors | 2012</small>
                                </li>

                            </ul>
                        </div>
                        <div class="achievements-section">
                            <h3 class="mb-4"><i class="ri-award-line me-2"></i>Awards &amp; Honors</h3>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="card mb-3 border-0 bg-light ">
                                        <div class="card-body">
                                            <h5 class="card-title">Best Fellow Award</h5>
                                            <p class="card-text text-muted">University of Louisville | 2018</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-3 border-0 bg-light ">
                                        <div class="card-body">
                                            <h5 class="card-title">Outstanding Junior Resident</h5>
                                            <p class="card-text text-muted">Johns Hopkins Sinai | 2014</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-3 border-0 bg-light ">
                                        <div class="card-body">
                                            <h5 class="card-title">Scholarship Honor Award</h5>
                                            <p class="card-text text-muted">McMaster University | 2008</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cta-section py-5">
        <div class="container text-center">
            <h2 class="display-5 mb-4">Interested in community heme/onc practice?</h2>
            <p class="lead mb-5">Connect with Dr. Gosain to discuss innovative approaches to oncology care and technology
                integration.</p>
            <a href="{{ route('contact') }}" class="btn btn-lg px-5 btn_pro">Contact Now <i
                    class="ri-arrow-right-line ms-2"></i></a>
        </div>
    </section>

    <section class="additional-info py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow bg-darkblue">
                        <div class="card-body">
                            <h3 class="card-title text-white fw-bold mb-4"><i
                                    class="ri-briefcase-line me-2"></i>Professional Experience</h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0 ps-0">
                                    <h5 class="fw-bold text-white mb-1">Medical Director</h5>
                                    <p class="text-white-50 mb-1">Wilmot Cancer Institute at Webster</p><small
                                        class="text-white">Present</small>
                                </li>
                                <li class="list-group-item border-0 ps-0">
                                    <h5 class="fw-bold text-white mb-1">Director, Regional Infusion Services</h5>
                                    <p class="text-white-50 mb-1">Wilmot Cancer Institute</p>
                                </li>
                                <li class="list-group-item border-0 ps-0">
                                    <h5 class="fw-bold text-white mb-1">Medical Director</h5>
                                    <p class="text-white-50 mb-1">Guthrie Cancer Center</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow bg-darkblue">
                        <div class="card-body">
                            <h3 class="card-title mb-4 fw-bold text-white"><i
                                    class="ri-lightbulb-flash-line me-2"></i>Innovations</h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0 ps-0">
                                    <h5 class="text-white fw-bold mb-1">Learn from Apps</h5>
                                    <p class="text-white-50">Co-founded tech venture bridging medicine and technology with
                                        efficient study tools.</p>
                                </li>
                                <li class="list-group-item border-0 ps-0">
                                    <h5 class="text-white fw-bold mb-1">American Board of AI in Medicine</h5>
                                    <p class="text-white-50">Certified in 2021, bringing artificial intelligence
                                        applications to oncology practice.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <p class="lead">Together with his brother Rohit, the Oncology Brothers offer the oncology community an
                    innovative, thoughtful, and intriguing perspective.</p>
            </div>
        </div>
    </section>


@endsection

@section('scripts')

@endsection

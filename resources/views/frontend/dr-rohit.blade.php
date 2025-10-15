@section('title', __('Dr Rohit Gosain, MD'))
@extends('frontend.layouts.master')

@section('content')

    <div class="home_banner general-banner position-relative"
        style="background-image: url('assets/frontend/images/banner-bg.webp'); background-size:cover; background-position:center; ">
        <div class="top_bg2"></div>
        <div class="home_banner__inner position-relative">
            <div class="container">
                <h1 class="text-center banner-h fw-bold">Rohit Gosain, MD</h1>
            </div>
        </div>
    </div>
    <section class="profile-section py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 pt-0 sticky-profile">
                    <div class="profile-card p-4 shadow rounded-lg text-center">
                        <img src="assets/frontend/images/rohit-profile.jpg" class="rounded-circle mb-4 profile-avatar"
                            alt="Rohit Gosain, MD">
                        <h3 class="mb-3 fw-bold">Rohit Gosain, MD</h3>
                        <p class="text-white">Medical Director, Hematology and Oncology – Roswell Park Care Network</p>
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

                            <p class="lead">Dr. Rohit Gosain is the Medical Director of Hematology and Oncology at
                                the Roswell Park Care Network in Southtowns, serving as a community oncologist who sees
                                benign and malignant hematology along with solid tumors. He is recognized for offering
                                his community‑leading expertise as one of the Oncology Brothers, contributing to
                                groundbreaking advancements in cancer treatments and medical technologies that
                                facilitate learning and improved patient care.</p>
                            <p>Rohit’s early passion for technology began with his studies in Computer Engineering at
                                the University of Waterloo, where he earned multiple awards for outstanding performance.
                                After starting his career as a software consultant and volunteering with the Toronto
                                Arthritis Community, he pursued medicine at Saba University School of Medicine. Rohit
                                blends his engineering experience with his clinical work, creating medical learning
                                technologies and reviewing numerous publications. He continues to push innovation in
                                cancer care and medical education.</p>

                        </div>
                        <div class="education-section mb-5">
                            <h3 class="mb-4"><i class="ri-graduation-cap-line me-2"></i>Education &amp; Training
                            </h3>
                            <ul class="timeline">

                                <li class="timeline-item mb-4">
                                    <h5 class="fw-bold">Fellowship, Medical Oncology and Hematology</h5>
                                    <p class="text-white mb-1">Roswell Park Comprehensive Cancer Center / University at
                                        Buffalo</p>
                                    <small class="text-white">2017–2020</small>
                                </li>

                                <li class="timeline-item mb-4">
                                    <h5 class="fw-bold">Residency, Internal Medicine</h5>
                                    <p class="text-white mb-1">Sinai Hospital of Baltimore / Johns Hopkins University
                                    </p>
                                    <small class="text-white">Outstanding Intern of the Year | 2017</small>
                                </li>

                                <li class="timeline-item mb-4">
                                    <h5 class="fw-bold">Doctor of Medicine</h5>
                                    <p class="text-white mb-1">Saba University School of Medicine</p>
                                    <small class="text-white">Graduated 2014</small>
                                </li>

                                <li class="timeline-item mb-4">
                                    <h5 class="fw-bold">BASc, Computer Engineering with Management Sciences</h5>
                                    <p class="text-white mb-1">University of Waterloo</p>
                                    <small class="text-white">Queen Elizabeth Scholarship for Outstanding Performance |
                                        Hira & Kamal Ahuja Engineering Award | 2008</small>
                                </li>

                            </ul>
                        </div>
                        <div class="achievements-section">
                            <h3 class="mb-4"><i class="ri-award-line me-2"></i>Awards &amp; Honors</h3>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="card mb-3 border-0 bg-light ">
                                        <div class="card-body">
                                            <h5 class="card-title">Outstanding Intern of the Year</h5>
                                            <p class="card-text text-muted">Sinai Hospital of Baltimore / Johns Hopkins
                                                | 2017</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-3 border-0 bg-light ">
                                        <div class="card-body">
                                            <h5 class="card-title">Queen Elizabeth Scholarship for Outstanding
                                                Performance</h5>
                                            <p class="card-text text-muted">University of Waterloo | 2008</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-3 border-0 bg-light ">
                                        <div class="card-body">
                                            <h5 class="card-title">Hira & Kamal Ahuja Engineering Award</h5>
                                            <p class="card-text text-muted">University of Waterloo | 2008</p>
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
            <h2 class="display-5 mb-4">Want to talk about community heme/onc practice?</h2>
            <p class="lead mb-5">Connect with Dr. Rohit Gosain to discuss advances in community oncology and technology
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
                                    <h5 class="fw-bold text-white">Medical Director, Hematology and Oncology</h5>
                                    <p class="text-white-50 mb-1">Roswell Park Care Network</p><small
                                        class="text-white">Present</small>
                                </li>
                                <li class="list-group-item border-0 ps-0">
                                    <h5 class="fw-bold text-white">Medical Director</h5>
                                    <p class="text-white-50 mb-1">Guthrie Cancer Center</p>
                                </li>
                                <li class="list-group-item border-0 ps-0">
                                    <h5 class="fw-bold text-white">Team Lead Software Consultant</h5>
                                    <p class="text-white-50 mb-1">Infusion</p>
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
                            <div class="innovation-item mb-4">
                                <h5 class="text-white fw-bold">Learn from Apps</h5>
                                <p class="text-white-50">Founded a medical learning portal combining educational tools for
                                    efficient study and knowledge-sharing.</p>
                            </div>
                            <div class="innovation-item">
                                <h5 class="text-white fw-bold">Medical Publications</h5>
                                <p class="text-white-50">Contributed and reviewed several publications, pioneering
                                    technology for efficient medical education.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <p class="lead">Together with his brother Rahul, the Oncology Brothers offer the oncology community an
                    innovative, thoughtful, and intriguing perspective.</p>
            </div>
        </div>
    </section>

@endsection

@section('scripts')

@endsection

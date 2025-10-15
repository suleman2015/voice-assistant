@section('title', __('Cookie Policy'))
@extends('frontend.layouts.master')

@section('content')


    <div class="home_banner general-banner position-relative"
        style="background-image: url('assets/frontend/images/banner2.webp'); background-size:cover; background-position:center; ">
        <div class="top_bg2"></div>
        <div class="home_banner__inner position-relative">
            <div class="container">
                <h1 class="text-center banner-h fw-bold">Cookie Policy</h1>
            </div>
        </div>
    </div>
    <div class="container py-5 last_section">
        {!! $page->content !!}
    </div>

@endsection

@section('scripts')

@endsection

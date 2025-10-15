@extends('admin.layouts.app')

@section('title', 'Profile Manager')

@push('styles')
@endpush
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @include('profile.partials.two-factor-authentication-form')
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush

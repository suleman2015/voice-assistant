@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18 fw-bold">Settings Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Layout -->
            <div class="row">
                @include('setting::components._side_list')

                @if (View::exists($formView))
                    @include($formView)
                @else
                    <!-- Right Side - Category Form -->
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">No View Available</h5>
                                <p class="card-text">The requested view could not be found. Please check your settings or try again later.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

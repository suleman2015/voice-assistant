@extends('admin.layouts.app')
@section('title')
    {{ __('Create Component') }}
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18 fw-bold">Components Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Components</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card card-body border-0 shadow mb-4">
                        <h2 class="h5 mb-4">{{ __('Dynamic Component') }}</h2>
                        <form method="POST" action="{{ route('components.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="icon">{{ __('Component Icon') }}</label>
                                        <x-img-up name="icon" accept="image/*" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="name">{{ __('Component Name') }}</label>
                                        <input class="form-control" name="name" value="{{ old('name') }}"
                                            id="name" type="text" placeholder="Enter Component name" required>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <x-editor-field label="{{ __('Content') }}" name="content" :value="old('content')" />
                                </div>

                                <div class="col-md-6 mb-3 mt-2">
                                    <div>
                                        <div class="form-check form-switch">
                                            <label class="form-check-label"
                                                for="status">{{ __('Component Status') }}</label>
                                            <i data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('When status is active, component will be visible in Page Manager') }}"
                                                class="mx-1 fa-solid fa-circle-info">
                                            </i>
                                            <input class="form-check-input" type="checkbox" value="1" checked
                                                name="status" id="status">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary" type="submit">{{ __('Create Component') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

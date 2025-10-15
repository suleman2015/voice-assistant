@extends('admin.layouts.app')

@section('title', 'Create Url')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="fw-bold mb-3">Create New Url</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Card Header -->
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h4 class="card-title mb-0">Create New Url</h4>
                            <div class="d-flex align-items-center gap-2">
                                <button type="submit" form="url-create-form" class="btn btn-sm btn-primary">
                                    <i class="fas fa-save me-1"></i> Save
                                </button>
                                <a href="{{ route('urlredirector.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                            </div>
                        </div>

                        <!-- Card Body / Form -->
                        <div class="card-body table-responsive">
                            <form action="{{ route('urlredirector.store') }}" method="POST" enctype="multipart/form-data"
                                id="url-create-form">
                                @csrf
                                <div class="row">

                                    <!-- Left Column -->
                                    <div class="col-md-9 border-end">
                                        <x-text label="Original Url" name="original_url"
                                            value="{{ old('original_url', $urlRedirector->original_url ?? '') }}"
                                            placeholder="Enter Original Url" />

                                        <x-text label="Target Url" name="target_url"
                                            value="{{ old('target_url', $urlRedirector->target_url ?? '') }}"
                                            placeholder="Enter Target Url" />
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-3">
                                        <x-date-field label="Expiry Date" name="expires_at"
                                            value="{{ old('expires_at', $urlRedirector->expires_at ?? '') }}"
                                            required="true" />

                                        <x-switch-field label="Active / Inactive" name="is_active" :checked="(old('is_active', $urlRedirector->is_active ?? '')) == 1"
                                            value="1" />
                                    </div>

                                </div> <!-- End row -->
                            </form>
                        </div> <!-- End card-body -->

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Edit Url')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="fw-bold mb-3">Edit Url</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="card-title mb-0">Edit Url</h4>
                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" form="url-edit-form" class="btn btn-sm btn-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                        <a href="{{ route('urlredirector.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <form action="{{ route('urlredirector.update', $urlredirector) }}" method="POST"
                        enctype="multipart/form-data" id="url-edit-form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-9 border-end">
                                <x-text label="Original Url" name="original_url"
                                    value="{{ old('original_url', $urlredirector->original_url) }}"
                                    placeholder="Enter Original Url" />

                                <x-text label="Target Url" name="target_url"
                                    value="{{ old('target_url', $urlredirector->target_url) }}"
                                    placeholder="Enter Target Url" />
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-3">
                                <x-date-field label="Expiry Date" name="expires_at" value="{{ $urlredirector->expires_at }}"
                                    required="true" :disablePast="true" />


                                <x-switch-field label="Active / Inactive" name="is_active" :checked="$urlredirector->is_active"
                                    value="1" />

                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

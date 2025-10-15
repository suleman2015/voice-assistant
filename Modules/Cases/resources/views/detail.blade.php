@extends('admin.layouts.app')

@section('title', 'Case Detail')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-4 text-secondary fw-bold">
                    <i class="fas fa-file-medical-alt me-2"></i> Case Details
                </h1>
                <a href="{{ route('cases.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Cases
                </a>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    {{-- Case Info --}}
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h4 class="mb-0">{{ $case->is_anonymous ? 'Anonymous Case' : $case->name }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-user-md me-2 text-secondary"></i> Profession:</strong>
                                        {{ $case->profession }}</p>
                                    <p><strong><i class="fas fa-stethoscope me-2 text-secondary"></i> Specialty:</strong>
                                        {{ $case->specialty }}</p>
                                    <p><strong><i class="far fa-calendar-alt me-2 text-secondary"></i> Case Date:</strong>
                                        {{ $case->case_date ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-user-secret me-2 text-secondary"></i> Anonymous:</strong>
                                        {{ $case->is_anonymous ? 'Yes' : 'No' }}</p>
                                    <p><strong><i class="fas fa-file-signature me-2 text-secondary"></i> Terms
                                            Agreed:</strong>
                                        {{ $case->terms_agreed ? 'Yes' : 'No' }}</p>
                                    <p><strong><i class="fas fa-clock me-2 text-secondary"></i> Created At:</strong>
                                        {{ $case->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-bold"><i class="fas fa-align-left me-2 text-secondary"></i>Description:</h6>
                                <div class="alert alert-secondary shadow-sm">
                                    {{ $case->description }}
                                </div>
                            </div>

                            {{-- Status dropdown --}}
                            <form action="{{ route('cases.updateStatus', $case->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('PUT')
                                <div class="d-flex align-items-center">
                                    <label for="status" class="fw-bold me-2"><i
                                            class="fas fa-flag me-2 text-secondary"></i>Status:</label>
                                    <select name="status" id="status" class="form-select w-auto me-3">
                                        <option value="pending" {{ $case->status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="approved" {{ $case->status == 'approved' ? 'selected' : '' }}>
                                            Approved
                                        </option>
                                        <option value="rejected" {{ $case->status == 'rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-save me-1"></i> Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    {{-- Uploaded Images --}}
                    @if ($case->images && count($case->images) > 0)
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-secondary text-white">
                                <h4 class="mb-0">Uploaded Images</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($case->images as $image)
                                        <div class="col-md-4 mb-4">
                                            <div class="card shadow-sm border-0 h-100">
                                                <img src="{{ asset($image->file_path) }}"
                                                    class="card-img-top img-fluid rounded-top" alt="Case Image">
                                                <div class="card-body">
                                                    <p class="mb-1"><strong>Type:</strong>
                                                        {{ $image->image_type ?? 'N/A' }}
                                                    </p>
                                                    <p class="mb-1"><strong>Date Taken:</strong>
                                                        {{ $image->date_taken ?? 'N/A' }}
                                                    </p>
                                                    <p class="mb-0"><strong>Uploaded:</strong>
                                                        {{ $image->created_at->format('Y-m-d H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info shadow-sm">
                            <i class="fas fa-info-circle me-2"></i>No images uploaded for this case.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

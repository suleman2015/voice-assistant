@extends('admin.layouts.app')

@section('title', 'Create Event')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="fw-bold mb-3">Create New Event</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Events</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h4 class="card-title mb-0">Create Event</h4>
                            <div class="d-flex align-items-center gap-2">
                                <button type="submit" form="event-create-form" class="btn btn-sm btn-primary">
                                    <i class="fas fa-save me-1"></i> Save
                                </button>
                                <a href="{{ route('events.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                            </div>
                        </div>

                        <div class="card-body table-responsive">
                            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" id="event-create-form">
                                @include('events::_form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

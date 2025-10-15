@extends('admin.layouts.app')

@section('title', 'Edit Event')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="card-title mb-0">Edit Event</h4>
                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" form="event-edit-form" class="btn btn-sm btn-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                        <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="event-edit-form" action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('events::_form', ['event' => $event])
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

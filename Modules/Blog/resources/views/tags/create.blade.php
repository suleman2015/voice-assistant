@extends('admin.layouts.app')

@section('title', 'Create Tag')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <h4 class="fw-bold mb-3">Create New Tag</h4>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tags.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Tag Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- SEO meta component -->
                        <x-seo-meta />

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('tags.index') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" class="btn btn-success">Save Tag</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

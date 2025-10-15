@extends('admin.layouts.app')

@section('title', 'Edit Tag')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <h4 class="fw-bold mb-3">Edit Tag</h4>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tags.update', $tag->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Tag Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $tag->name) }}"
                                required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3">{{ old('description', $tag->description) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="draft" {{ $tag->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ $tag->status == 'published' ? 'selected' : '' }}>Published
                                </option>
                                <option value="archived" {{ $tag->status == 'archived' ? 'selected' : '' }}>Archived
                                </option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- SEO meta component -->
                        <x-seo-meta :model="$tag ?? null" />

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('tags.index') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Tag</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

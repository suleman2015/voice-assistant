@extends('admin.layouts.app')

@section('title', 'Urls Management')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold"><i class="bi bi-link-45deg fs-1 me-2"></i>Urls Management</h4>
                <a href="{{ route('urlredirector.create') }}" class="btn btn-primary">+ Add New Url</a>
            </div>

            <!-- Urls Table -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Id</th>
                                <th>Original Url</th>
                                <th>Target Url</th>
                                <th>State</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($urlRedirects as $urlRedirect)
                                <tr>
                                    <td>{{ $urlRedirect->id }}</td>
                                    <td>{{ $urlRedirect->original_url }}</td>
                                    <td>{{ $urlRedirect->target_url }}</td>
                                    <td>
                                        @if ($urlRedirect->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $urlRedirect->created_at ? $urlRedirect->created_at->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td>{{ $urlRedirect->updated_at ? $urlRedirect->updated_at->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('urlredirector.edit', $urlRedirect->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('urlredirector.destroy', $urlRedirect->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">No Urls found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".delete-form").forEach(form => {
                form.addEventListener("submit", e => {
                    e.preventDefault();
                    alertify.confirm("Confirm Delete", "Are you sure you want to delete this Url?",
                        () => form.submit(),
                        () => alertify.error("Canceled")
                    );
                });
            });
        });
    </script>
@endpush

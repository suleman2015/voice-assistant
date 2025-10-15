@extends('admin.layouts.app')
@section('title')
    {{ __('Component Page') }}
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Component Page -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">{{ __('Component Page') }}</h4>
                            @can('posts.create')
                                <a href="{{ route('components.create') }}" class="btn btn-primary btn-action">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    {{ __('Create') }}
                                </a>
                            @endcan
                        </div>

                        <div class="card border-0 shadow mb-4">
                            <div class="card-body">
                                <form action="{{ route('components.index') }}" method="get" class="mb-4">
                                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-md-end">
                                        <div class="d-flex">
                                            <select class="form-select custom-select mb-2 me-1 mb-md-0 me-md-2"
                                                name="component_display" id="component-display1"
                                                aria-label="Default select example">
                                                @foreach ($display as $key => $value)
                                                    <option @if ($currentDisplay == $key) selected @endif
                                                        value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-select custom-select mb-2 me-1 mb-md-0 me-md-2"
                                                name="component_category" id="component-category"
                                                aria-label="Default select example">
                                                <option value="all">{{ __('All Categories') }}</option>
                                                @foreach ($categories as $category)
                                                    <option @if ($currentCategory == $category) selected @endif
                                                        value="{{ $category }}">{{ ucfirst($category) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="btn-toolbar  mb-md-0">
                                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center">
                                                <i class="bi bi-funnel-fill me-1"></i>
                                                {{ __('Filter Now') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @include('pagebuilder::component.partial._' . $currentDisplay)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('click', '.delete-btn', function() {
                const postId = $(this).data('id');
                const postName = $(this).data('name') || 'this component';
                const actionUrl = "{{ route('components.destroy', ':id') }}".replace(':id', postId);
                const button = $(this);

                alertify.confirm(
                    'Confirm Delete',
                    `Are you sure you want to delete <strong>${postName}</strong>?`,
                    function() {
                        $.ajax({
                            url: actionUrl,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                alertify.success(response.message ||
                                    'Component deleted successfully');

                                // Remove the row/card from DOM
                                const row = button.closest('tr');
                                const card = button.closest('.col-md-3');
                                if (row.length) {
                                    row.remove();
                                } else if (card.length) {
                                    card.remove();
                                }
                            },
                            error: function(xhr) {
                                alertify.error(xhr.responseJSON?.message ||
                                'Delete failed');
                            }
                        });
                    },
                    function() {
                        alertify.message('Delete cancelled');
                    }
                ).set('labels', {
                    ok: 'Delete',
                    cancel: 'Cancel'
                });
            });
        });
    </script>
@endpush

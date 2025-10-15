@extends('admin.layouts.app')

@section('title', 'Posts')

@push('styles')
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18 fw-bold">Posts Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Posts</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Posts Table</h4>
                            @can('posts.create')
                                <a href="{{ route('posts.create') }}" class="btn btn-danger btn-action">Create Post</a>
                            @endcan
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-bordered" id="posts-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/admin/dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            const table = $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('posts.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'categories', name: 'categories' },
                    { data: 'author_name', name: 'author_name' },
                    { data: 'type', name: 'type' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // Edit button — redirect to edit page
            $(document).on('click', '.edit-btn', function() {
                const editUrl = $(this).data('edit-url');
                window.location.href = editUrl;
            });

            // Delete button — confirm + AJAX
            $(document).on('click', '.delete-btn', function() {
                const postId = $(this).data('id');
                const postName = $(this).data('name') || 'this post';
                const actionUrl = "{{ route('posts.destroy', ':id') }}".replace(':id', postId);

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
                                alertify.success(response.message || 'Deleted successfully');
                                table.ajax.reload(null, false);
                            },
                            error: function(xhr) {
                                alertify.error(xhr.responseJSON.message || 'Delete failed');
                            }
                        });
                    },
                    function() {
                        alertify.message('Delete cancelled');
                    }
                ).set('labels', { ok: 'Delete', cancel: 'Cancel' });
            });
        });
    </script>
@endpush

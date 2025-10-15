@extends('admin.layouts.app')

@section('title', 'Pages')

@push('styles')
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Pages Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Pages Management</h4>
                            @can('pages.create')
                                <a href="{{ route('pages.create') }}" class="btn btn-primary btn-action">Create Page</a>
                            @endcan
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-bordered" id="pages-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
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
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script>
        $(function() {
            const table = $('#pages-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('pages.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Edit button — redirect to edit page
            $(document).on('click', '.edit-btn', function() {
                const editUrl = $(this).data('edit-url');
                window.location.href = editUrl;
            });

            // Delete button — confirm + AJAX
            $(document).on('click', '.delete-btn', function() {
                const pageId = $(this).data('id');
                const pageName = $(this).data('name') || 'this page';
                const actionUrl = "{{ route('pages.destroy', ':id') }}".replace(':id', pageId);

                alertify.confirm(
                    'Confirm Delete',
                    `Are you sure you want to delete <strong>${pageName}</strong>?`,
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
                                    'Deleted successfully');
                                table.ajax.reload(null,
                                    false); // reload table without resetting page
                            },
                            error: function(xhr) {
                                alertify.error(xhr.responseJSON.message || 'Delete failed');
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

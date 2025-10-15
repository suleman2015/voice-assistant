@extends('admin.layouts.app')

@section('title', 'Users Management')

@push('styles')
    <!-- DataTables -->
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" />
@endpush

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                        <h4 class="card-title mb-0 fw-bold"><i class="bi bi-table me-2"></i>Users Management</h4>
                        @can('create.user')
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Create User
                            </a>
                        @endcan
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped nowrap w-100" id="users-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables scripts -->
    <script src="{{ asset('assets/admin/dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>

    <script>
        $(function() {
            let table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.index') }}',
                responsive: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
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

            // Alertify-based delete confirmation
            $(document).on('click', '.deleteUserBtn', function() {
                const userId = $(this).data('id');
                const userName = $(this).data('name');
                const actionUrl = "{{ route('users.destroy', ':id') }}".replace(':id', userId);

                alertify.confirm(
                    'Delete User',
                    `Are you sure you want to delete <strong>${userName}</strong>?`,
                    function() {
                        // Submit form programmatically
                        const form = $('<form>', {
                            method: 'POST',
                            action: actionUrl
                        });

                        form.append('@csrf');
                        form.append('@method('DELETE')');
                        $('body').append(form);
                        form.submit();
                    },
                    function() {
                        alertify.message('Delete cancelled');
                    }
                ).set('labels', {
                    ok: 'Yes, Delete',
                    cancel: 'Cancel'
                });
            });
        });
    </script>
@endpush

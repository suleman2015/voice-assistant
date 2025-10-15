@extends('admin.layouts.app')

@section('title', 'Cases')

@push('styles')
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Cases Management</h4>
        </div>

        <!-- Cases Table -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered align-middle" id="cases-table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Specialty</th>
                            <th>Profession</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                </table>
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
            const table = $('#cases-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('cases.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'specialty', name: 'specialty' },
                    { data: 'profession', name: 'profession' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // Delete button — confirm + AJAX
            $(document).on('click', '.delete-btn', function() {
                const caseId = $(this).data('id');
                const caseName = $(this).data('name') || 'this case';
                const actionUrl = $(this).data('delete-url');

                alertify.confirm(
                    'Confirm Delete',
                    `Are you sure you want to delete <strong>${caseName}</strong>?`,
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

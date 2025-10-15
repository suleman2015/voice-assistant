@extends('admin.layouts.app')

@section('title', 'Newsletter Management')

@push('styles')
    <!-- DataTables -->
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                    <h1 class="card-title mb-0 fw-bold text-center">
                        <i class="bi bi-envelope-paper me-2"></i> Newsletters
                    </h1>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered" id="newsletter-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created At</th>
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
    <!-- Required datatable js -->
    <script src="{{ asset('assets/admin/dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            let table = $('#newsletter-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.newsletters.index") }}',
                language: {
                    processing: `<div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                 </div>`,
                    emptyTable: "No data available in table"
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'email', name: 'email'},
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Delete
            $(document).on('click', '.deleteNewsletterBtn', function() {
                let id = $(this).data('id');
                let email = $(this).data('email');
                if (confirm(`Delete subscription for ${email}?`)) {
                    $.ajax({
                        url: '/admin/newsletters/' + id,
                        type: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function(res) {
                            table.ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush

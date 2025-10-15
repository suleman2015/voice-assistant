@extends('admin.layouts.app')

@section('title', 'Menus')

@push('styles')
    {{-- DataTables --}}
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" />
@endpush

@section('content')
    <div class="page-content">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="fw-bold mb-3">Create New Menu</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Menu</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                        <h4 class="card-title mb-0 fw-bold"><i class="bi bi-list-ul me-2"></i>Menus</h4>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMenuModal">
                            <i class="bi bi-plus-circle me-1"></i> New Menu
                        </button>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped nowrap w-100" id="menus-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Items</th>
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

    {{-- Create menu modal --}}
    <div class="modal fade" id="newMenuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="{{ route('admin.menus.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create new menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input name="location" class="form-control" placeholder="main / footer / sidebar" required>
                        <div class="form-text">Letters, numbers, dashes & underscores only.</div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Create & edit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- DataTables --}}
    <script src="{{ asset('assets/admin/dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>

    <script>
        $(function() {
            const table = $('#menus-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.menus.index') }}',
                responsive: true,
                order: [
                    [5, 'desc']
                ], // updated_at desc
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
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'items_count',
                        name: 'items_count',
                        searchable: false
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

            // Toggle status (AJAX)
            $(document).on('click', '.js-toggle', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                $.ajax({
                    url,
                    method: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    complete: () => table.ajax.reload(null, false)
                });
            });

            // Delete with alertify
            $(document).on('click', '.js-delete', function(e) {
                e.preventDefault();
                const name = $(this).data('name');
                const url = $(this).data('url');

                alertify.confirm(
                    'Delete Menu',
                    `Are you sure you want to delete <strong>${name}</strong>?`,
                    function() {
                        const $form = $('<form>', {
                                method: 'POST',
                                action: url
                            })
                            .append(`@csrf`)
                            .append(`@method('DELETE')`);
                        $('body').append($form);
                        $form.trigger('submit');
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

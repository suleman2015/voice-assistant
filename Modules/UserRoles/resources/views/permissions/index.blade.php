@extends('admin.layouts.app')

@section('title', 'Permissions')

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

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18 fw-bold">Permissions Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Permissions</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Default Datatable</h4>
                            <button type="button" class="btn btn-primary btn-action" data-bs-toggle="modal"
                                data-bs-target="#createModal">Create Permission
                            </button>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered" id="permissions-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Roles</th>
                                        <th>Category</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Modal -->
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-light py-3">
                            <h3 class="modal-title fw-bold text-primary">
                                <i class="bi bi-plus-circle me-2"></i>Create Permission
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="{{ route('permissions.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-medium mb-2">Permission Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                                        <input type="text" class="form-control form-control-lg" id="name"
                                            name="name" required placeholder="Enter permission name">
                                    </div>
                                    <div class="form-text">Enter a unique name for this permission</div>
                                </div>
                                <div class="mb-4">
                                    <label for="category" class="form-label fw-medium mb-2">Category</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-grid"></i></span>
                                        <input type="text" class="form-control form-control-lg" id="category"
                                            name="category" required placeholder="Enter category name">
                                    </div>
                                    <div class="form-text">Group related permissions together</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-2">
                                    <button type="button" class="btn btn-secondary btn-action" data-bs-dismiss="modal">
                                        <i class="bi bi-x-lg me-1"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-action px-4">
                                        <i class="bi bi-check-circle me-1"></i> Create
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Create Modal -->

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-light py-3">
                            <h3 class="modal-title fw-bold text-primary">
                                <i class="bi bi-pencil-square me-2"></i>Edit Permission
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="" method="POST" id="editForm">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="edit-name" class="form-label fw-medium mb-2">Permission Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                                        <input type="text" class="form-control form-control-lg" id="edit-name"
                                            name="name" required placeholder="Enter permission name">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="edit-category" class="form-label fw-medium mb-2">Category</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-grid"></i></span>
                                        <input type="text" class="form-control form-control-lg" id="edit-category"
                                            name="category" required placeholder="Enter category name">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-2">
                                    <button type="button" class="btn btn-secondary btn-action" data-bs-dismiss="modal">
                                        <i class="bi bi-x-lg me-1"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-action px-4">
                                        <i class="bi bi-check-circle me-1"></i> Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Edit Modal -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>

    <script type="text/javascript">
        const permissionShowUrl = "{{ route('permissions.show', ':id') }}";
        const permissionUpdateUrl = "{{ route('permissions.update', ':id') }}";
        const permissionDeleteUrl = "{{ route('permissions.destroy', ':id') }}";

        $(function() {
            let table = $('#permissions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('permissions.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'index',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


            $(document).on('click', '.delete-btn', function() {
                var permissionId = $(this).data('id');
                var permissionName = $(this).data('name');
                var actionUrl = "{{ route('permissions.destroy', ':id') }}".replace(':id', permissionId);

                alertify.confirm(
                    'Confirm Delete',
                    'Are you sure you want to delete this permission',
                    function() {
                        // User confirmed delete
                        $.ajax({
                            url: actionUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                alertify.success(response.message);
                                // Reload page or update table
                                window.location.reload();
                            },
                            error: function(xhr) {
                                alertify.error(xhr.responseJSON.message ||
                                    'Failed to delete permission');
                            }
                        });
                    },
                    function() {
                        // User canceled delete
                        alertify.message('Delete canceled');
                    }
                ).set('labels', {
                    ok: 'Delete',
                    cancel: 'Cancel'
                });
            });

            // EDIT MODAL TRIGGER
            $(document).on('click', '.edit-btn', function() {
                const permissionId = $(this).data('id');
                const showUrl = permissionShowUrl.replace(':id', permissionId);
                const updateUrl = permissionUpdateUrl.replace(':id', permissionId);

                $.ajax({
                    url: showUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#editForm').attr('action', updateUrl);
                        $('#edit-name').val(response.name);
                        $('#edit-category').val(response.category ?? '');
                        $('#editModal').modal('show');
                    },
                    error: function() {
                        alert("Failed to fetch permission data.");
                    }
                });
            });
        });
    </script>
@endpush

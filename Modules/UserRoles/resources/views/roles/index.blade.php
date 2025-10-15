@extends('admin.layouts.app')

@section('title', 'Roles')

@push('styles')
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet">
@endpush

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                        <h4 class="card-title mb-0 fw-bold"><i class="bi bi-table me-2"></i>Roles User</h4>
                        <button type="button" class="btn btn-primary btn-action" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="bi bi-plus-circle me-1"></i> Create Role
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="roles-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-light py-3">
                                <h3 class="modal-title fw-bold text-danger">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Delete Role
                                </h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="text-center mb-4">
                                    <div class="mb-3">
                                        <i class="bi bi-exclamation-octagon display-4 text-danger"></i>
                                    </div>
                                    <h4 class="text-danger fw-bold mb-3">Are you sure you want to delete <span
                                            class="fw-bold" id="roleName"></span>?</h4>
                                    <p class="text-muted">This action is irreversible.</p>
                                </div>
                                <form method="POST" id="deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <div class="d-flex justify-content-center gap-3 pt-3 border-top">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-lg me-1"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-danger px-4">
                                            <i class="bi bi-trash3 me-1"></i> Delete
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content border-0 shadow-lg">
                            <!-- Modal Header -->
                            <div class="modal-header bg-light py-3">
                                <h3 class="modal-title fw-bold text-primary d-flex align-items-center">
                                    <i class="bi bi-pencil-square me-2 fs-4"></i>Edit Role
                                </h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- Scrollable Body -->
                            <div class="modal-body p-4 overflow-auto" style="max-height: calc(100vh - 160px);">
                                <form action="" method="POST" id="editForm">
                                    @csrf
                                    @method('PUT')

                                    <!-- Role Name -->
                                    <div class="mb-4">
                                        <label for="edit-name" class="form-label fw-medium mb-2">Role Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                                            <input type="text" class="form-control form-control-lg" id="edit-name"
                                                name="name" required>
                                        </div>
                                    </div>

                                    <!-- Permissions -->
                                    <div class="mb-4">
                                        <label class="form-label fw-medium mb-3 d-flex align-items-center">
                                            <i class="bi bi-shield-lock me-2"></i>Assign Permissions
                                        </label>

                                        <div class="border rounded-3 overflow-hidden">
                                            <div class="p-3 bg-light">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    <small class="text-muted">Select permissions to assign to this
                                                        role</small>
                                                </div>
                                            </div>

                                            <div class="p-3">
                                                @foreach ($permissions->groupBy('category') as $category => $categoryPermissions)
                                                    <div class="permission-category mb-4">
                                                        <h5 class="text-uppercase fw-bold mb-3 py-2 text-primary">
                                                            <i class="bi bi-grid me-2 text-primary fs-5"></i>
                                                            <span class="text-primary">{{ $category ?? 'Uncategorized' }}</span>
                                                        </h5>
                                                        <div class="row g-3">
                                                            @foreach ($categoryPermissions as $permission)
                                                                <div class="col-md-4">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch"
                                                                            id="edit-perm-{{ $permission->id }}"
                                                                            name="permissions[]"
                                                                            value="{{ $permission->id }}">
                                                                        <label class="form-check-label fw-medium text-dark"
                                                                            for="edit-perm-{{ $permission->id }}">
                                                                            {{ $permission->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer bg-white border-top py-3 px-4 d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg me-1"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary px-4" form="editForm">
                                    <i class="bi bi-check-circle me-1"></i> Update Role
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        const roleShowUrl = "{{ route('roles.show', ':id') }}";
        const roleUpdateUrl = "{{ route('roles.update', ':id') }}";

        $(function() {
            let table = $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('roles.index') }}',
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
                        data: 'permissions',
                        name: 'permissions',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
                var roleId = $(this).data('id');
                var roleName = $(this).data('name');
                var actionUrl = "{{ route('roles.destroy', ':id') }}".replace(':id', roleId);

                $('#deleteForm').attr('action', actionUrl);
                $('#roleName').text(roleName);

                $('#deleteModal').modal('show');

            });


            $(document).on('click', '.edit-btn', function() {
                const roleId = $(this).data('id');
                const showUrl = roleShowUrl.replace(':id', roleId);
                const updateUrl = roleUpdateUrl.replace(':id', roleId);

                $.ajax({
                    url: showUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#editForm').attr('action', updateUrl);
                        $('#edit-name').val(response.name);

                        $('input[name="permissions[]"]').prop('checked', false);

                        if (response.permissions) {
                            response.permissions.forEach(function(perm) {
                                $('#edit-perm-' + perm.id).prop('checked', true);
                            });
                        }

                        $('#editModal').modal('show');
                    },
                    error: function() {
                        alert('Failed to fetch role data.');
                    }
                });
            });
        });
    </script>
@endpush

@extends('admin.layouts.app')

@section('title', 'Contact Management')

@push('styles')
    <!-- DataTables -->
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/admin/dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                        <h1 class="card-title mb-0 fw-bold text-center"><i class="bi bi-people me-2"></i>Contact List</h1>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered" id="contacts-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>City</th>
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


    <div class="modal fade" id="contactDetailModal" tabindex="-1" aria-labelledby="contactDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white justify-content-center position-relative">
                    <h3 class="modal-title fs-4 fw-bold text-white m-0">
                        <i class="bi bi-person-lines-fill me-2"></i> Contact Details
                    </h3>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    {{-- <div class="row g-3"> --}}
                    <!-- Left Column -->
                    {{-- <div class="col-md-6"> --}}
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-person-circle me-2"></i>Personal Information
                    </h5>

                    <div class="d-flex flex-wrap py-2 border-bottom">
                        <div class="col-12 col-sm-5 text-muted">Name:</div>
                        <div class="col-12 col-sm-7" id="contactName">-</div>
                    </div>

                    <div class="d-flex flex-wrap py-2 border-bottom">
                        <div class="col-12 col-sm-5 text-muted">Email:</div>
                        <div class="col-12 col-sm-7">
                            <a href="#" class="text-decoration-none" id="contactEmailLink">-</a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap py-2 border-bottom">
                        <div class="col-12 col-sm-5 text-muted">Country:</div>
                        <div class="col-12 col-sm-7" id="contactCountry">-</div>
                    </div>

                    <div class="d-flex flex-wrap py-2 border-bottom">
                        <div class="col-12 col-sm-5 text-muted">City:</div>
                        <div class="col-12 col-sm-7" id="contactCity">-</div>
                    </div>

                    <div class="d-flex flex-wrap py-2 border-bottom">
                        <div class="col-12 col-sm-5 text-muted">Created At:</div>
                        <div class="col-12 col-sm-7" id="contactCreatedAt">-</div>
                    </div>
                    {{-- </div> --}}

                    {{-- <!-- Right Column -->
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">
                            <i class="bi bi-stars me-2"></i>Other Details
                        </h5>

                        <div class="d-flex flex-wrap py-2 border-bottom">
                            <div class="col-12 col-sm-5 text-muted">Phone:</div>
                            <div class="col-12 col-sm-7">
                                <a href="#" class="text-decoration-none" id="contactPhoneLink">-</a>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap py-2 border-bottom">
                            <div class="col-12 col-sm-5 text-muted">Subject:</div>
                            <div class="col-12 col-sm-7" id="contactSubject">-</div>
                        </div>

                        <div class="d-flex flex-wrap py-2 border-bottom">
                            <div class="col-12 col-sm-5 text-muted">Address:</div>
                            <div class="col-12 col-sm-7" id="contactAddress">-</div>
                        </div>
                    </div> --}}
                    {{-- </div> --}}

                    <!-- Message Section -->
                    <div class="mt-4">
                        <label class="form-label fw-bold text-muted small">Message</label>
                        <div id="contactMessage" class="border rounded p-3 bg-light"></div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Close
                    </button>
                    <div class="ms-auto d-flex align-items-center gap-3">
                        <select id="contactStatus" class="form-select w-auto">
                            <option value="unread">Unread</option>
                            <option value="read">Read</option>
                            <option value="replied">Replied</option>
                        </select>
                        <button type="button" class="btn btn-primary" id="saveStatusBtn">
                            <i class="bi bi-save me-1"></i> Save Status
                        </button>
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
    <script type="text/javascript">
        $(function() {
            // Define the named routes in your JavaScript
            var showContactUrl = "{{ route('contact.show', ':id') }}";
            var updateStatusUrl = "{{ route('contact.updateStatus', ':id') }}";
            var deleteContactUrl = "{{ route('contact.destroy', ':id') }}";
            var contactIndexUrl = "{{ route('contact.index') }}";

            // Initialize DataTable
            let table = $('#contacts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: contactIndexUrl,
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
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


            // Show contact in modal (details)
            $(document).on('click', '.showContactBtn', function() {
                const contactId = $(this).data('id');

                // Replace the :id placeholder with the actual contact ID in the route URL
                const url = showContactUrl.replace(':id', contactId);

                $.get(url, function(data) {
                    $('#contactName').text(data.name ?? '-');
                    $('#contactEmail').text(data.email ?? '-');
                    $('#contactEmailLink').attr('href', `mailto:${data.email}`).text(data.email ??
                        '-');

                    $('#contactPhone').text(data.phone ?? '-');
                    $('#contactPhoneLink').attr('href', `tel:${data.phone}`).text(data.phone ??
                        '-');

                    $('#contactCountry').text(data.country ?? '-');
                    $('#contactCity').text(data.city ?? '-');
                    $('#contactAddress').text(data.address ?? '-');
                    $('#contactSubject').text(data.subject ?? '-');
                    $('#contactMessage').text(data.content ?? '-');

                    $('#contactStatus').val((data.status ?? 'unread').toLowerCase());

                    $('#contactCreatedAt').text(
                        new Date(data.created_at).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        })
                    );

                    $('#saveStatusBtn').data('id', data.id);

                    const modal = new bootstrap.Modal(document.getElementById(
                        'contactDetailModal'));
                    modal.show();
                });
            });

            // Save status change (update contact status)
            $('#saveStatusBtn').on('click', function() {
                const contactId = $(this).data('id');
                const newStatus = $('#contactStatus').val();

                const url = updateStatusUrl.replace(':id', contactId);

                $.post(url, {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                }, function(response) {
                    $('#contactDetailModal').modal('hide');
                    $('#contacts-table').DataTable().ajax.reload(null, false);
                });
            });

            // Show delete confirmation using AlertifyJS
            $(document).on('click', '.deleteContactBtn', function() {
                const contactId = $(this).data('id');
                const contactName = $(this).data('name');
                const actionUrl = deleteContactUrl.replace(':id', contactId);

                alertify.confirm(
                    'Delete Contact',
                    `Are you sure you want to delete <strong>${contactName}</strong>? This action is irreversible.`,
                    function() {
                        // Submit delete form via AJAX or create and submit a temporary form
                        $.ajax({
                            url: actionUrl,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                alertify.success('Contact deleted successfully.');
                                $('#contacts-table').DataTable().ajax.reload(null, false);
                            },
                            error: function() {
                                alertify.error('Something went wrong. Please try again.');
                            }
                        });
                    },
                    function() {
                        alertify.message('Delete cancelled');
                    }
                ).set({
                    labels: {
                        ok: 'Yes, Delete',
                        cancel: 'Cancel'
                    },
                    closable: false,
                    movable: false,
                    transition: 'zoom'
                });
            });

        });
    </script>
@endpush

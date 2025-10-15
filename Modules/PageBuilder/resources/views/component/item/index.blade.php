<div class="row">
    <div class="col-12 col-xl-12">
        <div class="card border border-light shadow mb-4">
            <div class="d-flex justify-content-between w-100 flex-wrap card-header">
                <div class="mb-4 mb-lg-0">
                    <h2 class="h5">{{ __(ucwords(str_replace('_', ' ', $data['section'])) . ' ' . 'Item Manage') }}
                    </h2>
                </div>
                <div class="btn-toolbar mb-4">
                    @if ($data['with_modal'])
                        <button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center"
                            data-bs-toggle="modal" data-bs-target="#new-item-modal">
                            <i class="fas fa-plus me-1"></i>
                            {{ __('Add New') }}
                        </button>
                    @else
                        <a href="{{ route('component-item.create', ['component_id' => $data['id']]) }}"
                            class="btn btn-sm btn-primary d-inline-flex align-items-center">
                            <i class="fas fa-plus me-1"></i>
                            {{ __('Add New') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="table-responsive card-body">
                <table class="table table-striped table-bordered table-hover align-items-center">
                    <thead class="thead-light">
                        <tr>
                            @foreach (array_slice(array_keys((array) $data['item_list_level']), 0, 3) as $name)
                                <th class="border-0">{{ __(ucwords(str_replace('_', ' ', $name))) }}</th>
                            @endforeach
                            <th class="border-0 text-end">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['item_list_value'] as $items)
                            <tr>
                                @foreach (array_slice($items['content']->toArray(), 0, 3) as $item)
                                    <td>
                                        <span
                                            class="fw-bold text-primary">{{ strip_tags($item['value'] ?? '-') }}</span>
                                    </td>
                                @endforeach
                                <td class="text-end">
                                    @if ($data['with_modal'])
                                        <a href="javascript:void(0);" data-id="{{ $items['id'] }}"
                                            class="edit-modal-show text-warning me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('component-item.edit', $items['id']) }}"
                                            class="text-warning me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    <a href="javascript:void(0);" data-id="{{ $items['id'] }}"
                                        class="delete text-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if (count($data['item_list_value']) == 0)
                    <h5 class="text-center text-muted py-3">{{ __('No Data Available') }}</h5>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function deleteItemWithAlertify(url) {
        alertify.confirm("Delete Confirmation", "Are you sure you want to delete this item?",
            function() {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            alertify.success(response.message || 'Deleted successfully');
                            setTimeout(() => location.reload(), 800);
                        } else {
                            alertify.error(response.message || 'Delete failed');
                        }
                    },
                    error: function() {
                        alertify.error('An error occurred while deleting.');
                    }
                });
            },
            function() {
                alertify.message('Delete cancelled');
            });
    }

    $(document).ready(function() {
        $('.delete').on('click', function() {
            let id = $(this).data('id');
            let url = '{{ route('component-item.destroy', ':id') }}'.replace(':id', id);
            deleteItemWithAlertify(url);
        });
    });
</script>

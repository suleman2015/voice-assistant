@php
    $canEdit = false;
    $canDelete = false;
    $targetIsSuperadmin = $row->hasRole('superadmin');
    $targetIsAdmin = $row->hasRole('admin');

    if ($authUser->hasRole('superadmin') && $authUser->id === 1) {
        $canEdit = $canDelete = true;
    } elseif ($authUser->hasRole('superadmin') && !$targetIsSuperadmin) {
        $canEdit = $canDelete = true;
    } elseif ($authUser->hasRole('admin') && !$targetIsAdmin && !$targetIsSuperadmin) {
        $canEdit = $canDelete = true;
    }

    $editUrl = route('users.edit', $row->id);
@endphp

@if ($canEdit)
    <a href="{{ $editUrl }}" class="btn btn-sm btn-primary">Edit</a>
@else
    <button class="btn btn-sm btn-primary" disabled>Edit</button>
@endif

@if ($canDelete)
    <button type="button" class="btn btn-sm btn-danger deleteUserBtn" data-id="{{ $row->id }}"
        data-name="{{ e($row->name) }}">
        Delete
    </button>
@else
    <button class="btn btn-sm btn-danger" disabled>Delete</button>
@endif

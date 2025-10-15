@extends('admin.layouts.app')

@push('styles')
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.components._breadcrumb')

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Details</h4>
                            <p class="card-title-desc">Fill all information below</p>
                        </div>
                        <div class="card-body p-4">
                            <form id="editUserForm" method="POST" action="{{ route('users.update', $user->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-name-input" class="form-label">Name</label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                                class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-email-input" class="form-label">Email</label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                                class="form-control" placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>

                                {{-- Optional: Leave password fields blank when editing --}}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-password-input" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Enter New Password (leave blank to keep current)">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-confirm-password-input" class="form-label">Confirm
                                                Password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Confirm New Password">
                                        </div>
                                    </div>
                                </div>

                                @if (is_module_enabled('UserRoles'))
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="role" class="form-label">Assign Role</label>
                                                <select class="form-select" name="role" id="role">
                                                    <option value="">Select Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}"
                                                            {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                                            {{ ucfirst($role->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3 form-check form-switch">
                                            <!-- Hidden input ensures 0 is sent when checkbox is unchecked -->
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-md">Save</button>
                                            <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
    </div>
@endsection

@extends('admin.layouts.app')

@section('title', 'reCAPTCHA Settings')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18 fw-bold">Settings Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Layout -->
            <div class="row">
                @include('setting::components._side_list')

                <!-- reCAPTCHA Settings Form -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h4 class="card-title mb-0">reCAPTCHA Settings</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <form method="POST" action="{{ route('recaptcha.settings.update') }}">
                                @csrf
                                <div class="form-check form-switch">
                                    <input type="hidden" name="enabled" value="0"> {{-- Ensures a value is always sent --}}
                                    <input class="form-check-input" type="checkbox" id="enabled" name="enabled"
                                        value="1" {{ $setting?->enabled ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enabled">Enable reCAPTCHA</label>
                                </div>


                                <div class="mt-3">
                                    <label>Site Key</label>
                                    <input type="text" name="site_key" class="form-control"
                                        value="{{ $setting?->site_key }}">
                                </div>

                                <div class="mt-3">
                                    <label>Secret Key</label>
                                    <input type="text" name="secret_key" class="form-control"
                                        value="{{ $setting?->secret_key }}">
                                </div>

                                <button class="btn btn-primary mt-3">Save Settings</button>
                            </form>

                            <hr class="my-4">

                            <h4>Enable per Form</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Form Name</th>
                                        <th>Enabled</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($forms as $form)
                                        <tr>
                                            <td>{{ $form->form_name }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input toggle-form"
                                                        data-id="{{ $form->id }}" {{ $form->enabled ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.querySelectorAll('.toggle-form').forEach(toggle => {
            toggle.addEventListener('change', function() {
                fetch(`/dashboard/recaptcha/forms/toggle/${this.dataset.id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(res => res.json()).then(data => {
                    if (data.status !== 'ok') alert('Error toggling!');
                });
            });
        });
    </script>
@endpush

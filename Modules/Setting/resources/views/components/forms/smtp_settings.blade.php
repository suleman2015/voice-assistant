<!-- SMTP Settings Form -->
<div class="col-md-8">
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="card-title mb-0">SMTP Settings</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('setting.update') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Mail Mailer</label>
                        <input type="text" class="form-control" name="mail_mailer" value="{{ setting('mail_mailer') ?? 'smtp' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mail Host</label>
                        <input type="text" class="form-control" name="mail_host" value="{{ setting('mail_host') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Mail Port</label>
                        <input type="text" class="form-control" name="mail_port" value="{{ setting('mail_port') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mail Encryption</label>
                        <select class="form-select" name="mail_encryption">
                            <option value="">None</option>
                            <option value="ssl" {{ setting('mail_encryption') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="tls" {{ setting('mail_encryption') == 'tls' ? 'selected' : '' }}>TLS</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Mail Username</label>
                        <input type="text" class="form-control" name="mail_username" value="{{ setting('mail_username') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mail Password</label>
                        <input type="password" class="form-control" name="mail_password" value="{{ setting('mail_password') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mail From Address</label>
                    <input type="email" class="form-control" name="mail_from_address" value="{{ setting('mail_from_address') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mail From Name</label>
                    <input type="text" class="form-control" name="mail_from_name" value="{{ setting('mail_from_name') }}">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-light me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Save SMTP Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .avatar-upload {
            position: relative;
            max-width: 100%;
        }

        .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }

        .avatar-edit input {
            display: none;
        }

        .avatar-edit label {
            display: inline-block;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            text-align: center;
            line-height: 24px;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .avatar-edit label:hover {
            background: #f1f1f1;
        }

        .avatar-preview {
            height: 100px;
            border-radius: 2%;
            border: 1px dashed #d2d3d8;
            position: relative;
        }

        .avatar-preview>div {
            height: 100%;
            border-radius: 2%;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
@endpush

<div class="avatar-upload">
    <div class="avatar-edit">
        <input type="file" name="{{ $name }}" id="{{ $name . $ref }}_upload" accept="image/*" />
        <label for="{{ $name . $ref }}_upload" id="{{ $name . $ref }}_icon">
            <i class="mdi mdi-upload"></i>
        </label>
    </div>
    <div class="avatar-preview">
        <div id="{{ $name . $ref }}"
            style="background-image: url('{{ asset(isset($old) ? 'assets/' . $old : 'assets/general/images/placeholder-image.jpg') }}');">
        </div>
    </div>
</div>
{{-- <input type="hidden" name="{{ $name }}" id="{{ $name . $ref }}_hidden"> --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('{{ $name . $ref }}_upload');
            const preview = document.getElementById('{{ $name . $ref }}');
            const iconLabel = document.getElementById('{{ $name . $ref }}_icon');
            const hiddenInput = document.getElementById('{{ $name . $ref }}_hidden');

            let uploadedImage = null;

            function resetUpload() {
                input.value = '';
                preview.style.backgroundImage = "url('{{ asset($old ?? 'images/placeholder-image.jpg') }}')";
                iconLabel.innerHTML = '<i class="mdi mdi-upload"></i>';
                hiddenInput.value = '';
                uploadedImage = null;
            }

            iconLabel.addEventListener('click', function(e) {
                if (uploadedImage) {
                    e.preventDefault();
                    resetUpload();
                }
            });

            input.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.backgroundImage = `url('${e.target.result}')`;
                    iconLabel.innerHTML = '<i class="mdi mdi-delete"></i>';
                    // hiddenInput.value = file.name; // or base64 if you want to send encoded image
                    uploadedImage = file;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush

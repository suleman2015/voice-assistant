@extends('admin.layouts.app')

@section('content')
<div class="container py-4">

<div style="margin-top: 80px;">
    {{-- @include('components.media-file-selector') --}}
    <!-- Trigger Button -->
<div id="media-trigger" class="" style="cursor:pointer;" onclick="openMediaModal()">
    <div class="dropzone-placeholder text-center py-4 border rounded">
    <p class="outlined-text">Click to upload</p>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select or Upload an Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- Dropzone uploader --}}
                <div id="dropzone-wrapper">
                    <form action="{{ route('media.upload') }}" class="dropzone" id="file-dropzone">
                        @csrf
                        <div class="dz-message needsclick">
                            <strong>Drop files here or click to upload</strong><br>
                            <span class="text-muted">(Allowed: Images, PDF, Docs, MP4)</span>
                        </div>
                    </form>
                </div>

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div>
                    <button type="button" id="backButton" class="btn btn-sm btn-outline-secondary me-2 d-none" onclick="goBackFolder()">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                        <strong>Current Path:</strong> <span id="current-folder-path">/uploads/files</span>
                    </div>
                    <div class="input-group w-50">
                        <input type="text" class="form-control" id="folderNameInput" placeholder="Enter folder name">
                        <button class="btn btn-outline-secondary" id="createFolderBtn" type="button">Create Folder</button>
                    </div>
                </div>

                {{-- Uploaded Files --}}
                <div class="row mt-4" id="uploaded-files">
                    {{-- Folders --}}
                    @foreach ($folders as $folder)
                        <div class="col-3 mb-3 position-relative">
                            <div class="media-folder" data-folder="{{ $folder['path'] }}" title="Double-click to open">
                                <div class="text-center p-3 border rounded bg-light">
                                    <i class="bi bi-folder-fill fs-1 text-warning"></i>
                                    <p class="mb-0 small text-break">{{ $folder['name'] }}</p>
                                </div>
                            </div>
                            <button type="button" class="delete-folder-btn btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                    data-folder="{{ $folder['path'] }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    @endforeach

                    {{-- Files --}}
                    @foreach ($files as $file)
                        <div class="col-3 mb-3">
                            <div class="media-thumb" data-url="{{ $file['url'] }}">
                                <img src="{{ $file['url'] }}" class="img-fluid rounded">
                                <button type="button" class="delete-file-btn delete-file" data-name="{{ $file['name'] }}">×</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <ul id="media-context-menu" class="dropdown-menu" style="display:none; position:absolute; z-index:1055;">
                    <li><a class="dropdown-item preview-file" href="#">Preview</a></li>
                    <li><a class="dropdown-item rename-file" href="#">Rename</a></li>
                    <li><a class="dropdown-item crop-file" href="#">Crop</a></li>
                    <li><a class="dropdown-item download-file" href="#">Download</a></li>
                    <li><a class="dropdown-item copy-link" href="#">Copy Link</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger delete-file" href="#">Delete</a></li>
                </ul>

                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary" id="selectImageButton">Select Image</button> --}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- crop modal --}}
<div class="modal fade" id="cropModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body text-center">
          <img id="crop-image" src="" style="max-width:100%;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="saveCrop">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>

<style>
    .media-folder {
        cursor: pointer;
        height: 180px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 2px solid transparent;
        background: #f8f8f8;
        border-radius: 8px;
    }

    .media-folder.selected {
        border-color: #007bff;
    }

    .media-folder i {
        font-size: 2.5rem;
        margin-bottom: 8px;
    }
    .outlined-text {
        display: inline-block;
        padding: 8px 16px;
        border: 2px solid #000; /* Change color as needed */
        border-radius: 4px;
        font-weight: 500;
    }

    .media-thumb {
        position: relative;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 8px;
        height: 180px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f1f1;
    }
    .media-thumb img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .media-thumb.selected {
        border-color: #007bff;
    }
    .delete-file-btn {
        position: absolute;
        top: 4px;
        right: 6px;
        background: rgba(255, 0, 0, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        padding: 0 6px;
        cursor: pointer;
    }
    #file-dropzone {
    border: 2px dashed #ccc;
    padding: 30px;
    background: #f9f9f9;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 20px;
    display: block; /* was none */
    }
    .media-folder.selected {
        outline: 2px solid #007bff;
        border-radius: 8px;
    }

</style>
@endpush
</div>
</div>
@endsection


@push('scripts')
<!-- DROPZONE SCRIPT (LOAD FIRST) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    Dropzone.autoDiscover = false;
    let selectedFileUrl = null;
    let selectedFolder = @json($currentFolder ?? '');

    $(document).ready(function () {
        let selectedInputId = 'imageInput';
        let selectedPreviewId = 'imagePreview';

        window.openMediaModal = function (inputId = 'imageInput', previewId = 'imagePreview') {
            selectedInputId = inputId;
            selectedPreviewId = previewId;

            const modal = new bootstrap.Modal(document.getElementById('mediaModal'));
            modal.show();
            loadUploadedFiles();
        };

        let myDropzone = null;


        $('#createFolderBtn').on('click', function () {
            const folderName = $('#folderNameInput').val().trim();
            if (!folderName) return alert('Folder name is required');

            fetch("{{ route('media.create-folder') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name: folderName, base: selectedFolder })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadUploadedFiles();
                    alertify.success('Folder created successfully');
                } else {
                    alert(data.message || 'Error creating folder');
                }
            });
        });

        window.navigateToFolder = function (folderPath) {
            selectedFolder = folderPath;
            loadUploadedFiles();
        };
        window.goBackFolder = function () {
            if (!selectedFolder) return;
            const parts = selectedFolder.split('/');
            parts.pop(); // remove current folder
            selectedFolder = parts.join('/');
            loadUploadedFiles();
        };
        function reInitDropzoneWithRetry(attempt = 1) {
            const dropzoneEl = document.querySelector("#file-dropzone");

            if (!dropzoneEl) {
                if (attempt < 10) {
                    // Try again after 100ms (max 10 tries = 1s)
                    setTimeout(() => reInitDropzoneWithRetry(attempt + 1), 100);
                } else {
                    console.warn("Dropzone element still not found after retries.");
                }
                return;
            }

            if (Dropzone.instances.length > 0) {
                Dropzone.instances.forEach(z => z.destroy());
            }

            try {
                new Dropzone(dropzoneEl, {
                    url: "{{ route('media.upload') }}",
                    paramName: "file",
                    maxFilesize: 10,
                    acceptedFiles: "image/*,application/pdf,.doc,.docx,.xls,.xlsx,.mp4",
                    autoProcessQueue: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    sending: function (file, xhr, formData) {
                        formData.append("folder", selectedFolder);
                    },
                    success: function () {
                        loadUploadedFiles(); // refresh after upload
                    }
                });
            } catch (err) {
                console.error("Dropzone init failed:", err);
            }
        }
        function loadUploadedFiles() {
            fetch(`{{ route('media.index') }}?folder=${encodeURIComponent(selectedFolder)}`)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newDropzone = doc.querySelector('#file-dropzone');
                    if (newDropzone) {
                    document.querySelector('#file-dropzone')?.remove();
                        $('#dropzone-wrapper').append(newDropzone);
                        setTimeout(() => {
                            if (Dropzone.instances.length > 0) {
                                Dropzone.instances.forEach(z => z.destroy());
                            }

                            try {
                                new Dropzone("#file-dropzone", {
                                    url: "{{ route('media.upload') }}",
                                    paramName: "file",
                                    maxFilesize: 10,
                                    acceptedFiles: "image/*,application/pdf,.doc,.docx,.xls,.xlsx,.mp4",
                                    autoProcessQueue: true,
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    sending: function (file, xhr, formData) {
                                        formData.append("folder", selectedFolder);
                                    },
                                    success: function () {
                                        loadUploadedFiles(); // reload UI
                                    }
                                });
                            } catch (err) {
                                console.error("Dropzone init failed:", err);
                            }
                        }, 100); 
                    }

                    const uploadedFiles = doc.querySelector('#uploaded-files');
                    if (!uploadedFiles) return console.error('Missing #uploaded-files in response.');
                    $('#uploaded-files').html(uploadedFiles.innerHTML);
                    bindUIEvents(); 
                    const lastSegment = selectedFolder ? selectedFolder.split('/').pop() : '';
                    $('#current-folder-path').text('/uploads/files' + (lastSegment ? '/' + lastSegment : ''));
                    if (selectedFolder) {
                        $('#backButton').removeClass('d-none');
                    } else {
                        $('#backButton').addClass('d-none');
                    }
                })
                .catch(error => console.error('loadUploadedFiles() failed:', error));
        }

        function bindUIEvents() {
            $(document).off('click', '.media-folder').on('click', '.media-folder', function () {
                $('.media-folder').removeClass('selected');
                $(this).addClass('selected');
                selectedFolder = $(this).data('folder');
                $('#current-folder-path').text('/uploads/files/' + selectedFolder.split('/').pop());
                if (selectedFolder) {
                    $('#backButton').removeClass('d-none');
                } else {
                    $('#backButton').addClass('d-none');
                }
            });

            $(document).off('dblclick', '.media-folder').on('dblclick', '.media-folder', function () {
                selectedFolder = $(this).data('folder');
                loadUploadedFiles();
            });

            $(document).off('click', '.media-thumb').on('click', '.media-thumb', function () {
                $('.media-thumb').removeClass('selected');
                $(this).addClass('selected');
                selectedFileUrl = $(this).data('url');
            });

            $(document).off('click', '.delete-file-btn').on('click', '.delete-file-btn', function (e) {
                e.stopPropagation();
                const filename = $(this).data('name');

                fetch("{{ route('media.delete') }}", {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ filename, folder: selectedFolder })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        loadUploadedFiles();
                    } else {
                        alertify.error('Failed to delete file.');
                    }
                });
            });
        }


        loadUploadedFiles();

        $(document).off('click', '.delete-folder-btn').on('click', '.delete-folder-btn', function (e) {
            e.stopPropagation();
            const folder = $(this).data('folder');

            alertify.confirm(
                'Delete Folder',
                `Are you sure you want to delete the folder <strong>${folder}</strong> and all its contents?`,
                function () {
                    fetch("{{ route('media.delete-folder') }}", {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ folder })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            loadUploadedFiles();
                            alertify.success('🗂️ Folder deleted successfully');
                        } else {
                            alertify.error(data.message || '❌ Failed to delete folder.');
                        }
                    });
                },
                function () {
                    alertify.message('Deletion cancelled');
                }
            ).set('labels', { ok: 'Delete', cancel: 'Cancel' }).set('closable', false);
        });
      


        // functions
        let rightClickedFile = null;

        $(document).on("contextmenu", ".media-thumb img", function(e) {
                e.preventDefault();

                rightClickedFile = {
                    url: $(this).attr("src"),
                    name: $(this).closest(".media-thumb").find(".delete-file-btn").data("name"),
                    folder: selectedFolder
                };

                // Get modal container
                const modalBody = $("#mediaModal .modal-body");
                const offset = modalBody.offset();

                // Cursor position relative to modal body
                const x = e.pageX - offset.left;
                const y = e.pageY - offset.top;

                // Place menu inside modal body
                $("#media-context-menu")
                    .css({
                        top: y + "px",
                        left: x + "px",
                        position: "absolute"
                    })
                    .appendTo(modalBody) // ensure it's inside the modal
                    .show();
            });

            // Hide menu when clicking elsewhere
            $(document).click(function() {
                $("#media-context-menu").hide();
            });

            $(document).on("click", ".preview-file", function() {
                if (rightClickedFile && rightClickedFile.url) {
                    window.open(rightClickedFile.url, "_blank");
                }
            });

        // Rename
        $(document).on("click", ".rename-file", function() {
            let newName = prompt("Enter new name:", rightClickedFile.name);
            if (!newName) return;

            fetch("{{ route('media.rename') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" },
                body: JSON.stringify({
                    folder: rightClickedFile.folder,
                    old_name: rightClickedFile.name,
                    new_name: newName
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) loadUploadedFiles();
                else alert(data.message);
            });
        });

        // Delete
        $(document).on("click", ".delete-file", function() {
            fetch("{{ route('media.delete') }}", {
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" },
                body: JSON.stringify({
                    folder: rightClickedFile.folder,
                    filename: rightClickedFile.name
                })
            }).then(() => loadUploadedFiles());
        });

        // Copy Link
        $(document).on("click", ".copy-link", function() {
            navigator.clipboard.writeText(rightClickedFile.url);
            alert("Link copied!");
        });

        // Download
        $(document).on("click", ".download-file", function() {
            let a = document.createElement("a");
            a.href = rightClickedFile.url;
            a.download = rightClickedFile.name;
            a.click();
        });

        // Crop (open crop modal)
        $(document).on("click", ".crop-file", function() {
            $("#cropModal img").attr("src", rightClickedFile.url);
            $("#cropModal").modal("show");
        });

        //cropper js
        let cropper;
        $("#cropModal").on("shown.bs.modal", function() {
            cropper = new Cropper(document.getElementById("crop-image"), {
                aspectRatio: NaN,
                viewMode: 1
            });
        }).on("hidden.bs.modal", function() {
            cropper.destroy();
            cropper = null;
        });

        // Save cropped
        $("#saveCrop").click(function() {
            let canvas = cropper.getCroppedCanvas();
            canvas.toBlob(function(blob) {
                let formData = new FormData();
                formData.append("file", blob, rightClickedFile.name);
                formData.append("folder", rightClickedFile.folder);

                fetch("{{ route('media.crop') }}", {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        $("#cropModal").modal("hide");

                        // 🔥 Bust cache with timestamp
                        let timestamp = new Date().getTime();
                        let newUrl = rightClickedFile.url.split("?")[0] + "?t=" + timestamp;

                        // Update clicked thumbnail immediately
                        let thumb = $(`.media-thumb img[src^="${rightClickedFile.url.split("?")[0]}"]`);
                        thumb.attr("src", newUrl);

                        // Update reference so context menu works again
                        rightClickedFile.url = newUrl;

                        alertify.success('Image cropped successfully!');
                    }
                });
            });
        });

    });
</script>


@endpush
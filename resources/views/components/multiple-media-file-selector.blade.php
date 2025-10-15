<!-- Trigger Button -->
<div id="multiple-media-trigger" class="" style="cursor:pointer;" onclick="openMultipleMediaModal()">
    <div class="dropzone-placeholder text-center py-4 border rounded">
        <p class="outlined-text">Click to upload</p>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="multiMediaModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select or Upload Multiple Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- Dropzone uploader --}}
                {{-- <div id="dropzone-wrapper">
                    <form action="{{ route('media.upload') }}" class="dropzone" id="file-dropzone">
                        @csrf
                        <div class="dz-message needsclick">
                            <strong>Drop files here or click to upload</strong><br>
                            <span class="text-muted">(Allowed: Images, PDF, Docs, MP4)</span>
                        </div>
                    </form>
                </div> --}}

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" id="backButton" class="btn btn-sm btn-outline-secondary me-2 d-none"
                            onclick="goBackFolder()">
                            <i class="bi bi-arrow-left"></i> Back
                        </button>
                        <strong>Current Path:</strong> <span id="current-folder-path">/uploads/files</span>
                    </div>
                    <div class="input-group w-50">
                        <input type="text" class="form-control" id="folderNameInput" placeholder="Enter folder name">
                        <button class="btn btn-outline-secondary" id="createFolderBtn" type="button">Create
                            Folder</button>
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
                            <button type="button"
                                class="delete-folder-btn btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
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
                                <button type="button" class="delete-file-btn delete-file"
                                    data-name="{{ $file['name'] }}">×</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="selectImagesButton">Add Image</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" /> --}}
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
            border: 2px solid #000;
            /* Change color as needed */
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
            display: block;
            /* was none */
        }

        .media-folder.selected {
            outline: 2px solid #007bff;
            border-radius: 8px;
        }
    </style>
@endpush

@push('scripts')
    <!-- DROPZONE SCRIPT (LOAD FIRST) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

    <script>
        (function () {
            Dropzone.autoDiscover = false;

            let multi_selectedFileUrls = [];
            let multi_multiSelectMode = true;
            let multi_selectedFolder = '';

            setTimeout(function () {
                const mediaTrigger = document.getElementById('multiple-media-trigger');
                if (mediaTrigger) {
                    mediaTrigger.classList.add('d-none');
                    console.log('media_multiple initialized');
                }
            }, 1000);

            $(document).ready(function () {
                let selectedInputId = 'imageInput';
                let selectedPreviewId = 'imagesPreview';

                window.openMultipleMediaModal = function (inputId = 'imageInput', previewId = 'imagesPreview', allowMultiple = false) {
                    selectedInputId = inputId;
                    selectedPreviewId = previewId;
                    multi_multiSelectMode = allowMultiple;
                    multi_selectedFileUrls = [];

                    try {
                        const inputValue = document.getElementById(selectedInputId)?.value;
                        if (inputValue) {
                            if (allowMultiple) {
                                const parsed = JSON.parse(inputValue);
                                multi_selectedFileUrls = Array.isArray(parsed)? parsed.map(p => new URL("{{ url('/') }}" + (p.startsWith('/') ? p : '/' + p)).href) : [];
                            } else {
                                multi_selectedFileUrls = [new URL("{{ url('/') }}" + inputValue).href];
                            }
                        }
                    } catch (e) {
                        multi_selectedFileUrls = [];
                    }

                    $('.media-thumb').removeClass('selected');
                    const modal = new bootstrap.Modal(document.getElementById('multiMediaModal'));
                    modal.show();
                    loadUploadedFiles();
                };

                $('#createFolderBtn').on('click', function () {
                    const folderName = $('#folderNameInput').val().trim();
                    if (!folderName) return alert('Folder name is required');

                    fetch("{{ route('media.create-folder') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ name: folderName, base: multi_selectedFolder })
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

                window.goBackFolder = function () {
                    if (!multi_selectedFolder) return;
                    const parts = multi_selectedFolder.split('/');
                    parts.pop();
                    multi_selectedFolder = parts.join('/');
                    loadUploadedFiles();
                };

                function loadUploadedFiles() {
                    fetch(`{{ route('media.index') }}?folder=${encodeURIComponent(multi_selectedFolder)}`)
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const uploadedFiles = doc.querySelector('#uploaded-files');
                            if (!uploadedFiles) return console.error('Missing #uploaded-files in response.');

                            $('#uploaded-files').html(uploadedFiles.innerHTML);
                            bindUIEvents();

                            const lastSegment = multi_selectedFolder ? multi_selectedFolder.split('/').pop() : '';
                            $('#current-folder-path').text('/uploads/files' + (lastSegment ? '/' + lastSegment : ''));
                            $('#backButton').toggleClass('d-none', !multi_selectedFolder);
                        })
                        .catch(error => console.error('loadUploadedFiles() failed:', error));
                }

                function bindUIEvents() {
                    $(document).off('click', '.media-thumb').on('click', '.media-thumb', function () {
                        const url = $(this).data('url');

                        if (multi_multiSelectMode) {
                            $(this).toggleClass('selected');
                            const index = multi_selectedFileUrls.indexOf(url);
                            if (index > -1) {
                                multi_selectedFileUrls.splice(index, 1);
                            } else {
                                multi_selectedFileUrls.push(url);
                            }
                        } else {
                            $('.media-thumb').removeClass('selected');
                            $(this).addClass('selected');
                            multi_selectedFileUrls = [url];
                        }
                    });

                    setTimeout(() => {
                        multi_selectedFileUrls.forEach(url => {
                            $(`.media-thumb[data-url="${url}"]`).addClass('selected');
                        });
                    }, 200);
                }

                $('#selectImagesButton').on('click', function (e) {
                    e.preventDefault();

                    const previewContainer = $('#' + selectedPreviewId);
                    const inputField = $('#' + selectedInputId);

                    if (multi_multiSelectMode) {
                        if (multi_selectedFileUrls.length === 0) {
                            alert('Please select at least one image.');
                            return;
                        }

                        const relativeUrls = multi_selectedFileUrls.map(full => new URL(full).pathname);
                        inputField.val(JSON.stringify(relativeUrls));
                        previewContainer.empty();

                        relativeUrls.forEach(url => {
                            const full = "{{ url('/') }}" + url;
                            previewContainer.append(`
                                <div class="position-relative me-2 mb-2">
                                    <img src="${full}" style="width: 100px; height: 100px; object-fit: cover;" class="img-thumbnail" />
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image-btn"
                                        onclick="removeImageFromField('${selectedInputId}', '${selectedPreviewId}', '${url}')">×</button>
                                </div>
                            `);
                        });

                    } else {
                        if (multi_selectedFileUrls.length === 0) {
                            alert('Please select an image.');
                            return;
                        }

                        const fullUrl = multi_selectedFileUrls[0];
                        const relative = new URL(fullUrl).pathname;
                        inputField.val(relative);
                        previewContainer.html(`
                            <div class="position-relative me-2 mb-2">
                                <img src="{{ url('/') }}${relative}" style="width: 100px; height: 100px; object-fit: cover;" class="img-thumbnail" />
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image-btn"
                                    onclick="removeImageFromField('${selectedInputId}', '${selectedPreviewId}', '${relative}')">×</button>
                            </div>
                        `);
                    }

                    bootstrap.Modal.getInstance(document.getElementById('multiMediaModal')).hide();
                });

                window.removeImageFromField = function (inputId, previewId, removeUrl) {
                    const input = document.getElementById(inputId);
                    const preview = document.getElementById(previewId);
                    try {
                        let images = JSON.parse(input.value);
                        images = images.filter(img => img !== removeUrl);
                        input.value = JSON.stringify(images);

                        // Also remove the corresponding preview element
                        const buttons = preview.querySelectorAll(`button[onclick*="${removeUrl}"]`);
                        buttons.forEach(btn => btn.closest('div.position-relative').remove());
                    } catch (e) {
                        console.error("Failed to remove image:", e);
                    }
                };

            });
        })();
    </script>
@endpush

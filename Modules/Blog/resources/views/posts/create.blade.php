@extends('admin.layouts.app')

@section('title', 'Add Post')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18 fw-bold">Posts Management</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Posts</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="card-title mb-0">Create Post</h4>
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" form="post-create-form" class="btn btn-sm btn-primary">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                            <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                        <form id="post-create-form" action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                            @include('blog::posts._form', [
                                'post' => null,
                                'categories' => $categories ?? '',
                                'tags' => $tags ?? ''
                            ])
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

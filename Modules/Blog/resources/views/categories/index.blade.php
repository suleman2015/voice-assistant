@extends('admin.layouts.app')

@section('title', 'Categories')

@push('styles')
    <style>
        .category-tree .list-group-item {
            background: transparent !important;
            border: none !important;
            padding: 4px 8px;
        }

        .category-tree .list-group-item a {
            text-decoration: none;
            font-size: 14px;
        }

        .category-tree .list-group-item .btn {
            border-radius: 6px;
        }
    </style>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18 fw-bold">Categories Management</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Categories</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Layout -->
            <div class="row">
                <div class="col-md-4">
                    @include('blog::categories._sidebar', ['categories' => $categories])
                </div>
                <div class="col-md-8">
                    @include('blog::categories._form', [
                        'categories' => $categories,
                        'category' => $editCategory ?? null,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
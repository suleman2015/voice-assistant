@extends('admin.layouts.app')
@section('title')
    {{ __('Manage Component') }}
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="py-4">
                <div class="d-flex justify-content-between w-100 flex-wrap">
                    <div class="mb-3 mb-lg-0">
                        <h1 class="h4">{{ __('Manage Component') }}</h1>
                    </div>
                    <div class="btn-toolbar  mb-md-0 mb-2 mb-md-0">
                        <a href="{{ route('pages.index') }}" class="btn btn-sm btn-primary d-inline-flex align-items-center">
                            <i class="fas fa-arrow-left me-2"></i>
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card card-body border-0 shadow mb-4">
                        <form method="POST" action="{{ route('pages.update', $page->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="d-flex justify-content-between flex-wrap w-100 mb-3">
                                <div class="mb-2 mb-lg-0">
                                    <h2 class="h5 mb-2">{{ __('Update Page') }}</h2>
                                </div>
                                <div class="d-flex flex-column flex-sm-row flex-wrap align-items-start">
                                    <div class="form-check form-switch mb-2 ms-sm-3">
                                        <label class="form-check-label"
                                            for="flexSwitchCheckDefault">{{ __('Page Status') }}</label>
                                        <input class="form-check-input" type="checkbox" value="1" name="is_active"
                                            @checked($page->is_active) id="flexSwitchCheckDefault">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 mb-3">
                                  <x-name-field name="title" label="Title" :value="old('title', $page->title ?? '')" :required="true" data-generate-slug="#slug" />
        
                                </div>
                                <div class="col-md-6 mb-3">
                                  <x-slug-field name="slug" :value="old('slug', $page->slug ?? '')" :model="$page ?? null" :id="$page->id ?? null" :required="true" />
                                </div>
                                <x-editor-field label="Content" name="content" :value="old('content', $page->content ?? '')" />
                                <x-seo-meta :model="$page ?? null" />
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary mt-2" type="submit">{{ __('Update Page') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    @include('pagebuilder::partial._page_script');
@endpush

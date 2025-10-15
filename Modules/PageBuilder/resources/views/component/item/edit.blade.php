@extends('admin.layouts.app')
@section('title')
	{{ __('Update Item') }}
@endsection
@section('content')
	<div class="py-4">
		<div class="d-flex justify-content-between w-100 flex-wrap">
			<div class="mb-3 mb-lg-0">
				<h1 class="h4">{{ __('Update Item') }}</h1>
			</div>
			<div class="btn-toolbar  mb-md-0 mb-2 ">
				<a href="{{ route('components.edit', $componentId) }}" class="btn btn-sm btn-primary d-inline-flex align-items-center">
					<i class="fas fa-arrow-left me-2"></i>
					{{ __('Back') }}
				</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-xl-12">
			<div class="card card-body border-0 shadow mb-4">
				<h2 class="h5 mb-4">{{ __('Update Item') }}</h2>
				
				@include('pagebuilder::component.partial._edit_item',['id' => $id,'modifiedData' => $modifiedData,'languages' => $languages,'componentId' => $componentId])
				
			</div>
		</div>
	</div>
@endsection
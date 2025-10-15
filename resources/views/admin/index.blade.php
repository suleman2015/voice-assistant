@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            @include('admin.components._breadcrumb')
            @include('admin.components._dashboard_summary')
            @include('admin.components._recent_activity')
        </div>
        @include('admin.components._footer')
    </div>
@endsection

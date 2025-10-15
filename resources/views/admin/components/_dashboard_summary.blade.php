@php
    $totalUsers = Modules\Users\Models\User::count();
    $totalPosts = Modules\Blog\Models\Post::count();
    $totalCases = Modules\Cases\Models\UserCase::count();
    $totalEvents = Modules\Events\Models\Event::count();
@endphp
<div class="row">
    <!-- Users Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Number of Users</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{ $totalUsers }}">0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Posts Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Number of Blog Posts</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{ $totalPosts }}">0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cases Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Number of Cases</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{ $totalCases }}">0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate">Number of Events</span>
                        <h4 class="mb-3">
                            <span class="counter-value" data-target="{{ $totalEvents }}">0</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

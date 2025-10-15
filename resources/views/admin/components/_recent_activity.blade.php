@php
    use Spatie\Activitylog\Models\Activity;
    use Carbon\Carbon;

    // -----------------------------------------
    // ACTIVITY LOG QUERIES
    // -----------------------------------------
    $allActivities = Activity::latest()->take(200)->get(); // keep a healthy buffer; JS paginates
    $thisMonth = Activity::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->latest()
        ->get();
    $lastMonth = Activity::whereMonth('created_at', Carbon::now()->subMonth()->month)
        ->whereYear('created_at', Carbon::now()->subMonth()->year)
        ->latest()
        ->get();

    // -----------------------------------------
    // HELPERS FOR ACTIVITY CHANGES
    // -----------------------------------------
    function stringifyValue($val) {
        if (is_array($val) || is_object($val)) {
            return json_encode($val, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        return $val ?? 'null';
    }

    function formatChanges($activity) {
        $changes = [];
        // Spatie casts "properties" to an Arr/Collection; guard for string JSON as well
        $props = $activity->properties;
        if (is_string($props)) {
            $decoded = json_decode($props, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $props = collect($decoded);
            }
        }

        if ($props && method_exists($props, 'has') && $props->has('attributes')) {
            $new = $props['attributes'] ?? [];
            $old = $props['old'] ?? [];
            foreach ($new as $field => $value) {
                $oldVal = $old[$field] ?? null;
                if ($oldVal !== $value) {
                    $changes[] = $field . ': ' . stringifyValue($oldVal) . ' → ' . stringifyValue($value);
                }
            }
        }
        return $changes;
    }
@endphp

<div class="row">
    {{-- =======================
         RECENT ACTIVITY (LEFT)
         ======================= --}}
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h6 class="card-title mb-0 flex-grow-1">Recent Activity</h6>
                <div class="flex-shrink-0">
                    <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#all-activity" role="tab">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#this-month" role="tab">This Month</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#last-month" role="tab">Last Month</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body px-0">
                <div class="tab-content">

                    {{-- All Activity --}}
                    <div class="tab-pane active" id="all-activity" role="tabpanel">
                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                            <table class="table align-middle table-nowrap table-borderless">
                                <tbody id="activity-all-body">
                                    @forelse($allActivities as $activity)
                                        <tr>
                                            <td style="width: 50px;">
                                                <div class="font-size-22 text-primary">
                                                    <i class="bx bx-news d-block"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <h5 class="font-size-14 mb-1">
                                                        {{ ucfirst($activity->description) }}
                                                        on <strong>{{ class_basename($activity->subject_type) }}</strong>
                                                        #{{ $activity->subject_id }}
                                                    </h5>
                                                    <small class="text-muted">
                                                        by {{ $activity->causer?->name ?? 'System' }}
                                                        • {{ $activity->created_at->diffForHumans() }}
                                                    </small>

                                                    @php $changes = formatChanges($activity); @endphp
                                                    @if (count($changes))
                                                        <ul class="mt-1 text-muted small ps-3">
                                                            @foreach ($changes as $change)
                                                                <li>{{ $change }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr data-empty="1">
                                            <td colspan="2" class="text-center text-muted">No activity found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div id="activity-all-pager" class="px-3 pb-3"></div>
                    </div>

                    {{-- This Month --}}
                    <div class="tab-pane" id="this-month" role="tabpanel">
                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                            <table class="table align-middle table-nowrap table-borderless">
                                <tbody id="activity-this-body">
                                    @forelse($thisMonth as $activity)
                                        <tr>
                                            <td style="width: 50px;">
                                                <div class="font-size-22 text-success">
                                                    <i class="bx bx-check-circle d-block"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <h5 class="font-size-14 mb-1">
                                                        {{ ucfirst($activity->description) }}
                                                        on <strong>{{ class_basename($activity->subject_type) }}</strong>
                                                        #{{ $activity->subject_id }}
                                                    </h5>
                                                    <small class="text-muted">
                                                        by {{ $activity->causer?->name ?? 'System' }}
                                                        • {{ $activity->created_at->diffForHumans() }}
                                                    </small>

                                                    @php $changes = formatChanges($activity); @endphp
                                                    @if (count($changes))
                                                        <ul class="mt-1 text-muted small ps-3">
                                                            @foreach ($changes as $change)
                                                                <li>{{ $change }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr data-empty="1">
                                            <td colspan="2" class="text-center text-muted">No activity this month</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div id="activity-this-pager" class="px-3 pb-3"></div>
                    </div>

                    {{-- Last Month --}}
                    <div class="tab-pane" id="last-month" role="tabpanel">
                        <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
                            <table class="table align-middle table-nowrap table-borderless">
                                <tbody id="activity-last-body">
                                    @forelse($lastMonth as $activity)
                                        <tr>
                                            <td style="width: 50px;">
                                                <div class="font-size-22 text-warning">
                                                    <i class="bx bx-edit d-block"></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <h5 class="font-size-14 mb-1">
                                                        {{ ucfirst($activity->description) }}
                                                        on <strong>{{ class_basename($activity->subject_type) }}</strong>
                                                        #{{ $activity->subject_id }}
                                                    </h5>
                                                    <small class="text-muted">
                                                        by {{ $activity->causer?->name ?? 'System' }}
                                                        • {{ $activity->created_at->diffForHumans() }}
                                                    </small>

                                                    @php $changes = formatChanges($activity); @endphp
                                                    @if (count($changes))
                                                        <ul class="mt-1 text-muted small ps-3">
                                                            @foreach ($changes as $change)
                                                                <li>{{ $change }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr data-empty="1">
                                            <td colspan="2" class="text-center text-muted">No activity last month</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div id="activity-last-pager" class="px-3 pb-3"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- end col --}}
</div> {{-- end row --}}

{{-- =========================
     JS PAGINATION (vanilla)
     ========================= --}}
<script>
    (function () {
        // Config: items per page for each section
        const PAGE_SIZE = 6;

        function buildPager(container, totalPages, currentPage, onGo) {
            if (!container) return;
            container.innerHTML = '';
            if (totalPages <= 1) return;

            const nav = document.createElement('nav');
            const ul = document.createElement('ul');
            ul.className = 'pagination pagination-sm mb-0';

            function liBtn(label, page, disabled = false, active = false) {
                const li = document.createElement('li');
                li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = 'javascript:void(0)';
                a.textContent = label;
                if (!disabled && !active) {
                    a.addEventListener('click', () => onGo(page));
                }
                li.appendChild(a);
                return li;
            }

            // Prev
            ul.appendChild(liBtn('«', currentPage - 1, currentPage === 1));

            // Numbers (compact)
            const windowSize = 5;
            let start = Math.max(1, currentPage - Math.floor(windowSize / 2));
            let end = Math.min(totalPages, start + windowSize - 1);
            if (end - start + 1 < windowSize) {
                start = Math.max(1, end - windowSize + 1);
            }

            if (start > 1) ul.appendChild(liBtn('1', 1, false, currentPage === 1));
            if (start > 2) {
                const dots = document.createElement('li');
                dots.className = 'page-item disabled';
                dots.innerHTML = '<span class="page-link">…</span>';
                ul.appendChild(dots);
            }

            for (let i = start; i <= end; i++) {
                ul.appendChild(liBtn(String(i), i, false, currentPage === i));
            }

            if (end < totalPages - 1) {
                const dots = document.createElement('li');
                dots.className = 'page-item disabled';
                dots.innerHTML = '<span class="page-link">…</span>';
                ul.appendChild(dots);
            }
            if (end < totalPages) ul.appendChild(liBtn(String(totalPages), totalPages, false, currentPage === totalPages));

            // Next
            ul.appendChild(liBtn('»', currentPage + 1, currentPage === totalPages));

            nav.appendChild(ul);
            container.appendChild(nav);
        }

        function paginateTable(tbodyId, pagerId, perPage) {
            const tbody = document.getElementById(tbodyId);
            const pager = document.getElementById(pagerId);
            if (!tbody || !pager) return;

            const rows = Array.from(tbody.querySelectorAll('tr'));
            // If it's the empty state row only, skip pagination
            if (rows.length === 0 || (rows.length === 1 && rows[0].dataset.empty === '1')) {
                pager.innerHTML = '';
                return;
            }

            let currentPage = Number(tbody.dataset.currentPage || 1);
            const totalPages = Math.max(1, Math.ceil(rows.length / perPage));

            function render(page) {
                currentPage = Math.max(1, Math.min(page, totalPages));
                tbody.dataset.currentPage = String(currentPage);
                rows.forEach((row, idx) => {
                    const start = (currentPage - 1) * perPage;
                    const end = currentPage * perPage;
                    row.style.display = (idx >= start && idx < end) ? '' : 'none';
                });
                buildPager(pager, totalPages, currentPage, render);
            }

            render(currentPage);
        }

        // Initialize all paginations (first paint)
        function initAll() {
            paginateTable('activity-all-body', 'activity-all-pager', PAGE_SIZE);
            paginateTable('activity-this-body', 'activity-this-pager', PAGE_SIZE);
            paginateTable('activity-last-body', 'activity-last-pager', PAGE_SIZE);
        }

        // Re-init on tab change so hidden tabs render their first page correctly
        document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function (tabLink) {
            tabLink.addEventListener('shown.bs.tab', function (e) {
                const target = e.target.getAttribute('href'); // pane selector
                switch (target) {
                    case '#all-activity':
                        paginateTable('activity-all-body', 'activity-all-pager', PAGE_SIZE);
                        break;
                    case '#this-month':
                        paginateTable('activity-this-body', 'activity-this-pager', PAGE_SIZE);
                        break;
                    case '#last-month':
                        paginateTable('activity-last-body', 'activity-last-pager', PAGE_SIZE);
                        break;
                }
            });
        });

        document.addEventListener('DOMContentLoaded', initAll);
    })();
</script>

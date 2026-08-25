@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $metricCards = [
            ['label' => 'ADMISSION INQUIRY', 'value' => $stats['admission_inquiries'] ?? 14, 'meta' => 'TODAY : 0 WON : 6', 'icon' => 'fa-regular fa-clipboard', 'color' => 'text-red-500', 'style' => 'color:#ff1f3d', 'route' => 'admin.adm.enquiries.index'],
            ['label' => 'REGISTRATION', 'value' => $stats['registrations'] ?? 0, 'meta' => 'SELF : 0 ONLINE : 0', 'icon' => 'fa-regular fa-clipboard', 'color' => 'text-neutral-700', 'style' => 'color:#111827', 'route' => 'admin.adm.student-registrations.index'],
            ['label' => 'ADMISSION', 'value' => $stats['admissions'] ?? 0, 'meta' => 'TODAY : 0 LEAVING : 0', 'icon' => 'fa-regular fa-id-badge', 'color' => 'text-emerald-500', 'style' => 'color:#00a651', 'route' => 'admin.adm.students.index'],
            ['label' => 'STUDENTS', 'value' => $stats['students'] ?? 0, 'meta' => 'P : 0 A : 0 L : 0', 'icon' => 'fa-solid fa-user-graduate', 'color' => 'text-orange-500', 'style' => 'color:#ff7a00', 'route' => 'admin.adm.students.index'],
            ['label' => 'ADMIN STAFF', 'value' => $stats['admin_staff'] ?? 0, 'meta' => 'P : 0 A : 0 L : 0', 'icon' => 'fa-solid fa-users-gear', 'color' => 'text-pink-500', 'style' => 'color:#ff008c', 'route' => 'admin.hrms.staff.index'],
            ['label' => 'TEACHING STAFF', 'value' => $stats['teaching_staff'] ?? 1, 'meta' => 'P : 0 A : 0 L : 0', 'icon' => 'fa-solid fa-users', 'color' => 'text-slate-500', 'style' => 'color:#64748b', 'route' => 'admin.hrms.staff.index'],
            ['label' => 'ALLIED STAFF', 'value' => $stats['allied_staff'] ?? 0, 'meta' => 'P : 0 A : 0 L : 0', 'icon' => 'fa-solid fa-people-group', 'color' => 'text-lime-500', 'style' => 'color:#84cc16', 'route' => 'admin.hrms.staff.index'],
            ['label' => 'FAMILIES', 'value' => $stats['families'] ?? 0, 'meta' => '', 'icon' => 'fa-solid fa-people-roof', 'color' => 'text-sky-500', 'style' => 'color:#0ea5e9', 'route' => 'admin.adm.siblings.index'],
            ['label' => 'COMPLAIN', 'value' => $stats['complaints'] ?? 0, 'meta' => 'TODAY : 0', 'icon' => 'fa-regular fa-rectangle-list', 'color' => 'text-purple-600', 'style' => 'color:#7e22ce', 'route' => 'admin.adm.complaints.index'],
            ['label' => 'VISITORS', 'value' => $stats['visitors'] ?? 0, 'meta' => 'TODAY : 0', 'icon' => 'fa-regular fa-building', 'color' => 'text-amber-700', 'style' => 'color:#92400e'],
            ['label' => 'PURCHASE', 'value' => $stats['purchases'] ?? 0, 'meta' => 'TODAY : 0', 'icon' => 'fa-solid fa-cart-shopping', 'color' => 'text-orange-600', 'style' => 'color:#ff4b1f'],
            ['label' => 'SALES', 'value' => $stats['sales'] ?? 0, 'meta' => 'TODAY : 0', 'icon' => 'fa-solid fa-money-bill-trend-up', 'color' => 'text-green-600', 'style' => 'color:#00a000'],
        ];

        $progressPanels = [
            'Admission Enquiry For Jul 2026' => [
                ['label' => '1 ACTIVE', 'value' => '25%', 'width' => '25%', 'color' => 'bg-red-500', 'style' => 'background:#ef4444'],
                ['label' => '1 WON', 'value' => '25%', 'width' => '25%', 'color' => 'bg-amber-500', 'style' => 'background:#f59e0b'],
                ['label' => '2 PASSIVE', 'value' => '50%', 'width' => '50%', 'color' => 'bg-orange-400', 'style' => 'background:#fb923c'],
                ['label' => '0 LOST', 'value' => '0%', 'width' => '0%', 'color' => 'bg-neutral-400', 'style' => 'background:#a3a3a3'],
                ['label' => '0 DEAD', 'value' => '0%', 'width' => '0%', 'color' => 'bg-neutral-400', 'style' => 'background:#a3a3a3'],
            ],
            'Student Today Attendance' => [
                ['label' => 'PRESENT', 'value' => '', 'width' => '0%', 'color' => 'bg-green-500', 'style' => 'background:#22c55e'],
                ['label' => 'ABSENT', 'value' => '', 'width' => '0%', 'color' => 'bg-red-500', 'style' => 'background:#ef4444'],
                ['label' => 'LEAVE', 'value' => '', 'width' => '0%', 'color' => 'bg-blue-500', 'style' => 'background:#3b82f6'],
                ['label' => 'LATE', 'value' => '', 'width' => '0%', 'color' => 'bg-amber-500', 'style' => 'background:#f59e0b'],
                ['label' => 'HALF DAY', 'value' => '', 'width' => '0%', 'color' => 'bg-purple-500', 'style' => 'background:#a855f7'],
            ],
            'Staff Today Attendance' => [
                ['label' => 'PRESENT', 'value' => '', 'width' => '0%', 'color' => 'bg-green-500', 'style' => 'background:#22c55e'],
                ['label' => 'RED LEAVE', 'value' => '', 'width' => '0%', 'color' => 'bg-red-500', 'style' => 'background:#ef4444'],
                ['label' => 'BLUE LEAVE', 'value' => '', 'width' => '0%', 'color' => 'bg-blue-500', 'style' => 'background:#3b82f6'],
                ['label' => 'GREEN LEAVE', 'value' => '', 'width' => '0%', 'color' => 'bg-emerald-500', 'style' => 'background:#10b981'],
                ['label' => 'LATE', 'value' => '', 'width' => '0%', 'color' => 'bg-amber-500', 'style' => 'background:#f59e0b'],
                ['label' => 'HALF DAY', 'value' => '', 'width' => '0%', 'color' => 'bg-purple-500', 'style' => 'background:#a855f7'],
            ],
        ];
    @endphp

    <section id="dashboard-tab" class="admin-dashboard-section overflow-hidden rounded border border-neutral-300 bg-white shadow-sm">
        <div class="admin-dashboard-grid">
            <div class="admin-metric-grid">
                @foreach ($metricCards as $card)
                    @if (!empty($card['route']))<a href="{{ route($card['route'], absolute: false) }}" class="admin-metric-card" style="--metric-color: {{ preg_replace('/.*color:([^;]+).*/', '$1', $card['style']) }}">@else<article class="admin-metric-card" style="--metric-color: {{ preg_replace('/.*color:([^;]+).*/', '$1', $card['style']) }}">@endif
                        <div class="admin-metric-icon {{ $card['color'] }}" style="{{ $card['style'] }}">
                            <i class="{{ $card['icon'] }}"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="admin-card-title {{ $card['color'] }} text-sm font-medium" style="{{ $card['style'] }}">{{ $card['label'] }}</p>
                            <p class="admin-card-value text-sm font-bold text-blue-700">{{ $card['value'] }}</p>
                            @if ($card['meta'])
                                <p class="admin-card-meta {{ $card['color'] }} text-sm font-semibold" style="{{ $card['style'] }}">{{ $card['meta'] }}</p>
                            @endif
                        </div>
                    @if (!empty($card['route']))</a>@else</article>@endif
                @endforeach
            </div>

            <article class="admin-summary-card flex min-h-[248px] flex-col justify-end rounded-xl border border-neutral-300 bg-white p-3 shadow-sm">
                <div class="admin-stat-line mb-2 flex items-center justify-between border-b border-neutral-200 pb-2 text-sm text-emerald-600">
                    <span><i class="fa-solid fa-user"></i> Students</span>
                    <span class="rounded border border-emerald-500 px-1">{{ $stats['students'] ?? 0 }}</span>
                </div>
                <div class="admin-stat-line mb-2 flex items-center justify-between border-b border-neutral-200 pb-2 text-sm text-sky-500">
                    <span><i class="fa-solid fa-child"></i> Boys</span>
                    <span class="rounded border border-sky-500 px-1">0</span>
                </div>
                <div class="admin-stat-line flex items-center justify-between text-sm text-pink-600">
                    <span><i class="fa-solid fa-child-dress"></i> Girls</span>
                    <span class="rounded border border-pink-500 px-1">0</span>
                </div>
            </article>

            <article class="admin-summary-card admin-donut-card flex min-h-[248px] flex-col justify-center rounded-xl border border-neutral-300 bg-white p-3 shadow-sm">
                <div class="admin-donut"></div>
                <div class="admin-stat-line mb-2 flex items-center justify-between border-b border-neutral-200 pb-2 text-sm text-emerald-600">
                    <span><i class="fa-solid fa-user"></i> Staff</span>
                    <span class="rounded border border-emerald-500 px-1">{{ $stats['staff'] ?? 0 }}</span>
                </div>
                <div class="admin-stat-line mb-2 flex items-center justify-between border-b border-neutral-200 pb-2 text-sm text-sky-500">
                    <span><i class="fa-solid fa-mars"></i> Male</span>
                    <span class="rounded border border-sky-500 px-1">1</span>
                </div>
                <div class="admin-stat-line flex items-center justify-between text-sm text-pink-600">
                    <span><i class="fa-solid fa-venus"></i> Female</span>
                    <span class="rounded border border-pink-500 px-1">1</span>
                </div>
            </article>
        </div>

        <div class="admin-panels-row grid gap-3 px-3 pb-3 xl:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
            <div class="admin-three-panels grid gap-3 lg:grid-cols-3">
                @foreach ($progressPanels as $title => $rows)
                    <section class="admin-panel overflow-hidden rounded-xl bg-white shadow-lg">
                        <h2 class="admin-panel-title bg-[#2f61b3] px-2 py-1 text-sm font-semibold text-white">{{ $title }}</h2>
                        <div class="admin-progress-body space-y-4 p-3">
                            @foreach ($rows as $row)
                                <div class="admin-progress-row">
                                    <div class="admin-progress-label mb-3 flex items-center justify-between text-lg">
                                        <span>{{ $row['label'] }}</span>
                                        <span>{{ $row['value'] }}</span>
                                    </div>
                                    <div class="admin-progress-track h-1.5 bg-neutral-200">
                                        <div class="admin-progress-fill h-full {{ $row['color'] }}" style="width: {{ $row['width'] }}; {{ $row['style'] }}"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>

            <section class="admin-panel overflow-hidden rounded-xl bg-white shadow-lg">
                <div class="admin-panel-title flex items-center justify-between bg-[#2f61b3] px-2 py-1 text-sm font-semibold text-white">
                    <span>Complains For Jul 2026</span>
                    <span>Today : 0 / Total : 0 / Solved : 0</span>
                </div>
                <div class="min-h-[288px]"></div>
            </section>
        </div>

        <div class="admin-fees-row grid gap-4 px-3 pb-4 xl:grid-cols-[minmax(0,2fr)_minmax(360px,0.8fr)]">
            <section class="admin-panel overflow-hidden rounded-xl bg-white shadow-lg">
                <h2 class="admin-panel-title">Fees Collection Statistics For - {{ now()->format('M Y') }}</h2>
                <div class="px-4 pt-4 text-center text-sm">
                    RECEIVABLE: 0 / &nbsp;&nbsp; COLLECTION: 0 / &nbsp;&nbsp; WAIVE OFF: 0 / &nbsp;&nbsp; BALANCE: 0 / &nbsp;&nbsp; TODAY COLLECTION: 0
                </div>
                <div class="admin-chart-placeholder" aria-label="Fees collection chart"></div>
            </section>

            <section class="admin-panel overflow-hidden rounded-xl bg-white shadow-lg">
                <h2 class="admin-panel-title">Fee Overview</h2>
                <div class="admin-progress-body">
                    @foreach ([['1 PAID', '50%', '#0a9f62'], ['1 UN PAID', '50%', '#3d7db5'], ['0 CONCESSION', '0%', '#e4e4e4'], ['0 FREE', '0%', '#f95d9b'], ['1 DEFAULTER', '50%', '#b41600']] as $fee)
                        <div class="admin-progress-row">
                            <div class="admin-progress-label"><span>{{ $fee[0] }}</span><span>{{ $fee[1] }}</span></div>
                            <div class="admin-progress-track"><div class="admin-progress-fill" style="width:{{ $fee[1] }};background:{{ $fee[2] }}"></div></div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="admin-fees-row grid gap-4 px-3 pb-4 xl:grid-cols-[minmax(0,2fr)_minmax(360px,0.8fr)]">
            <section class="admin-panel overflow-hidden rounded-xl bg-white shadow-lg">
                <h2 class="admin-panel-title">Expenses For - {{ now()->format('F Y') }}</h2>
                <div class="px-4 pt-4 text-center text-base">TOTAL: 0 &nbsp;&nbsp;&nbsp; TODAY: 0</div>
                <div class="admin-chart-placeholder" aria-label="Expenses chart"></div>
            </section>

            <section class="admin-panel overflow-hidden rounded-xl bg-white shadow-lg">
                <h2 class="admin-panel-title flex items-center justify-between">Expenses For - {{ now()->format('F Y') }} <span aria-hidden="true">−</span></h2>
                <div class="admin-chart-placeholder" aria-label="Expenses overview chart"></div>
            </section>
        </div>

        @php
            $weekStart = now()->startOfWeek();
            $weekDays = collect(range(0, 6))->map(fn ($day) => $weekStart->copy()->addDays($day));
        @endphp
        <section class="admin-panel mx-3 mb-4 overflow-hidden rounded-xl bg-white shadow-lg">
            <h2 class="admin-panel-title flex items-center justify-between">Calendar <span aria-hidden="true">−</span></h2>
            <div class="flex items-center justify-between px-4 py-3 text-lg">
                <span class="rounded bg-neutral-700 px-3 py-1 text-white">‹ &nbsp; › &nbsp; Today</span>
                <strong>{{ $weekStart->format('F j') }} – {{ $weekStart->copy()->addDays(6)->format('j Y') }}</strong>
                <span class="rounded bg-neutral-700 px-3 py-1 text-white">Month &nbsp; Week &nbsp; Day</span>
            </div>
            <div class="admin-calendar">
                <div class="admin-calendar-head"><div></div>@foreach ($weekDays as $day)<div>{{ $day->format('D n/j') }}</div>@endforeach</div>
                @foreach (['all-day', '12am', '1am', '2am', '3am', '4am', '5am', '6am', '7am', '8am', '9am', '10am', '11am', '12pm', '1pm', '2pm', '3pm'] as $hour)
                    <div class="admin-calendar-row"><div>{{ $hour }}</div>@foreach ($weekDays as $day)<div></div>@endforeach</div>
                @endforeach
            </div>
        </section>
    </section>

    <section id="admin-empty-tab" class="admin-dashboard-section hidden min-h-[420px] p-8" aria-live="polite">
        <h2 class="text-xl font-semibold text-[#24448d]"></h2>
        <p class="mt-2 text-sm text-neutral-500">This module structure is ready for its module-by-module implementation.</p>
    </section>

    <section id="cms-tab" class="admin-dashboard-section hidden" aria-label="CMS modules">
        @include('admin.partials.cms-module-picker')
    </section>

    <section id="reports-tab" class="admin-dashboard-section hidden min-h-[420px] p-8" aria-live="polite">
        <h2 class="text-xl font-semibold text-[#24448d]">Reports</h2>
        <p class="mt-2 text-sm text-neutral-500">Reports structure is ready for module-by-module implementation.</p>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const dashboard = document.getElementById('dashboard-tab');
            const empty = document.getElementById('admin-empty-tab');
            const cms = document.getElementById('cms-tab');
            const reports = document.getElementById('reports-tab');
            const title = empty?.querySelector('h2');
            const tabs = [...document.querySelectorAll('[data-admin-tab]')];
            const names = { '#modules': 'Modules', '#lms': 'LMS', '#system-settings': 'System Settings' };
            const sync = () => {
                const hash = window.location.hash || '#dashboard';
                const isEmpty = Boolean(names[hash]);
                const isCms = hash === '#cms';
                const isReports = hash === '#reports';
                if (dashboard) dashboard.classList.toggle('hidden', isEmpty || isCms || isReports);
                if (empty) empty.classList.toggle('hidden', !isEmpty);
                if (cms) cms.classList.toggle('hidden', !isCms);
                if (reports) reports.classList.toggle('hidden', !isReports);
                if (title) title.textContent = names[hash] || 'Dashboard';
                tabs.forEach((tab) => tab.classList.toggle('is-active', (tab.dataset.adminTab || '#dashboard') === hash));
            };
            window.addEventListener('hashchange', sync);
            sync();
        })();
    </script>
@endpush

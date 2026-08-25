@php
    $sidebarItems = [
        ['label' => 'Dashboard', 'icon' => 'fa-solid fa-desktop', 'route' => 'admin.dashboard'],
        ['label' => 'Staff Recruitment', 'icon' => 'fa-solid fa-users', 'route' => 'admin.hrms.staff.index'],
        ['label' => 'Internal & External Commn', 'icon' => 'fa-regular fa-comments', 'route' => 'admin.adm.mail-sms.index'],
        ['label' => 'Customer Services Mgmt.', 'icon' => 'fa-solid fa-list-check', 'route' => 'admin.adm.complaints.index'],
        ['label' => 'Admission Process', 'icon' => 'fa-solid fa-user-plus', 'route' => 'admin.adm.student-registrations.index'],
        ['label' => 'Withdrawal Process', 'icon' => 'fa-solid fa-ban', 'route' => 'admin.adm.student-transfers.index'],
        ['label' => 'Attendance Mgmt.', 'icon' => 'fa-regular fa-calendar-check', 'route' => 'admin.adm.attendance.index'],
        ['label' => 'Syllabus Mgmt.', 'icon' => 'fa-regular fa-building', 'route' => 'admin.academics.syllabus.index'],
        ['label' => 'Effective Lesson Planning', 'icon' => 'fa-regular fa-calendar-check', 'route' => 'admin.academics.lessons.index'],
        ['label' => 'Timetable & staffing', 'icon' => 'fa-regular fa-clock', 'route' => 'admin.academics.timetables.index'],
        ['label' => 'Homework', 'icon' => 'fa-solid fa-flask', 'route' => 'admin.academics.homework.index'],
        ['label' => 'Paper Generate', 'icon' => 'fa-regular fa-copy', 'route' => 'admin.academics.paper-generate.index'],
        ['label' => 'Examination', 'icon' => 'fa-regular fa-file-lines', 'route' => 'admin.academics.exam-schedules.index'],
        ['label' => 'Test System', 'icon' => 'fa-regular fa-file', 'route' => 'admin.academics.test-schedules.index'],
    ];
@endphp

@php
    $isAcademicsArea = request()->routeIs('admin.academics.*');
    $curriculumItems = [
        ['label' => 'Subjects', 'icon' => 'fa-solid fa-angle-double-right', 'route' => 'admin.academics.subjects.index'],
        ['label' => 'Subjects Group', 'icon' => 'fa-solid fa-angle-double-right', 'route' => 'admin.academics.subject-groups.index'],
        ['label' => 'Chapter', 'icon' => 'fa-solid fa-angle-double-right', 'route' => 'admin.academics.chapters.index'],
        ['label' => 'Topic', 'icon' => 'fa-solid fa-angle-double-right', 'route' => 'admin.academics.topics.index'],
        ['label' => 'Modules', 'icon' => 'fa-solid fa-angle-double-right', 'route' => 'admin.academics.domain-modules.index'],
        ['label' => 'Domain', 'icon' => 'fa-solid fa-angle-double-right', 'route' => 'admin.academics.domains.index'],
    ];
@endphp

<aside class="admin-sidebar fixed inset-y-0 left-0 z-30 hidden w-[240px] overflow-hidden bg-[#24448d] text-white shadow-xl lg:block">
    <div class="admin-sidebar-header flex h-16 items-center gap-2 border-b border-white/10 bg-[#24448d] px-2">
        <div class="admin-avatar flex h-11 w-11 items-center justify-center rounded-full border border-white/50 bg-white/90 text-2xl text-slate-500">
            <i class="fa-regular fa-user"></i>
        </div>
        <a href="{{ route('admin.dashboard', absolute: false) }}" class="min-w-0 text-lg font-semibold text-white no-underline">
            <i class="fa-regular fa-hand-point-right"></i>
            Super Admin
        </a>
    </div>

    <div class="border-b border-black/20 bg-[#254693] px-4 py-2 shadow-inner">
        <p class="text-base font-semibold">Current Session: 2026-27</p>
        <div class="mt-2 flex items-center justify-between text-base">
            <span>Quick Links</span>
            <span class="text-lg"><i class="fa-solid fa-grip"></i></span>
        </div>
    </div>

    <nav class="h-[calc(100vh-136px)] overflow-y-auto pb-6 pt-2 [scrollbar-width:thin]">
        @foreach ($sidebarItems as $item)
            <a
                href="{{ route($item['route'], absolute: false) }}"
                class="admin-sidebar-link flex items-center gap-3 px-3 py-3 text-[14px] font-semibold transition hover:bg-white/10 {{ request()->routeIs($item['route']) ? 'is-active' : '' }}"
            >
                <span class="w-6 text-center text-lg"><i class="{{ $item['icon'] }}"></i></span>
                <span class="min-w-0 flex-1 truncate">{{ $item['label'] }}</span>
                @unless ($loop->first)
                    <span class="text-2xl leading-none"><i class="fa-solid fa-angle-right"></i></span>
                @endunless
            </a>

            @if ($loop->first)
                @if ($isAcademicsArea)
                    <a href="{{ route('admin.academics.dashboard.view', absolute: false) }}" class="admin-sidebar-link flex items-center gap-3 px-3 py-3 text-[14px] font-semibold transition hover:bg-white/10">
                        <span class="w-6 text-center text-lg"><i class="fa-solid fa-life-ring"></i></span>
                        <span class="min-w-0 flex-1 truncate">Manual Support</span>
                        <span class="text-2xl leading-none"><i class="fa-solid fa-angle-right"></i></span>
                    </a>
                @endif

                <div class="admin-sidebar-group {{ $isAcademicsArea ? 'is-open' : '' }}">
                    <button type="button" data-sidebar-toggle aria-expanded="{{ $isAcademicsArea ? 'true' : 'false' }}"
                       class="admin-sidebar-link admin-sidebar-group-toggle w-full border-0 text-left {{ $isAcademicsArea ? 'is-active' : '' }}">
                        <span class="w-6 text-center text-lg"><i class="fa-solid fa-book-open"></i></span>
                        <span class="min-w-0 flex-1 truncate">Curriculum Mgmt.</span>
                        <span class="admin-sidebar-chevron text-2xl leading-none"><i class="fa-solid fa-angle-right"></i></span>
                    </button>
                    <div class="admin-sidebar-submenu">
                        @foreach ($curriculumItems as $curriculumItem)
                            <a href="{{ route($curriculumItem['route'], absolute: false) }}" class="admin-sidebar-submenu-link {{ request()->routeIs($curriculumItem['route']) ? 'is-active' : '' }}">
                                <i class="{{ $curriculumItem['icon'] }}"></i>
                                <span>{{ $curriculumItem['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        @endforeach
    </nav>
</aside>

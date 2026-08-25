<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'TNT SOL')</title>
        <link rel="stylesheet" href="{{ asset('assets/themes/default/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/themes/default/fontawesome/css/v4-shims.min.css') }}">
        @vite(['resources/css/app.css'])
        <style>
            body.admin-body {
                margin: 0;
                background: #f3f6f8;
                color: #111827;
                font-family: Arial, Helvetica, sans-serif;
            }

            .admin-content-wrap {
                min-width: 0;
                padding-left: 240px;
            }

            .admin-main {
                padding: 8px 8px 24px;
            }

            body.admin-body:not(:has(.admin-module-tabs)) .admin-main,
            .admin-main.is-academic-main {
                padding-top: 64px;
            }

            .admin-sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                z-index: 30;
                width: 240px;
                overflow: hidden;
                background: #24448d;
                color: #fff;
                box-shadow: 0 12px 28px rgba(15, 23, 42, .3);
            }

            .admin-sidebar-header {
                display: flex;
                height: 54px;
                align-items: center;
                gap: 8px;
                border-bottom: 1px solid rgba(255, 255, 255, .12);
                padding: 0 7px;
            }

            .admin-avatar {
                display: inline-flex;
                width: 34px;
                height: 34px;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                border: 1px solid rgba(255, 255, 255, .55);
                background: rgba(255, 255, 255, .92);
                color: #64748b;
            }

            .admin-sidebar-link {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 8px 10px;
                color: #fff;
                font-size: 13px;
                font-weight: 400;
                text-decoration: none;
                border-left: 3px solid transparent;
                transition: background-color .18s ease, border-left-color .18s ease, color .18s ease;
            }

            .admin-sidebar-link:hover,
            .admin-sidebar-link.is-active,
            .admin-sidebar-group.is-open > .admin-sidebar-group-toggle {
                background: #3B6EC4 !important;
                border-left: 3px solid #D6DCE8 !important;
                color: #fff;
            }

            .admin-sidebar-group-toggle {
                cursor: pointer;
                font-family: inherit;
                background: transparent;
            }

            .admin-sidebar-chevron {
                display: inline-block;
                transition: transform .18s ease;
            }

            .admin-sidebar-group.is-open > .admin-sidebar-group-toggle .admin-sidebar-chevron,
            .admin-sidebar-group.is-open > button.admin-sidebar-group-toggle .admin-sidebar-chevron {
                transform: rotate(90deg);
            }

            .admin-sidebar-submenu {
                display: block;
                max-height: 0;
                overflow: hidden;
                opacity: 0;
                background: #24448d;
                padding: 3px 0 6px;
                transition: max-height .24s ease, opacity .18s ease;
            }

            .admin-sidebar-group.is-open .admin-sidebar-submenu {
                max-height: 460px;
                opacity: 1;
            }

            .admin-sidebar-submenu-link {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 6px 12px 6px 20px;
                color: #fff;
                font-size: 12px;
                font-weight: 400;
                text-decoration: none;
                border-left: 3px solid transparent;
                transition: background-color .18s ease, padding-left .18s ease;
            }

            .admin-sidebar-submenu-link:hover,
            .admin-sidebar-submenu-link.is-active {
                background: #3f70c9 !important;
                color: #fff !important;
                font-weight: 600;
                padding-left: 24px;
            }

            @keyframes admin-submenu-in {
                from { opacity: 0; transform: translateY(-4px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .main-footer,
            .admin-footer {
                background: #ececec !important;
                padding-top: 2px !important;
                padding-bottom: 2px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                text-align: right !important;
                font-size: 10px !important;
                color: #444 !important;
                border-top: 1px solid #d2d6de !important;
            }

            .admin-topbar {
                position: fixed;
                top: 0;
                right: 0;
                left: 240px;
                z-index: 20;
                height: 54px;
                background: #24448d;
                color: #fff;
                box-shadow: 0 2px 8px rgba(15, 23, 42, .3);
            }

            .admin-topbar-inner {
                display: flex;
                height: 100%;
                align-items: center;
                gap: 12px;
                padding: 0 10px;
            }

            .admin-brand {
                display: flex;
                height: 36px;
                min-width: 340px;
                align-items: center;
                border-radius: 999px 18px 0 999px;
                background: #3f70c9;
                padding: 0 16px;
                color: #fff;
                font-size: 20px;
                font-weight: 700;
                letter-spacing: 1px;
                text-decoration: none;
            }

            .admin-search {
                display: flex;
                width: min(300px, 100%);
                margin: 0 auto;
                overflow: hidden;
                border-radius: 999px;
                background: #fff;
                box-shadow: 0 1px 4px rgba(15, 23, 42, .18);
            }

            .admin-search input {
                min-width: 0;
                flex: 1;
                border: 0;
                padding: 8px 13px;
                font-size: 14px;
                outline: 0;
            }

            .admin-search button {
                width: 42px;
                border: 0;
                background: #3f70c9;
                color: #fff;
                font-size: 18px;
            }

            .admin-topbar-icons {
                display: flex;
                align-items: center;
                gap: 18px;
                margin-left: auto;
                font-size: 16px;
            }

            .admin-header-action {
                position: relative;
                border: 0;
                background: transparent;
                padding: 0;
                color: inherit;
                cursor: pointer;
                font: inherit;
                line-height: 1;
                transition: transform .16s ease, color .16s ease;
            }

            .admin-header-action:hover,
            .admin-header-action.is-open {
                color: #bfdbfe;
                transform: translateY(-2px);
            }

            .admin-profile-action {
                display: inline-flex;
                width: 32px;
                height: 32px;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                background: rgba(255,255,255,.9);
                color: #64748b;
                font-size: 14px;
            }

            .admin-header-popover {
                position: absolute;
                top: 52px;
                right: 14px;
                z-index: 50;
                min-width: 220px;
                border: 1px solid #d4d4d4;
                border-radius: 6px;
                background: #fff;
                padding: 12px;
                color: #1f2937;
                font-size: 13px;
                box-shadow: 0 8px 18px rgba(15,23,42,.22);
                animation: admin-popover-in .16s ease-out;
            }

            .admin-header-popover h3 { margin: 0 0 8px; color: #24448d; font-size: 14px; font-weight: 600; }
            .admin-header-popover a { display: block; padding: 6px 4px; color: #24448d; text-decoration: none; }
            .admin-header-popover a:hover { background: #eef4ff; }
            @keyframes admin-popover-in { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }

            .admin-dashboard-section {
                overflow: hidden;
                border: 1px solid #d4d4d4;
                background: #fff;
                box-shadow: 0 1px 3px rgba(15, 23, 42, .12);
            }

            .admin-module-tabs {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 54px;
                border-bottom: 1px solid #f59e0b;
                padding: 10px;
            }

            .admin-module-tab {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                border: 1px solid transparent;
                border-radius: 6px;
                background: #fff;
                padding: 8px 16px;
                color: #1f2937;
                font-size: 14px;
                font-weight: 500;
                text-decoration: none;
                box-shadow: 0 8px 18px rgba(15, 23, 42, .18);
                transition: transform .18s ease, box-shadow .18s ease, background-color .18s ease, color .18s ease;
            }

            .admin-module-tab:hover {
                transform: translateY(-2px);
                background: #2f61b3;
                border-color: #2f61b3;
                color: #fff;
                box-shadow: 0 10px 20px rgba(15, 23, 42, .28);
            }

            .admin-module-tab:hover i {
                transform: scale(1.15) rotate(-5deg);
            }

            .admin-module-tab i {
                transition: transform .18s ease;
            }

            .cms-module-picker {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 8px;
                border: 1px solid #d4d4d4;
                border-top: 0;
                background: #fff;
                padding: 10px 8px 20px;
            }

            .cms-module-card {
                display: flex;
                min-height: 58px;
                align-items: center;
                gap: 12px;
                border: 2px solid #111;
                border-radius: 12px;
                padding: 8px;
                color: #111827;
                font-size: 12px;
                font-weight: 700;
                text-decoration: none;
                transition: transform .18s ease, box-shadow .18s ease, background-color .18s ease;
            }

            .cms-module-card i {
                color: #2f61b3;
                font-size: 26px;
                transition: transform .18s ease;
            }

            .cms-module-card img {
                width: 38px;
                height: 38px;
                object-fit: contain;
                transition: transform .18s ease;
            }

            .cms-module-card:hover {
                transform: translateY(-2px);
                background: #fff;
                box-shadow: 0 4px 9px rgba(15, 23, 42, .16);
            }

            .cms-module-card:hover i {
                transform: scale(1.12) rotate(-6deg);
            }

            .cms-module-card:hover img {
                transform: scale(1.12) rotate(-6deg);
            }

            .admin-academics-workspace {
                min-height: calc(100vh - 150px);
                border: 1px solid #d4d4d4;
                background: #fff;
            }

            .subject-table th, .sg-table th, .ch-table th, .tp-table th, .dm-table th, .domain-table th {
                cursor: pointer;
                user-select: none;
                background: #24448d;
                color: #fff;
                font-size: 14px;
                font-weight: 700 !important;
            }

            .admin-sort-indicator {
                display: inline-block;
                margin-left: 4px;
                color: rgba(255,255,255,.9);
                font-size: 11px;
                font-weight: 700;
                line-height: 1;
            }

            /* Keep all Curriculum Management list headers aligned with CMSC. */
            .subject-box-title, .sg-title, .ch-title, .tp-title, .dm-title, .domain-title {
                display: block !important;
                box-sizing: border-box;
                min-height: 43px;
                margin: 0;
                padding: 8px 10px;
                color: #1f2937;
                font-size: 18px;
                font-weight: 400;
                line-height: 1.25;
                visibility: visible !important;
                border-bottom: 1px solid #d5d5d5;
            }

            .tp-exports, .dm-exports, .ch-exports, .sg-exports, .domain-exports {
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .tp-exports button, .dm-exports button, .ch-exports button, .sg-exports button, .domain-exports button,
            .curriculum-export-columns {
                position: relative;
                display: inline-flex;
                width: 27px;
                height: 27px;
                align-items: center;
                justify-content: center;
                border: 0;
                border-radius: 4px;
                background: #24448d;
                color: #fff;
                cursor: pointer;
                font-size: 14px;
                transition: transform .16s ease, background-color .16s ease, box-shadow .16s ease;
            }

            .tp-exports button:hover, .dm-exports button:hover, .ch-exports button:hover, .sg-exports button:hover, .domain-exports button:hover,
            .curriculum-export-columns:hover {
                z-index: 2;
                transform: translateY(-2px);
                background: #3f70c9;
                box-shadow: 0 3px 6px rgba(15,23,42,.22);
            }

            .tp-exports button::after, .dm-exports button::after, .ch-exports button::after, .sg-exports button::after, .domain-exports button::after,
            .curriculum-export-columns::after {
                content: attr(data-tooltip);
                position: absolute;
                top: calc(100% + 7px);
                left: 50%;
                z-index: 20;
                padding: 4px 7px;
                border-radius: 3px;
                background: #222;
                color: #fff;
                font-size: 11px;
                line-height: 1;
                white-space: nowrap;
                opacity: 0;
                pointer-events: none;
                transform: translate(-50%, -3px);
                transition: opacity .14s ease, transform .14s ease;
            }

            .tp-exports button:hover::after, .dm-exports button:hover::after, .ch-exports button:hover::after, .sg-exports button:hover::after, .domain-exports button:hover::after,
            .curriculum-export-columns:hover::after {
                opacity: 1;
                transform: translate(-50%, 0);
            }

            .admin-module-tab.is-active {
                background: #2f61b3;
                color: #fff;
            }

            .admin-dashboard-grid {
                display: grid;
                grid-template-columns: minmax(0, 4.2fr) minmax(164px, 1fr) minmax(164px, 1fr);
                gap: 8px;
                padding: 8px;
            }

            .admin-metric-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 10px;
            }

            .admin-metric-card,
            .admin-summary-card,
            .admin-panel {
                border: 1px solid #d4d4d4;
                border-radius: 12px;
                background: #fff;
                box-shadow: 0 8px 18px rgba(15, 23, 42, .08);
                transition: transform .18s ease, box-shadow .18s ease;
            }

            .admin-summary-card:hover,
            .admin-panel:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 12px rgba(15, 23, 42, .16);
            }

            .admin-metric-card {
                display: flex;
                min-height: 60px;
                align-items: center;
                gap: 8px;
                padding: 6px 8px;
                color: inherit;
                text-decoration: none;
                transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
            }

            .admin-metric-card:hover {
                transform: translateY(-3px);
                border-color: var(--metric-color, #2f61b3);
                background: var(--metric-color, #2f61b3);
                box-shadow: 0 8px 16px color-mix(in srgb, var(--metric-color, #2f61b3) 42%, transparent);
            }

            .admin-metric-card:hover .admin-card-title,
            .admin-metric-card:hover .admin-card-value,
            .admin-metric-card:hover .admin-card-meta,
            .admin-metric-card:hover .admin-metric-icon {
                color: #fff !important;
            }

            .admin-metric-card:hover .admin-metric-icon {
                transform: scale(1.12) rotate(-5deg);
            }

            .admin-metric-icon {
                width: 40px;
                text-align: center;
                font-size: 26px;
                line-height: 1;
                transition: transform .18s ease;
            }

            .admin-card-title {
                margin: 0;
                font-size: 11px;
                font-weight: 500;
            }

            .admin-card-value,
            .admin-card-meta {
                margin: 2px 0 0;
                font-size: 11px;
                font-weight: 700;
            }

            .admin-summary-card {
                display: flex;
                min-height: 198px;
                flex-direction: column;
                justify-content: flex-end;
                padding: 8px;
            }

            .admin-donut-card {
                justify-content: center;
            }

            .admin-panels-row,
            .admin-fees-row {
                display: grid;
                gap: 10px;
                padding: 0 12px 12px;
            }

            .admin-panels-row {
                grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
            }

            .admin-three-panels {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 10px;
            }

            .admin-fees-row {
                grid-template-columns: minmax(0, 2fr) minmax(360px, .8fr);
            }

            .admin-panel-title {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: #2f61b3;
                color: #fff;
                padding: 6px 8px;
                font-size: 12px;
                font-weight: 700;
            }

            .admin-progress-body {
                padding: 10px 9px;
            }

            .admin-progress-row {
                margin-bottom: 10px;
            }

            .admin-progress-label {
                display: flex;
                justify-content: space-between;
                margin-bottom: 7px;
                font-size: 14px;
            }

            .admin-progress-track {
                height: 5px;
                background: #e5e7eb;
            }

            .admin-progress-fill {
                height: 100%;
            }

            .admin-stat-line {
                display: flex;
                justify-content: space-between;
                border-bottom: 1px solid #e5e7eb;
                padding: 6px 0;
                font-size: 12px;
            }

            .admin-donut {
                width: 86px;
                height: 86px;
                margin: 0 auto 12px;
                border-radius: 999px;
                background: conic-gradient(#0ea5e9 0 50%, #ec4899 50% 100%);
                position: relative;
            }

            .admin-donut::after {
                content: "";
                position: absolute;
                inset: 22px;
                border-radius: 999px;
                background: #fff;
            }

            .admin-chart-placeholder {
                position: relative;
                height: 185px;
                margin: 8px 12px 14px;
                overflow: hidden;
                background: repeating-linear-gradient(to bottom, transparent 0 44px, #e5e7eb 45px 46px);
            }

            .admin-chart-placeholder::after {
                content: "";
                position: absolute;
                left: 0;
                right: 0;
                top: 50%;
                height: 3px;
                background: #5277d9;
                box-shadow: 0 0 0 4px rgba(82, 119, 217, .08);
            }

            .admin-calendar {
                overflow: hidden;
                margin: 0 10px 12px;
                border: 1px solid #d4d4d4;
                border-radius: 4px;
            }

            .admin-calendar-head,
            .admin-calendar-row {
                display: grid;
                grid-template-columns: 72px repeat(7, minmax(80px, 1fr));
            }

            .admin-calendar-head > div,
            .admin-calendar-row > div {
                min-height: 34px;
                border-right: 1px solid #ddd;
                border-bottom: 1px solid #ddd;
                padding: 7px 8px;
                font-size: 13px;
            }

            .admin-calendar-head > div {
                background: #f7f7f7;
                text-align: center;
                font-weight: 600;
            }

            .admin-calendar-row > div:first-child {
                text-align: right;
                color: #555;
                font-weight: 600;
            }

            .admin-calendar-row > div:nth-child(3) {
                background: #fffbe6;
            }

            @media (max-width: 1279px) {
                .admin-dashboard-grid,
                .admin-panels-row,
                .admin-fees-row {
                    grid-template-columns: 1fr;
                }

                .admin-metric-grid,
                .admin-three-panels {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .cms-module-picker {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (min-width: 1280px) {
                .admin-sidebar { width: 240px !important; }
                .admin-topbar { left: 240px !important; }
                .admin-content-wrap { padding-left: 240px !important; }
                .admin-main { padding-left: 8px; padding-right: 8px; }
            }

            @media (max-width: 1023px) {
                .admin-sidebar {
                    display: none;
                }

                .admin-content-wrap {
                    padding-left: 0;
                }

                .admin-topbar {
                    left: 0;
                }
            }

            @media (max-width: 767px) {
                .admin-search,
                .admin-topbar-icons {
                    display: none;
                }

                .admin-brand {
                    min-width: 0;
                    flex: 1;
                }

                .admin-metric-grid,
                .admin-three-panels {
                    grid-template-columns: 1fr;
                }

                .cms-module-picker {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        @stack('styles')
    </head>
    <body class="admin-body bg-[#f3f6f8] text-neutral-900">
        <div class="min-h-screen">
                @include('admin.partials.sidebar')

            <div class="admin-content-wrap min-w-0 lg:pl-[240px]">
                @include('admin.partials.header')
                @unless(request()->routeIs('admin.academics.*'))
                    @include('admin.partials.navbar')
                @endunless

                <main class="admin-main px-2 pb-6 {{ request()->routeIs('admin.academics.*') ? 'is-academic-main' : '' }} sm:px-3">
                    @unless(request()->routeIs('admin.academics.domain-modules.index'))
                        @include('admin.partials.alerts')
                    @endunless
                    @yield('content')
                </main>

                @include('admin.partials.footer')
            </div>
        </div>

        <script>
            window.adminRoutes = {
                dashboard: @json(route('admin.dashboard')),
                staff: @json(route('admin.staff.index')),
                report: @json(route('admin.report.index')),
                frontcms: @json(route('admin.frontcms.index')),
                membership: @json(route('admin.membership.index')),
                qms: @json(route('admin.qms.index')),
                systemNotification: @json(route('admin.system-notification.index')),
            };

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (window.jQuery && csrfToken) {
                window.jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });
            }
        </script>
        <script src="{{ asset('assets/dist/datatables/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/vfs_fonts.js') }}"></script>
        @stack('scripts')
        <script>
            (() => {
                const exportGroups = '.tp-exports, .dm-exports, .ch-exports, .sg-exports, .domain-exports';
                document.querySelectorAll(exportGroups).forEach((group) => {
                    group.querySelectorAll('button').forEach((button) => {
                        button.dataset.tooltip ||= button.title || button.dataset.export || 'Export';
                    });
                    let columns = group.querySelector('[data-columns], #sg-columns');
                    if (!columns) {
                        columns = document.createElement('button');
                        columns.type = 'button';
                        columns.dataset.columns = 'true';
                        columns.dataset.tooltip = 'Columns';
                        columns.title = 'Columns';
                        columns.innerHTML = '<i class="fa-solid fa-table-columns"></i>';
                        group.append(columns);
                    }
                    columns.dataset.columns = 'true';
                    columns.dataset.tooltip = 'Columns';
                    if (columns.id !== 'sg-columns') columns.addEventListener('click', () => {
                        const table = group.closest('section')?.querySelector('table');
                        const cells = table ? [...table.querySelectorAll('tr')].map((row) => row.lastElementChild).filter(Boolean) : [];
                        const hidden = cells[0]?.style.display === 'none';
                        cells.forEach((cell) => { cell.style.display = hidden ? '' : 'none'; });
                    });
                });

                document.addEventListener('click', (event) => {
                    const button = event.target.closest('[data-export="pdf"], [data-tp-export="pdf"], [data-dm-export="pdf"], [data-ch-export="pdf"], [data-sg-export="pdf"], [data-domain-export="pdf"]');
                    if (!button) return;
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    const section = button.closest('section') || document;
                    const table = section.querySelector('table');
                    if (!table || !window.pdfMake) return;

                    const titleEl = section.querySelector('.subject-box-title, .sg-title, .ch-title, .tp-title, .dm-title, .domain-title, .download_label, h2, h3');
                    const title = (titleEl?.innerText || document.title).replace(/\s+-\s+.*$/, '').trim();

                    const headerCells = [...table.querySelectorAll('thead th')];
                    const exportColIndices = [];
                    const headerTexts = [];

                    headerCells.forEach((th, idx) => {
                        if (/action/i.test(th.textContent)) return;
                        exportColIndices.push(idx);
                        const cleanText = th.innerText.replace(/[▼▲↕↑↓\r\n]/g, ' ').replace(/\s+/g, ' ').trim();
                        headerTexts.push(cleanText);
                    });

                    if (headerTexts.length === 0) return;

                    const rowEls = [...table.querySelectorAll('tbody tr')].filter((tr) => !tr.querySelector('[colspan]') && tr.children.length >= headerCells.length);
                    const rowsData = rowEls.map((tr) => {
                        return exportColIndices.map((idx) => {
                            const td = tr.children[idx];
                            return td ? td.innerText.replace(/[\r\n]+/g, ' ').replace(/\s+/g, ' ').trim() : '';
                        });
                    });

                    const tableBody = [
                        headerTexts.map((text) => ({ text, style: 'tableHeaderCell' })),
                        ...rowsData.map((row) => row.map((cell) => ({ text: cell, style: 'tableBodyCell' })))
                    ];

                    const docDefinition = {
                        content: [
                            { text: title, style: 'docTitle' },
                            {
                                table: {
                                    headerRows: 1,
                                    widths: Array(headerTexts.length).fill('*'),
                                    body: tableBody
                                },
                                layout: {
                                    hLineWidth: (i, node) => 0.5,
                                    vLineWidth: (i, node) => 0,
                                    hLineColor: (i, node) => '#d1d5db',
                                    fillColor: (rowIndex, node, columnIndex) => {
                                        if (rowIndex === 0) return '#24448d';
                                        return (rowIndex % 2 === 1) ? '#f3f4f6' : '#ffffff';
                                    },
                                    paddingLeft: (i, node) => 8,
                                    paddingRight: (i, node) => 8,
                                    paddingTop: (i, node) => 6,
                                    paddingBottom: (i, node) => 6
                                }
                            }
                        ],
                        styles: {
                            docTitle: {
                                fontSize: 16,
                                bold: true,
                                margin: [0, 0, 0, 10],
                                color: '#111827'
                            },
                            tableHeaderCell: {
                                bold: true,
                                color: '#ffffff',
                                fontSize: 10
                            },
                            tableBodyCell: {
                                fontSize: 9,
                                color: '#1f2937'
                            }
                        },
                        defaultStyle: {
                            fontSize: 9
                        }
                    };

                    const filename = `${title.toLowerCase().replace(/[^a-z0-9]+/g, '-')}.pdf`;
                    window.pdfMake.createPdf(docDefinition).download(filename);
                }, true);
            })();
        </script>
        <script>
            (() => {
                const tables = document.querySelectorAll('.subject-table, .sg-table, .ch-table, .tp-table, .dm-table, .domain-table');

                tables.forEach((table) => {
                    const headers = [...table.querySelectorAll('thead th')];
                    const body = table.querySelector('tbody');
                    if (!body) return;

                    headers.forEach((header, index) => {
                        if (/action/i.test(header.textContent)) return;

                        const label = header.textContent.replace(/[▼▲↕↑↓]/g, '').trim();
                        header.textContent = label + ' ';
                        const indicator = document.createElement('span');
                        indicator.className = 'admin-sort-indicator';
                        indicator.textContent = '▼';
                        header.append(indicator);
                        header.dataset.sortDirection = 'none';

                        header.addEventListener('click', () => {
                            const current = header.dataset.sortDirection;
                            const direction = current === 'asc' ? 'desc' : 'asc';

                            headers.forEach((other) => {
                                const otherIndicator = other.querySelector('.admin-sort-indicator');
                                if (otherIndicator && other !== header) {
                                    other.dataset.sortDirection = 'none';
                                    otherIndicator.textContent = '▼';
                                }
                            });

                            header.dataset.sortDirection = direction;
                            indicator.textContent = direction === 'asc' ? '▲' : '▼';

                            const rows = [...body.querySelectorAll('tr')].filter((row) => row.children.length === headers.length && !row.querySelector('[colspan]'));
                            rows.sort((a, b) => {
                                const first = a.children[index]?.innerText.trim() ?? '';
                                const second = b.children[index]?.innerText.trim() ?? '';
                                const numericFirst = Number(first.replace(/[^0-9.-]/g, ''));
                                const numericSecond = Number(second.replace(/[^0-9.-]/g, ''));
                                const comparison = first !== '' && second !== '' && Number.isFinite(numericFirst) && Number.isFinite(numericSecond) && !Number.isNaN(numericFirst) && !Number.isNaN(numericSecond)
                                    ? numericFirst - numericSecond
                                    : first.localeCompare(second, undefined, {numeric: true, sensitivity: 'base'});
                                return direction === 'asc' ? comparison : -comparison;
                            });

                            rows.forEach((row) => body.append(row));
                        });
                    });
                });
            })();
        </script>
        <script>
            document.querySelectorAll('[data-sidebar-toggle]').forEach((toggle) => {
                toggle.addEventListener('click', () => {
                    const group = toggle.closest('.admin-sidebar-group');
                    const open = group.classList.toggle('is-open');
                    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                });
            });
        </script>
        <script>
            (() => {
                const popover = document.getElementById('admin-header-popover');
                const menus = {
                    calculator: '<h3>Calculator</h3><div>Use the search and dashboard tools to calculate live totals.</div>',
                    notifications: '<h3>Notifications</h3><div>No new notifications.</div><a href="{{ route('admin.system-notification.index', absolute: false) }}">Open notifications</a>',
                    messages: '<h3>Messages</h3><div>No new messages.</div><a href="{{ route('admin.adm.mail-sms.index', absolute: false) }}">Open communication</a>',
                    calendar: '<h3>Calendar</h3><div>View attendance and scheduled activities.</div><a href="{{ route('admin.adm.calendar.index', absolute: false) }}">Open calendar</a>',
                    tasks: '<h3>Tasks</h3><div>1 task is waiting for review.</div>',
                    birthdays: '<h3>Birthdays</h3><div>No birthdays today.</div>',
                    profile: '<h3>Super Admin</h3><a href="{{ route('admin.dashboard', absolute: false) }}">Open dashboard</a>',
                };
                document.querySelectorAll('[data-header-menu]').forEach((button) => button.addEventListener('click', () => {
                    const isSame = button.classList.contains('is-open');
                    document.querySelectorAll('[data-header-menu]').forEach((item) => item.classList.remove('is-open'));
                    if (isSame) {
                        if (popover) popover.hidden = true;
                        return;
                    }
                    if (popover) {
                        popover.innerHTML = menus[button.dataset.headerMenu] || '';
                        popover.hidden = false;
                    }
                    button.classList.add('is-open');
                }));
                document.addEventListener('click', (event) => {
                    if (event.target.closest('[data-header-menu]') || event.target.closest('#admin-header-popover')) return;
                    document.querySelectorAll('[data-header-menu]').forEach((item) => item.classList.remove('is-open'));
                    if (popover) popover.hidden = true;
                });
            })();
        </script>
    </body>
</html>

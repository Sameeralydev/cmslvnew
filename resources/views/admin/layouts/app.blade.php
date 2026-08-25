<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Admin') - {{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('assets/themes/default/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/datatables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/datatables/css/buttons.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/dist/datatables/css/dataTables.bootstrap.min.css') }}">
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
                padding-left: 296px;
            }

            .admin-main {
                padding: 72px 8px 24px;
            }

            .admin-sidebar {
                position: fixed;
                inset: 0 auto 0 0;
                z-index: 30;
                width: 296px;
                overflow: hidden;
                background: #24448d;
                color: #fff;
                box-shadow: 0 12px 28px rgba(15, 23, 42, .3);
            }

            .admin-sidebar-header {
                display: flex;
                height: 64px;
                align-items: center;
                gap: 8px;
                border-bottom: 1px solid rgba(255, 255, 255, .12);
                padding: 0 8px;
            }

            .admin-avatar {
                display: inline-flex;
                width: 42px;
                height: 42px;
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
                gap: 12px;
                padding: 10px 14px;
                color: #fff;
                font-size: 15px;
                font-weight: 500;
                text-decoration: none;
                cursor: pointer;
            }

            .admin-sidebar-link:hover {
                background: rgba(255, 255, 255, 0.1);
            }

            .admin-sidebar-link.is-active {
                background-color: #3368bf !important;
                border-left: none !important;
            }

            .sidebar-submenu {
                background-color: #28539e;
            }

            .sidebar-submenu a {
                text-decoration: none;
                color: #ffffff;
                font-weight: 400;
                font-size: 14px;
            }

            .sidebar-submenu a:hover {
                background: rgba(255, 255, 255, 0.1);
                color: #ffffff;
            }

            .admin-topbar {
                position: fixed;
                top: 0;
                right: 0;
                left: 296px;
                z-index: 20;
                height: 64px;
                background: #24448d;
                color: #fff;
                box-shadow: 0 2px 8px rgba(15, 23, 42, .3);
            }

            .admin-topbar-inner {
                display: flex;
                height: 100%;
                align-items: center;
                gap: 16px;
                padding: 0 14px;
            }

            .admin-brand {
                display: flex;
                height: 36px;
                min-width: 300px;
                align-items: center;
                border-radius: 999px 18px 0 999px;
                background: #3f70c9;
                padding: 0 18px;
                color: #fff;
                font-size: 24px;
                font-weight: 700;
                letter-spacing: 1px;
                text-decoration: none;
            }

            .search-pill-container {
                display: flex;
                width: 100%;
                height: 36px;
                align-items: center;
                overflow: hidden;
                border-radius: 9999px;
                background: #ffffff;
                box-shadow: 0 1px 4px rgba(0, 0, 0, .15);
            }

            .search-pill-input {
                min-width: 0;
                flex: 1;
                border: 0;
                background: transparent;
                padding: 0 16px;
                font-size: 13.5px;
                color: #374151;
                outline: none;
            }

            .search-pill-input::placeholder {
                color: #9ca3af;
                font-size: 13.5px;
            }

            .search-pill-btn {
                display: flex;
                height: 100%;
                width: 46px;
                align-items: center;
                justify-content: center;
                border: 0;
                background: #2F5DA8;
                color: #ffffff;
                font-size: 14px;
                cursor: pointer;
                transition: background-color .15s ease;
            }

            .search-pill-btn:hover {
                background: #244c8c;
            }

            .branch-header-btn {
                display: inline-flex;
                width: 32px;
                height: 32px;
                align-items: center;
                justify-content: center;
                border-radius: 4px;
                background: #ffffff;
                color: #24448d;
                font-size: 16px;
                text-decoration: none;
                box-shadow: 0 1px 3px rgba(0, 0, 0, .12);
                transition: all .15s ease;
            }

            .branch-header-btn:hover {
                background: #f1f5f9;
                color: #1e3a8a;
            }

            .admin-topbar-icons {
                display: flex;
                align-items: center;
                gap: 18px;
                margin-left: auto;
                font-size: 19px;
            }

            .admin-dashboard-section {
                overflow: hidden;
                border: 1px solid #d4d4d4;
                background: #fff;
                box-shadow: 0 1px 3px rgba(15, 23, 42, .12);
            }

            .admin-module-tabs {
                display: flex;
                flex-wrap: wrap;
                gap: 16px;
                border-bottom: 1px solid #f59e0b;
                padding: 12px;
            }

            .admin-module-tab {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                border: 0;
                border-radius: 6px;
                background: #fff;
                padding: 9px 20px;
                color: #1f2937;
                font-size: 16px;
                box-shadow: 0 8px 18px rgba(15, 23, 42, .18);
            }

            .admin-module-tab.is-active {
                background: #2f61b3;
                color: #fff;
            }

            .admin-dashboard-grid {
                display: grid;
                grid-template-columns: minmax(0, 4fr) minmax(250px, 1fr) minmax(250px, 1fr);
                gap: 10px;
                padding: 12px;
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
            }

            .admin-metric-card {
                display: flex;
                min-height: 74px;
                align-items: center;
                gap: 12px;
                padding: 8px 12px;
            }

            .admin-metric-icon {
                width: 40px;
                text-align: center;
                font-size: 30px;
                line-height: 1;
            }

            .admin-card-title {
                margin: 0;
                font-size: 14px;
                font-weight: 500;
            }

            .admin-card-value,
            .admin-card-meta {
                margin: 2px 0 0;
                font-size: 14px;
                font-weight: 700;
            }

            .admin-summary-card {
                display: flex;
                min-height: 248px;
                flex-direction: column;
                justify-content: flex-end;
                padding: 12px;
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
                font-size: 14px;
                font-weight: 700;
            }

            .admin-progress-body {
                padding: 14px 12px;
            }

            .admin-progress-row {
                margin-bottom: 16px;
            }

            .admin-progress-label {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                font-size: 18px;
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
                font-size: 14px;
            }

            .admin-donut {
                width: 112px;
                height: 112px;
                margin: 0 auto 18px;
                border-radius: 999px;
                background: conic-gradient(#0ea5e9 0 50%, #ec4899 50% 100%);
                position: relative;
            }

            .admin-donut::after {
                content: "";
                position: absolute;
                inset: 28px;
                border-radius: 999px;
                background: #fff;
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
            }

            /* Global DataTables Toolbar Matching CodeIgniter (Search + Solid Blue Export Buttons) */
            .dataTables_wrapper::after {
                content: "";
                display: table;
                clear: both;
            }

            .dataTables_wrapper .dataTables_filter {
                float: left !important;
                text-align: left !important;
                margin-bottom: 12px !important;
            }

            .dataTables_wrapper .dataTables_filter label {
                font-weight: normal !important;
                margin: 0 !important;
            }

            .dataTables_wrapper .dataTables_filter input {
                height: 32px !important;
                width: 200px !important;
                padding: 4px 10px !important;
                border: 1px solid #ced4da !important;
                border-radius: 4px !important;
                font-size: 13px !important;
                outline: none !important;
                color: #495057 !important;
                background-color: #fff !important;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
                margin-left: 0 !important;
                box-sizing: border-box !important;
            }

            .dataTables_wrapper .dataTables_filter input:focus {
                border-color: #24448d !important;
                box-shadow: 0 0 0 2px rgba(36, 68, 141, 0.2) !important;
            }

            .dt-buttons {
                float: right !important;
                margin-bottom: 12px !important;
                display: inline-flex !important;
                gap: 4px !important;
                align-items: center !important;
            }

            .dt-buttons .dt-button {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 32px !important;
                height: 32px !important;
                padding: 0 !important;
                background: #1e3a8a !important;
                border: 1px solid #1e3a8a !important;
                color: #ffffff !important;
                border-radius: 4px !important;
                font-size: 13.5px !important;
                cursor: pointer !important;
                transition: all 0.15s ease !important;
                margin-right: 0 !important;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
                box-sizing: border-box !important;
            }

            .dt-buttons .dt-button i {
                color: #ffffff !important;
                font-size: 13.5px !important;
            }

            .dt-buttons .dt-button:hover {
                background: #172554 !important;
                border-color: #172554 !important;
                color: #ffffff !important;
                transform: translateY(-1px) !important;
                box-shadow: 0 2px 5px rgba(30, 58, 138, 0.3) !important;
            }
        </style>
        @stack('styles')
    </head>
    <body class="admin-body bg-[#f3f6f8] text-neutral-900">
        <div class="min-h-screen">
            @include('admin.partials.sidebar')

            <div class="admin-content-wrap min-w-0 lg:pl-[296px]">
                @include('admin.partials.header')
                @include('admin.partials.navbar')

                <main class="admin-main px-2 pb-6 pt-[72px] sm:px-3">
                    @include('admin.partials.alerts')
                    @yield('content')
                </main>

                @include('admin.partials.footer')
            </div>
        </div>

        <script src="{{ asset('assets/vendor-updates/jquery/jquery-3.7.1.min.js') }}"></script>
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
        <script src="{{ asset('assets/dist/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/dist/datatables/js/ss.custom.js') }}"></script>
        @stack('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toggleBtn = document.getElementById('sidebarToggleBtn');
                var sidebar = document.querySelector('.admin-sidebar');
                if (toggleBtn && sidebar) {
                    toggleBtn.addEventListener('click', function() {
                        if (sidebar.style.display === 'block') {
                            sidebar.style.display = '';
                        } else {
                            sidebar.style.display = 'block';
                        }
                    });
                }
            });
        </script>
    </body>
</html>

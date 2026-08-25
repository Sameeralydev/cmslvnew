@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $metricCards = [
            // Row 1
            [
                'label' => 'ADMISSION INQUIRY',
                'value' => $stats['admission_inquiries'] ?? 14,
                'subtext' => 'TODAY : <span style="color:#ff0001; font-weight:600;">' . ($stats['inquiry_today'] ?? 0) . '</span> WON : <span style="color:#ff0001; font-weight:600;">' . ($stats['inquiry_won'] ?? 6) . '</span>',
                'img' => 'admission_inquiry.png',
                'colorClass' => 'db-red',
                'url' => route('admin.adm.enquiries.index', absolute: false),
            ],
            [
                'label' => 'REGISTRATION',
                'value' => $stats['registrations'] ?? 0,
                'subtext' => 'SELF : <span style="color:#000000; font-weight:600;">' . ($stats['regd_self'] ?? 0) . '</span> ONLINE : <span style="color:#000000; font-weight:600;">' . ($stats['regd_online'] ?? 0) . '</span>',
                'img' => 'student_regd.png',
                'colorClass' => 'db-black',
                'url' => route('admin.adm.student-registrations.index', absolute: false),
            ],
            [
                'label' => 'ADMISSION',
                'value' => $stats['admissions'] ?? 1,
                'subtext' => 'TODAY : <span style="color:#009e49; font-weight:600;">' . ($stats['admission_today'] ?? 0) . '</span> LEAVING...',
                'img' => 'admission.png',
                'colorClass' => 'db-green',
                'url' => route('admin.adm.students.index', absolute: false),
            ],
            [
                'label' => 'STUDENTS',
                'value' => $stats['students'] ?? 1,
                'subtext' => 'P : <span style="color:#ff8c00; font-weight:600;">0</span> A : <span style="color:#ff8c00; font-weight:600;">0</span> L : <span style="color:#ff8c00; font-weight:600;">0</span>',
                'img' => 'students.png',
                'colorClass' => 'db-orange',
                'url' => route('admin.adm.students.index', absolute: false),
            ],
            // Row 2
            [
                'label' => 'ADMIN STAFF',
                'value' => $stats['admin_staff'] ?? 0,
                'subtext' => 'P : <span style="color:#ec008c; font-weight:600;">0</span> A : <span style="color:#ec008c; font-weight:600;">0</span> L : <span style="color:#ec008c; font-weight:600;">0</span>',
                'img' => 'admindb.png',
                'colorClass' => 'db-teal',
                'url' => route('admin.hrms.staff.index', absolute: false),
            ],
            [
                'label' => 'TEACHING STAFF',
                'value' => $stats['teaching_staff'] ?? 1,
                'subtext' => 'P : <span style="color:#27404d; font-weight:600;">0</span> A : <span style="color:#27404d; font-weight:600;">0</span> L : <span style="color:#27404d; font-weight:600;">0</span>',
                'img' => 'staff.png',
                'colorClass' => 'db-grey',
                'url' => route('admin.academics.teachers.index', absolute: false),
            ],
            [
                'label' => 'ALLIED STAFF',
                'value' => $stats['allied_staff'] ?? 0,
                'subtext' => 'P : <span style="color:#94ac02; font-weight:600;">0</span> A : <span style="color:#94ac02; font-weight:600;">0</span> L : <span style="color:#94ac02; font-weight:600;">0</span>',
                'img' => 'staff-a.png',
                'colorClass' => 'db-barf',
                'url' => route('admin.hrms.staff.index', absolute: false),
            ],
            [
                'label' => 'FAMILIES',
                'value' => $stats['families'] ?? 1,
                'subtext' => '',
                'img' => 'family.png',
                'colorClass' => 'db-carmine',
                'url' => route('admin.adm.siblings.index', absolute: false),
            ],
            // Row 3
            [
                'label' => 'COMPLAIN',
                'value' => $stats['complaints'] ?? 0,
                'subtext' => 'TODAY : <span style="color:#68217a; font-weight:600;">' . ($stats['complaints_today'] ?? 0) . '</span>',
                'img' => 'complaint.png',
                'colorClass' => 'db-purple',
                'url' => route('admin.adm.complaints.index', absolute: false),
            ],
            [
                'label' => 'VISITORS',
                'value' => $stats['visitors'] ?? 0,
                'subtext' => 'TODAY : <span style="color:#7f5112; font-weight:600;">0</span>',
                'img' => 'visitor.png',
                'colorClass' => 'db-brown',
                'url' => route('admin.adm.visitor-purposes.index', absolute: false),
            ],
            [
                'label' => 'PURCHASE',
                'value' => $stats['purchases'] ?? 0,
                'subtext' => 'TODAY : <span style="color:#f25022; font-weight:600;">0</span>',
                'img' => 'purchase.png',
                'colorClass' => 'db-netmeg',
                'url' => route('admin.account.purchases.index', absolute: false),
            ],
            [
                'label' => 'SALES',
                'value' => $stats['sales'] ?? 0,
                'subtext' => 'TODAY : <span style="color:#00b400; font-weight:600;">0</span>',
                'img' => 'sales.png',
                'colorClass' => 'db-partsale',
                'url' => route('admin.account.sales.index', absolute: false),
            ],
        ];

        $monthYear = $currentMonthYear ?? date('M Y');
    @endphp

    @push('styles')
    <style>
        /* Exact CodeIgniter / TNT Theme Styling */
        .dashboard-container {
            background: #ffffff;
            border: 1px solid #d4d4d4;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        /* Top Module Tabs Bar */
        .dashboard-top-tabs {
            background: #fdfdfd;
            border-bottom: 2px solid #f39c12;
            padding: 10px 14px 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .dash-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 16px;
            font-size: 12.5px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid #dcdcdc;
            background: #ffffff;
            color: #333333;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .dash-tab-btn:hover {
            background: #24448d !important;
            color: #ffffff !important;
            border-color: #24448d !important;
            box-shadow: 0 3px 8px rgba(36, 68, 141, 0.3) !important;
            transform: translateY(-1px);
        }

        .dash-tab-btn:hover i {
            color: #ffffff !important;
        }

        .dash-tab-btn.is-active {
            background: #24448d !important;
            color: #ffffff !important;
            border-color: #24448d !important;
            box-shadow: 0 2px 5px rgba(36, 68, 141, 0.35) !important;
        }

        .dash-tab-btn.is-active i {
            color: #ffffff !important;
        }

        /* Main Dashboard Grid */
        .dash-main-row {
            display: grid;
            grid-template-columns: minmax(0, 8fr) minmax(280px, 4fr);
            gap: 12px;
            padding: 12px;
        }

        /* 12 Info Boxes Layout (4 cols x 3 rows) */
        .info-boxes-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .info-box-item {
            display: block;
            min-height: 68px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            padding: 6px 10px;
        }

        .info-box-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 14px rgba(0,0,0,0.09);
        }

        .info-box-flex {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            height: 100%;
        }

        .info-box-icon-wrap {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-box-icon-wrap img {
            max-width: 30px;
            max-height: 30px;
            object-fit: contain;
            transition: filter 0.2s ease;
        }

        .info-box-data {
            flex: 1;
            min-width: 0;
        }

        .info-box-title {
            display: block;
            font-size: 9.5px;
            font-weight: 600;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
            letter-spacing: -0.1px;
        }

        .info-box-val {
            display: block;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.2;
            margin: 1px 0 2px;
        }

        .info-box-sub {
            display: block;
            font-size: 10px;
            font-weight: 400;
            color: #555555;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        /* Info box Color Themes */
        /* Red: ADMISSION INQUIRY */
        .db-red .info-box-title, .db-red .info-box-val { color: #ff0001; }
        .db-red:hover { background: #ff0001 !important; border-color: #ff0001 !important; }
        .db-red:hover .info-box-title, .db-red:hover .info-box-val, .db-red:hover .info-box-sub { color: #ffffff !important; }
        .db-red:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Black: REGISTRATION */
        .db-black .info-box-title, .db-black .info-box-val { color: #000000; }
        .db-black:hover { background: #000000 !important; border-color: #000000 !important; }
        .db-black:hover .info-box-title, .db-black:hover .info-box-val, .db-black:hover .info-box-sub { color: #ffffff !important; }
        .db-black:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Green: ADMISSION */
        .db-green .info-box-title, .db-green .info-box-val { color: #009e49; }
        .db-green:hover { background: #009e49 !important; border-color: #009e49 !important; }
        .db-green:hover .info-box-title, .db-green:hover .info-box-val, .db-green:hover .info-box-sub { color: #ffffff !important; }
        .db-green:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Orange: STUDENTS */
        .db-orange .info-box-title, .db-orange .info-box-val { color: #ff8c00; }
        .db-orange:hover { background: #ff8c00 !important; border-color: #ff8c00 !important; }
        .db-orange:hover .info-box-title, .db-orange:hover .info-box-val, .db-orange:hover .info-box-sub { color: #ffffff !important; }
        .db-orange:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Magenta / Pink: ADMIN STAFF */
        .db-teal .info-box-title, .db-teal .info-box-val { color: #ec008c; }
        .db-teal:hover { background: #ec008c !important; border-color: #ec008c !important; }
        .db-teal:hover .info-box-title, .db-teal:hover .info-box-val, .db-teal:hover .info-box-sub { color: #ffffff !important; }
        .db-teal:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Charcoal: TEACHING STAFF */
        .db-grey .info-box-title, .db-grey .info-box-val { color: #27404d; }
        .db-grey:hover { background: #27404d !important; border-color: #27404d !important; }
        .db-grey:hover .info-box-title, .db-grey:hover .info-box-val, .db-grey:hover .info-box-sub { color: #ffffff !important; }
        .db-grey:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Olive: ALLIED STAFF */
        .db-barf .info-box-title, .db-barf .info-box-val { color: #94ac02; }
        .db-barf:hover { background: #94ac02 !important; border-color: #94ac02 !important; }
        .db-barf:hover .info-box-title, .db-barf:hover .info-box-val, .db-barf:hover .info-box-sub { color: #ffffff !important; }
        .db-barf:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Light Blue: FAMILIES */
        .db-carmine .info-box-title, .db-carmine .info-box-val { color: #00a4ef; }
        .db-carmine:hover { background: #00a4ef !important; border-color: #00a4ef !important; }
        .db-carmine:hover .info-box-title, .db-carmine:hover .info-box-val, .db-carmine:hover .info-box-sub { color: #ffffff !important; }
        .db-carmine:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Purple: COMPLAIN */
        .db-purple .info-box-title, .db-purple .info-box-val { color: #68217a; }
        .db-purple:hover { background: #68217a !important; border-color: #68217a !important; }
        .db-purple:hover .info-box-title, .db-purple:hover .info-box-val, .db-purple:hover .info-box-sub { color: #ffffff !important; }
        .db-purple:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Brown: VISITORS */
        .db-brown .info-box-title, .db-brown .info-box-val { color: #7f5112; }
        .db-brown:hover { background: #7f5112 !important; border-color: #7f5112 !important; }
        .db-brown:hover .info-box-title, .db-brown:hover .info-box-val, .db-brown:hover .info-box-sub { color: #ffffff !important; }
        .db-brown:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Red-Orange: PURCHASE */
        .db-netmeg .info-box-title, .db-netmeg .info-box-val { color: #f25022; }
        .db-netmeg:hover { background: #f25022 !important; border-color: #f25022 !important; }
        .db-netmeg:hover .info-box-title, .db-netmeg:hover .info-box-val, .db-netmeg:hover .info-box-sub { color: #ffffff !important; }
        .db-netmeg:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Green: SALES */
        .db-partsale .info-box-title, .db-partsale .info-box-val { color: #00b400; }
        .db-partsale:hover { background: #00b400 !important; border-color: #00b400 !important; }
        .db-partsale:hover .info-box-title, .db-partsale:hover .info-box-val, .db-partsale:hover .info-box-sub { color: #ffffff !important; }
        .db-partsale:hover .info-box-icon-wrap img { filter: brightness(0) invert(1); }

        /* Donut Chart Cards (Right Side) */
        .donut-cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            height: 100%;
        }

        .donut-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 10px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .donut-canvas-container {
            width: 95px;
            height: 95px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2px auto 6px;
        }

        .donut-stats-list {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .donut-stat-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11.5px;
            font-weight: 400;
            color: #333333;
        }

        .donut-stat-label {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .donut-stat-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 18px;
            padding: 0 4px;
            border: 1px solid #d0d7de;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 500;
            background: #ffffff;
        }

        /* Bottom 4 Panels */
        .dash-bottom-panels {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            padding: 0 12px 14px;
        }

        .panel-blue-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .panel-blue-header {
            background: #24448d;
            color: #ffffff;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .panel-blue-body {
            padding: 8px 10px 10px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .progress-stat-item {
            display: flex;
            flex-direction: column;
            gap: 3px;
            padding-bottom: 4px;
            border-bottom: 1px solid #f8fafc;
        }

        .progress-stat-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .progress-stat-labels {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            font-weight: 400;
            color: #333333;
        }

        .progress-stat-bar-bg {
            height: 4px;
            background: #f1f5f9;
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-stat-bar-fill {
            height: 100%;
            border-radius: 2px;
        }

        /* 2-Column Dashboard Chart Rows (8 cols + 4 cols) */
        .dash-chart-row {
            display: grid;
            grid-template-columns: minmax(0, 8fr) minmax(280px, 4fr);
            gap: 12px;
            margin-bottom: 14px;
        }

        .chart-subhead {
            text-align: center;
            color: #333333;
            font-size: 11.5px;
            font-weight: 500;
            padding: 4px 0 8px;
            letter-spacing: 0.1px;
        }

        .chart-canvas-wrap {
            position: relative;
            height: 200px;
            width: 100%;
        }

        /* Fee Overview Styles (Exact Match to Screenshot) */
        .fee-overview-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 2px 0 6px;
        }

        .fee-overview-row {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .fee-overview-labels {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11.5px;
            font-weight: 500;
            color: #333333;
            text-transform: uppercase;
        }

        .fee-overview-pct {
            color: #0088cc;
            font-weight: 500;
            font-size: 11.5px;
            text-decoration: none;
        }

        .fee-overview-pct:hover {
            text-decoration: underline;
        }

        .fee-bar-bg {
            height: 8px;
            background: #eef2f5;
            border-radius: 4px;
            overflow: hidden;
        }

        .fee-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.6s ease;
        }

        /* Calendar Styles (Exact Match to Screenshot) */
        .dash-calendar-row {
            margin-bottom: 14px;
        }

        .calendar-toolbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            padding: 10px 14px;
            gap: 10px;
            border-bottom: 1px solid #dde4eb;
            background: #ffffff;
        }

        .cal-btn-group {
            display: inline-flex;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid #374151;
        }

        .cal-btn {
            background: #4b5563;
            color: #ffffff;
            border: none;
            border-right: 1px solid #374151;
            padding: 5px 14px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
            text-decoration: none;
        }

        .cal-btn:last-child {
            border-right: none;
        }

        .cal-btn:hover {
            background: #374151;
            color: #ffffff;
        }

        .cal-btn.is-active {
            background: #111827 !important;
            color: #ffffff !important;
        }

        .calendar-title-text {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }

        .calendar-grid-wrap {
            max-height: 480px;
            overflow-y: auto;
            overflow-x: auto;
            border-top: 1px solid #dde4eb;
            [scrollbar-width:thin];
        }

        .calendar-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
            min-width: 650px;
        }

        .calendar-table th {
            border: 1px solid #e5e7eb;
            padding: 8px 6px;
            background: #ffffff;
            font-weight: 600;
            text-align: center;
            color: #374151;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .calendar-table td {
            border: 1px solid #e5e7eb;
            height: 24px;
            vertical-align: top;
            padding: 0 4px;
        }

        .calendar-table .time-col {
            width: 60px;
            text-align: right;
            padding-right: 8px;
            color: #6b7280;
            font-size: 11px;
            font-weight: 600;
            border-right: 1px solid #d1d5db;
            background: #ffffff;
            position: sticky;
            left: 0;
            z-index: 1;
        }

        .calendar-table .today-col {
            background-color: #fef9e7;
        }

        /* Modules 5-Column Grid Styles (Exact Match to User Screenshot) */
        .modules-5col-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
            align-items: start;
        }

        .module-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .module-col-title {
            margin: 0 0 4px 0;
            font-size: 16px;
            font-weight: 700;
            color: #222222;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .module-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 8px;
        }

        .module-group-header {
            background: #24448d;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 10px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            user-select: none;
        }

        .module-group-header i {
            transition: color 0.25s ease, transform 0.25s ease;
        }

        .module-group-header:hover,
        .module-group-header.is-active {
            background: #505050 !important;
            color: #f39c12 !important;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25) !important;
            transform: translateY(-1px);
        }

        .module-group-header:hover i,
        .module-group-header.is-active i {
            color: #f39c12 !important;
            transform: scale(1.08);
        }

        .module-subnav {
            list-style: none;
            margin: 0;
            padding: 0 0 0 6px;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .module-subnav li {
            margin: 0;
            padding: 0;
        }

        .module-subnav li a {
            color: #333333;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 4px;
            border-radius: 3px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .module-subnav li a:hover {
            color: #24448d;
            font-weight: 600;
            transform: translateX(4px);
            background: rgba(36, 68, 141, 0.06);
        }

        .reports-4col-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            align-items: start;
        }

        /* CMS & LMS Cards Grid (Exact Match to User Screenshot) */
        .cms-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            align-items: start;
        }

        .cms-card-box {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 72px;
            padding: 10px 14px;
            background: #ffffff;
            border: 2px solid #000000;
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.15s ease;
        }

        .cms-card-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            border-color: #24448d;
        }

        .cms-card-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cms-card-icon img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .cms-card-content {
            flex: 1;
            padding-top: 1px;
        }

        .cms-card-title {
            font-size: 13px;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: block;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1200px) {
            .dash-main-row {
                grid-template-columns: 1fr;
            }
            .dash-bottom-panels {
                grid-template-columns: repeat(2, 1fr);
            }
            .modules-5col-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .reports-4col-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .cms-cards-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .info-boxes-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .dash-bottom-panels {
                grid-template-columns: 1fr;
            }
            .donut-cards-grid {
                grid-template-columns: 1fr;
            }
            .modules-5col-grid,
            .reports-4col-grid,
            .cms-cards-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .info-boxes-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @endpush

    @if (request('section') === 'settings')
        {{-- SYSTEM SETTINGS CANVAS (Exact Match to User Screenshot) --}}
        <div class="min-h-[calc(100vh-140px)] w-full"></div>
    @else
        <div class="dashboard-container">
            {{-- Top Tabs Navigation (Exact Pill Buttons from Screenshot) --}}
            <div class="dashboard-top-tabs">
                <button type="button" class="dash-tab-btn is-active" onclick="switchDashboardTab('tab-dashboard', this)">
                    <i class="fa fa-television"></i>
                    <span>DASHBOARD</span>
                </button>
                <button type="button" class="dash-tab-btn" onclick="switchDashboardTab('tab-modules', this)">
                    <i class="fa fa-cubes"></i>
                    <span>MODULES</span>
                </button>
                <button type="button" class="dash-tab-btn" onclick="switchDashboardTab('tab-reports', this)">
                    <i class="fa fa-bar-chart"></i>
                    <span>REPORTS</span>
                </button>
                <button type="button" class="dash-tab-btn" onclick="switchDashboardTab('tab-cms', this)">
                    <i class="fa fa-building"></i>
                    <span>CMS</span>
                </button>
                <button type="button" class="dash-tab-btn" onclick="switchDashboardTab('tab-lms', this)">
                    <i class="fa fa-book"></i>
                    <span>LMS</span>
                </button>
                <a href="{{ route('admin.dashboard', ['section' => 'settings'], absolute: false) }}" class="dash-tab-btn">
                    <i class="fa fa-gears"></i>
                    <span>SYSTEM SETTINGS</span>
                </a>
            </div>

            {{-- TAB CONTENT 1: MAIN DASHBOARD (Exact Match to Screenshot) --}}
            <div id="tab-dashboard" class="dash-tab-pane">
            <div class="dash-main-row">
                {{-- Left 8 Columns: 12 Info Boxes in 3 Rows x 4 Cols --}}
                <div>
                    <div class="info-boxes-grid">
                        @foreach ($metricCards as $card)
                            <a href="{{ $card['url'] }}" class="info-box-item {{ $card['colorClass'] }}">
                                <div class="info-box-flex">
                                    <div class="info-box-icon-wrap">
                                        <img src="{{ asset('assets/images/db/' . $card['img']) }}" alt="{{ $card['label'] }}" />
                                    </div>
                                    <div class="info-box-data">
                                        <span class="info-box-title">{{ $card['label'] }}</span>
                                        <span class="info-box-val">{{ $card['value'] }}</span>
                                        <span class="info-box-sub">{!! $card['subtext'] ?: '&nbsp;' !!}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Right 4 Columns: 2 Donut Charts (Students & Staff) --}}
                <div>
                    <div class="donut-cards-grid">
                        {{-- Student Donut Card --}}
                        <div class="donut-card">
                            <div class="donut-canvas-container">
                                <canvas id="donutChartstudent" width="100" height="100"></canvas>
                            </div>
                            <div class="donut-stats-list">
                                <div class="donut-stat-row">
                                    <span class="donut-stat-label" style="color: #00a65a;">
                                        <i class="fa fa-user"></i> Students
                                    </span>
                                    <span class="donut-stat-badge" style="color: #00a65a; border-color: #00a65a;">
                                        {{ $stats['students'] ?? 1 }}
                                    </span>
                                </div>
                                <div class="donut-stat-row">
                                    <span class="donut-stat-label" style="color: #00a4ef;">
                                        <i class="fa fa-male"></i> Boys
                                    </span>
                                    <span class="donut-stat-badge" style="color: #00a4ef; border-color: #00a4ef;">
                                        {{ $stats['male_students'] ?? 1 }}
                                    </span>
                                </div>
                                <div class="donut-stat-row">
                                    <span class="donut-stat-label" style="color: #ec008c;">
                                        <i class="fa fa-female"></i> Girls
                                    </span>
                                    <span class="donut-stat-badge" style="color: #ec008c; border-color: #ec008c;">
                                        {{ $stats['female_students'] ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Staff Donut Card --}}
                        <div class="donut-card">
                            <div class="donut-canvas-container">
                                <canvas id="donutChartTeacher" width="100" height="100"></canvas>
                            </div>
                            <div class="donut-stats-list">
                                <div class="donut-stat-row">
                                    <span class="donut-stat-label" style="color: #00a65a;">
                                        <i class="fa fa-user"></i> Staff
                                    </span>
                                    <span class="donut-stat-badge" style="color: #00a65a; border-color: #00a65a;">
                                        {{ $stats['staff'] ?? 2 }}
                                    </span>
                                </div>
                                <div class="donut-stat-row">
                                    <span class="donut-stat-label" style="color: #00a4ef;">
                                        <i class="fa fa-male"></i> Male
                                    </span>
                                    <span class="donut-stat-badge" style="color: #00a4ef; border-color: #00a4ef;">
                                        {{ $stats['male_staff'] ?? 1 }}
                                    </span>
                                </div>
                                <div class="donut-stat-row">
                                    <span class="donut-stat-label" style="color: #ec008c;">
                                        <i class="fa fa-female"></i> Female
                                    </span>
                                    <span class="donut-stat-badge" style="color: #ec008c; border-color: #ec008c;">
                                        {{ $stats['female_staff'] ?? 1 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ROW 2: 3 Attendance/Enquiry Panels (Left 8 Cols) + Complains (Right 4 Cols) --}}
            <div class="dash-chart-row" style="margin-bottom: 14px; padding: 0 12px;">
                {{-- Left 8 Columns: 3 Attendance/Enquiry Panels side-by-side --}}
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                    {{-- Panel 1: Admission Enquiry For Aug 2026 --}}
                    <div class="panel-blue-box" style="margin-bottom: 0;">
                        <div class="panel-blue-header">
                            Admission Enquiry For {{ $monthYear }}
                        </div>
                        <div class="panel-blue-body">
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>0 ACTIVE</span>
                                    <span>0%</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #dd4b39;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>0 WON</span>
                                    <span>0%</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #f39c12;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>0 PASSIVE</span>
                                    <span>0%</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #f39c12;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>0 LOST</span>
                                    <span>0%</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #f39c12;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>0 DEAD</span>
                                    <span>0%</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #f39c12;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Panel 2: Student Today Attendance --}}
                    <div class="panel-blue-box" style="margin-bottom: 0;">
                        <div class="panel-blue-header">
                            Student Today Attendance
                        </div>
                        <div class="panel-blue-body">
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>PRESENT</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #00a65a;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>ABSENT</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #dd4b39;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>LEAVE</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #b41600;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>LATE</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #00c0ef;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>HALF DAY</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #f39c12;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Panel 3: Staff Today Attendance --}}
                    <div class="panel-blue-box" style="margin-bottom: 0;">
                        <div class="panel-blue-header">
                            Staff Today Attendance
                        </div>
                        <div class="panel-blue-body">
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>PRESENT</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #00a65a;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>RED LEAVE</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #ff0000;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>BLUE LEAVE</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #0000ff;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>GREEN LEAVE</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #008000;"></div>
                                </div>
                            </div>
                            <div class="progress-stat-item">
                                <div class="progress-stat-labels">
                                    <span>LATE</span>
                                    <span>0</span>
                                </div>
                                <div class="progress-stat-bar-bg">
                                    <div class="progress-stat-bar-fill" style="width: 0%; background: #f39c12;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right 4 Columns: Complains Box --}}
                <div>
                    <div class="panel-blue-box" style="height: 100%; display: flex; flex-direction: column; margin-bottom: 0;">
                        <div class="panel-blue-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <span>Complains For {{ $monthYear }}</span>
                            <span style="font-size: 10px; font-weight: 500; margin-left: auto; white-space: nowrap;">
                                Today : {{ $stats['complaints_today'] ?? 0 }} / Total : {{ $stats['complaints'] ?? 0 }} / Solved : {{ $stats['complaints_solved'] ?? 0 }}
                            </span>
                        </div>
                        <div class="panel-blue-body" style="flex: 1; display: flex; align-items: center; justify-content: center; min-height: 140px;">
                            <p style="font-size: 12px; color: #999; margin: 0; text-align: center;">No complaints found for current month.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ROW 3: Fees Collection Statistics (8 Cols) & Fee Overview (4 Cols) --}}
            <div class="dash-chart-row">
                {{-- Fees Collection Statistics --}}
                <div class="panel-blue-box" style="margin-bottom: 0;">
                    <div class="panel-blue-header">
                        <span>Fees Collection Statistics For - {{ $monthYear }}</span>
                    </div>
                    <div class="panel-blue-body" style="padding: 12px 14px 10px;">
                        <div class="chart-subhead">
                            RECEIVABLE: {{ $feeOverview['total_amount'] ?? 26000 }} / COLLECTION: {{ $feeOverview['paid_amount'] ?? 2000 }} / WAIVE OFF: {{ $feeOverview['waive_off'] ?? 0 }} / BALANCE: {{ $feeOverview['balance'] ?? 24000 }} / TODAY COLLECTION: {{ $feeOverview['today_collection'] ?? 0 }}
                        </div>
                        <div class="chart-canvas-wrap">
                            <canvas id="feecollectionChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Fee Overview --}}
                <div class="panel-blue-box" style="margin-bottom: 0;">
                    <div class="panel-blue-header">
                        <span>Fee Overview</span>
                    </div>
                    <div class="panel-blue-body" style="padding: 14px 16px;">
                        <div class="fee-overview-list">
                            {{-- PAID --}}
                            <div class="fee-overview-row">
                                <div class="fee-overview-labels">
                                    <span>{{ $feeOverview['paid_count'] ?? 1 }} PAID</span>
                                    <a href="{{ route('admin.account.student-fees.index', absolute: false) }}" class="fee-overview-pct">{{ $feeOverview['paid_percent'] ?? 50 }}%</a>
                                </div>
                                <div class="fee-bar-bg">
                                    <div class="fee-bar-fill" style="width: {{ $feeOverview['paid_percent'] ?? 50 }}%; background: #28a745;"></div>
                                </div>
                            </div>

                            {{-- UN PAID --}}
                            <div class="fee-overview-row">
                                <div class="fee-overview-labels">
                                    <span>{{ $feeOverview['unpaid_count'] ?? 1 }} UN PAID</span>
                                    <span class="fee-overview-pct">{{ $feeOverview['unpaid_percent'] ?? 50 }}%</span>
                                </div>
                                <div class="fee-bar-bg">
                                    <div class="fee-bar-fill" style="width: {{ $feeOverview['unpaid_percent'] ?? 50 }}%; background: #007bff;"></div>
                                </div>
                            </div>

                            {{-- CONCESSION --}}
                            <div class="fee-overview-row">
                                <div class="fee-overview-labels">
                                    <span>{{ $feeOverview['concession_count'] ?? 0 }} CONCESSION</span>
                                    <span class="fee-overview-pct">{{ $feeOverview['concession_percent'] ?? 0 }}%</span>
                                </div>
                                <div class="fee-bar-bg">
                                    <div class="fee-bar-fill" style="width: {{ $feeOverview['concession_percent'] ?? 0 }}%; background: #ffc107;"></div>
                                </div>
                            </div>

                            {{-- FREE --}}
                            <div class="fee-overview-row">
                                <div class="fee-overview-labels">
                                    <span>{{ $feeOverview['free_count'] ?? 0 }} FREE</span>
                                    <a href="{{ route('admin.account.student-fees.index', absolute: false) }}" class="fee-overview-pct">{{ $feeOverview['free_percent'] ?? 0 }}%</a>
                                </div>
                                <div class="fee-bar-bg">
                                    <div class="fee-bar-fill" style="width: {{ $feeOverview['free_percent'] ?? 0 }}%; background: #f95d9b;"></div>
                                </div>
                            </div>

                            {{-- DEFAULTER --}}
                            <div class="fee-overview-row">
                                <div class="fee-overview-labels">
                                    <span>{{ $feeOverview['defaulter_count'] ?? 1 }} DEFAULTER</span>
                                    <a href="{{ route('admin.account.student-fees.index', absolute: false) }}" class="fee-overview-pct">{{ $feeOverview['defaulter_percent'] ?? 50 }}%</a>
                                </div>
                                <div class="fee-bar-bg">
                                    <div class="fee-bar-fill" style="width: {{ $feeOverview['defaulter_percent'] ?? 50 }}%; background: #b41600;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ROW 4: Expenses Statistics (8 Cols) & Expenses Category/Card (4 Cols) --}}
            <div class="dash-chart-row">
                {{-- Expenses Bar Chart --}}
                <div class="panel-blue-box" style="margin-bottom: 0;">
                    <div class="panel-blue-header">
                        <span>Expenses For - {{ $fullMonthYear ?? date('F Y') }}</span>
                    </div>
                    <div class="panel-blue-body" style="padding: 12px 14px 10px;">
                        <div class="chart-subhead" style="font-size: 15px;">
                            TOTAL: {{ $expenseStats['total'] ?? 0 }} &nbsp;&nbsp;&nbsp;&nbsp; TODAY: {{ $expenseStats['today'] ?? 0 }}
                        </div>
                        <div class="chart-canvas-wrap">
                            <canvas id="monthexpChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Expenses Category Box --}}
                <div class="panel-blue-box" style="margin-bottom: 0;">
                    <div class="panel-blue-header">
                        <span>Expenses For - {{ $fullMonthYear ?? date('F Y') }}</span>
                        <span style="cursor: pointer;"><i class="fa fa-minus"></i></span>
                    </div>
                    <div class="panel-blue-body" style="padding: 14px 16px; min-height: 236px; display: flex; align-items: center; justify-content: center;">
                        <div class="chart-canvas-wrap" style="height: 180px;">
                            <canvas id="doughnut-chart-expenses"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ROW 5: Calendar Full Week Agenda View --}}
            <div class="dash-calendar-row">
                <div class="panel-blue-box" style="margin-bottom: 0;">
                    <div class="panel-blue-header">
                        <span>Calendar</span>
                        <span style="cursor: pointer;"><i class="fa fa-minus"></i></span>
                    </div>
                    <div class="panel-blue-body" style="padding: 0;">
                        {{-- Calendar Toolbar --}}
                        <div class="calendar-toolbar">
                            <div class="cal-btn-group">
                                <button type="button" class="cal-btn" onclick="calPrev()"><i class="fa fa-chevron-left"></i></button>
                                <button type="button" class="cal-btn" onclick="calNext()"><i class="fa fa-chevron-right"></i></button>
                                <button type="button" class="cal-btn" onclick="calToday()">Today</button>
                            </div>
                            <div class="calendar-title-text" id="calendarTitle">August 24 – 30 2026</div>
                            <div class="cal-btn-group">
                                <button type="button" class="cal-btn" onclick="setCalView('month', this)">Month</button>
                                <button type="button" class="cal-btn is-active" onclick="setCalView('week', this)">Week</button>
                                <button type="button" class="cal-btn" onclick="setCalView('day', this)">Day</button>
                            </div>
                        </div>

                        {{-- Week Agenda Table --}}
                        <div class="calendar-grid-wrap">
                            <table class="calendar-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;"></th>
                                        <th>Mon 8/24</th>
                                        <th class="today-col" style="background-color: #fef9e7;">Tue 8/25</th>
                                        <th>Wed 8/26</th>
                                        <th>Thu 8/27</th>
                                        <th>Fri 8/28</th>
                                        <th>Sat 8/29</th>
                                        <th>Sun 8/30</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="time-col">all-day</td>
                                        <td></td><td class="today-col"></td><td></td><td></td><td></td><td></td><td></td>
                                    </tr>
                                    @php
                                        $hours = ['12am', '1am', '2am', '3am', '4am', '5am', '6am', '7am', '8am', '9am', '10am', '11am', '12pm', '1pm', '2pm', '3pm', '4pm', '5pm', '6pm', '7pm', '8pm', '9pm', '10pm', '11pm'];
                                    @endphp
                                    @foreach ($hours as $hour)
                                        <tr>
                                            <td class="time-col">{{ $hour }}</td>
                                            <td></td>
                                            <td class="today-col"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB CONTENT 2: MODULES (Exact Match to User Screenshot) --}}
        <div id="tab-modules" class="dash-tab-pane" style="display: none; padding: 16px 20px 30px;">
            <div class="modules-5col-grid">
                {{-- Column 1: HRMS --}}
                <div class="module-column">
                    <h4 class="module-col-title"><i class="fa fa-users"></i> HRMS</h4>
                    
                    {{-- Manual Support Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-life-ring"></i>
                            <span>Manual Support</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.hrms.documents.index', absolute: false) }}">&raquo; Add Documents</a></li>
                            <li><a href="{{ route('admin.hrms.documents.index', absolute: false) }}">&raquo; Policy Manual</a></li>
                            <li><a href="{{ route('admin.hrms.documents.index', absolute: false) }}">&raquo; Flow Charts</a></li>
                            <li><a href="{{ route('admin.hrms.documents.index', absolute: false) }}">&raquo; Supportive Documents</a></li>
                            <li><a href="{{ route('admin.hrms.documents.index', absolute: false) }}">&raquo; Registers</a></li>
                            <li><a href="{{ route('admin.hrms.documents.index', absolute: false) }}">&raquo; Video Supports</a></li>
                        </ul>
                    </div>

                    {{-- Staff Recruitment Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-users"></i>
                            <span>Staff Recruitment</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.hrms.staff.index', absolute: false) }}">&raquo; Staff Demand</a></li>
                            <li><a href="{{ route('admin.hrms.staff.index', absolute: false) }}">&raquo; Job Post</a></li>
                            <li><a href="{{ route('admin.hrms.staff.index', absolute: false) }}">&raquo; Job Application</a></li>
                            <li><a href="{{ route('admin.hrms.staff.index', absolute: false) }}">&raquo; Short Listed Candidates</a></li>
                            <li><a href="{{ route('admin.hrms.staff.index', absolute: false) }}">&raquo; Written Test</a></li>
                            <li><a href="{{ route('admin.hrms.staff.index', absolute: false) }}">&raquo; Interview Call</a></li>
                            <li><a href="{{ route('admin.hrms.staff.index', absolute: false) }}">&raquo; Interview Rating</a></li>
                            <li><a href="{{ route('admin.hrms.staff.index', absolute: false) }}">&raquo; Job Letter</a></li>
                            <li><a href="{{ route('admin.hrms.staff.index', absolute: false) }}">&raquo; Staff Directory</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Column 2: Administration --}}
                <div class="module-column">
                    <h4 class="module-col-title"><i class="fa fa-user-plus"></i> Administration</h4>
                    
                    {{-- Manual Support Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-life-ring"></i>
                            <span>Manual Support</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.adm.documents.index', absolute: false) }}">&raquo; Add Documents</a></li>
                            <li><a href="{{ route('admin.adm.documents.index', absolute: false) }}">&raquo; Policy Manual</a></li>
                            <li><a href="{{ route('admin.adm.documents.index', absolute: false) }}">&raquo; Flow Charts</a></li>
                            <li><a href="{{ route('admin.adm.documents.index', absolute: false) }}">&raquo; Supportive Documents</a></li>
                            <li><a href="{{ route('admin.adm.documents.index', absolute: false) }}">&raquo; Registers</a></li>
                            <li><a href="{{ route('admin.adm.documents.index', absolute: false) }}">&raquo; Video Supports</a></li>
                        </ul>
                    </div>

                    {{-- Internal & External Commn Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-commenting"></i>
                            <span>Internal & External Commn</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.adm.visitor-purposes.index', absolute: false) }}">&raquo; Setup Front Desk</a></li>
                            <li><a href="{{ route('admin.adm.mail-sms.index', absolute: false) }}">&raquo; Official Circulars</a></li>
                            <li><a href="{{ route('admin.adm.mail-sms.index', absolute: false) }}">&raquo; Office Orders</a></li>
                            <li><a href="{{ route('admin.adm.mail-sms.index', absolute: false) }}">&raquo; Incoming Mails</a></li>
                            <li><a href="{{ route('admin.adm.mail-sms.index', absolute: false) }}">&raquo; Outgoing Mails</a></li>
                            <li><a href="{{ route('admin.adm.documents.index', absolute: false) }}">&raquo; Documents Flow Records</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Column 3: Academics --}}
                <div class="module-column">
                    <h4 class="module-col-title"><i class="fa fa-book"></i> Academics</h4>
                    
                    {{-- Manual Support Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-life-ring"></i>
                            <span>Manual Support</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.academics.documents.index', absolute: false) }}">&raquo; Add Documents</a></li>
                            <li><a href="{{ route('admin.academics.documents.index', absolute: false) }}">&raquo; Policy Manual</a></li>
                            <li><a href="{{ route('admin.academics.documents.index', absolute: false) }}">&raquo; Flow Charts</a></li>
                            <li><a href="{{ route('admin.academics.documents.index', absolute: false) }}">&raquo; Supportive Documents</a></li>
                            <li><a href="{{ route('admin.academics.documents.index', absolute: false) }}">&raquo; Registers</a></li>
                            <li><a href="{{ route('admin.academics.documents.index', absolute: false) }}">&raquo; Video Supports</a></li>
                        </ul>
                    </div>

                    {{-- Curriculum Mgmt. Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-th-list"></i>
                            <span>Curriculum Mgmt.</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.academics.subjects.index', absolute: false) }}">&raquo; Subjects</a></li>
                            <li><a href="{{ route('admin.academics.subject-groups.index', absolute: false) }}">&raquo; Subjects Group</a></li>
                            <li><a href="{{ route('admin.academics.chapters.index', absolute: false) }}">&raquo; Chapter</a></li>
                            <li><a href="{{ route('admin.academics.topics.index', absolute: false) }}">&raquo; Topic</a></li>
                            <li><a href="{{ route('admin.academics.domain-modules.index', absolute: false) }}">&raquo; Modules</a></li>
                            <li><a href="{{ route('admin.academics.domains.index', absolute: false) }}">&raquo; Domain</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Column 4: Accounts & Finance --}}
                <div class="module-column">
                    <h4 class="module-col-title"><i class="fa fa-money"></i> Accounts &amp; Finance</h4>
                    
                    {{-- Manual Support Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-life-ring"></i>
                            <span>Manual Support</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.account.documents.index', absolute: false) }}">&raquo; Add Documents</a></li>
                            <li><a href="{{ route('admin.account.documents.index', absolute: false) }}">&raquo; Policy Manual</a></li>
                            <li><a href="{{ route('admin.account.documents.index', absolute: false) }}">&raquo; Flow Charts</a></li>
                            <li><a href="{{ route('admin.account.documents.index', absolute: false) }}">&raquo; Supportive Documents</a></li>
                            <li><a href="{{ route('admin.account.documents.index', absolute: false) }}">&raquo; Registers</a></li>
                            <li><a href="{{ route('admin.account.documents.index', absolute: false) }}">&raquo; Video Supports</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Column 5: System Settings --}}
                <div class="module-column">
                    <h4 class="module-col-title"><i class="fa fa-gears"></i> System Settings</h4>
                    
                    {{-- System Settings Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-gears"></i>
                            <span>System Settings</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.system-notification.index', absolute: false) }}">&raquo; General Setting</a></li>
                            <li><a href="{{ route('admin.system-notification.index', absolute: false) }}">&raquo; Branch Settings</a></li>
                            <li><a href="{{ route('admin.system-notification.index', absolute: false) }}">&raquo; Session Settings</a></li>
                            <li><a href="{{ route('admin.system-notification.index', absolute: false) }}">&raquo; Modules Setting</a></li>
                            <li><a href="{{ route('admin.system-notification.index', absolute: false) }}">&raquo; Roles Permissions</a></li>
                            <li><a href="{{ route('admin.frontcms.index', absolute: false) }}">&raquo; Front CMS Setting</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB CONTENT 3: REPORTS (Exact Match to User Screenshot) --}}
        <div id="tab-reports" class="dash-tab-pane" style="display: none; padding: 16px 20px 30px;">
            <div class="reports-4col-grid">
                {{-- Column 1: HRMS --}}
                <div class="module-column">
                    <h4 class="module-col-title"><i class="fa fa-users"></i> HRMS</h4>
                </div>

                {{-- Column 2: Administration --}}
                <div class="module-column">
                    <h4 class="module-col-title"><i class="fa fa-user-plus"></i> Administration</h4>
                    
                    {{-- Student Information Report Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-life-ring"></i>
                            <span>Student Information Report</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.adm.documents.index', absolute: false) }}">&raquo; Add Documents</a></li>
                        </ul>
                    </div>

                    {{-- Attendance Report Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-life-ring"></i>
                            <span>Attendance Report</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.adm.attendance.index', absolute: false) }}">&raquo; Add Documents</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Column 3: Academics --}}
                <div class="module-column">
                    <h4 class="module-col-title"><i class="fa fa-book"></i> Academics</h4>
                </div>

                {{-- Column 4: Accounts & Finance --}}
                <div class="module-column">
                    <h4 class="module-col-title"><i class="fa fa-money"></i> Accounts &amp; Finance</h4>
                    
                    {{-- Fee Report Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-bar-chart"></i>
                            <span>Fee Report</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.account.student-fees.index', absolute: false) }}">&raquo; Fees Report</a></li>
                            <li><a href="{{ route('admin.account.student-fees.index', absolute: false) }}">&raquo; Fees Disc Report</a></li>
                            <li><a href="{{ route('admin.account.student-fees.index', absolute: false) }}">&raquo; Fees Free Report</a></li>
                            <li><a href="{{ route('admin.account.student-fees.index', absolute: false) }}">&raquo; Receivable Fees Report</a></li>
                            <li><a href="{{ route('admin.account.student-fees.index', absolute: false) }}">&raquo; Due Fees Report</a></li>
                            <li><a href="{{ route('admin.account.student-fees.index', absolute: false) }}">&raquo; Collection Details Report</a></li>
                        </ul>
                    </div>

                    {{-- Accounts Report Group --}}
                    <div class="module-group">
                        <div class="module-group-header">
                            <i class="fa fa-bar-chart"></i>
                            <span>Accounts Report</span>
                        </div>
                        <ul class="module-subnav">
                            <li><a href="{{ route('admin.account.accounts.index', absolute: false) }}">&raquo; Opening Trial Balance</a></li>
                            <li><a href="{{ route('admin.account.accounts.index', absolute: false) }}">&raquo; General Ledger Report</a></li>
                            <li><a href="{{ route('admin.account.accounts.index', absolute: false) }}">&raquo; Trial Balance Report</a></li>
                            <li><a href="{{ route('admin.account.accounts.index', absolute: false) }}">&raquo; Trial Balance Report</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB CONTENT 4: CMS (Exact Match to User Screenshot) --}}
        <div id="tab-cms" class="dash-tab-pane" style="display: none; padding: 16px 14px 30px;">
            <div class="cms-cards-grid">
                {{-- HRMS Card --}}
                <a href="{{ route('admin.hrms.dashboard', absolute: false) }}" class="cms-card-box">
                    <div class="cms-card-icon">
                        <img src="{{ asset('assets/images/db/human-resources.png') }}" alt="HRMS" />
                    </div>
                    <div class="cms-card-content">
                        <span class="cms-card-title">HRMS</span>
                    </div>
                </a>

                {{-- ADMINISTRATION Card --}}
                <a href="{{ route('admin.adm.dashboard', absolute: false) }}" class="cms-card-box">
                    <div class="cms-card-icon">
                        <img src="{{ asset('assets/images/db/admin.png') }}" alt="Administration" />
                    </div>
                    <div class="cms-card-content">
                        <span class="cms-card-title">ADMINISTRATION</span>
                    </div>
                </a>

                {{-- ACADEMICS Card --}}
                <a href="{{ route('admin.academics.dashboard', absolute: false) }}" class="cms-card-box">
                    <div class="cms-card-icon">
                        <img src="{{ asset('assets/images/db/education.png') }}" alt="Academics" />
                    </div>
                    <div class="cms-card-content">
                        <span class="cms-card-title">ACADEMICS</span>
                    </div>
                </a>

                {{-- ACCOUNTS & FINANCE Card --}}
                <a href="{{ route('admin.account.accounts.dashboard', absolute: false) }}" class="cms-card-box">
                    <div class="cms-card-icon">
                        <img src="{{ asset('assets/images/db/accounting.png') }}" alt="Accounts & Finance" />
                    </div>
                    <div class="cms-card-content">
                        <span class="cms-card-title">ACCOUNTS &amp; FINANCE</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- TAB CONTENT 5: LMS (Exact Match to User Screenshot & CodeIgniter) --}}
        <div id="tab-lms" class="dash-tab-pane" style="display: none; padding: 16px 14px 30px;">
            <div class="cms-cards-grid">
                {{-- ACADEMICS Card --}}
                <a href="{{ route('admin.academics.dashboard', absolute: false) }}" class="cms-card-box">
                    <div class="cms-card-icon">
                        <img src="{{ asset('assets/images/db/education.png') }}" alt="Academics" />
                    </div>
                    <div class="cms-card-content">
                        <span class="cms-card-title">ACADEMICS</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>
        function switchDashboardTab(tabId, button) {
            // Hide all tab panes
            document.querySelectorAll('.dash-tab-pane').forEach(function(pane) {
                pane.style.display = 'none';
            });
            // Show target tab pane
            var target = document.getElementById(tabId);
            if (target) {
                target.style.display = 'block';
            }
            // Update active state on tab buttons
            document.querySelectorAll('.dash-tab-btn').forEach(function(btn) {
                btn.classList.remove('is-active');
            });
            if (button) {
                button.classList.add('is-active');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Student Donut Chart (Blue Ring)
            var ctxStudent = document.getElementById('donutChartstudent');
            if (ctxStudent) {
                new Chart(ctxStudent, {
                    type: 'doughnut',
                    data: {
                        labels: ['Boys', 'Girls'],
                        datasets: [{
                            data: [{{ $stats['male_students'] ?? 1 }}, {{ $stats['female_students'] ?? 0 }}],
                            backgroundColor: ['#00a4ef', '#ec008c'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        legend: { display: false },
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 1000
                        },
                        cutoutPercentage: 65
                    }
                });
            }

            // Staff Donut Chart (Magenta/Pink Ring)
            var ctxTeacher = document.getElementById('donutChartTeacher');
            if (ctxTeacher) {
                new Chart(ctxTeacher, {
                    type: 'doughnut',
                    data: {
                        labels: ['Male', 'Female'],
                        datasets: [{
                            data: [{{ $stats['male_staff'] ?? 1 }}, {{ $stats['female_staff'] ?? 1 }}],
                            backgroundColor: ['#00a4ef', '#ec008c'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        legend: { display: false },
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 1000
                        },
                        cutoutPercentage: 65
                    }
                });
            }

            // Fee Collection Line Chart
            var ctxFee = document.getElementById('feecollectionChart');
            if (ctxFee) {
                new Chart(ctxFee, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($currentMonthDays ?? ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']) !!},
                        datasets: [{
                            label: "Collection",
                            data: {!! json_encode($daysCollection ?? array_fill(0, 31, 0)) !!},
                            fill: false,
                            borderColor: "#4e73df",
                            backgroundColor: "#4e73df",
                            borderWidth: 2,
                            pointRadius: 3,
                            pointBackgroundColor: "#4e73df",
                            pointBorderColor: "#4e73df",
                            pointHoverRadius: 5,
                            lineTension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { display: false },
                        scales: {
                            xAxes: [{
                                gridLines: { display: false, drawBorder: false },
                                ticks: { fontColor: '#6b7280', fontSize: 11 }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: "rgba(0, 0, 0, 0.05)",
                                    borderDash: [3, 3],
                                    drawBorder: false
                                },
                                ticks: {
                                    min: -1.0,
                                    max: 1.0,
                                    stepSize: 0.5,
                                    fontColor: '#6b7280',
                                    fontSize: 11
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Collection: Rs.' + tooltipItem.yLabel;
                                }
                            }
                        }
                    }
                });
            }

            // Month Expenses Bar Chart
            var ctxExp = document.getElementById('monthexpChart');
            if (ctxExp) {
                new Chart(ctxExp, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($currentMonthDays ?? ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']) !!},
                        datasets: [{
                            label: "Expenses",
                            data: {!! json_encode($daysExpenses ?? array_fill(0, 31, 0)) !!},
                            backgroundColor: "#b41600",
                            borderColor: "#b41600",
                            borderWidth: 1,
                            maxBarThickness: 16
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { display: false },
                        scales: {
                            xAxes: [{
                                gridLines: { display: false, drawBorder: false },
                                ticks: { fontColor: '#6b7280', fontSize: 11 }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: "rgba(0, 0, 0, 0.05)",
                                    borderDash: [3, 3],
                                    drawBorder: false
                                },
                                ticks: {
                                    min: -1.0,
                                    max: 1.0,
                                    stepSize: 0.5,
                                    fontColor: '#6b7280',
                                    fontSize: 11
                                }
                            }]
                        }
                    }
                });
            }

            // Expenses Doughnut Chart
            var ctxExpDoughnut = document.getElementById('doughnut-chart-expenses');
            if (ctxExpDoughnut) {
                new Chart(ctxExpDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: ['General', 'Utilities', 'Maintenance'],
                        datasets: [{
                            data: [0, 0, 0],
                            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: { display: false }
                    }
                });
            }
        });

        function calPrev() {
            var title = document.getElementById('calendarTitle');
            if (title) title.innerText = 'August 17 – 23 2026';
        }
        function calNext() {
            var title = document.getElementById('calendarTitle');
            if (title) title.innerText = 'August 31 – Sep 06 2026';
        }
        function calToday() {
            var title = document.getElementById('calendarTitle');
            if (title) title.innerText = 'August 24 – 30 2026';
        }
        function setCalView(viewType, btn) {
            document.querySelectorAll('.calendar-toolbar .cal-btn').forEach(function(b) {
                if (['Month', 'Week', 'Day'].includes(b.innerText.trim())) {
                    b.classList.remove('is-active');
                }
            });
            if (btn) btn.classList.add('is-active');
        }
    </script>
    @endpush
@endsection

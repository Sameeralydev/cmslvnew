@extends('admin.layouts.app')

@section('title', $module['label'] ?? 'Documents')

@section('content')
    @include('admin.academics.partials.nav')

    @if (($moduleKey ?? '') === 'documents' || request()->is('admin/academics/documents*'))
        <style>
            .doc-page-container {
                padding: 14px 16px 30px;
                background: #f4f6f9;
                min-height: calc(100vh - 120px);
            }

            .doc-main-grid {
                display: grid;
                grid-template-columns: minmax(320px, 4fr) minmax(0, 8fr);
                gap: 16px;
                align-items: start;
            }

            @media (max-width: 992px) {
                .doc-main-grid {
                    grid-template-columns: 1fr;
                }
            }

            .doc-card {
                background: #ffffff;
                border: 1px solid #dde4eb;
                border-radius: 8px;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
                overflow: hidden;
            }

            .doc-card-header {
                padding: 12px 16px;
                border-bottom: 1px solid #eef2f5;
                font-size: 16px;
                font-weight: 700;
                color: #333333;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .doc-card-body {
                padding: 16px;
            }

            .doc-form-group {
                margin-bottom: 14px;
            }

            .doc-label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                color: #333333;
                margin-bottom: 6px;
            }

            .doc-req {
                color: #e53e3e;
                font-weight: bold;
            }

            .doc-select,
            .doc-input,
            .doc-textarea {
                width: 100%;
                border: 1px solid #cbd5e1;
                border-radius: 4px;
                padding: 7px 12px;
                font-size: 13.5px;
                color: #333333;
                background: #ffffff;
                outline: none;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            .doc-select:focus,
            .doc-input:focus,
            .doc-textarea:focus {
                border-color: #24448d;
                box-shadow: 0 0 0 2px rgba(36, 68, 141, 0.15);
            }

            .doc-file-dropzone {
                border: 1px solid #cbd5e1;
                border-radius: 4px;
                padding: 10px 14px;
                text-align: center;
                background: #fafbfc;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                color: #64748b;
                font-size: 13px;
                font-weight: 500;
                position: relative;
            }

            .doc-file-dropzone:hover {
                background: #f1f5f9;
                border-color: #24448d;
                color: #24448d;
            }

            .doc-file-input {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                cursor: pointer;
            }

            .doc-btn-save {
                background: #24448d;
                color: #ffffff;
                border: none;
                border-radius: 4px;
                padding: 7px 24px;
                font-size: 13.5px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .doc-btn-save:hover {
                background: #1a3369;
                transform: translateY(-1px);
                box-shadow: 0 3px 8px rgba(36, 68, 141, 0.3);
            }

            /* Toolbar */
            .doc-toolbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 12px;
            }

            .doc-search-box {
                border: 1px solid #cbd5e1;
                border-radius: 4px;
                padding: 6px 12px;
                font-size: 13px;
                width: 220px;
                outline: none;
            }

            .doc-search-box:focus {
                border-color: #24448d;
            }

            .doc-export-btns {
                display: inline-flex;
                gap: 4px;
            }

            .doc-export-btn {
                background: #24448d;
                color: #ffffff;
                border: none;
                border-radius: 4px;
                width: 32px;
                height: 30px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 13px;
                cursor: pointer;
                transition: background 0.15s ease;
                text-decoration: none;
            }

            .doc-export-btn:hover {
                background: #1a3369;
                color: #ffffff;
            }

            /* Table */
            .doc-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12.5px;
            }

            .doc-table th {
                background: #24448d;
                color: #ffffff;
                font-weight: 700;
                padding: 9px 12px;
                text-align: left;
                border: 1px solid #1a3369;
                letter-spacing: 0.3px;
            }

            .doc-table td {
                padding: 8px 12px;
                border: 1px solid #e2e8f0;
                vertical-align: middle;
                color: #333333;
            }

            .doc-table tr:nth-child(even) {
                background-color: #f8fafc;
            }

            .doc-table tr:hover {
                background-color: #f1f5f9;
            }

            .doc-actions {
                display: inline-flex;
                gap: 4px;
                justify-content: flex-end;
            }

            .doc-act-btn {
                width: 26px;
                height: 26px;
                border-radius: 4px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #ffffff !important;
                font-size: 11px;
                border: none;
                cursor: pointer;
                transition: opacity 0.15s ease, transform 0.15s ease;
                text-decoration: none;
            }

            .doc-act-btn:hover {
                opacity: 0.9;
                transform: scale(1.06);
            }

            .doc-act-view { background: #24448d; }
            .doc-act-download { background: #28a745; }
            .doc-act-edit { background: #24448d; }
            .doc-act-delete { background: #dc3545; }
        </style>

        <div class="doc-page-container">
            <div class="doc-main-grid">
                {{-- LEFT COLUMN: Add Documents Form (Exact Match to Screenshot) --}}
                <div class="doc-card">
                    <div class="doc-card-header">
                        <span>Add Documents</span>
                    </div>
                    <form action="#" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); alert('Document submitted successfully!');">
                        @csrf
                        <div class="doc-card-body">
                            {{-- Documents Type --}}
                            <div class="doc-form-group">
                                <label class="doc-label" for="doc_type">Documents Type <span class="doc-req">*</span></label>
                                <select name="doc_type" id="doc_type" class="doc-select" required>
                                    <option value="">Select</option>
                                    <option value="1">Policy Manual</option>
                                    <option value="2">Flow Charts</option>
                                    <option value="3">Supportive Documents</option>
                                    <option value="4">Registers</option>
                                    <option value="5">Video Supports</option>
                                </select>
                            </div>

                            {{-- Title --}}
                            <div class="doc-form-group">
                                <label class="doc-label" for="title">Title <span class="doc-req">*</span></label>
                                <input type="text" name="title" id="title" class="doc-input" required />
                            </div>

                            {{-- Attach Document --}}
                            <div class="doc-form-group">
                                <label class="doc-label">
                                    Attach Document <span class="doc-req" style="font-size: 11px; font-weight: normal;">(PDF File only OR File Size 1MB) *</span>
                                </label>
                                <div class="doc-file-dropzone">
                                    <i class="fa fa-cloud-upload text-base"></i>
                                    <span id="fileDropText">Drag and drop a file here or click</span>
                                    <input type="file" name="documents" class="doc-file-input" accept=".pdf,.doc,.docx" onchange="updateFileLabel(this)" required />
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="doc-form-group">
                                <label class="doc-label" for="description">Description</label>
                                <textarea name="description" id="description" rows="4" class="doc-textarea"></textarea>
                            </div>

                            {{-- Submit Button --}}
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="doc-btn-save">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- RIGHT COLUMN: Documents List Table (Exact Match to Screenshot) --}}
                <div class="doc-card">
                    <div class="doc-card-header">
                        <span>Documents List</span>
                    </div>
                    <div class="doc-card-body">
                        {{-- Toolbar: Search on Left, 6 Blue Export Buttons on Right --}}
                        <div class="doc-toolbar">
                            <div>
                                <input type="text" id="docSearchInput" class="doc-search-box" placeholder="Search..." onkeyup="filterDocsTable()" />
                            </div>
                            <div class="doc-export-btns">
                                <button type="button" class="doc-export-btn" title="Copy" onclick="copyTableData()"><i class="fa fa-copy"></i></button>
                                <button type="button" class="doc-export-btn" title="Excel"><i class="fa fa-file-excel-o"></i></button>
                                <button type="button" class="doc-export-btn" title="CSV"><i class="fa fa-file-text-o"></i></button>
                                <button type="button" class="doc-export-btn" title="PDF"><i class="fa fa-file-pdf-o"></i></button>
                                <button type="button" class="doc-export-btn" title="Print" onclick="window.print()"><i class="fa fa-print"></i></button>
                                <button type="button" class="doc-export-btn" title="Columns"><i class="fa fa-columns"></i></button>
                            </div>
                        </div>

                        {{-- Table (Solid Blue Header with Title, Documents Type, Action) --}}
                        <div class="overflow-x-auto">
                            <table class="doc-table" id="docsTable">
                                <thead>
                                    <tr>
                                        <th>Title <i class="fa fa-sort-asc text-[10px] ml-1"></i></th>
                                        <th>Documents Type <i class="fa fa-sort-asc text-[10px] ml-1"></i></th>
                                        <th style="width: 140px; text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sampleDocs = [
                                            ['title' => 'POLICY MANUAL ACADEMICS', 'type' => 'Policy Manual'],
                                            ['title' => 'FLOW CHARTS ACADEMICS', 'type' => 'Flow Charts'],
                                            ['title' => 'ACADEMIC CALENDAR & SYLLABUS', 'type' => 'Supportive Documents'],
                                            ['title' => 'LESSON PLANNING TEMPLATE', 'type' => 'Supportive Documents'],
                                            ['title' => 'EXAM SCHEME OF STUDIES', 'type' => 'Supportive Documents'],
                                            ['title' => 'HOMEWORK POLICY GUIDE', 'type' => 'Supportive Documents'],
                                            ['title' => 'STUDENT DIARY GUIDELINES', 'type' => 'Supportive Documents'],
                                            ['title' => 'ONLINE EXAM GUIDELINES', 'type' => 'Supportive Documents'],
                                            ['title' => 'TEACHER TIMETABLE REGISTER', 'type' => 'Registers'],
                                        ];
                                    @endphp

                                    @foreach ($sampleDocs as $doc)
                                        <tr>
                                            <td class="font-medium text-slate-800">{{ $doc['title'] }}</td>
                                            <td class="text-slate-600">{{ $doc['type'] }}</td>
                                            <td style="text-align: right;">
                                                <div class="doc-actions">
                                                    {{-- View --}}
                                                    <a href="#" class="doc-act-btn doc-act-view" title="View">
                                                        <i class="fa fa-file-text-o"></i>
                                                    </a>
                                                    {{-- Download --}}
                                                    <a href="#" class="doc-act-btn doc-act-download" title="Download">
                                                        <i class="fa fa-cloud-download"></i>
                                                    </a>
                                                    {{-- Edit --}}
                                                    <a href="#" class="doc-act-btn doc-act-edit" title="Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    {{-- Delete --}}
                                                    <a href="#" class="doc-act-btn doc-act-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this document?')">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function updateFileLabel(input) {
                var label = document.getElementById('fileDropText');
                if (input.files && input.files[0]) {
                    label.innerText = input.files[0].name;
                } else {
                    label.innerText = 'Drag and drop a file here or click';
                }
            }

            function filterDocsTable() {
                var input = document.getElementById('docSearchInput');
                var filter = input.value.toLowerCase();
                var table = document.getElementById('docsTable');
                var tr = table.getElementsByTagName('tr');

                for (var i = 1; i < tr.length; i++) {
                    var tdTitle = tr[i].getElementsByTagName('td')[0];
                    var tdType = tr[i].getElementsByTagName('td')[1];
                    if (tdTitle || tdType) {
                        var txtTitle = tdTitle ? (tdTitle.textContent || tdTitle.innerText) : '';
                        var txtType = tdType ? (tdType.textContent || tdType.innerText) : '';
                        if (txtTitle.toLowerCase().indexOf(filter) > -1 || txtType.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = '';
                        } else {
                            tr[i].style.display = 'none';
                        }
                    }
                }
            }

            function copyTableData() {
                var table = document.getElementById('docsTable');
                var range = document.createRange();
                range.selectNode(table);
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);
                document.execCommand('copy');
                window.getSelection().removeAllRanges();
                alert('Table data copied to clipboard!');
            }
        </script>
    @else
        @include('admin.partials.module_table_component')
    @endif
@endsection

@extends('admin.layouts.app')

@section('title', 'TNT SOL')

@push('styles')
    <style>
        .subject-page { display: grid; grid-template-columns: minmax(280px, 1fr) minmax(0, 2fr); gap: 8px; }
        .subject-box { overflow: hidden; border: 1px solid #cfcfcf; border-radius: 6px; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,.08); }
        .subject-box-title { display: block !important; box-sizing: border-box; min-height: 43px; margin: 0 !important; border-bottom: 1px solid #d5d5d5; background: #fff; padding: 8px 10px; color: #1f2937; font-size: 18px; font-weight: 400; line-height: 1.25; visibility: visible !important; }
        .subject-form { padding: 12px 10px 16px; }
        .subject-form label { display: block; margin-bottom: 5px; color: #1f2937; font-size: 14px; }
        .subject-required { color: #e11d48; }
        .subject-input { width: 100%; border: 1px solid #bdbdbd; border-radius: 3px; padding: 8px; font-size: 14px; }
        .subject-radio-row { display: flex; gap: 14px; margin: 14px 0 24px; }
        .subject-radio-row label { display: inline-flex; align-items: center; gap: 5px; margin: 0; }
        .subject-error { margin-top: 4px; color: #dc2626; font-size: 12px; }
        .subject-form-footer { display: flex; justify-content: flex-end; margin: 16px -10px -16px; border-top: 1px solid #d5d5d5; padding: 10px; }
        .subject-btn { border: 0; border-radius: 2px; background: #24448d; padding: 7px 14px; color: #fff; cursor: pointer; font-size: 14px; }
        .subject-btn:hover { background: #2f61b3; }
        .subject-list-body { padding: 10px; }
        .subject-tools { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 8px; }
        .subject-search { width: 175px; border: 1px solid #999; border-radius: 4px; padding: 5px; }
        .subject-export-tools { display: flex; gap: 4px; }
        .subject-export-tools button, .subject-columns summary { position: relative; display: inline-flex; align-items: center; justify-content: center; width: 27px; height: 27px; border: 0; border-radius: 4px; background: #24448d; color: #fff; cursor: pointer; font-size: 14px; transition: transform .16s ease, background-color .16s ease, box-shadow .16s ease; }
        .subject-export-tools button:hover, .subject-columns summary:hover { z-index: 2; transform: translateY(-2px); background: #3f70c9; box-shadow: 0 3px 6px rgba(15,23,42,.22); }
        .subject-export-tools button::after, .subject-columns summary::after { content: attr(data-tooltip); position: absolute; top: calc(100% + 7px); left: 50%; z-index: 10; padding: 4px 7px; border-radius: 3px; background: #222; color: #fff; font-size: 11px; line-height: 1; white-space: nowrap; opacity: 0; pointer-events: none; transform: translate(-50%, -3px); transition: opacity .14s ease, transform .14s ease; }
        .subject-export-tools button:hover::after, .subject-columns summary:hover::after { opacity: 1; transform: translate(-50%, 0); }
        .subject-columns { position: relative; }
        .subject-columns menu { position: absolute; right: 0; z-index: 3; margin: 3px 0 0; min-width: 150px; border: 1px solid #bbb; background: #fff; padding: 7px; color: #111; box-shadow: 0 3px 8px #999; }
        .subject-columns label { display: block; padding: 4px; font-size: 12px; }
        .subject-table-wrap { overflow-x: auto; }
        .subject-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .subject-table th { background: #24448d; padding: 9px 8px; color: #fff; text-align: left; white-space: nowrap; font-weight: 700; font-size: 14px; }
        .subject-table td { border-bottom: 1px solid #e5e7eb; padding: 8px; }
        .subject-table tbody tr:hover { background: #f4f7fb; }
        .subject-action { display: inline-flex; width: 26px; height: 26px; align-items: center; justify-content: center; border-radius: 3px; color: #fff; text-decoration: none; }
        .subject-action-edit { background: #24448d; }
        .subject-action-delete { border: 0; background: #dc3545; cursor: pointer; }
        .subject-empty { padding: 55px 10px; color: #f29ca4; text-align: center; }
        .subject-footer { display: flex; justify-content: space-between; padding-top: 8px; color: #666; font-size: 12px; }
        .subject-pagination nav { display: flex; gap: 4px; }
        .subject-pagination a, .subject-pagination span { padding: 2px 5px; }
        @media (max-width: 900px) { .subject-page { grid-template-columns: 1fr; } }
        @media print { .admin-sidebar, .admin-topbar, .admin-module-tabs, .subject-form-box, .subject-tools, .subject-action-col, .subject-footer, .admin-footer { display: none !important; } .admin-content-wrap { padding-left: 0 !important; } .admin-main { padding: 0 !important; } }
    </style>
@endpush

@section('content')
    <div class="subject-page">
        <section class="subject-box subject-form-box">
                <div class="subject-box-title">{{ $subject ? 'Edit Subject' : 'Add Subject' }}</div>
                <form class="subject-form" method="POST" action="{{ $subject ? route('admin.academics.subjects.update', $subject, absolute: false) : route('admin.academics.subjects.store', absolute: false) }}">
                    @csrf
                    @if ($subject) @method('PUT') @endif

                    <label for="subject-name">Subject Name <span class="subject-required">*</span></label>
                    <input id="subject-name" name="name" class="subject-input" value="{{ old('name', $subject?->name) }}" autofocus required>
                    @error('name') <p class="subject-error">{{ $message }}</p> @enderror

                    <div class="subject-radio-row">
                        @foreach (['theory' => 'Theory', 'practical' => 'Practical'] as $value => $label)
                            <label><input type="radio" name="type" value="{{ $value }}" @checked(old('type', $subject?->type) === $value) required> {{ $label }}</label>
                        @endforeach
                    </div>
                    @error('type') <p class="subject-error">{{ $message }}</p> @enderror

                    <label for="subject-code">Subject Code <span class="subject-required">*</span></label>
                    <input id="subject-code" name="code" class="subject-input" value="{{ old('code', $subject?->code) }}" required>
                    @error('code') <p class="subject-error">{{ $message }}</p> @enderror

                    <div class="subject-form-footer">
                        @if ($subject)<a href="{{ route('admin.academics.subjects.index', absolute: false) }}" class="mr-2 rounded border border-neutral-300 px-3 py-1.5 text-sm text-neutral-700">Cancel</a>@endif
                        <button class="subject-btn" type="submit">{{ $subject ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
        </section>

        <section class="subject-box">
            <h2 class="subject-box-title">Subject List</h2>
            <div class="subject-list-body">
                <div class="subject-tools">
                    <form method="GET" action="{{ route('admin.academics.subjects.index', absolute: false) }}">
                        <input class="subject-search" name="search" value="{{ request('search') }}" placeholder="Search..." aria-label="Search subjects">
                    </form>
                    <div class="subject-export-tools">
                        <button type="button" data-export="copy" data-tooltip="Copy" title="Copy" aria-label="Copy"><i class="fa-regular fa-copy"></i></button>
                        <button type="button" data-export="excel" data-tooltip="Excel" title="Excel" aria-label="Excel"><i class="fa-regular fa-file-excel"></i></button>
                        <button type="button" data-export="csv" data-tooltip="CSV" title="CSV" aria-label="CSV"><i class="fa-regular fa-file-lines"></i></button>
                        <button type="button" data-export="pdf" data-tooltip="PDF" title="PDF" aria-label="PDF"><i class="fa-regular fa-file-pdf"></i></button>
                        <button type="button" data-export="print" data-tooltip="Print" title="Print" aria-label="Print"><i class="fa-solid fa-print"></i></button>
                        <details class="subject-columns">
                            <summary data-tooltip="Columns" title="Columns" aria-label="Columns"><i class="fa-solid fa-table-columns"></i></summary>
                            <menu>
                                <label><input type="checkbox" data-column="0" checked> Subject</label>
                                <label><input type="checkbox" data-column="1" checked> Subject Code</label>
                                <label><input type="checkbox" data-column="2" checked> Subject Type</label>
                                <label><input type="checkbox" data-column="3" checked> Action</label>
                            </menu>
                        </details>
                    </div>
                </div>

                <div class="subject-table-wrap">
                    <table id="subject-table" class="subject-table">
                        <thead><tr><th>Subject <span>▼</span></th><th>Subject Code <span>▼</span></th><th>Subject Type <span>▼</span></th><th class="subject-action-col">Action</th></tr></thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr>
                                    <td>{{ $record->name }}</td>
                                    <td>{{ $record->code }}</td>
                                    <td>{{ ucfirst($record->type) }}</td>
                                    <td class="subject-action-col">
                                        <a class="subject-action subject-action-edit" href="{{ route('admin.academics.subjects.index', ['edit' => $record->id], absolute: false) }}" title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                        <form class="inline" method="POST" action="{{ route('admin.academics.subjects.destroy', $record, absolute: false) }}" onsubmit="return confirm('Delete this subject?')">
                                            @csrf @method('DELETE')
                                            <button class="subject-action subject-action-delete" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="subject-empty">No data available in table</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="subject-footer">
                    <span>Records: {{ $records->total() ? (($records->currentPage() - 1) * $records->perPage() + 1) : 0 }} to {{ ($records->currentPage() - 1) * $records->perPage() + $records->count() }} of {{ $records->total() }}</span>
                    <div class="subject-pagination">{{ $records->links() }}</div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/dist/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/dist/datatables/js/vfs_fonts.js') }}"></script>
    <script>
        (() => {
            const table = document.getElementById('subject-table');
            if (!table) return;
            const rows = [...table.querySelectorAll('tbody tr')].filter(row => row.querySelectorAll('td').length === 4);
            const data = () => rows.map(row => [...row.querySelectorAll('td')].map(cell => cell.innerText.trim()));
            const download = (content, name, type) => { const a = document.createElement('a'); a.href = URL.createObjectURL(new Blob([content], {type})); a.download = name; a.click(); URL.revokeObjectURL(a.href); };
            const csv = () => [['Subject', 'Subject Code', 'Subject Type'], ...data().map(row => row.slice(0, 3))].map(row => row.map(value => `"${value.replaceAll('"', '""')}"`).join(',')).join('\n');
            document.querySelectorAll('[data-export]').forEach(button => button.addEventListener('click', async () => {
                const type = button.dataset.export;
                if (type === 'copy') await navigator.clipboard.writeText(data().map(row => row.slice(0, 3).join('\t')).join('\n'));
                if (type === 'csv') download(csv(), 'subjects.csv', 'text/csv');
                if (type === 'excel') download(`<table>${table.innerHTML}</table>`, 'subjects.xls', 'application/vnd.ms-excel');
                if (type === 'print') window.print();
            }));
            document.querySelectorAll('[data-column]').forEach(toggle => toggle.addEventListener('change', () => {
                const index = Number(toggle.dataset.column);
                table.querySelectorAll('tr').forEach(row => { const cell = row.children[index]; if (cell) cell.style.display = toggle.checked ? '' : 'none'; });
            }));
        })();
    </script>
@endpush

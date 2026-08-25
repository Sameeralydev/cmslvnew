@extends('admin.layouts.app')

@section('title', 'Subject Groups')

@push('styles')
    <style>
        .sg-page { display:grid; grid-template-columns:minmax(280px,1fr) minmax(0,2fr); gap:8px; }
        .sg-box { overflow:hidden; border:1px solid #cfcfcf; border-radius:6px; background:#fff; box-shadow:0 1px 2px rgba(0,0,0,.08); }
        .sg-title { border-bottom:1px solid #d5d5d5; padding:8px 10px; color:#1f2937; font-size:18px; }
        .sg-form { padding:10px; }
        .sg-form label { display:block; margin-bottom:5px; color:#1f2937; font-size:14px; }
        .sg-required { color:#e11d48; }
        .sg-input, .sg-select, .sg-textarea { width:100%; border:1px solid #bdbdbd; border-radius:3px; padding:8px; font-size:14px; }
        .sg-select { background:#fff; }
        .sg-field { margin-bottom:14px; }
        .sg-subjects { max-height:150px; overflow-y:auto; border:1px solid #ddd; padding:5px 8px; }
        .sg-check { display:block !important; margin:6px 0; }
        .sg-check input { margin-right:6px; }
        .sg-error { margin-top:3px; color:#dc2626; font-size:12px; }
        .sg-footer { display:flex; justify-content:flex-end; margin:15px -10px -10px; border-top:1px solid #d5d5d5; padding:10px; }
        .sg-btn { border:0; border-radius:2px; background:#24448d; padding:7px 14px; color:#fff; cursor:pointer; font-size:14px; text-decoration:none; }
        .sg-btn:hover { background:#2f61b3; }
        .sg-list { padding:10px; }
        .sg-tools { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-bottom:8px; }
        .sg-search { width:175px; border:1px solid #999; border-radius:4px; padding:5px; }
        .sg-exports { display:flex; gap:4px; }
        .sg-exports button { width:27px; height:27px; border:0; border-radius:4px; background:#24448d; color:#fff; cursor:pointer; }
        .sg-exports button:hover { background:#3f70c9; }
        .sg-table-wrap { overflow-x:auto; }
        .sg-table { width:100%; border-collapse:collapse; font-size:13px; }
        .sg-table th { background:#24448d; padding:9px 8px; color:#fff; text-align:left; white-space:nowrap; font-weight:700; font-size:14px; }
        .sg-table td { border-bottom:1px solid #e5e7eb; padding:8px; vertical-align:top; }
        .sg-table tbody tr:hover { background:#f4f7fb; }
        .sg-action { display:inline-flex; width:26px; height:26px; align-items:center; justify-content:center; border:0; border-radius:3px; color:#fff; text-decoration:none; cursor:pointer; }
        .sg-edit { background:#24448d; }
        .sg-delete { background:#dc3545; }
        .sg-empty { padding:55px 10px; color:#f29ca4; text-align:center; }
        .sg-foot { display:flex; justify-content:space-between; padding-top:8px; color:#666; font-size:12px; }
        @media(max-width:900px){ .sg-page{grid-template-columns:1fr;} }
        @media print { .admin-sidebar,.admin-topbar,.admin-module-tabs,.sg-form-box,.sg-tools,.sg-action-col,.sg-foot,.admin-footer{display:none!important;} .admin-content-wrap{padding-left:0!important;} .admin-main{padding:0!important;} }
    </style>
@endpush

@section('content')
    <div class="sg-page">
        <section class="sg-box sg-form-box">
            <h2 class="sg-title">{{ $subjectGroup ? 'Edit Subject Group' : 'Add Subject Group' }}</h2>
            <form class="sg-form" method="POST" action="{{ $subjectGroup ? route('admin.academics.subject-groups.update', $subjectGroup, absolute:false) : route('admin.academics.subject-groups.store', absolute:false) }}">
                @csrf
                @if($subjectGroup) @method('PUT') @endif

                <div class="sg-field">
                    <label for="sg-class">Class <span class="sg-required">*</span></label>
                    <select id="sg-class" name="class_id" class="sg-select" required>
                        <option value="">Select</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" @selected((string)old('class_id', $subjectGroup?->class_id) === (string)$class->id)>{{ $class->class }}</option>
                        @endforeach
                    </select>
                    @error('class_id')<p class="sg-error">{{ $message }}</p>@enderror
                </div>

                <div class="sg-field">
                    <label for="sg-name">Name <span class="sg-required">*</span></label>
                    <input id="sg-name" name="name" class="sg-input" value="{{ old('name', $subjectGroup?->name) }}" required autofocus>
                    @error('name')<p class="sg-error">{{ $message }}</p>@enderror
                </div>

                <div class="sg-field">
                    <label>Subject <span class="sg-required">*</span></label>
                    <div class="sg-subjects">
                        @php($selectedSubjects = collect(old('subjects', $subjectGroup?->subjects?->pluck('id')->all() ?? []))->map(fn($id)=>(string)$id)->all())
                        @forelse($subjects as $subject)
                            <label class="sg-check"><input type="checkbox" name="subjects[]" value="{{ $subject->id }}" @checked(in_array((string)$subject->id, $selectedSubjects, true))> {{ $subject->name }}@if($subject->code) ({{ $subject->code }})@endif</label>
                        @empty
                            <span class="text-sm text-neutral-500">Add subjects first.</span>
                        @endforelse
                    </div>
                    @error('subjects')<p class="sg-error">{{ $message }}</p>@enderror
                    @error('subjects.*')<p class="sg-error">{{ $message }}</p>@enderror
                </div>

                <div class="sg-field">
                    <label for="sg-description">Description</label>
                    <textarea id="sg-description" name="description" rows="3" class="sg-textarea">{{ old('description', $subjectGroup?->description) }}</textarea>
                </div>

                <div class="sg-footer">
                    @if($subjectGroup)<a class="sg-btn mr-2 bg-neutral-500" href="{{ route('admin.academics.subject-groups.index', absolute:false) }}">Cancel</a>@endif
                    <button class="sg-btn" type="submit">{{ $subjectGroup ? 'Update' : 'Save' }}</button>
                </div>
            </form>
        </section>

        <section class="sg-box">
            <h2 class="sg-title">Subject Group List</h2>
            <div class="sg-list">
                <div class="sg-tools">
                    <form method="GET" action="{{ route('admin.academics.subject-groups.index', absolute:false) }}"><input class="sg-search" name="search" value="{{ request('search') }}" placeholder="Search..."></form>
                    <div class="sg-exports">
                        <button type="button" data-sg-export="copy" title="Copy"><i class="fa-regular fa-copy"></i></button>
                        <button type="button" data-sg-export="excel" title="Excel"><i class="fa-regular fa-file-excel"></i></button>
                        <button type="button" data-sg-export="csv" title="CSV"><i class="fa-regular fa-file-lines"></i></button>
                        <button type="button" data-sg-export="pdf" title="PDF"><i class="fa-regular fa-file-pdf"></i></button>
                        <button type="button" data-sg-export="print" title="Print"><i class="fa-solid fa-print"></i></button>
                        <button type="button" id="sg-columns" title="Columns"><i class="fa-solid fa-table-columns"></i></button>
                    </div>
                </div>
                <div class="sg-table-wrap">
                    <table id="subject-group-table" class="sg-table">
                        <thead><tr><th>Name ▼</th><th>Class ▼</th><th>Subject ▼</th><th class="sg-action-col">Action</th></tr></thead>
                        <tbody>
                            @forelse($records as $record)
                                <tr>
                                    <td title="{{ $record->description }}">{{ $record->name }}</td>
                                    <td>{{ $classNames[$record->class_id] ?? $record->class_id }}</td>
                                    <td>@foreach($record->subjects as $groupSubject)<div>{{ $groupSubject->name }}@if($groupSubject->code) ({{ $groupSubject->code }})@endif</div>@endforeach</td>
                                    <td class="sg-action-col"><a class="sg-action sg-edit" href="{{ route('admin.academics.subject-groups.index', ['edit'=>$record->id], absolute:false) }}" title="Edit"><i class="fa-solid fa-pencil"></i></a> <form class="inline" method="POST" action="{{ route('admin.academics.subject-groups.destroy', $record, absolute:false) }}" onsubmit="return confirm('Delete this subject group?')">@csrf @method('DELETE')<button class="sg-action sg-delete" title="Delete"><i class="fa-solid fa-trash"></i></button></form></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="sg-empty">No data available in table</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="sg-foot"><span>Records: {{ $records->total() ? (($records->currentPage()-1)*$records->perPage()+1) : 0 }} to {{ ($records->currentPage()-1)*$records->perPage()+$records->count() }} of {{ $records->total() }}</span><span>{{ $records->links() }}</span></div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
(() => { const table=document.getElementById('subject-group-table'); if(!table)return; const rows=[...table.querySelectorAll('tbody tr')].filter(r=>r.children.length===4); const data=()=>rows.map(r=>[...r.children].map(c=>c.innerText.trim())); const download=(c,n,t)=>{const a=document.createElement('a');a.href=URL.createObjectURL(new Blob([c],{type:t}));a.download=n;a.click();URL.revokeObjectURL(a.href)}; const csv=()=>[['Name','Class','Subject'],...data().map(r=>r.slice(0,3))].map(r=>r.map(v=>`"${v.replaceAll('"','""')}"`).join(',')).join('\n'); document.querySelectorAll('[data-sg-export]').forEach(b=>b.addEventListener('click',async()=>{const t=b.dataset.sgExport;if(t==='copy')await navigator.clipboard.writeText(data().map(r=>r.slice(0,3).join('\t')).join('\n'));if(t==='csv')download(csv(),'subject-groups.csv','text/csv');if(t==='excel')download(`<table>${table.innerHTML}</table>`,'subject-groups.xls','application/vnd.ms-excel');if(t==='pdf'||t==='print')window.print()})); document.getElementById('sg-columns')?.addEventListener('click',()=>table.querySelectorAll('tr').forEach(r=>{const c=r.children[3];if(c)c.style.display=c.style.display==='none'?'':'none'})); })();
</script>
@endpush

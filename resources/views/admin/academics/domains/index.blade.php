@extends('admin.layouts.app')

@section('title', 'Domain')

@push('styles')
<style>
.domain-page{display:grid;grid-template-columns:minmax(280px,1fr) minmax(0,2fr);gap:8px}.domain-box{overflow:hidden;border:1px solid #cfcfcf;border-radius:6px;background:#fff;box-shadow:0 1px 2px rgba(0,0,0,.08)}.domain-title{border-bottom:1px solid #d5d5d5;padding:8px 10px;color:#1f2937;font-size:18px}.domain-form,.domain-list{padding:10px}.domain-label{display:block;margin:0 0 5px;color:#1f2937;font-size:14px}.domain-req{color:#e11d48}.domain-select{width:100%;border:1px solid #bdbdbd;border-radius:3px;background:#fff;padding:8px;font-size:14px}.domain-module{display:block;padding:5px 0;font-size:14px}.domain-module input{margin-right:7px}.domain-footer{display:flex;justify-content:flex-end;margin:10px -10px -10px;border-top:1px solid #d5d5d5;padding:10px}.domain-btn{border:0;border-radius:2px;background:#24448d;padding:7px 14px;color:#fff;cursor:pointer;font-size:14px;text-decoration:none}.domain-btn:hover{background:#2f61b3}.domain-tools{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:8px}.domain-search{width:175px;border:1px solid #999;border-radius:4px;padding:5px}.domain-exports{display:flex;gap:4px}.domain-exports button{width:27px;height:27px;border:0;border-radius:4px;background:#24448d;color:#fff;cursor:pointer}.domain-exports button:hover{background:#3f70c9}.domain-table-wrap{overflow-x:auto}.domain-table{width:100%;border-collapse:collapse;table-layout:fixed;font-size:12px}.domain-table th{background:#24448d;padding:8px 7px;color:#fff;text-align:left;font-weight:700}.domain-table th:nth-child(1){width:34%}.domain-table th:nth-child(2){width:46%}.domain-table th:nth-child(3){width:20%}.domain-table td{border-bottom:1px solid #dfe3e8;padding:7px;vertical-align:top}.domain-table tbody tr:hover{background:#f4f7fb}.domain-action{display:inline-flex;width:25px;height:25px;align-items:center;justify-content:center;border:0;border-radius:3px;color:#fff;text-decoration:none;cursor:pointer}.domain-edit{background:#24448d}.domain-delete{background:#dc3545}.domain-empty{padding:55px 10px!important;color:#f29ca4;text-align:center}.domain-foot{display:flex;justify-content:space-between;padding-top:7px;color:#666;font-size:11px}@media(max-width:900px){.domain-page{grid-template-columns:1fr}}@media print{.admin-sidebar,.admin-topbar,.admin-module-tabs,.domain-form-box,.domain-tools,.domain-action-col,.domain-foot,.admin-footer{display:none!important}.admin-content-wrap{padding-left:0!important}.admin-main{padding:0!important}}
</style>
@endpush

@section('content')
<div class="domain-page">
    <section class="domain-box domain-form-box">
        <h2 class="domain-title">{{ $domain ? 'Edit Domain' : 'Add Domain' }}</h2>
        @include('admin.partials.alerts')
        <form class="domain-form" method="POST" action="{{ $domain ? route('admin.academics.domains.update',$domain,absolute:false) : route('admin.academics.domains.store',absolute:false) }}">
            @csrf @if($domain) @method('PUT') @endif
            <label class="domain-label" for="subject_id">Subject <span class="domain-req">*</span></label>
            <select id="subject_id" name="subject_id" class="domain-select" required>
                <option value="">Select</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected((string)old('subject_id',$domain?->subject_id)===(string)$subject->id)>{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

            <div style="margin-top:16px">
                <label class="domain-label">Modules <span class="domain-req">*</span></label>
                @foreach($modules as $module)
                    <label class="domain-module"><input type="checkbox" name="modules[]" value="{{ $module->id }}" @checked(in_array($module->id, old('modules',$selectedModules)))>{{ $module->name }}</label>
                @endforeach
                @if($modules->isEmpty())<p class="text-sm text-neutral-500">Add modules first.</p>@endif
                @error('modules')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                @error('modules.*')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="domain-footer">
                @if($domain)<a class="domain-btn" style="background:#6b7280;margin-right:8px" href="{{ route('admin.academics.domains.index',absolute:false) }}">Cancel</a>@endif
                <button class="domain-btn" type="submit">{{ $domain?'Update':'Save' }}</button>
            </div>
        </form>
    </section>

    <section class="domain-box">
        <h2 class="domain-title">Domain List</h2>
        <div class="domain-list">
            <div class="domain-tools">
                <form method="GET" action="{{ route('admin.academics.domains.index',absolute:false) }}"><input class="domain-search" name="search" value="{{ request('search') }}" placeholder="Search..."></form>
                <div class="domain-exports"><button type="button" data-domain-export="copy" title="Copy"><i class="fa-regular fa-copy"></i></button><button type="button" data-domain-export="excel" title="Excel"><i class="fa-regular fa-file-excel"></i></button><button type="button" data-domain-export="csv" title="CSV"><i class="fa-regular fa-file-lines"></i></button><button type="button" data-domain-export="pdf" title="PDF"><i class="fa-regular fa-file-pdf"></i></button><button type="button" data-domain-export="print" title="Print"><i class="fa-solid fa-print"></i></button></div>
            </div>
            <div class="domain-table-wrap"><table id="domain-table" class="domain-table"><thead><tr><th>Subject ▼</th><th>Domain ▼</th><th class="domain-action-col">Action</th></tr></thead><tbody>
                @forelse($records as $record)
                    <tr><td>{{ $record->subject_name }}</td><td>@foreach($record->module_names as $moduleName)<div>{{ $moduleName }}</div>@endforeach</td><td class="domain-action-col"><a class="domain-action domain-edit" href="{{ route('admin.academics.domains.index',['edit'=>$record->id],absolute:false) }}" title="Edit"><i class="fa-solid fa-pencil"></i></a> <form class="inline" method="POST" action="{{ route('admin.academics.domains.destroy',$record,absolute:false) }}" onsubmit="return confirm('Delete this domain?')">@csrf @method('DELETE')<button class="domain-action domain-delete" title="Delete"><i class="fa-solid fa-trash"></i></button></form></td></tr>
                @empty<tr><td colspan="3" class="domain-empty">No data available in table</td></tr>@endforelse
            </tbody></table></div>
            <div class="domain-foot"><span>Records: {{ $records->total()?(($records->currentPage()-1)*$records->perPage()+1):0 }} to {{ ($records->currentPage()-1)*$records->perPage()+$records->count() }} of {{ $records->total() }}</span><span>{{ $records->links() }}</span></div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
(()=>{const t=document.getElementById('domain-table');if(!t)return;const rows=()=>[...t.querySelectorAll('tbody tr')].filter(r=>r.children.length===3),data=()=>rows().map(r=>[...r.children].map(c=>c.innerText.trim())),download=(c,n,type)=>{const a=document.createElement('a');a.href=URL.createObjectURL(new Blob([c],{type}));a.download=n;a.click();URL.revokeObjectURL(a.href)},csv=()=>[['Subject','Domain'],...data().map(r=>r.slice(0,2))].map(r=>r.map(v=>`"${v.replaceAll('"','""')}"`).join(',')).join('\n');document.querySelectorAll('[data-domain-export]').forEach(b=>b.addEventListener('click',async()=>{const x=b.dataset.domainExport;if(x==='copy')await navigator.clipboard.writeText(data().map(r=>r.slice(0,2).join('\t')).join('\n'));if(x==='csv')download(csv(),'domains.csv','text/csv');if(x==='excel')download(`<table>${t.innerHTML}</table>`,'domains.xls','application/vnd.ms-excel');if(x==='pdf'||x==='print')window.print()}));})();
</script>
@endpush

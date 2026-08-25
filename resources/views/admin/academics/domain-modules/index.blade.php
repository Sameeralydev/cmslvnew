@extends('admin.layouts.app')

@section('title', 'Modules')

@push('styles')
<style>
.dm-page{display:grid;grid-template-columns:minmax(280px,1fr) minmax(0,2fr);gap:8px}.dm-box{overflow:hidden;border:1px solid #cfcfcf;border-radius:6px;background:#fff;box-shadow:0 1px 2px rgba(0,0,0,.08)}.dm-title{border-bottom:1px solid #d5d5d5;padding:8px 10px;color:#1f2937;font-size:18px}.dm-form,.dm-list{padding:10px}.dm-row{display:grid;grid-template-columns:1fr 1fr;gap:8px}.dm-row label{display:block;margin-bottom:5px;color:#1f2937;font-size:14px}.dm-req{color:#e11d48}.dm-input{width:100%;border:1px solid #bdbdbd;border-radius:3px;padding:8px;font-size:14px}.dm-more{display:flex;justify-content:flex-end;margin:10px 0}.dm-btn{border:0;border-radius:2px;background:#24448d;padding:7px 14px;color:#fff;cursor:pointer;font-size:14px;text-decoration:none}.dm-btn:hover{background:#2f61b3}.dm-add{padding:3px 6px;font-size:12px}.dm-remove{border:0;background:transparent;color:#dc3545;cursor:pointer;font-size:17px}.dm-footer{display:flex;justify-content:flex-end;margin:10px -10px -10px;border-top:1px solid #d5d5d5;padding:10px}.dm-tools{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:8px}.dm-search{width:175px;border:1px solid #999;border-radius:4px;padding:5px}.dm-exports{display:flex;gap:4px}.dm-exports button{width:27px;height:27px;border:0;border-radius:4px;background:#24448d;color:#fff;cursor:pointer}.dm-exports button:hover{background:#3f70c9}.dm-table-wrap{overflow-x:auto}.dm-table{width:100%;border-collapse:collapse;font-size:13px}.dm-table th{background:#24448d;padding:9px 8px;color:#fff;text-align:left;font-weight:700}.dm-table td{border-bottom:1px solid #e5e7eb;padding:8px}.dm-table tbody tr:hover{background:#f4f7fb}.dm-action{display:inline-flex;width:26px;height:26px;align-items:center;justify-content:center;border:0;border-radius:3px;color:#fff;text-decoration:none;cursor:pointer}.dm-edit{background:#24448d}.dm-delete{background:#dc3545}.dm-empty{padding:55px 10px;color:#f29ca4;text-align:center}.dm-foot{display:flex;justify-content:space-between;padding-top:8px;color:#666;font-size:12px}@media(max-width:900px){.dm-page{grid-template-columns:1fr}}@media print{.admin-sidebar,.admin-topbar,.admin-module-tabs,.dm-form-box,.dm-tools,.dm-action-col,.dm-foot,.admin-footer{display:none!important}.admin-content-wrap{padding-left:0!important}.admin-main{padding:0!important}}
</style>
<style>
    .dm-table { table-layout: fixed; font-size: 12px; }
    .dm-table th { padding: 8px 7px; font-weight: 700; }
    .dm-table th:nth-child(1) { width: 42%; }
    .dm-table th:nth-child(2) { width: 35%; }
    .dm-table th:nth-child(3) { width: 23%; }
    .dm-table td { padding: 7px; border-bottom-color: #dfe3e8; }
    .dm-action { width: 25px; height: 25px; vertical-align: middle; }
    .dm-foot { padding-top: 7px; font-size: 11px; }
</style>
@endpush

@section('content')
<div class="dm-page">
    <section class="dm-box dm-form-box"><h2 class="dm-title">{{ $module?'Edit Modules':'Add Modules' }}</h2>
        @include('admin.partials.alerts')
        <form class="dm-form" method="POST" action="{{ $module?route('admin.academics.domain-modules.update',$module,absolute:false):route('admin.academics.domain-modules.store',absolute:false) }}">
            @csrf @if($module) @method('PUT') @endif
            <div id="module-rows">@php($englishNames=old('eng_name',$module ? [$module->name] : [''])) @php($urduNames=old('urdu_name',$module ? [$module->urdu] : [''])) @foreach($englishNames as $index=>$english)<div class="dm-row module-row"><div><label>Name English <span class="dm-req">*</span></label><input name="eng_name[]" class="dm-input" value="{{ $english }}" required></div><div><label>Name Urdu</label><input name="urdu_name[]" class="dm-input" value="{{ $urduNames[$index]??'' }}"></div>@if($index>0)<div><button type="button" class="dm-remove module-remove">×</button></div>@endif</div>@endforeach</div>
            @error('eng_name')<p class="text-xs text-red-600">{{ $message }}</p>@enderror @error('eng_name.*')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            @unless($module)<div class="dm-more"><button type="button" id="add-module-row" class="dm-btn dm-add"><i class="fa-solid fa-plus"></i> Add More...</button></div>@endunless
            <div class="dm-footer">@if($module)<a class="dm-btn mr-2 bg-neutral-500" href="{{ route('admin.academics.domain-modules.index',absolute:false) }}">Cancel</a>@endif<button class="dm-btn" type="submit">{{ $module?'Update':'Save' }}</button></div>
        </form>
    </section>

    <section class="dm-box"><h2 class="dm-title">Modules List</h2><div class="dm-list"><div class="dm-tools"><form method="GET" action="{{ route('admin.academics.domain-modules.index',absolute:false) }}"><input class="dm-search" name="search" value="{{ request('search') }}" placeholder="Search..."></form><div class="dm-exports"><button type="button" data-dm-export="copy" title="Copy"><i class="fa-regular fa-copy"></i></button><button type="button" data-dm-export="excel" title="Excel"><i class="fa-regular fa-file-excel"></i></button><button type="button" data-dm-export="csv" title="CSV"><i class="fa-regular fa-file-lines"></i></button><button type="button" data-dm-export="pdf" title="PDF"><i class="fa-regular fa-file-pdf"></i></button><button type="button" data-dm-export="print" title="Print"><i class="fa-solid fa-print"></i></button></div></div><div class="dm-table-wrap"><table id="module-table" class="dm-table"><thead><tr><th>English Name ▼</th><th>Urdu Name ▼</th><th class="dm-action-col">Action</th></tr></thead><tbody>@forelse($records as $record)<tr><td>{{ $record->name }}</td><td dir="rtl">{{ $record->urdu }}</td><td class="dm-action-col"><a class="dm-action dm-edit" href="{{ route('admin.academics.domain-modules.index',['edit'=>$record->id],absolute:false) }}" title="Edit"><i class="fa-solid fa-pencil"></i></a> <form class="inline" method="POST" action="{{ route('admin.academics.domain-modules.destroy',$record,absolute:false) }}" onsubmit="return confirm('Delete this module?')">@csrf @method('DELETE')<button class="dm-action dm-delete" title="Delete"><i class="fa-solid fa-trash"></i></button></form></td></tr>@empty<tr><td colspan="3" class="dm-empty">No data available in table</td></tr>@endforelse</tbody></table></div><div class="dm-foot"><span>Records: {{ $records->total()?(($records->currentPage()-1)*$records->perPage()+1):0 }} to {{ ($records->currentPage()-1)*$records->perPage()+$records->count() }} of {{ $records->total() }}</span><span>{{ $records->links() }}</span></div></div></section>
</div>
@endsection

@push('scripts')
<script>
(()=>{document.getElementById('add-module-row')?.addEventListener('click',()=>{const r=document.createElement('div');r.className='dm-row module-row';r.innerHTML='<div><label>English Name <span class="dm-req">*</span></label><input name="eng_name[]" class="dm-input" required></div><div><label>Urdu Name</label><input name="urdu_name[]" class="dm-input"></div><div><button type="button" class="dm-remove module-remove">×</button></div>';document.getElementById('module-rows').append(r)});document.getElementById('module-rows')?.addEventListener('click',e=>{if(e.target.closest('.module-remove'))e.target.closest('.module-row').remove()});const t=document.getElementById('module-table'),rows=[...t.querySelectorAll('tbody tr')].filter(r=>r.children.length===3),data=()=>rows.map(r=>[...r.children].map(c=>c.innerText.trim())),download=(c,n,type)=>{const a=document.createElement('a');a.href=URL.createObjectURL(new Blob([c],{type}));a.download=n;a.click();URL.revokeObjectURL(a.href)},csv=()=>[['English Name','Urdu Name'],...data().map(r=>r.slice(0,2))].map(r=>r.map(v=>`"${v.replaceAll('"','""')}"`).join(',')).join('\n');document.querySelectorAll('[data-dm-export]').forEach(b=>b.addEventListener('click',async()=>{const x=b.dataset.dmExport;if(x==='copy')await navigator.clipboard.writeText(data().map(r=>r.slice(0,2).join('\t')).join('\n'));if(x==='csv')download(csv(),'modules.csv','text/csv');if(x==='excel')download(`<table>${t.innerHTML}</table>`,'modules.xls','application/vnd.ms-excel');if(x==='pdf'||x==='print')window.print()}));})();
</script>
@endpush

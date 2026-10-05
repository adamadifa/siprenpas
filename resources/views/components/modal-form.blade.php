@props(['id' => '', 'size' => '', 'show' => '', 'title' => '', 'icon' => 'ti ti-file-text'])
<div class="modal fade" id="{{ $id }}" tabindex="-1" data-bs-focus="false" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog {{ $size }} modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border border-slate-200/90 shadow-2xl rounded-2xl bg-white">
            <!-- Modal Header (Clean White / No Background Color) -->
            <div class="px-6 py-4 bg-white border-b border-slate-200/90 flex items-center justify-between text-slate-900">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-base shrink-0 font-bold">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <h5 class="modal-title text-base font-bold text-slate-900 tracking-tight truncate mb-0" id="myModalLabel{{ $id }}">{{ $title }}</h5>
                </div>
                <button type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body p-6 bg-white">
                <div id="{{ $show }}"></div>
            </div>
        </div>
    </div>
</div>

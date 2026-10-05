@extends('layouts.app')
@section('titlepage', 'Manajemen Kuisioner')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-clipboard-list text-2xl"></i>
                </div>
                <span>Manajemen Kuisioner & Survei</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola instrumen survei, kelola butir pertanyaan kuisioner, dan pantau rekapitulasi hasil responden
            </p>
        </div>

        <!-- Right Side: Breadcrumb Navigation & Action -->
        <div class="flex flex-col md:items-end gap-2.5">
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Kuisioner</span>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('questionnaires.list') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-xl text-xs border border-slate-200 shadow-2xs transition active:scale-95">
                    <i class="ti ti-external-link text-base text-emerald-600"></i>
                    <span>Halaman Publik</span>
                </a>
                <button type="button" id="btncreateKuisioner" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all duration-200 active:scale-95 cursor-pointer border-0">
                    <i class="ti ti-plus text-base"></i>
                    <span>Tambah Kuisioner</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ================= 2. SEARCH & FILTER TOOLBAR ================= -->
    <form action="{{ route('admin.questionnaires.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari judul atau deskripsi kuisioner..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap border-0">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.questionnaires.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Pencarian">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. CARD TABLE LIST ================= -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <!-- Solid Emerald Card Header -->
        <div class="bg-emerald-600 px-4 py-3 sm:px-5 sm:py-3.5 flex items-center justify-between flex-wrap gap-2.5">
            <div class="flex items-center gap-2 text-white">
                <i class="ti ti-clipboard-check text-lg"></i>
                <h2 class="text-sm sm:text-base font-extrabold tracking-tight">
                    Daftar Instrumen Kuisioner
                </h2>
                <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-white/20 text-white border border-white/20">
                    {{ $questionnaires->total() }} Kuisioner
                </span>
            </div>
        </div>

        <!-- Table Responsive -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                    <tr>
                        <th class="py-2.5 px-3.5 text-center w-12">NO.</th>
                        <th class="py-2.5 px-3.5 min-w-[220px]">JUDUL KUISIONER</th>
                        <th class="py-2.5 px-3.5 min-w-[260px]">DESKRIPSI</th>
                        <th class="py-2.5 px-3.5 text-center w-36">JML PERTANYAAN</th>
                        <th class="py-2.5 px-3.5 text-center w-48">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[12px]">
                    @forelse($questionnaires as $q)
                        <tr class="hover:bg-emerald-50/40 transition-colors">
                            <!-- Number -->
                            <td class="py-2.5 px-3.5 text-center font-bold text-slate-500 whitespace-nowrap">
                                {{ $loop->iteration + ($questionnaires->currentPage() - 1) * $questionnaires->perPage() }}
                            </td>

                            <!-- Title -->
                            <td class="py-2.5 px-3.5 font-bold text-slate-900">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-sm border border-emerald-200 shrink-0 mt-0.5">
                                        <i class="ti ti-notes"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs font-black text-slate-900 leading-snug block">{{ $q->title }}</span>
                                        <span class="text-[10px] font-medium text-slate-400">ID: #{{ $q->id }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="py-2.5 px-3.5 text-slate-600 leading-relaxed text-xs">
                                {{ $q->description ? Str::limit($q->description, 120) : '-' }}
                            </td>

                            <!-- Total Questions Count -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold {{ $q->questions_count > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                    <i class="ti ti-help-circle text-sm"></i>
                                    <span>{{ $q->questions_count }} Butir</span>
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-2.5 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Kelola Pertanyaan -->
                                    <a href="{{ route('admin.questionnaires.questions.index', $q->id) }}" 
                                        class="px-2.5 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold border border-blue-200 text-xs shadow-2xs transition active:scale-95 flex items-center gap-1"
                                        title="Kelola Butir Pertanyaan">
                                        <i class="ti ti-list-details text-sm"></i>
                                        <span>Soal</span>
                                    </a>

                                    <!-- Report -->
                                    <a href="{{ route('admin.questionnaires.report', $q->id) }}" 
                                        class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold border border-emerald-200 text-xs shadow-2xs transition active:scale-95 flex items-center gap-1"
                                        title="Lihat Laporan Rekapitulasi">
                                        <i class="ti ti-chart-bar text-sm"></i>
                                        <span>Hasil</span>
                                    </a>

                                    <!-- Edit Modal Trigger -->
                                    <a href="#" 
                                        class="editKuisioner w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center border border-amber-200 shadow-2xs transition active:scale-95"
                                        data-id="{{ $q->id }}"
                                        title="Edit Judul & Deskripsi">
                                        <i class="ti ti-edit text-base"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.questionnaires.destroy', $q->id) }}" method="POST" class="deleteform inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-confirm w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center border border-rose-200 shadow-2xs transition active:scale-95 cursor-pointer" title="Hapus Kuisioner">
                                            <i class="ti ti-trash text-base"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400 text-xs">
                                <i class="ti ti-clipboard-x text-4xl mb-2 block text-slate-300"></i>
                                Belum ada instrumen kuisioner yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($questionnaires->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $questionnaires->links() }}
            </div>
        @endif
    </div>
</div>

<x-modal-form id="mdlcreateKuisioner" size="modal-lg" show="loadcreateKuisioner" title="Tambah Kuisioner" />
<x-modal-form id="mdleditKuisioner" size="modal-lg" show="loadeditKuisioner" title="Edit Kuisioner" />
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $('#btncreateKuisioner').click(function(e) {
            e.preventDefault();
            $('#mdlcreateKuisioner').modal('show');
            $('#loadcreateKuisioner').load('/admin/questionnaires/create');
        });

        $('.editKuisioner').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#mdleditKuisioner').modal('show');
            $('#loadeditKuisioner').load('/admin/questionnaires/' + id + '/edit');
        });

        $(".delete-confirm").click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Menghapus kuisioner ini akan menghapus seluruh butir soal dan jawaban responden yang terkait!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'rounded-xl font-bold px-4 py-2',
                    cancelButton: 'rounded-xl font-bold px-4 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
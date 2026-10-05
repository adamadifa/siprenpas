@extends('layouts.app')
@section('titlepage', 'Push Notifikasi Subscriber')

@section('content')
<div class="space-y-5">

    <!-- ================= 1. PAGE HEADER (NO CARD) WITH RIGHT BREADCRUMB ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-1">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-200/80 shadow-2xs">
                    <i class="ti ti-bell-ringing text-2xl"></i>
                </div>
                <span>Push Notification Subscriber</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Daftar perangkat browser wali santri & pengguna yang terdaftar menerima notifikasi web push instan
            </p>
        </div>

        <!-- Right Side: Breadcrumb & Actions -->
        <div class="flex flex-col md:items-end gap-2.5">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-xs text-slate-400 font-medium">
                <a href="{{ route('dashboard.index') }}" class="hover:text-slate-700 transition flex items-center gap-1">
                    <i class="ti ti-home text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-slate-500 flex items-center gap-1">
                    <i class="ti ti-settings text-sm"></i>
                    <span>Sistem</span>
                </span>
                <span class="mx-2 text-slate-300">/</span>
                <span class="font-bold text-slate-800">Push Notifikasi</span>
            </nav>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-semibold shadow-2xs">
            <div class="flex items-center gap-2">
                <i class="ti ti-circle-check text-base text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 cursor-pointer">
                <i class="ti ti-x text-sm"></i>
            </button>
        </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
        <div class="flex items-center justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-semibold shadow-2xs">
            <div class="flex items-center gap-2">
                <i class="ti ti-alert-circle text-base text-rose-600"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900 cursor-pointer">
                <i class="ti ti-x text-sm"></i>
            </button>
        </div>
    @endif

    <!-- Callout Info -->
    <div class="flex items-start gap-3.5 p-4 bg-emerald-50/80 border border-emerald-200/80 rounded-2xl text-emerald-900 shadow-2xs">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold">
            <i class="ti ti-info-circle"></i>
        </div>
        <div class="text-xs">
            <p class="font-bold text-emerald-950">Informasi Web Push Notification</p>
            <p class="text-emerald-700/90 mt-0.5 leading-relaxed">
                Perangkat otomatis terdaftar saat wali santri atau pengguna menekan izin <em>"Izinkan Notifikasi"</em> pada portal Siportuweb. Anda dapat menguji pengiriman notifikasi dengan menekan tombol <strong>Tes Notifikasi</strong>.
            </p>
        </div>
    </div>

    <!-- ================= 2. FILTER & SEARCH TOOLBAR ================= -->
    <form action="{{ route('push-subscriptions.index') }}" method="GET" class="w-full">
        <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 w-full">
            <!-- Search Input -->
            <div class="flex-1 min-w-0 w-full relative">
                <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none"></i>
                <input type="text" 
                       name="search" 
                       value="{{ Request('search') }}" 
                       placeholder="Cari nama pengguna atau email subscriber..." 
                       class="w-full pl-11 pr-4 py-2.5 sm:py-3 text-sm bg-white border border-slate-300/90 rounded-xl text-slate-800 font-medium placeholder-slate-400 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 sm:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-xs transition inline-flex items-center justify-center gap-2 cursor-pointer active:scale-95 whitespace-nowrap">
                    <i class="ti ti-search text-base"></i>
                    <span>Cari</span>
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('push-subscriptions.index') }}" class="py-2.5 sm:py-3 px-3.5 bg-white hover:bg-slate-100 text-slate-600 border border-slate-300/90 rounded-xl font-semibold text-sm transition inline-flex items-center justify-center shrink-0 shadow-xs" title="Reset Filter">
                        <i class="ti ti-refresh text-base"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- ================= 3. SOLID EMERALD TABLE CARD ================= -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
        <!-- Solid Emerald Header -->
        <div class="bg-emerald-600 px-5 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-2.5">
                <i class="ti ti-bell-ringing text-xl"></i>
                <h3 class="font-bold text-sm tracking-wide text-white">Daftar Perangkat Subscriber</h3>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-xs">
                Total: {{ count($subscriptions) }} Perangkat
            </span>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-600 text-white uppercase text-[11px] font-extrabold tracking-wider border-t border-emerald-500/50">
                        <th class="py-3.5 px-4 w-14 text-center">NO</th>
                        <th class="py-3.5 px-5 min-w-[240px]">PENGGUNA / WALI</th>
                        <th class="py-3.5 px-5 min-w-[300px]">ENDPOINT GATEWAY</th>
                        <th class="py-3.5 px-4 text-center w-44">TANGGAL BERLANGGANAN</th>
                        <th class="py-3.5 px-4 text-center w-32">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($subscriptions as $s)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <!-- No -->
                            <td class="py-4 px-4 text-center font-bold text-slate-400">
                                {{ $loop->iteration }}
                            </td>

                            <!-- User / Wali -->
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100 font-bold text-xs shadow-2xs">
                                        <i class="ti ti-user text-base"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-emerald-700 transition-colors truncate">
                                            {{ $s->user->name ?? 'Pengguna / Guest' }}
                                        </h4>
                                        <span class="text-[11px] text-slate-400 truncate block">
                                            {{ $s->user->email ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Endpoint -->
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-mono text-[11px] border border-slate-200 max-w-md truncate" title="{{ $s->endpoint }}">
                                        <i class="ti ti-link text-slate-400 shrink-0"></i>
                                        <span class="truncate">{{ $s->endpoint }}</span>
                                    </span>
                                </div>
                            </td>

                            <!-- Tanggal Berlangganan -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 text-slate-600 font-medium">
                                    <i class="ti ti-calendar text-slate-400"></i>
                                    {{ $s->created_at ? $s->created_at->translatedFormat('d M Y H:i') : '-' }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <a href="{{ route('push-subscriptions.test', $s->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-sky-50 hover:bg-sky-600 text-sky-700 hover:text-white font-bold text-xs border border-sky-200/80 transition-all duration-150 shadow-2xs"
                                       title="Kirim Tes Notifikasi">
                                        <i class="ti ti-bell-ringing text-sm"></i>
                                        <span>Tes</span>
                                    </a>

                                    @can('push-subscriptions.destroy')
                                        <form method="POST" name="deleteform" class="deleteform inline-block m-0"
                                              action="{{ route('push-subscriptions.destroy', $s->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition-colors border border-rose-200/60 delete-confirm cursor-pointer shadow-2xs"
                                                    title="Hapus Subscriber">
                                                <i class="ti ti-trash text-base"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-14 text-center bg-white">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl shadow-inner">
                                    <i class="ti ti-bell-off"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Belum Ada Perangkat Subscriber</h4>
                                <p class="text-xs text-slate-400 max-w-sm mx-auto">
                                    Pengguna atau wali santri akan muncul di sini setelah mengaktifkan izin notifikasi pada portal Siportuweb.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Handle delete confirmation
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Hapus Subscriber?',
                text: "Notifikasi tidak akan terkirim lagi ke perangkat ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl text-xs mr-2',
                    cancelButton: 'px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl text-xs'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

<div class="space-y-4">
    <!-- Header Banner Note -->
    <div class="p-3.5 bg-emerald-50 border border-emerald-200/80 rounded-xl flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-2xs">
            <i class="ti ti-calendar-event text-base"></i>
        </div>
        <div>
            <h4 class="text-xs font-bold text-emerald-950">Pilih Parameter Presensi</h4>
            <p class="text-[11px] text-emerald-800 mt-0.5 leading-relaxed">
                Tentukan tanggal kegiatan pembelajaran, unit pendidikan, dan kelas santri untuk menampilkan jadwal pelajaran yang tersedia.
            </p>
        </div>
    </div>

    <!-- Filter Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <!-- Tanggal -->
        <div class="space-y-1.5">
            <label for="modal_tanggal" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-calendar text-sm text-slate-400"></i>
                <span>Tanggal Pertemuan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-calendar-event text-base"></i>
                </div>
                <input type="text" 
                       id="modal_tanggal" 
                       value="{{ date('Y-m-d') }}" 
                       class="w-full pl-9 pr-3.5 py-2 text-sm font-bold font-mono text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition flatpickr-modal">
            </div>
        </div>

        <!-- Unit Pendidikan -->
        <div class="space-y-1.5">
            <label for="modal_kode_unit" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-school text-sm text-slate-400"></i>
                <span>Unit Pendidikan <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-building text-base"></i>
                </div>
                <select id="modal_kode_unit" class="w-full pl-9 pr-8 py-2 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition">
                    @if(count($units) > 1)
                        <option value="">-- Pilih Unit --</option>
                    @endif
                    @foreach ($units as $u)
                        <option value="{{ $u->kode_unit }}" {{ count($units) == 1 ? 'selected' : '' }}>
                            {{ $u->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Kelas -->
        <div class="space-y-1.5">
            <label for="modal_kode_kelas" class="block text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="ti ti-door-enter text-sm text-slate-400"></i>
                <span>Kelas Santri <span class="text-rose-500 font-bold">*</span></span>
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="ti ti-door text-base"></i>
                </div>
                <select id="modal_kode_kelas" class="w-full pl-9 pr-8 py-2 text-sm font-semibold text-slate-800 bg-white border border-slate-300 rounded-xl shadow-2xs focus:outline-hidden focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition" {{ count($units) > 1 ? 'disabled' : '' }}>
                    <option value="">-- Pilih Kelas --</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Schedule Results Header -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
        <h5 class="text-xs font-bold text-slate-800 flex items-center gap-2">
            <i class="ti ti-calendar-time text-emerald-600"></i>
            <span>Daftar Jadwal Pembelajaran</span>
        </h5>
        <span id="schedule-count-badge" class="hidden px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
            0 Jadwal
        </span>
    </div>

    <!-- Dynamic Schedule Container -->
    <div id="list-jadwal-modal" class="space-y-2.5 max-h-[380px] overflow-y-auto pr-1">
        <div class="p-8 text-center bg-slate-50 border border-dashed border-slate-200 rounded-xl text-slate-400">
            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400">
                <i class="ti ti-calendar-search text-xl"></i>
            </div>
            <p class="text-xs font-semibold text-slate-600">Silakan pilih Tanggal, Unit, dan Kelas</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Jadwal mata pelajaran akan otomatis muncul di sini</p>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Initialize Flatpickr in modal
        if (typeof flatpickr === 'function') {
            $('#modal_tanggal').flatpickr({
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                defaultDate: "{{ date('Y-m-d') }}",
                onChange: function() {
                    loadJadwalModal();
                }
            });
        }

        function loadJadwalModal() {
            var tanggal = $('#modal_tanggal').val();
            var kode_unit = $('#modal_kode_unit').val();
            var kode_kelas = $('#modal_kode_kelas').val();

            if (tanggal && kode_unit && kode_kelas) {
                $('#list-jadwal-modal').html(`
                    <div class="p-8 text-center bg-white">
                        <div class="w-8 h-8 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                        <div class="text-xs font-bold text-slate-700">Mencari Jadwal Pelajaran...</div>
                    </div>
                `);

                $.ajax({
                    url: "{{ route('presensi-mapel.get-jadwal') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        kode_unit: kode_unit,
                        kode_kelas: kode_kelas
                    },
                    dataType: "json",
                    success: function(respond) {
                        var html = '';
                        if (respond && respond.length > 0) {
                            $('#schedule-count-badge').text(respond.length + ' Jadwal').removeClass('hidden');

                            respond.forEach(function(item) {
                                const mapelNama = (item.mapel && item.mapel.nama_matpel) ? item.mapel.nama_matpel : 'Mata Pelajaran';
                                const guruNama = (item.guru && item.guru.karyawan && item.guru.karyawan.nama_lengkap) ? item.guru.karyawan.nama_lengkap : ((item.guru && item.guru.nama_guru) ? item.guru.nama_guru : '-');
                                const jamMulai = item.jam_mulai ? item.jam_mulai.substring(0,5) : '00:00';
                                const jamSelesai = item.jam_selesai ? item.jam_selesai.substring(0,5) : '00:00';
                                const kelompok = (item.mapel && item.mapel.kelompok) ? `<span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">Kelompok ${item.mapel.kelompok}</span>` : '';
                                
                                let actionBtn = '';
                                if (item.has_presensi) {
                                    actionBtn = `
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="ti ti-circle-check text-xs"></i> Sudah Diisi
                                            </span>
                                            <a href="/presensi-mapel/${item.presensi_id_encrypted}/edit" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-xs transition active:scale-95">
                                                <i class="ti ti-edit text-sm"></i>
                                                <span>Edit</span>
                                            </a>
                                        </div>
                                    `;
                                } else {
                                    actionBtn = `
                                        <a href="/presensi-mapel/${item.id_encrypted}/${tanggal}/input" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition active:scale-95">
                                            <span>Mulai Presensi</span>
                                            <i class="ti ti-arrow-right text-sm"></i>
                                        </a>
                                    `;
                                }

                                html += `
                                    <div class="p-3.5 bg-white border border-slate-200 rounded-xl hover:border-emerald-400 hover:shadow-xs transition group">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                            <div class="flex items-start gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex flex-col items-center justify-center shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition shadow-2xs">
                                                    <span class="text-[9px] font-bold uppercase leading-none">Jam</span>
                                                    <span class="text-xs font-black leading-none mt-0.5">${item.jam_ke || 1}</span>
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-emerald-800 transition">
                                                            ${mapelNama}
                                                        </h4>
                                                        ${kelompok}
                                                    </div>
                                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-[11px] text-slate-500 font-medium">
                                                        <span class="flex items-center gap-1 text-slate-700 font-semibold">
                                                            <i class="ti ti-user text-emerald-600"></i> ${guruNama}
                                                        </span>
                                                        <span class="flex items-center gap-1 font-mono font-bold text-emerald-700">
                                                            <i class="ti ti-clock text-slate-400"></i> ${jamMulai} - ${jamSelesai}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex sm:justify-end shrink-0">
                                                ${actionBtn}
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            $('#schedule-count-badge').addClass('hidden');
                            html = `
                                <div class="p-8 text-center bg-amber-50/70 border border-amber-200 rounded-xl text-amber-800">
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center mx-auto mb-2 text-amber-700">
                                        <i class="ti ti-calendar-off text-xl"></i>
                                    </div>
                                    <h5 class="text-xs font-bold text-amber-950">Tidak Ada Jadwal Pelajaran</h5>
                                    <p class="text-[11px] text-amber-700 mt-0.5">Tidak ditemukan jadwal aktif untuk kelas ini pada hari yang dipilih.</p>
                                </div>
                            `;
                        }
                        $('#list-jadwal-modal').html(html);
                    },
                    error: function() {
                        $('#schedule-count-badge').addClass('hidden');
                        $('#list-jadwal-modal').html(`
                            <div class="p-6 text-center bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-xs">
                                <i class="ti ti-alert-circle text-lg mb-1 block"></i>
                                Terjadi kesalahan saat memuat data jadwal. Silakan coba lagi.
                            </div>
                        `);
                    }
                });
            }
        }

        function loadKelasByUnit(kode_unit) {
            if (kode_unit) {
                $('#modal_kode_kelas').html('<option value="">Memuat Kelas...</option>').prop('disabled', true);
                $.ajax({
                    url: "{{ route('jadwal-pelajaran.get-data-by-unit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_unit: kode_unit
                    },
                    success: function(res) {
                        var opt = '<option value="">-- Pilih Kelas --</option>';
                        if (res.kelas && res.kelas.length > 0) {
                            res.kelas.forEach(function(item) {
                                opt += `<option value="${item.kode_kelas}">${item.nama_kelas}</option>`;
                            });
                        }
                        $('#modal_kode_kelas').html(opt).prop('disabled', false);
                    }
                });
            } else {
                $('#modal_kode_kelas').html('<option value="">-- Pilih Kelas --</option>').prop('disabled', true);
                $('#list-jadwal-modal').html(`
                    <div class="p-8 text-center bg-slate-50 border border-dashed border-slate-200 rounded-xl text-slate-400">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400">
                            <i class="ti ti-calendar-search text-xl"></i>
                        </div>
                        <p class="text-xs font-semibold text-slate-600">Silakan pilih Tanggal, Unit, dan Kelas</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Jadwal mata pelajaran akan otomatis muncul di sini</p>
                    </div>
                `);
            }
        }

        // Auto load if single unit already selected
        var initialUnit = $('#modal_kode_unit').val();
        if (initialUnit) {
            loadKelasByUnit(initialUnit);
        }

        $('#modal_kode_unit').change(function() {
            var kode_unit = $(this).val();
            loadKelasByUnit(kode_unit);
        });

        $('#modal_kode_kelas').change(function() {
            loadJadwalModal();
        });
    });
</script>

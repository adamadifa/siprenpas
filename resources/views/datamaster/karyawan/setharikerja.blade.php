<form action="{{ route('karyawan.updateharikerja', Crypt::encrypt($karyawan->npp)) }}" method="POST" id="formSetharikerja" class="space-y-5" novalidate>
    @csrf
    @method('PUT')

    <!-- ================= 1. INFORMASI PEGAWAI ================= -->
    <div class="bg-slate-50/80 border border-slate-200/90 rounded-xl p-4 sm:p-5">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-14 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg border border-emerald-200 shrink-0">
                @if (!empty($karyawan->foto) && Storage::disk('public')->exists('photos/karyawan/' . $karyawan->foto))
                    <img src="{{ getfotoKaryawan($karyawan->foto) }}" alt="{{ $karyawan->nama_lengkap }}" class="w-full h-full object-cover rounded-lg">
                @else
                    {{ strtoupper(substr($karyawan->nama_lengkap, 0, 1)) }}
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <h4 class="text-sm sm:text-base font-bold text-slate-900 truncate">
                        {{ textCamelCase($karyawan->nama_lengkap) }}
                    </h4>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700">
                        {{ $karyawan->npp }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Pilih hari-hari efektif kerja karyawan dalam satu minggu untuk perhitungan presensi dan absensi.
                </p>
            </div>
        </div>
    </div>

    <!-- ================= 2. QUICK SELECT BUTTONS ================= -->
    <div class="flex flex-wrap items-center justify-between gap-2 px-1">
        <span class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
            <i class="ti ti-calendar-check text-emerald-600 text-base"></i>
            <span>Pilih Jadwal Hari Kerja:</span>
        </span>
        <div class="flex flex-wrap items-center gap-1.5">
            <button type="button" id="btnSelect5Days" class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 transition cursor-pointer active:scale-95">
                Senin - Jumat (5 Hari)
            </button>
            <button type="button" id="btnSelect6Days" class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 transition cursor-pointer active:scale-95">
                Senin - Sabtu (6 Hari)
            </button>
            <button type="button" id="btnSelectAllDays" class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 transition cursor-pointer active:scale-95">
                Pilih Semua
            </button>
            <button type="button" id="btnClearDays" class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition cursor-pointer active:scale-95">
                Reset
            </button>
        </div>
    </div>

    <!-- ================= 3. DAY CHECKBOX CARDS GRID ================= -->
    @php
        $days = [
            ['name' => 'Senin', 'code' => 'senin', 'desc' => 'Awal pekan kerja'],
            ['name' => 'Selasa', 'code' => 'selasa', 'desc' => 'Hari kerja reguler'],
            ['name' => 'Rabu', 'code' => 'rabu', 'desc' => 'Hari kerja reguler'],
            ['name' => 'Kamis', 'code' => 'kamis', 'desc' => 'Hari kerja reguler'],
            ['name' => 'Jumat', 'code' => 'jumat', 'desc' => 'Hari kerja reguler'],
            ['name' => 'Sabtu', 'code' => 'sabtu', 'desc' => 'Akhir pekan / piket'],
            ['name' => 'Minggu', 'code' => 'minggu', 'desc' => 'Hari libur / shift'],
        ];
        $currentHariKerja = strtolower($karyawan->hari_kerja ?? '');
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach ($days as $day)
            @php
                $isChecked = str_contains($currentHariKerja, $day['code']);
            @endphp
            <label class="day-card relative flex items-center justify-between p-3.5 rounded-xl border-2 transition-all cursor-pointer select-none {{ $isChecked ? 'border-emerald-600 bg-emerald-50/40 text-emerald-950 shadow-2xs' : 'border-slate-200 bg-white hover:border-slate-300 text-slate-700' }}">
                <div class="flex items-center gap-3">
                    <div class="day-checkbox-box w-5 h-5 rounded-md flex items-center justify-center border transition {{ $isChecked ? 'bg-emerald-600 border-emerald-600 text-white' : 'bg-white border-slate-300 text-transparent' }}">
                        <i class="ti ti-check text-xs"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold">{{ $day['name'] }}</div>
                        <div class="text-[11px] text-slate-400 font-normal">{{ $day['desc'] }}</div>
                    </div>
                </div>

                <input type="checkbox" 
                       name="hari[]" 
                       value="{{ $day['name'] }}" 
                       class="day-input sr-only" 
                       data-day="{{ $day['code'] }}"
                       {{ $isChecked ? 'checked' : '' }}>

                <span class="day-badge px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $isChecked ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-400' }}">
                    {{ $isChecked ? 'Kerja' : 'Libur' }}
                </span>
            </label>
        @endforeach
    </div>

    <div id="hariError" class="hidden text-xs font-semibold text-rose-500 flex items-center gap-1.5 p-2.5 bg-rose-50 rounded-xl border border-rose-200">
        <i class="ti ti-alert-circle text-base"></i>
        <span>Pilih minimal 1 hari kerja untuk karyawan ini!</span>
    </div>

    <!-- ================= 4. MODAL ACTIONS FOOTER ================= -->
    <div class="pt-4 border-t border-slate-200/90 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5">
        <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer active:scale-95" data-bs-dismiss="modal">
            Batal
        </button>
        <button type="submit" id="btnUpdateHariKerja" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <i class="ti ti-refresh text-base"></i>
            <span>Update Hari Kerja</span>
        </button>
    </div>
</form>

<script>
    $(function() {
        function updateCardAppearance($checkbox) {
            const isChecked = $checkbox.is(':checked');
            const $card = $checkbox.closest('.day-card');
            const $box = $card.find('.day-checkbox-box');
            const $badge = $card.find('.day-badge');

            if (isChecked) {
                $card.addClass('border-emerald-600 bg-emerald-50/40 text-emerald-950 shadow-2xs')
                     .removeClass('border-slate-200 bg-white hover:border-slate-300 text-slate-700');
                $box.addClass('bg-emerald-600 border-emerald-600 text-white')
                    .removeClass('bg-white border-slate-300 text-transparent');
                $badge.addClass('bg-emerald-100 text-emerald-800')
                      .removeClass('bg-slate-100 text-slate-400')
                      .text('KERJA');
            } else {
                $card.removeClass('border-emerald-600 bg-emerald-50/40 text-emerald-950 shadow-2xs')
                     .addClass('border-slate-200 bg-white hover:border-slate-300 text-slate-700');
                $box.removeClass('bg-emerald-600 border-emerald-600 text-white')
                    .addClass('bg-white border-slate-300 text-transparent');
                $badge.removeClass('bg-emerald-100 text-emerald-800')
                      .addClass('bg-slate-100 text-slate-400')
                      .text('LIBUR');
            }
        }

        // Checkbox change handler
        $(document).on('change', '.day-input', function() {
            updateCardAppearance($(this));
            $("#hariError").addClass('hidden');
        });

        // Quick Select Buttons
        $("#btnSelect5Days").click(function() {
            const fiveDays = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
            $(".day-input").each(function() {
                const day = $(this).data('day');
                $(this).prop('checked', fiveDays.includes(day));
                updateCardAppearance($(this));
            });
            $("#hariError").addClass('hidden');
        });

        $("#btnSelect6Days").click(function() {
            const sixDays = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
            $(".day-input").each(function() {
                const day = $(this).data('day');
                $(this).prop('checked', sixDays.includes(day));
                updateCardAppearance($(this));
            });
            $("#hariError").addClass('hidden');
        });

        $("#btnSelectAllDays").click(function() {
            $(".day-input").each(function() {
                $(this).prop('checked', true);
                updateCardAppearance($(this));
            });
            $("#hariError").addClass('hidden');
        });

        $("#btnClearDays").click(function() {
            $(".day-input").each(function() {
                $(this).prop('checked', false);
                updateCardAppearance($(this));
            });
        });

        // Submit form handler
        $("#formSetharikerja").submit(function(e) {
            const checkedCount = $(".day-input:checked").length;
            if (checkedCount === 0) {
                e.preventDefault();
                $("#hariError").removeClass('hidden');
                return false;
            }

            $("#btnUpdateHariKerja").prop("disabled", true).html(
                `<div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div> <span>Menyimpan...</span>`
            );
        });
    });
</script>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa - Tap RFID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#64748B',
                        success: '#10B981',
                        warning: '#F59E0B',
                        danger: '#EF4444',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Header dengan Jam Digital Besar -->
        <div class="container mx-auto px-4 py-3">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-2 shadow-lg p-2">
                    <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo Persis Alamin" class="w-full h-full object-contain">
                </div>

                <!-- Jam Digital Besar -->
                <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl p-4 shadow-2xl mb-3">
                    <div class="text-center">
                        <div id="digital-date" class="text-lg font-semibold text-blue-300 mb-1"></div>
                        <div id="digital-time" class="text-4xl font-mono font-bold text-white tracking-wider"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content - Dua Kolom -->
        <div class="container mx-auto px-4 py-2">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                <!-- Kolom Kiri - Instruksi Tap to Presence -->
                <div class="bg-white rounded-xl shadow-xl p-4">
                    <div class="text-center mb-4">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full mb-3 relative shadow-lg">
                            <i class="fas fa-hand-pointer text-white text-3xl"></i>
                            <div class="absolute inset-0 rounded-full border-2 border-white border-opacity-30 animate-pulse"></div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Tap to Presence</h2>
                        <p class="text-sm text-gray-600 mb-4">Tempelkan kartu RFID Anda di area scanner untuk melakukan presensi</p>

                        <!-- RFID Scanner Visual -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-3 border-2 border-dashed border-blue-300 mb-4">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-wifi text-2xl text-blue-500 mr-2"></i>
                                <span class="text-lg font-semibold text-blue-700">RFID Scanner</span>
                            </div>
                            <p class="text-sm text-blue-600">Area ini akan mendeteksi kartu RFID Anda secara otomatis</p>
                        </div>

                        <!-- Input RFID -->
                        <div class="bg-white border border-gray-300 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-id-card text-blue-500 mr-2"></i>
                                <span class="text-sm font-semibold text-gray-700">RFID Reader</span>
                            </div>
                            <div class="relative">
                                <input type="text" id="manual-rfid" placeholder="Tempelkan kartu RFID atau ketik manual"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                    autocomplete="off">
                                <div class="absolute right-2 top-2">
                                    <i class="fas fa-wifi text-blue-500 text-sm animate-pulse"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">RFID akan terbaca otomatis atau tekan Enter untuk input manual</p>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan - Riwayat Presensi -->
                <div class="bg-white rounded-xl shadow-xl p-4">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Riwayat Presensi Hari Ini</h2>

                    <!-- Status Display -->
                    <div id="status-display" class="hidden mb-4">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center justify-center mb-2">
                                <div id="status-icon" class="w-8 h-8 rounded-full flex items-center justify-center mr-3">
                                    <i id="status-icon-class" class="text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 id="status-title" class="text-sm font-semibold text-gray-800"></h3>
                                    <p id="status-message" class="text-xs text-gray-600"></p>
                                </div>
                            </div>

                            <!-- Student Info -->
                            <div id="student-info" class="hidden">
                                <div class="border-t pt-2">
                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        <div>
                                            <span class="text-gray-500">Nama:</span>
                                            <span id="student-name" class="font-medium text-gray-800 ml-1"></span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Kelas:</span>
                                            <span id="student-class" class="font-medium text-gray-800 ml-1"></span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Masuk:</span>
                                            <span id="jam-masuk" class="font-medium text-gray-800 ml-1">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Keluar:</span>
                                            <span id="jam-keluar" class="font-medium text-gray-800 ml-1">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="mt-4">
                        <div id="recent-activity" class="space-y-2">
                            @if (isset($riwayatPresensi) && $riwayatPresensi->count() > 0)
                                @foreach ($riwayatPresensi as $presensi)
                                    <div class="flex items-center justify-between bg-white p-2 rounded-md shadow-sm border">
                                        <div class="flex items-center">
                                            <!-- Foto Siswa -->
                                            <div class="w-10 h-10 rounded-full overflow-hidden mr-3 bg-gray-200 flex items-center justify-center">
                                                @if ($presensi->foto && file_exists(public_path('storage/' . $presensi->foto_siswa)))
                                                    <img src="{{ asset('storage/' . $presensi->foto_siswa) }}" alt="{{ $presensi->nama_lengkap }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <i class="fas fa-user text-gray-500 text-lg"></i>
                                                @endif
                                            </div>

                                            <!-- Status Icon -->
                                            <div
                                                class="w-6 h-6 rounded-full flex items-center justify-center mr-2 {{ $presensi->jenis_presensi == 'masuk' ? 'bg-blue-500' : 'bg-orange-500' }}">
                                                <i
                                                    class="fas {{ $presensi->jenis_presensi == 'masuk' ? 'fa-sign-in-alt' : 'fa-sign-out-alt' }} text-white text-xs"></i>
                                            </div>

                                            <div>
                                                <p class="text-sm font-medium text-gray-800">{{ $presensi->nama_lengkap }}</p>
                                                <p class="text-xs text-gray-600">{{ $presensi->nama_kelas ?? '-' }} •
                                                    {{ \Carbon\Carbon::parse($presensi->created_at)->format('H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p
                                                class="text-xs font-medium {{ $presensi->jenis_presensi == 'masuk' ? 'text-blue-600' : 'text-orange-600' }}">
                                                {{ $presensi->jenis_presensi == 'masuk' ? 'Masuk' : 'Keluar' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $presensi->jam_presensi ? \Carbon\Carbon::parse($presensi->jam_presensi)->format('H:i') : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-gray-500 py-4">
                                    <i class="fas fa-inbox text-2xl mb-1"></i>
                                    <p class="text-sm">Belum ada aktivitas presensi</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg p-4 flex items-center">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mr-3"></div>
                <span class="text-sm text-gray-700">Memproses presensi...</span>
            </div>
        </div>

        <script>
            // Update time and date untuk jam digital
            function updateDateTime() {
                const now = new Date();
                const dateOptions = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const timeOptions = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };

                // Update jam digital
                document.getElementById('digital-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
                document.getElementById('digital-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
            }

            // Update every second
            setInterval(updateDateTime, 1000);
            updateDateTime();

            // Show status
            function showStatus(success, title, message, data = null) {
                const statusDisplay = document.getElementById('status-display');
                const statusIcon = document.getElementById('status-icon');
                const statusIconClass = document.getElementById('status-icon-class');
                const statusTitle = document.getElementById('status-title');
                const statusMessage = document.getElementById('status-message');
                const studentInfo = document.getElementById('student-info');

                // Set status colors and icons
                if (success) {
                    statusIcon.className = 'w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-success';
                    statusIconClass.className = 'fas fa-check text-white text-xl';
                } else {
                    statusIcon.className = 'w-12 h-12 rounded-full flex items-center justify-center mr-4 bg-danger';
                    statusIconClass.className = 'fas fa-times text-white text-xl';
                }

                statusTitle.textContent = title;
                statusMessage.textContent = message;

                // Show student info if available
                if (data) {
                    document.getElementById('student-name').textContent = data.nama || '-';
                    document.getElementById('student-class').textContent = data.kelas || '-';
                    document.getElementById('jam-masuk').textContent = data.jam_masuk || '-';
                    document.getElementById('jam-keluar').textContent = data.jam_keluar || '-';
                    studentInfo.classList.remove('hidden');
                } else {
                    studentInfo.classList.add('hidden');
                }

                statusDisplay.classList.remove('hidden');

                // Auto hide after 5 seconds
                setTimeout(() => {
                    statusDisplay.classList.add('hidden');
                }, 5000);
            }

            // Show loading
            function showLoading() {
                document.getElementById('loading-overlay').classList.remove('hidden');
            }

            // Hide loading
            function hideLoading() {
                document.getElementById('loading-overlay').classList.add('hidden');
            }

            // Scan RFID
            function scanRfid(rfidCode) {
                if (!rfidCode) {
                    showStatus(false, 'Error', 'RFID Code tidak boleh kosong!');
                    return;
                }

                showLoading();

                fetch('{{ route('public.presensi-siswa.scan') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            rfid_code: rfidCode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();

                        if (data.success) {
                            showStatus(true, 'Berhasil!', data.message, data.data);
                            addToRecentActivity(data.data, 'success');
                        } else {
                            showStatus(false, 'Gagal!', data.message, data.data);
                            addToRecentActivity(data.data, 'error');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        showStatus(false, 'Error', 'Terjadi kesalahan pada server!');
                        console.error('Error:', error);
                    });
            }

            // Auto scan when RFID is detected
            function handleRfidInput() {
                const rfidInput = document.getElementById('manual-rfid');
                const rfidCode = rfidInput.value.trim();

                if (rfidCode && rfidCode.length >= 10) { // Minimum 10 karakter untuk RFID
                    scanRfid(rfidCode);
                    rfidInput.value = '';
                    return true; // Indikator bahwa auto-scan berhasil
                }
                return false; // Auto-scan tidak berhasil
            }

            // Manual scan with Enter key
            function scanManual() {
                const rfidInput = document.getElementById('manual-rfid');
                const rfidCode = rfidInput.value.trim();

                if (rfidCode && rfidCode.length >= 10) {
                    scanRfid(rfidCode);
                    rfidInput.value = '';
                } else if (rfidCode && rfidCode.length < 10) {
                    alert('RFID Code harus minimal 10 karakter!');
                } else {
                    alert('Masukkan RFID Code terlebih dahulu!');
                }
            }

            // Refresh riwayat presensi dari database
            function refreshRiwayatPresensi() {
                fetch('{{ route('public.presensi-siswa.riwayat') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateRiwayatDisplay(data.data);
                        }
                    })
                    .catch(error => {
                        console.error('Error refreshing riwayat:', error);
                    });
            }

            // Update display riwayat presensi
            function updateRiwayatDisplay(riwayatData) {
                const recentActivity = document.getElementById('recent-activity');

                if (riwayatData.length === 0) {
                    recentActivity.innerHTML = `
                        <div class="text-center text-gray-500 py-4">
                            <i class="fas fa-inbox text-2xl mb-1"></i>
                            <p class="text-sm">Belum ada aktivitas presensi</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                riwayatData.forEach(presensi => {
                    const statusClass = presensi.jenis_presensi === 'masuk' ? 'bg-blue-500' : 'bg-orange-500';
                    const statusIcon = presensi.jenis_presensi === 'masuk' ? 'fa-sign-in-alt' : 'fa-sign-out-alt';
                    const statusText = presensi.jenis_presensi === 'masuk' ? 'Masuk' : 'Keluar';
                    const statusTextClass = presensi.jenis_presensi === 'masuk' ? 'text-blue-600' : 'text-orange-600';

                    const jamPresensi = presensi.jam_presensi ? new Date('1970-01-01T' + presensi.jam_presensi).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '-';
                    const waktuPresensi = new Date(presensi.created_at).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    // Foto siswa
                    const fotoSiswa = presensi.foto_siswa ?
                        `<img src="/storage/${presensi.foto_siswa}" alt="${presensi.nama_lengkap}" class="w-full h-full object-cover">` :
                        `<i class="fas fa-user text-gray-500 text-lg"></i>`;

                    html += `
                        <div class="flex items-center justify-between bg-white p-2 rounded-md shadow-sm border">
                            <div class="flex items-center">
                                <!-- Foto Siswa -->
                                <div class="w-10 h-10 rounded-full overflow-hidden mr-3 bg-gray-200 flex items-center justify-center">
                                    ${fotoSiswa}
                                </div>

                                <!-- Status Icon -->
                                <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 ${statusClass}">
                                    <i class="fas ${statusIcon} text-white text-xs"></i>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-800">${presensi.nama_lengkap}</p>
                                    <p class="text-xs text-gray-600">${presensi.nama_kelas || '-'} • ${waktuPresensi}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium ${statusTextClass}">
                                    ${statusText}
                                </p>
                                <p class="text-xs text-gray-500">
                                    ${jamPresensi}
                                </p>
                            </div>
                        </div>
                    `;
                });

                recentActivity.innerHTML = html;
            }

            // Add to recent activity (legacy function for compatibility)
            function addToRecentActivity(data, type) {
                // Refresh riwayat dari database instead of adding manually
                refreshRiwayatPresensi();
            }

            // Simulate RFID scanner (for demo purposes)
            // In real implementation, this would be handled by RFID hardware
            document.addEventListener('keydown', function(event) {
                // Simulate RFID scan with Enter key + random number
                if (event.key === 'Enter' && event.ctrlKey) {
                    const testRfid = 'TEST' + Math.floor(Math.random() * 1000);
                    scanRfid(testRfid);
                }
            });

            // Auto focus on RFID input
            document.getElementById('manual-rfid').focus();

            // Auto refresh riwayat setiap 30 detik
            setInterval(refreshRiwayatPresensi, 30000);

            // Event listeners for RFID input
            let inputTimeout;
            document.getElementById('manual-rfid').addEventListener('input', function() {
                // Clear previous timeout
                clearTimeout(inputTimeout);

                // Auto scan when RFID is detected (minimum 10 characters for your RFID cards)
                if (this.value.length >= 10) {
                    // Add small delay to prevent multiple triggers
                    inputTimeout = setTimeout(() => {
                        handleRfidInput();
                    }, 100);
                }
            });

            // Enter key for manual input
            document.getElementById('manual-rfid').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    // Cek dulu apakah auto-scan sudah berjalan
                    const rfidCode = this.value.trim();
                    if (rfidCode && rfidCode.length >= 10) {
                        // Jika sudah 10+ karakter, biarkan auto-scan yang handle
                        return;
                    } else {
                        // Jika belum 10 karakter, jalankan manual scan
                        scanManual();
                    }
                }
            });
        </script>
</body>

</html>

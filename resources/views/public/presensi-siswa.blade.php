<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa - Tap RFID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        * {
            font-family: 'Poppins', sans-serif !important;
        }

        .swal2-popup-custom {
            border-radius: 20px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-family: 'Poppins', sans-serif !important;
        }

        .swal2-confirm-custom {
            border-radius: 12px !important;
            font-weight: 600 !important;
            padding: 12px 24px !important;
            font-size: 14px !important;
            box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.3) !important;
            transition: all 0.3s ease !important;
        }

        .swal2-confirm-custom:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px 0 rgba(16, 185, 129, 0.4) !important;
        }

        .swal2-timer-progress-bar {
            background: linear-gradient(90deg, #10B981, #059669) !important;
        }

        .swal2-success-circular-line-left,
        .swal2-success-circular-line-right,
        .swal2-success-fix {
            background-color: #10B981 !important;
        }

        .swal2-success-ring {
            border-color: #10B981 !important;
        }

        .swal2-success-line-tip,
        .swal2-success-line-long {
            background-color: #10B981 !important;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }


        /* Ionicons styling */
        ion-icon {
            display: inline-block;
            vertical-align: middle;
        }

        .swal2-popup-custom ion-icon {
            color: inherit !important;
        }

        /* Success Animation Styles */
        @keyframes checkmark-bounce {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes success-pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
            }
        }

        .success-checkmark {
            animation: checkmark-bounce 0.6s ease-out;
        }

        .success-pulse {
            animation: success-pulse 2s infinite;
        }
    </style>
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

<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen">
    <div
        class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 flex flex-col items-center justify-center relative">
        <!-- Background Shadow Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-10 left-10 w-72 h-72 bg-green-500 rounded-full filter blur-3xl"></div>
            <div class="absolute top-20 right-20 w-80 h-80 bg-emerald-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-20 left-1/3 w-64 h-64 bg-green-400 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-10 right-1/3 w-76 h-76 bg-emerald-400 rounded-full filter blur-3xl"></div>
        </div>
        <!-- Header dengan Jam Digital Besar -->
        <div class="container mx-auto px-4 mb-8 relative z-10">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-6 shadow-lg p-2">
                    <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo Persis Alamin"
                        class="w-full h-full object-contain">
                </div>

                <!-- Jam Digital Besar -->
                <div class="bg-gradient-to-r from-green-600 to-green-800 rounded-xl p-6 shadow-2xl mb-3">
                    <div class="text-center">
                        <div id="digital-date" class="text-xl font-semibold text-green-200 mb-2"></div>
                        <div id="digital-time" class="text-6xl font-mono font-bold text-white tracking-wider"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content - Dua Kolom -->
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                <!-- Kolom Kiri - Instruksi Tap to Presence -->
                <div class="bg-white rounded-xl shadow-xl p-4">
                    <div class="text-center mb-4">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full mb-3 relative shadow-lg">
                            <ion-icon name="finger-print" class="text-white" style="font-size: 32px;"></ion-icon>
                            <div
                                class="absolute inset-0 rounded-full border-2 border-white border-opacity-30 animate-pulse">
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Tap to Presence</h2>
                        <p class="text-sm text-gray-600 mb-4">Tempelkan kartu RFID Anda di area scanner untuk melakukan
                            presensi</p>

                        <!-- RFID Scanner Visual -->
                        <div
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-3 border-2 border-dashed border-blue-300 mb-4">
                            <div class="flex items-center justify-center mb-2">
                                <ion-icon name="wifi" class="text-2xl text-blue-500 mr-2"
                                    style="font-size: 24px;"></ion-icon>
                                <span class="text-lg font-semibold text-blue-700">RFID Scanner</span>
                            </div>
                            <p class="text-sm text-blue-600">Area ini akan mendeteksi kartu RFID Anda secara otomatis
                            </p>
                        </div>

                        <!-- Input RFID -->
                        <div class="bg-white border border-gray-300 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                <ion-icon name="card" class="text-blue-500 mr-2" style="font-size: 16px;"></ion-icon>
                                <span class="text-sm font-semibold text-gray-700">RFID Reader</span>
                            </div>
                            <div class="relative">
                                <input type="text" id="manual-rfid"
                                    placeholder="Tempelkan kartu RFID atau ketik manual"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                    autocomplete="off">
                                <div class="absolute right-2 top-2">
                                    <ion-icon name="wifi" class="text-blue-500 text-sm animate-pulse"
                                        style="font-size: 14px;"></ion-icon>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">RFID akan terbaca otomatis atau tekan Enter untuk
                                input manual</p>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan - Siswa Terbaru yang Berhasil Absen -->
                <div class="bg-white rounded-xl shadow-xl p-4">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Siswa Terbaru</h2>
                    <p class="text-sm text-gray-600 text-center mb-4">{{ \Carbon\Carbon::now()->format('l, d F Y') }}
                    </p>

                    <!-- Layout Foto dan Data Siswa Bersebelahan -->
                    <div class="mt-4">
                        <div id="recent-activity" class="flex items-center justify-center">
                            @if (isset($riwayatPresensi) && $riwayatPresensi->count() > 0)
                                @php
                                    $presensiTerbaru = $riwayatPresensi->first();
                                @endphp
                                <!-- Container Foto dan Data - Full Width -->
                                <div class="w-full">
                                    <div
                                        class="flex items-center space-x-4 p-4 {{ $presensiTerbaru->jenis_presensi == 'masuk' ? 'bg-gradient-to-r from-green-50 to-green-100' : 'bg-gradient-to-r from-red-50 to-red-100' }} rounded-xl shadow-lg border {{ $presensiTerbaru->jenis_presensi == 'masuk' ? 'border-green-200' : 'border-red-200' }}">

                                        <!-- Foto Siswa -->
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-32 h-48 rounded-lg overflow-hidden bg-gray-200 flex items-center justify-center shadow-lg">
                                                @if (
                                                    $presensiTerbaru->foto_siswa &&
                                                        file_exists(public_path('storage/photos/pendaftaran/' . $presensiTerbaru->foto_siswa)))
                                                    <img src="{{ asset('storage/photos/pendaftaran/' . $presensiTerbaru->foto_siswa) }}"
                                                        alt="{{ $presensiTerbaru->nama_lengkap }}"
                                                        class="w-full h-auto object-contain">
                                                @else
                                                    <ion-icon name="person" class="text-gray-500"
                                                        style="font-size: 48px;"></ion-icon>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Data Siswa dalam Tabel -->
                                        <div class="flex-grow">
                                            <h3 class="text-lg font-bold text-gray-800 mb-3 text-center">
                                                {{ $presensiTerbaru->nama_lengkap }}</h3>

                                            <table class="w-full text-sm  rounded-lg">
                                                <tbody>
                                                    <tr class="border-b border-gray-200">
                                                        <td class="py-2 font-semibold text-gray-600 w-1/3">Unit
                                                            Pendidikan</td>
                                                        <td class="py-2 text-gray-800">
                                                            {{ $presensiTerbaru->nama_unit ?? '-' }}</td>
                                                    </tr>
                                                    <tr class="border-b border-gray-200">
                                                        <td class="py-2 font-semibold text-gray-600 w-1/3">Kelas
                                                        </td>
                                                        <td class="py-2 text-gray-800">
                                                            {{ $presensiTerbaru->nama_kelas ?? '-' }}</td>
                                                    </tr>
                                                    <tr class="border-b border-gray-200">
                                                        <td class="py-2 font-semibold text-gray-600 w-1/3">Waktu
                                                            Presensi</td>
                                                        <td class="py-2 text-gray-800 font-mono">
                                                            {{ \Carbon\Carbon::parse($presensiTerbaru->created_at)->format('H:i') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-2 font-semibold text-gray-600 w-1/3">Status
                                                        </td>
                                                        <td class="py-2">
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $presensiTerbaru->jenis_presensi == 'masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                <ion-icon
                                                                    name="{{ $presensiTerbaru->jenis_presensi == 'masuk' ? 'log-in' : 'log-out' }}"
                                                                    class="mr-1"
                                                                    style="font-size: 10px;"></ion-icon>
                                                                {{ $presensiTerbaru->jenis_presensi == 'masuk' ? 'Masuk' : 'Pulang' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-gray-500 py-8">
                                    <div
                                        class="w-32 h-auto rounded-lg bg-gray-200 flex items-center justify-center mx-auto mb-4">
                                        <ion-icon name="person" class="text-gray-400"
                                            style="font-size: 48px;"></ion-icon>
                                    </div>
                                    <p class="text-sm">Belum ada siswa yang absen</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div id="loading-overlay"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
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
                // Show Sweet Alert for error messages only
                if (!success) {
                    Swal.fire({
                        icon: 'error',
                        title: title,
                        text: message,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#EF4444',
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else {
                    // For successful presensi, show success animation first
                    showSuccessAnimation(data);
                }
            }

            // Show success animation with checklist
            function showSuccessAnimation(data) {
                const recentActivity = document.getElementById('recent-activity');

                // Show success animation
                recentActivity.innerHTML = `
                    <div class="w-full flex items-center justify-center">
                        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl shadow-lg border border-green-200 p-8 text-center">
                            <!-- Success Icon with Animation -->
                            <div class="mb-6">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-500 shadow-lg success-pulse">
                                    <ion-icon name="checkmark-circle" class="text-white success-checkmark" style="font-size: 48px;"></ion-icon>
                                </div>
                            </div>
                            
                            <!-- Success Message -->
                            <h3 class="text-2xl font-bold text-green-800 mb-2">Berhasil Absen!</h3>
                            <p class="text-green-600 text-lg">Data presensi telah tercatat</p>
                            
                            <!-- Loading indicator -->
                            <div class="mt-4">
                                <div class="inline-flex items-center text-green-600">
                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-green-600 mr-2"></div>
                                    <span class="text-sm">Memuat data...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // After 3 seconds, refresh the riwayat to show actual data
                setTimeout(() => {
                    refreshRiwayatPresensi();
                }, 3000);
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
                    .then(response => {
                        hideLoading();
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showStatus(true, 'Berhasil!', data.message, data.data);
                            addToRecentActivity(data.data, 'success');
                        } else {
                            // Tampilkan pesan error yang lebih spesifik
                            let errorTitle = 'Gagal Presensi!';
                            let errorMessage = data.message;

                            if (data.message.includes('tidak ditemukan')) {
                                errorTitle = 'Siswa Tidak Ditemukan';
                                errorMessage = 'RFID Code tidak terdaftar dalam sistem. Silakan hubungi admin.';
                            } else if (data.message.includes('sudah melakukan presensi')) {
                                errorTitle = 'Sudah Presensi';
                                errorMessage = 'Anda sudah melakukan presensi keluar hari ini.';
                            } else if (data.message.includes('sudah ada presensi')) {
                                errorTitle = 'Presensi Sudah Ada';
                                errorMessage = 'Presensi untuk hari ini sudah tercatat.';
                            }

                            showStatus(false, errorTitle, errorMessage, data.data);
                            addToRecentActivity(data.data, 'error');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        showStatus(false, 'Error Server', 'Terjadi kesalahan pada server. Silakan coba lagi.');
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
                    Swal.fire({
                        icon: 'warning',
                        title: 'RFID Code Terlalu Pendek',
                        text: 'RFID Code harus minimal 10 karakter!',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#F59E0B'
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'RFID Code Kosong',
                        text: 'Masukkan RFID Code terlebih dahulu!',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3B82F6'
                    });
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

            // Update display riwayat presensi - hanya menampilkan 1 siswa terbaru
            function updateRiwayatDisplay(riwayatData) {
                const recentActivity = document.getElementById('recent-activity');

                if (riwayatData.length === 0) {
                    recentActivity.innerHTML = `
                        <div class="text-center text-gray-500 py-8">
                            <div class="w-32 h-auto rounded-lg bg-gray-200 flex items-center justify-center mx-auto mb-4">
                                <ion-icon name="person" class="text-gray-400" style="font-size: 48px;"></ion-icon>
                            </div>
                            <p class="text-sm">Belum ada siswa yang absen</p>
                        </div>
                    `;
                    return;
                }

                // Ambil hanya siswa terbaru (pertama dalam array)
                const presensi = riwayatData[0];
                const statusClass = presensi.jenis_presensi === 'masuk' ? 'bg-green-500' : 'bg-red-500';
                const statusIcon = presensi.jenis_presensi === 'masuk' ? 'log-in' : 'log-out';
                const statusText = presensi.jenis_presensi === 'masuk' ? 'Masuk' : 'Pulang';
                const statusTextClass = presensi.jenis_presensi === 'masuk' ? 'text-green-600' : 'text-red-600';

                const waktuPresensi = new Date(presensi.created_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Foto siswa
                const fotoSiswa = presensi.foto_siswa ?
                    `<img src="/storage/photos/pendaftaran/${presensi.foto_siswa}" alt="${presensi.nama_lengkap}" class="w-full h-auto object-contain">` :
                    `<ion-icon name="person" class="text-gray-500" style="font-size: 48px;"></ion-icon>`;

                const html = `
                    <!-- Container Foto dan Data - Full Width -->
                    <div class="w-full">
                        <div class="flex items-center space-x-4 p-4 ${presensi.jenis_presensi === 'masuk' ? 'bg-gradient-to-r from-green-50 to-green-100' : 'bg-gradient-to-r from-red-50 to-red-100'} rounded-xl shadow-lg border ${presensi.jenis_presensi === 'masuk' ? 'border-green-200' : 'border-red-200'}">
                            
                                <!-- Foto Siswa -->
                            <div class="flex-shrink-0">
                                <div class="w-32 h-48 rounded-lg overflow-hidden bg-gray-200 flex items-center justify-center shadow-lg">
                                    ${fotoSiswa}
                                </div>
                            </div>

                            <!-- Data Siswa dalam Tabel -->
                            <div class="flex-grow">
                                <h3 class="text-lg font-bold text-gray-800 mb-3 text-center">${presensi.nama_lengkap}</h3>
                                
                                <table class="w-full text-sm  rounded-lg">
                                        <tbody>
                                            <tr class="border-b border-gray-200">
                                                <td class="py-2 font-semibold text-gray-600 w-1/3">Unit Pendidikan</td>
                                                <td class="py-2 text-gray-800">${presensi.nama_unit || '-'}</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="py-2 font-semibold text-gray-600 w-1/3">Kelas</td>
                                                <td class="py-2 text-gray-800">${presensi.nama_kelas || '-'}</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="py-2 font-semibold text-gray-600 w-1/3">Waktu Presensi</td>
                                                <td class="py-2 text-gray-800 font-mono">${waktuPresensi}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 font-semibold text-gray-600 w-1/3">Status</td>
                                                <td class="py-2">
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium ${presensi.jenis_presensi === 'masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                                        <ion-icon name="${statusIcon}" class="mr-1" style="font-size: 10px;"></ion-icon>
                                    ${statusText}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;

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

            // Keep cursor always focused on RFID input
            function keepFocusOnRfid() {
                const rfidInput = document.getElementById('manual-rfid');
                if (document.activeElement !== rfidInput) {
                    rfidInput.focus();
                }
            }

            // Focus on RFID input when clicking anywhere on the page
            document.addEventListener('click', function(event) {
                // Don't refocus if clicking on the input itself or its container
                if (!event.target.closest('#manual-rfid') && !event.target.closest(
                        '.bg-white.border.border-gray-300.rounded-lg.p-3')) {
                    setTimeout(keepFocusOnRfid, 100);
                }
            });

            // Focus on RFID input when pressing any key (except when typing in input)
            document.addEventListener('keydown', function(event) {
                const rfidInput = document.getElementById('manual-rfid');
                if (document.activeElement !== rfidInput && event.key !== 'Tab') {
                    rfidInput.focus();
                }
            });

            // Keep focus when window regains focus
            window.addEventListener('focus', function() {
                setTimeout(keepFocusOnRfid, 100);
            });

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

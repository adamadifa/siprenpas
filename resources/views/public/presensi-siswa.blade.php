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

                <!-- Kolom Kanan - Riwayat Presensi -->
                <div class="bg-white rounded-xl shadow-xl p-4">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Riwayat Presensi Hari Ini</h2>
                    <p class="text-sm text-gray-600 text-center mb-4">{{ \Carbon\Carbon::now()->format('l, d F Y') }}
                    </p>


                    <!-- Recent Activity -->
                    <div class="mt-4">
                        <div id="recent-activity" class="space-y-2">
                            @if (isset($riwayatPresensi) && $riwayatPresensi->count() > 0)
                                @foreach ($riwayatPresensi as $presensi)
                                    <div
                                        class="flex items-center justify-between {{ $presensi->jenis_presensi == 'masuk' ? 'bg-gradient-to-r from-green-50 to-green-100' : 'bg-gradient-to-r from-red-50 to-red-100' }} p-4 rounded-lg shadow-md border {{ $presensi->jenis_presensi == 'masuk' ? 'border-green-200' : 'border-red-200' }}">
                                        <div class="flex items-center">
                                            <!-- Foto Siswa -->
                                            <div
                                                class="w-12 h-12 rounded-full overflow-hidden mr-4 bg-gray-200 flex items-center justify-center">
                                                @if ($presensi->foto_siswa && file_exists(public_path('storage/photos/pendaftaran/' . $presensi->foto_siswa)))
                                                    <img src="{{ asset('storage/photos/pendaftaran/' . $presensi->foto_siswa) }}"
                                                        alt="{{ $presensi->nama_lengkap }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <i class="fas fa-user text-gray-500 text-lg"></i>
                                                @endif
                                            </div>

                                            <!-- Status Icon -->
                                            <div
                                                class="w-8 h-8 rounded-full flex items-center justify-center mr-3 {{ $presensi->jenis_presensi == 'masuk' ? 'bg-green-500' : 'bg-red-500' }}">
                                                <ion-icon
                                                    name="{{ $presensi->jenis_presensi == 'masuk' ? 'log-in' : 'log-out' }}"
                                                    class="text-white" style="font-size: 16px;"></ion-icon>
                                            </div>

                                            <div>
                                                <p class="text-base font-semibold text-gray-800">
                                                    {{ $presensi->nama_lengkap }}</p>
                                                <div class="flex items-center space-x-2 text-sm">
                                                    <div
                                                        class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                        <ion-icon name="business" class="mr-1"
                                                            style="font-size: 12px;"></ion-icon>
                                                        <span>{{ $presensi->nama_unit ?? '-' }}</span>
                                                    </div>
                                                    <div
                                                        class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                        <ion-icon name="school" class="mr-1"
                                                            style="font-size: 12px;"></ion-icon>
                                                        <span>{{ $presensi->nama_kelas ?? '-' }}</span>
                                                    </div>
                                                    <div
                                                        class="inline-flex items-center px-2 py-1 text-orange-600 text-xs font-medium">
                                                        <ion-icon name="time" class="mr-1"
                                                            style="font-size: 12px;"></ion-icon>
                                                        <span
                                                            class="font-mono">{{ \Carbon\Carbon::parse($presensi->created_at)->format('H:i') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center justify-end mb-1">
                                                <ion-icon
                                                    name="{{ $presensi->jenis_presensi == 'masuk' ? 'log-in' : 'log-out' }}"
                                                    class="text-sm mr-2 {{ $presensi->jenis_presensi == 'masuk' ? 'text-green-500' : 'text-red-500' }}"
                                                    style="font-size: 14px;"></ion-icon>
                                                <p
                                                    class="text-sm font-semibold {{ $presensi->jenis_presensi == 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $presensi->jenis_presensi == 'masuk' ? 'Masuk' : 'Pulang' }}
                                                </p>
                                            </div>
                                            <div class="flex items-center justify-end">
                                                <ion-icon name="time" class="text-sm text-gray-400 mr-2"
                                                    style="font-size: 14px;"></ion-icon>
                                                <p class="text-sm text-gray-500 font-mono">
                                                    {{ $presensi->jam_presensi ? \Carbon\Carbon::parse($presensi->jam_presensi)->format('H:i') : '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-gray-500 py-4">
                                    <ion-icon name="archive" class="text-2xl mb-1"
                                        style="font-size: 24px;"></ion-icon>
                                    <p class="text-sm">Belum ada aktivitas presensi</p>
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
                // Show Sweet Alert for error messages
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
                    // Show success message with Sweet Alert
                    let htmlContent = '';

                    if (data) {
                        // Get current time for display
                        const now = new Date();
                        const currentTime = now.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        // Determine status and color
                        const isMasuk = data.status === 'masuk';
                        const statusText = isMasuk ? 'MASUK' : 'PULANG';
                        const statusColor = isMasuk ? '#10B981' : '#EF4444'; // Green for masuk, red for pulang
                        const statusIcon = isMasuk ? 'log-in' : 'log-out';

                        // Check if photo exists
                        const fotoSiswa = data.foto_siswa && data.foto_siswa.trim() !== '' ?
                            `<img src="/storage/photos/pendaftaran/${data.foto_siswa}" alt="${data.nama}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                             <div class="w-full h-full flex items-center justify-center" style="display: none;">
                                <i class="fas fa-user text-5xl text-gray-400"></i>
                             </div>` :
                            `<i class="fas fa-user text-5xl text-gray-400"></i>`;

                        htmlContent = `
                            <div class="text-center" style="font-family: 'Poppins', sans-serif;">
                                <!-- Header with Success Icon -->
                                <div class="mb-6">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background: linear-gradient(135deg, ${statusColor}20, ${statusColor}10);">
                                        <ion-icon name="${statusIcon}" style="font-size: 32px; color: ${statusColor};"></ion-icon>
                                    </div>
                                    <h2 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Poppins', sans-serif;">Presensi Berhasil!</h2>
                                    <p class="text-gray-600 text-sm">Data presensi telah tercatat dengan baik</p>
                                </div>
                                
                                <!-- Student Photo with Enhanced Design -->
                                <div class="mb-6">
                                    <div class="w-24 h-24 rounded-full overflow-hidden mx-auto bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center shadow-xl border-4 border-white relative" style="border-color: ${statusColor}30;">
                                        ${fotoSiswa}
                                        <!-- Enhanced status indicator ring -->
                                        <div class="absolute -inset-1 rounded-full border-2" style="border-color: ${statusColor}40;"></div>
                                    </div>
                                </div>
                                
                                <!-- Student Name with Enhanced Typography -->
                                <h3 class="text-xl font-bold text-gray-900 mb-4" style="font-family: 'Poppins', sans-serif;">${data.nama || '-'}</h3>
                                
                                <!-- Enhanced Status Badge -->
                                <div class="inline-flex items-center px-6 py-3 rounded-full mb-6 shadow-lg" style="background: linear-gradient(135deg, ${statusColor}20, ${statusColor}10); border: 2px solid ${statusColor}30;">
                                    <ion-icon name="${statusIcon}" class="mr-3" style="font-size: 20px; color: ${statusColor};"></ion-icon>
                                    <span class="font-bold text-lg" style="font-family: 'Poppins', sans-serif; color: ${statusColor};">${statusText}</span>
                                </div>
                                
                                <!-- Enhanced Student Info Cards -->
                                <div class="mb-6">
                                    <div class="grid grid-cols-1 gap-3">
                                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center mr-3">
                                                    <ion-icon name="business" style="font-size: 18px; color: white !important;"></ion-icon>
                                                </div>
                                                <span class="text-gray-700 font-semibold text-sm" style="font-family: 'Poppins', sans-serif;">Unit Pendidikan</span>
                                            </div>
                                            <span class="font-bold text-gray-900 text-base" style="font-family: 'Poppins', sans-serif;">${data.unit || '-'}</span>
                                        </div>
                                        
                                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl border border-emerald-200">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center mr-3">
                                                    <ion-icon name="school" style="font-size: 18px; color: white !important;"></ion-icon>
                                                </div>
                                                <span class="text-gray-700 font-semibold text-sm" style="font-family: 'Poppins', sans-serif;">Kelas</span>
                                            </div>
                                            <span class="font-bold text-gray-900 text-base" style="font-family: 'Poppins', sans-serif;">${data.kelas || '-'}</span>
                                        </div>
                                        
                                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl border border-orange-200">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center mr-3">
                                                    <ion-icon name="time" style="font-size: 18px; color: white !important;"></ion-icon>
                                                </div>
                                                <span class="text-gray-700 font-semibold text-sm" style="font-family: 'Poppins', sans-serif;">Waktu Presensi</span>
                                            </div>
                                            <span class="font-mono font-bold text-gray-900 text-base">${currentTime}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Enhanced Success Message -->
                                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-4 border border-green-200 shadow-sm">
                                    <div class="flex items-center justify-center mb-2">
                                        <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center mr-2">
                                            <ion-icon name="checkmark-circle" class="text-white" style="font-size: 16px;"></ion-icon>
                                        </div>
                                        <span class="text-gray-800 font-semibold text-sm" style="font-family: 'Poppins', sans-serif;">Presensi Tercatat</span>
                                    </div>
                                    <p class="text-gray-600 text-sm" style="font-family: 'Poppins', sans-serif;">${message}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        htmlContent = `
                            <div class="text-center">
                                <p class="text-lg font-semibold text-gray-800 mb-2">${title}</p>
                                <p class="text-gray-600">${message}</p>
                            </div>
                        `;
                    }

                    Swal.fire({
                        icon: false,
                        title: '',
                        html: htmlContent,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#10B981',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: true,
                        customClass: {
                            popup: 'swal2-popup-custom',
                            confirmButton: 'swal2-confirm-custom'
                        },
                        didOpen: () => {
                            // Add entrance animation
                            const popup = Swal.getPopup();
                            popup.style.transform = 'scale(0.8)';
                            popup.style.opacity = '0';

                            // Animate in
                            popup.animate([{
                                    transform: 'scale(0.8)',
                                    opacity: '0'
                                },
                                {
                                    transform: 'scale(1)',
                                    opacity: '1'
                                }
                            ], {
                                duration: 300,
                                easing: 'cubic-bezier(0.34, 1.56, 0.64, 1)',
                                fill: 'forwards'
                            });

                        }
                    });
                }

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

            // Update display riwayat presensi
            function updateRiwayatDisplay(riwayatData) {
                const recentActivity = document.getElementById('recent-activity');

                if (riwayatData.length === 0) {
                    recentActivity.innerHTML = `
                        <div class="text-center text-gray-500 py-4">
                            <ion-icon name="archive" class="text-2xl mb-1" style="font-size: 24px;"></ion-icon>
                            <p class="text-sm">Belum ada aktivitas presensi</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                riwayatData.forEach(presensi => {
                    const statusClass = presensi.jenis_presensi === 'masuk' ? 'bg-green-500' : 'bg-red-500';
                    const statusIcon = presensi.jenis_presensi === 'masuk' ? 'log-in' : 'log-out';
                    const statusText = presensi.jenis_presensi === 'masuk' ? 'Masuk' : 'Pulang';
                    const statusTextClass = presensi.jenis_presensi === 'masuk' ? 'text-green-600' : 'text-red-600';

                    const jamPresensi = presensi.jam_presensi ? new Date('1970-01-01T' + presensi.jam_presensi)
                        .toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }) : '-';
                    const waktuPresensi = new Date(presensi.created_at).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    // Foto siswa
                    const fotoSiswa = presensi.foto_siswa ?
                        `<img src="/storage/photos/pendaftaran/${presensi.foto_siswa}" alt="${presensi.nama_lengkap}" class="w-full h-full object-cover rounded-full">` :
                        `<div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center">
                            <ion-icon name="person" class="text-gray-500" style="font-size: 20px;"></ion-icon>
                        </div>`;

                    html += `
                        <div class="flex items-center justify-between ${presensi.jenis_presensi === 'masuk' ? 'bg-gradient-to-r from-green-50 to-green-100' : 'bg-gradient-to-r from-red-50 to-red-100'} p-4 rounded-lg shadow-md border ${presensi.jenis_presensi === 'masuk' ? 'border-green-200' : 'border-red-200'}">
                            <div class="flex items-center">
                                <!-- Foto Siswa -->
                                <div class="w-12 h-12 rounded-full overflow-hidden mr-4 bg-gray-200 flex items-center justify-center">
                                    ${fotoSiswa}
                                </div>

                                <!-- Status Icon -->
                                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 ${statusClass}">
                                    <ion-icon name="${statusIcon}" class="text-white" style="font-size: 16px;"></ion-icon>
                                </div>

                                <div>
                                    <p class="text-base font-semibold text-gray-800">${presensi.nama_lengkap}</p>
                                    <div class="flex items-center space-x-2 text-sm">
                                        <div class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                            <ion-icon name="business" class="mr-1" style="font-size: 12px;"></ion-icon>
                                            <span>${presensi.nama_unit || '-'}</span>
                                        </div>
                                        <div class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                            <ion-icon name="school" class="mr-1" style="font-size: 12px;"></ion-icon>
                                            <span>${presensi.nama_kelas || '-'}</span>
                                        </div>
                                        <div class="inline-flex items-center px-2 py-1 text-orange-600 text-xs font-medium">
                                            <ion-icon name="time" class="mr-1" style="font-size: 12px;"></ion-icon>
                                            <span class="font-mono">${waktuPresensi}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center justify-end mb-1">
                                    <ion-icon name="${statusIcon}" class="text-sm mr-2 ${presensi.jenis_presensi === 'masuk' ? 'text-green-500' : 'text-red-500'}" style="font-size: 14px;"></ion-icon>
                                    <p class="text-sm font-semibold ${statusTextClass}">
                                    ${statusText}
                                </p>
                                </div>
                                <div class="flex items-center justify-end">
                                    <ion-icon name="time" class="text-sm text-gray-400 mr-2" style="font-size: 14px;"></ion-icon>
                                    <p class="text-sm text-gray-500 font-mono">
                                    ${jamPresensi}
                                </p>
                                </div>
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

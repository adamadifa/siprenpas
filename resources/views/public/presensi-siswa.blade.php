<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart RFID Attendance - Pesantren Persatuan Islam 80 Al Amin</title>
    
    <!-- Google Fonts: Plus Jakarta Sans, Noto Sans Arabic & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        arabic: ['"Noto Sans Arabic"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        cyber: {
                            cyan: '#06b6d4',
                            amber: '#f59e0b',
                            emerald: '#10b981',
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'ping-slow': 'ping 2s cubic-bezier(0, 0, 0.2, 1) infinite',
                        'radar': 'radar 3s linear infinite',
                        'scanline': 'scanline 2.5s ease-in-out infinite alternate',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        radar: {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' },
                        },
                        scanline: {
                            '0%': { transform: 'translateY(-100%)', opacity: '0.2' },
                            '50%': { opacity: '0.8' },
                            '100%': { transform: 'translateY(1000%)', opacity: '0.2' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-8px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #04130f;
        }

        .arabic-text {
            font-family: 'Noto Sans Arabic', 'Plus Jakarta Sans', sans-serif;
        }

        /* Islamic Geometric Pattern Overlay */
        .bg-islamic-pattern {
            background-image: radial-gradient(rgba(16, 185, 129, 0.12) 1.5px, transparent 1.5px),
                              radial-gradient(rgba(6, 182, 212, 0.08) 1.5px, transparent 1.5px);
            background-size: 32px 32px;
            background-position: 0 0, 16px 16px;
        }

        /* Glowing Border & HUD Card Effects */
        .hud-card {
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.4) 0%, rgba(2, 44, 34, 0.7) 100%);
            border: 1px solid rgba(52, 211, 153, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37), inset 0 0 16px rgba(16, 185, 129, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .hud-card-active {
            border: 1px solid rgba(52, 211, 153, 0.45);
            box-shadow: 0 12px 40px 0 rgba(16, 185, 129, 0.15), inset 0 0 24px rgba(16, 185, 129, 0.15);
        }

        .hud-badge {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(52, 211, 153, 0.3);
        }

        /* Custom SweetAlert in Dark Cyber Islamic Theme */
        .swal2-popup-custom {
            background: #064e3b !important;
            border: 1px solid rgba(52, 211, 153, 0.4) !important;
            color: #ffffff !important;
            border-radius: 24px !important;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7) !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .swal2-title, .swal2-html-container {
            color: #ffffff !important;
        }

        /* Pulse glow */
        .glow-emerald {
            box-shadow: 0 0 35px rgba(16, 185, 129, 0.35);
        }

        .glow-cyan {
            box-shadow: 0 0 35px rgba(6, 182, 212, 0.35);
        }
    </style>
</head>

<body class="h-full text-slate-100 flex flex-col justify-between overflow-x-hidden relative bg-[#031510]">

    <!-- ================= BACKGROUND TECH AMBIENCE ================= -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <!-- Islamic Pattern Grid -->
        <div class="absolute inset-0 bg-islamic-pattern opacity-60"></div>

        <!-- Ambient Tech Nebula Lights -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute top-1/3 -right-32 w-96 h-96 bg-teal-500/15 rounded-full blur-[140px]"></div>
        <div class="absolute -bottom-32 left-1/3 w-[500px] h-96 bg-cyan-600/15 rounded-full blur-[150px]"></div>
        
        <!-- Glowing Top Border Line -->
        <div class="absolute top-0 inset-x-0 h-[2px] bg-gradient-to-r from-transparent via-emerald-400 to-transparent opacity-75"></div>
    </div>

    <!-- ================= TOP HEADER (ISLAMIC & TECH INTEGRATED) ================= -->
    <header class="relative z-10 pt-5 pb-3 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Left: Brand & Islamic Salutation -->
            <div class="flex items-center gap-4 text-center md:text-left">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-2xl blur-xs opacity-60 group-hover:opacity-100 transition duration-300"></div>
                    <div class="relative w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-slate-900/90 border border-emerald-400/40 p-2 flex items-center justify-center shadow-xl">
                        <img src="{{ asset('assets/img/logo/persisalamin.png') }}" 
                             alt="Logo Persis Al Amin" 
                             class="w-full h-full object-contain filter drop-shadow-md"
                             onerror="this.src='/assets/img/logo/persisalamin.png'">
                    </div>
                </div>

                <div>
                    <!-- Arabic School Name: Ma'had Al-Ittihad Al-Islami 80 Al-Amin -->
                    <div class="arabic-text text-emerald-300 text-sm sm:text-base font-medium tracking-normal leading-snug">
                        معهد الإتحاد الإسلامي ٨٠ الأمين
                    </div>
                    <h1 class="text-base sm:text-xl font-black text-white tracking-tight flex items-center gap-2 justify-center md:justify-start">
                        <span>Smart RFID Attendance System</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                            v2.4 IoT
                        </span>
                    </h1>
                    <p class="text-xs text-emerald-100/70 font-medium">
                        Pesantren Persatuan Islam 80 Al Amin Sindangkasih Ciamis
                    </p>
                </div>
            </div>

            <!-- Right: Tech HUD Date & Realtime Clock -->
            <div class="flex items-center gap-3 self-center md:self-auto hud-card px-5 py-3 rounded-2xl border border-emerald-500/30 shadow-lg">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-xl border border-emerald-400/30">
                    <i class="ti ti-clock-hour-4 animate-pulse-slow"></i>
                </div>
                <div class="text-right">
                    <div id="digital-date" class="text-[11px] font-bold text-emerald-200 uppercase tracking-widest font-mono">
                        MEMUAT TANGGAL...
                    </div>
                    <div id="digital-time" class="text-2xl sm:text-3xl font-black text-white font-mono tracking-tight leading-none text-emerald-400 mt-0.5">
                        00:00:00
                    </div>
                </div>
                <!-- Pulsing live indicator -->
                <div class="flex flex-col items-center gap-1 pl-2 border-l border-white/15">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <span class="text-[9px] font-black text-emerald-300 uppercase tracking-tighter">ONLINE</span>
                </div>
            </div>

        </div>
    </header>

    <!-- ================= MAIN SCANNER WORKSPACE ================= -->
    <main class="relative z-10 flex-1 flex items-center py-4 px-4 sm:px-8">
        <div class="max-w-7xl w-full mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            
            <!-- ================= LEFT COLUMN: RFID SCANNER PORTAL (5 Cols) ================= -->
            <div class="lg:col-span-5 flex flex-col justify-between hud-card rounded-3xl p-6 sm:p-7 border border-emerald-500/30 relative overflow-hidden group">
                
                <!-- Background Geometric Watermark -->
                <div class="absolute -right-12 -bottom-12 text-emerald-500/5 pointer-events-none">
                    <i class="ti ti-nfc text-[240px]"></i>
                </div>

                <!-- Top Scanner Status Badge -->
                <div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold hud-badge text-emerald-300">
                            <i class="ti ti-radar animate-spin" style="animation-duration: 4s;"></i>
                            <span>NFC / RFID Reader Standby</span>
                        </span>
                        <span class="text-[11px] font-mono font-bold text-emerald-400/80">
                            ID: SCANNER-GATE-01
                        </span>
                    </div>

                    <!-- Interactive Holographic Radar Visualizer -->
                    <div class="my-6 relative flex flex-col items-center justify-center">
                        <!-- Outer Radar Rings -->
                        <div class="relative w-48 h-48 sm:w-56 sm:h-56 rounded-full border-2 border-emerald-500/25 flex items-center justify-center p-4">
                            <!-- Animated Pulse Rings -->
                            <div class="absolute inset-0 rounded-full border border-emerald-400/20 animate-ping-slow"></div>
                            <div class="absolute inset-3 rounded-full border border-dashed border-teal-400/30 animate-radar"></div>
                            <div class="absolute inset-8 rounded-full border border-emerald-500/40"></div>

                            <!-- Central Glowing Tap Target -->
                            <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full bg-gradient-to-tr from-emerald-600 via-teal-600 to-emerald-400 p-0.5 shadow-2xl glow-emerald flex items-center justify-center animate-float">
                                <div class="w-full h-full rounded-full bg-[#04241c] flex flex-col items-center justify-center text-center p-3">
                                    <i class="ti ti-wifi text-3xl text-emerald-300 animate-pulse"></i>
                                    <span class="text-[11px] font-black uppercase tracking-wider text-emerald-200 mt-1">TAP DISINI</span>
                                </div>
                            </div>
                        </div>

                        <!-- Scanner Guidance Message -->
                        <div class="mt-4 text-center">
                            <h2 class="text-lg sm:text-xl font-black text-white tracking-tight">
                                Tempelkan Smart Card RFID
                            </h2>
                            <p class="text-xs text-emerald-200/75 mt-1 max-w-xs mx-auto">
                                Dekatkan kartu santri ke sensor pembaca untuk mencatat waktu kehadiran harian
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RFID Input Box (Always Focused & Listening) -->
                <div class="space-y-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-400">
                            <i class="ti ti-credit-card text-lg"></i>
                        </div>
                        <input type="text" 
                               id="manual-rfid"
                               placeholder="Menunggu sensor kartu atau input manual..."
                               class="w-full pl-11 pr-12 py-3 bg-black/40 border border-emerald-500/40 rounded-xl text-white font-mono text-sm placeholder-emerald-300/40 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition tracking-wider shadow-inner"
                               autocomplete="off"
                               autofocus>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-emerald-400">
                            <i class="ti ti-sparkles text-sm animate-pulse"></i>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[11px] text-emerald-200/70 px-1">
                        <span class="flex items-center gap-1.5">
                            <i class="ti ti-info-circle text-emerald-400"></i>
                            <span>Sensor otomatis merekam input 10 digit</span>
                        </span>
                        <span class="font-mono text-emerald-300/90 font-bold">Auto-Scan [ON]</span>
                    </div>
                </div>

            </div>

            <!-- ================= RIGHT COLUMN: LIVE RECENT ATTENDANCE DISPLAY (7 Cols) ================= -->
            <div class="lg:col-span-7 flex flex-col justify-between hud-card rounded-3xl p-6 sm:p-7 border border-emerald-500/30 relative overflow-hidden">
                
                <!-- Section Header -->
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-lg border border-emerald-400/30">
                            <i class="ti ti-user-check"></i>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-black text-white tracking-tight">
                                Log Santri Terverifikasi
                            </h3>
                            <p class="text-[11px] text-emerald-200/70">Aktivitas kehadiran santri terbaru hari ini</p>
                        </div>
                    </div>

                    <span class="px-3 py-1 rounded-full text-[11px] font-bold hud-badge text-emerald-300 flex items-center gap-1.5">
                        <i class="ti ti-history text-xs"></i>
                        <span>Live Feed</span>
                    </span>
                </div>

                <!-- Dynamic Recent Activity Display Container -->
                <div id="recent-activity" class="my-auto py-4">
                    @if (isset($riwayatPresensi) && $riwayatPresensi->count() > 0)
                        @php
                            $presensiTerbaru = $riwayatPresensi->first();
                            $isMasuk = $presensiTerbaru->jenis_presensi == 'masuk';
                            
                            $photoUrl = null;
                            if ($presensiTerbaru->foto_siswa) {
                                if (file_exists(public_path('storage/photos/pendaftaran/' . $presensiTerbaru->foto_siswa))) {
                                    $photoUrl = asset('storage/photos/pendaftaran/' . $presensiTerbaru->foto_siswa);
                                } elseif (file_exists(public_path('storage/' . $presensiTerbaru->foto_siswa))) {
                                    $photoUrl = asset('storage/' . $presensiTerbaru->foto_siswa);
                                }
                            }
                        @endphp

                        <div class="w-full bg-gradient-to-br {{ $isMasuk ? 'from-emerald-950/70 via-emerald-900/40 to-teal-950/60 border-emerald-500/40' : 'from-rose-950/70 via-rose-900/40 to-red-950/60 border-rose-500/40' }} rounded-2xl p-5 sm:p-6 border shadow-2xl relative overflow-hidden transition-all duration-300">
                            
                            <!-- Top Status Chip -->
                            <div class="flex items-center justify-between gap-2 mb-4 pb-3 border-b border-white/10">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black {{ $isMasuk ? 'bg-emerald-500 text-white shadow-xs' : 'bg-rose-500 text-white shadow-xs' }}">
                                    <i class="ti {{ $isMasuk ? 'ti-login' : 'ti-logout' }} text-sm"></i>
                                    <span>PRESENSI {{ strtoupper($presensiTerbaru->jenis_presensi) }} SUKSES</span>
                                </span>
                                <span class="font-mono text-xs font-bold text-white/90">
                                    {{ \Carbon\Carbon::parse($presensiTerbaru->created_at)->format('H:i:s') }} WIB
                                </span>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 sm:gap-6">
                                
                                <!-- Student Photo Hologram Frame -->
                                <div class="relative shrink-0 group">
                                    <div class="w-32 h-40 sm:w-36 sm:h-44 rounded-2xl overflow-hidden bg-slate-900/80 border-2 {{ $isMasuk ? 'border-emerald-400/60' : 'border-rose-400/60' }} shadow-xl relative flex items-center justify-center p-1">
                                        @if ($photoUrl)
                                            <img src="{{ $photoUrl }}" 
                                                 alt="{{ $presensiTerbaru->nama_lengkap }}" 
                                                 class="w-full h-full object-cover rounded-xl filter drop-shadow-md">
                                        @else
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <i class="ti ti-user text-5xl"></i>
                                                <span class="text-[10px] font-bold mt-1 uppercase text-slate-400">No Photo</span>
                                            </div>
                                        @endif
                                        
                                        <!-- Tech Corner Accents -->
                                        <div class="absolute top-1 left-1 w-2 h-2 border-t-2 border-l-2 {{ $isMasuk ? 'border-emerald-300' : 'border-rose-300' }}"></div>
                                        <div class="absolute bottom-1 right-1 w-2 h-2 border-b-2 border-r-2 {{ $isMasuk ? 'border-emerald-300' : 'border-rose-300' }}"></div>
                                    </div>
                                </div>

                                <!-- Student Details Grid -->
                                <div class="flex-1 w-full text-center sm:text-left">
                                    <h4 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight">
                                        {{ $presensiTerbaru->nama_lengkap }}
                                    </h4>
                                    <p class="text-xs font-bold text-emerald-300 mt-0.5">
                                        No. Reg: {{ $presensiTerbaru->no_pendaftaran ?? '-' }}
                                    </p>

                                    <!-- Key Metrics Table -->
                                    <div class="grid grid-cols-2 gap-2.5 mt-4">
                                        <div class="bg-black/30 rounded-xl p-2.5 border border-white/10">
                                            <div class="text-[10px] uppercase font-bold text-slate-400 flex items-center gap-1 justify-center sm:justify-start">
                                                <i class="ti ti-school text-emerald-400"></i>
                                                <span>Unit Pendidikan</span>
                                            </div>
                                            <div class="text-xs sm:text-sm font-black text-white mt-0.5 truncate">
                                                {{ $presensiTerbaru->nama_unit ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="bg-black/30 rounded-xl p-2.5 border border-white/10">
                                            <div class="text-[10px] uppercase font-bold text-slate-400 flex items-center gap-1 justify-center sm:justify-start">
                                                <i class="ti ti-door-enter text-teal-400"></i>
                                                <span>Kelas / Rombel</span>
                                            </div>
                                            <div class="text-xs sm:text-sm font-black text-white mt-0.5 truncate">
                                                {{ $presensiTerbaru->nama_kelas ?? 'Belum Diplot' }}
                                            </div>
                                        </div>

                                        <div class="bg-black/30 rounded-xl p-2.5 border border-white/10">
                                            <div class="text-[10px] uppercase font-bold text-slate-400 flex items-center gap-1 justify-center sm:justify-start">
                                                <i class="ti ti-clock text-cyan-400"></i>
                                                <span>Waktu Scan</span>
                                            </div>
                                            <div class="text-xs sm:text-sm font-black text-white font-mono mt-0.5">
                                                {{ \Carbon\Carbon::parse($presensiTerbaru->created_at)->format('H:i') }} WIB
                                            </div>
                                        </div>

                                        <div class="bg-black/30 rounded-xl p-2.5 border border-white/10">
                                            <div class="text-[10px] uppercase font-bold text-slate-400 flex items-center gap-1 justify-center sm:justify-start">
                                                <i class="ti ti-activity text-amber-400"></i>
                                                <span>Status</span>
                                            </div>
                                            <div class="text-xs sm:text-sm font-black text-emerald-300 mt-0.5">
                                                Hadir Tepat Waktu
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @else
                        <!-- Standby Empty State -->
                        <div class="text-center py-12 px-4 rounded-2xl bg-black/20 border border-white/5">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-3xl mx-auto mb-3 border border-emerald-500/20">
                                <i class="ti ti-id-badge-2"></i>
                            </div>
                            <h4 class="text-base font-bold text-white">Belum Ada Presensi Hari Ini</h4>
                            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                Tempelkan kartu smart RFID untuk memverifikasi dan menampilkan data santri
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Footer Info Strip -->
                <div class="pt-3 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-emerald-200/60">
                    <span class="flex items-center gap-1">
                        <i class="ti ti-shield-check text-emerald-400"></i>
                        <span>Enkripsi RFID Smart Gate Terlindungi</span>
                    </span>
                    <span class="font-mono text-emerald-300/80">Sistem Presensi Digital Terpadu</span>
                </div>

            </div>

        </div>
    </main>

    <!-- ================= FOOTER (ISLAMIC MOTTO & WATERMARK) ================= -->
    <footer class="relative z-10 py-3 px-4 text-center border-t border-white/10 bg-black/30 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-emerald-200/70">
            <span class="arabic-text text-xs sm:text-sm text-emerald-300/90 font-normal">
                مَنْ جَدَّ وَجَدَ • Barangsiapa yang bersungguh-sungguh, maka ia akan berhasil
            </span>
            <span class="font-medium">
                © {{ date('Y') }} Pesantren Persatuan Islam 80 Al Amin Sindangkasih Ciamis. Hak Cipta Dilindungi.
            </span>
        </div>
    </footer>

    <!-- ================= LOADING OVERLAY ================= -->
    <div id="loading-overlay" class="fixed inset-0 bg-black/75 backdrop-blur-md flex items-center justify-center hidden z-50 transition-opacity">
        <div class="hud-card p-6 rounded-3xl border border-emerald-400/50 text-center shadow-2xl max-w-xs mx-4">
            <div class="relative w-16 h-16 mx-auto mb-4">
                <div class="absolute inset-0 rounded-full border-3 border-emerald-400/20"></div>
                <div class="w-16 h-16 border-3 border-emerald-400 border-t-transparent rounded-full animate-spin"></div>
                <i class="ti ti-fingerprint text-emerald-300 text-2xl absolute inset-0 m-auto flex items-center justify-center"></i>
            </div>
            <h4 class="text-sm font-black text-white">Memproses Kartu RFID...</h4>
            <p class="text-xs text-emerald-200/75 mt-1 font-mono">Sinkronisasi Basis Data Pesantren</p>
        </div>
    </div>

    <!-- ================= SCRIPTS ================= -->
    <script>
        // Update Realtime Islamic Digital Clock
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

            const dateStr = now.toLocaleDateString('id-ID', dateOptions);
            const timeStr = now.toLocaleTimeString('id-ID', timeOptions);

            const elDate = document.getElementById('digital-date');
            const elTime = document.getElementById('digital-time');
            if (elDate) elDate.textContent = dateStr;
            if (elTime) elTime.textContent = timeStr;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();

        // Show Status & Animations
        function showStatus(success, title, message, data = null) {
            if (!success) {
                Swal.fire({
                    customClass: {
                        popup: 'swal2-popup-custom'
                    },
                    icon: 'error',
                    title: title,
                    text: message,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#ef4444',
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#04241c',
                    color: '#ffffff'
                });
            } else {
                showSuccessAnimation(data);
            }
        }

        // Show Success Animation with Holographic Feedback
        function showSuccessAnimation(data) {
            const recentActivity = document.getElementById('recent-activity');
            if (!recentActivity) return;

            const isMasuk = !data || !data.status || data.status === 'masuk';

            recentActivity.innerHTML = `
                <div class="w-full bg-gradient-to-br from-emerald-950/90 via-teal-900/60 to-emerald-900/80 rounded-2xl p-8 border border-emerald-400/60 shadow-2xl text-center animate-pulse">
                    <div class="w-20 h-20 rounded-full bg-emerald-500/20 text-emerald-300 border-2 border-emerald-400 mx-auto mb-4 flex items-center justify-center text-4xl shadow-xl">
                        <i class="ti ti-check"></i>
                    </div>
                    <div class="arabic-text text-emerald-300 text-base mb-1 font-medium">
                        أَهْلًا وَسَهْلًا • Selamat Datang
                    </div>
                    <h3 class="text-2xl font-black text-white tracking-tight">Presensi Berhasil Diverifikasi!</h3>
                    <p class="text-sm font-semibold text-emerald-200 mt-1">${data && data.nama ? data.nama : 'Data santri telah berhasil direkam'}</p>
                    
                    <div class="mt-4 inline-flex items-center gap-2 text-xs font-mono text-emerald-300 bg-black/40 px-3 py-1 rounded-full border border-emerald-500/30">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></div>
                        <span>Memperbarui log sistem...</span>
                    </div>
                </div>
            `;

            setTimeout(() => {
                refreshRiwayatPresensi();
            }, 2500);
        }

        // Loading Overlay Helpers
        function showLoading() {
            const el = document.getElementById('loading-overlay');
            if (el) el.classList.remove('hidden');
        }

        function hideLoading() {
            const el = document.getElementById('loading-overlay');
            if (el) el.classList.add('hidden');
        }

        // Scan RFID Request
        function scanRfid(rfidCode) {
            if (!rfidCode) {
                showStatus(false, 'Kartu Tidak Terdeteksi', 'RFID Code tidak boleh kosong!');
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
                        showStatus(true, 'Alhamdulillah!', data.message, data.data);
                    } else {
                        let errorTitle = 'Gagal Presensi';
                        let errorMessage = data.message;

                        if (data.message && data.message.includes('tidak ditemukan')) {
                            errorTitle = 'Santri Tidak Ditemukan';
                            errorMessage = 'Kartu RFID belum terdaftar di sistem. Silakan daftarkan kartu di kantor administrasi.';
                        } else if (data.message && data.message.includes('sudah melakukan presensi')) {
                            errorTitle = 'Sudah Presensi Keluar';
                            errorMessage = 'Presensi keluar untuk hari ini sudah tercatat sebelumnya.';
                        }

                        showStatus(false, errorTitle, errorMessage, data.data);
                    }
                })
                .catch(error => {
                    hideLoading();
                    showStatus(false, 'Gangguan Jaringan', 'Terjadi kesalahan koneksi ke server. Silakan coba lagi.');
                    console.error('Error:', error);
                });
        }

        // Auto Scan on RFID Detection
        function handleRfidInput() {
            const rfidInput = document.getElementById('manual-rfid');
            if (!rfidInput) return false;
            const rfidCode = rfidInput.value.trim();

            if (rfidCode && rfidCode.length >= 10) {
                scanRfid(rfidCode);
                rfidInput.value = '';
                return true;
            }
            return false;
        }

        // Refresh Riwayat from Database
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

        // Render Recent Activity Card
        function updateRiwayatDisplay(riwayatData) {
            const recentActivity = document.getElementById('recent-activity');
            if (!recentActivity) return;

            if (!riwayatData || riwayatData.length === 0) {
                recentActivity.innerHTML = `
                    <div class="text-center py-12 px-4 rounded-2xl bg-black/20 border border-white/5">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-3xl mx-auto mb-3 border border-emerald-500/20">
                            <i class="ti ti-id-badge-2"></i>
                        </div>
                        <h4 class="text-base font-bold text-white">Belum Ada Presensi Hari Ini</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                            Tempelkan kartu smart RFID untuk memverifikasi dan menampilkan data santri
                        </p>
                    </div>
                `;
                return;
            }

            const presensi = riwayatData[0];
            const isMasuk = presensi.jenis_presensi === 'masuk';
            const waktuPresensi = new Date(presensi.created_at).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            let fotoSiswaHtml = '';
            if (presensi.foto_siswa) {
                fotoSiswaHtml = `<img src="/storage/photos/pendaftaran/${presensi.foto_siswa}" alt="${presensi.nama_lengkap}" class="w-full h-full object-cover rounded-xl filter drop-shadow-md" onerror="this.src='/storage/${presensi.foto_siswa}'">`;
            } else {
                fotoSiswaHtml = `
                    <div class="flex flex-col items-center justify-center text-slate-400">
                        <i class="ti ti-user text-5xl"></i>
                        <span class="text-[10px] font-bold mt-1 uppercase text-slate-400">No Photo</span>
                    </div>
                `;
            }

            const html = `
                <div class="w-full bg-gradient-to-br ${isMasuk ? 'from-emerald-950/70 via-emerald-900/40 to-teal-950/60 border-emerald-500/40' : 'from-rose-950/70 via-rose-900/40 to-red-950/60 border-rose-500/40'} rounded-2xl p-5 sm:p-6 border shadow-2xl relative overflow-hidden transition-all duration-300">
                    
                    <!-- Top Status Chip -->
                    <div class="flex items-center justify-between gap-2 mb-4 pb-3 border-b border-white/10">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black ${isMasuk ? 'bg-emerald-500 text-white shadow-xs' : 'bg-rose-500 text-white shadow-xs'}">
                            <i class="ti ${isMasuk ? 'ti-login' : 'ti-logout'} text-sm"></i>
                            <span>PRESENSI ${presensi.jenis_presensi.toUpperCase()} SUKSES</span>
                        </span>
                        <span class="font-mono text-xs font-bold text-white/90">
                            ${waktuPresensi} WIB
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 sm:gap-6">
                        
                        <!-- Student Photo Hologram Frame -->
                        <div class="relative shrink-0 group">
                            <div class="w-32 h-40 sm:w-36 sm:h-44 rounded-2xl overflow-hidden bg-slate-900/80 border-2 ${isMasuk ? 'border-emerald-400/60' : 'border-rose-400/60'} shadow-xl relative flex items-center justify-center p-1">
                                ${fotoSiswaHtml}
                                <!-- Tech Corner Accents -->
                                <div class="absolute top-1 left-1 w-2 h-2 border-t-2 border-l-2 ${isMasuk ? 'border-emerald-300' : 'border-rose-300'}"></div>
                                <div class="absolute bottom-1 right-1 w-2 h-2 border-b-2 border-r-2 ${isMasuk ? 'border-emerald-300' : 'border-rose-300'}"></div>
                            </div>
                        </div>

                        <!-- Student Details Grid -->
                        <div class="flex-1 w-full text-center sm:text-left">
                            <h4 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-tight">
                                ${presensi.nama_lengkap}
                            </h4>
                            <p class="text-xs font-bold text-emerald-300 mt-0.5">
                                No. Reg: ${presensi.no_pendaftaran || '-'}
                            </p>

                            <!-- Key Metrics Table -->
                            <div class="grid grid-cols-2 gap-2.5 mt-4">
                                <div class="bg-black/30 rounded-xl p-2.5 border border-white/10">
                                    <div class="text-[10px] uppercase font-bold text-slate-400 flex items-center gap-1 justify-center sm:justify-start">
                                        <i class="ti ti-school text-emerald-400"></i>
                                        <span>Unit Pendidikan</span>
                                    </div>
                                    <div class="text-xs sm:text-sm font-black text-white mt-0.5 truncate">
                                        ${presensi.nama_unit || '-'}
                                    </div>
                                </div>

                                <div class="bg-black/30 rounded-xl p-2.5 border border-white/10">
                                    <div class="text-[10px] uppercase font-bold text-slate-400 flex items-center gap-1 justify-center sm:justify-start">
                                        <i class="ti ti-door-enter text-teal-400"></i>
                                        <span>Kelas / Rombel</span>
                                    </div>
                                    <div class="text-xs sm:text-sm font-black text-white mt-0.5 truncate">
                                        ${presensi.nama_kelas || 'Belum Diplot'}
                                    </div>
                                </div>

                                <div class="bg-black/30 rounded-xl p-2.5 border border-white/10">
                                    <div class="text-[10px] uppercase font-bold text-slate-400 flex items-center gap-1 justify-center sm:justify-start">
                                        <i class="ti ti-clock text-cyan-400"></i>
                                        <span>Waktu Scan</span>
                                    </div>
                                    <div class="text-xs sm:text-sm font-black text-white font-mono mt-0.5">
                                        ${waktuPresensi} WIB
                                    </div>
                                </div>

                                <div class="bg-black/30 rounded-xl p-2.5 border border-white/10">
                                    <div class="text-[10px] uppercase font-bold text-slate-400 flex items-center gap-1 justify-center sm:justify-start">
                                        <i class="ti ti-activity text-amber-400"></i>
                                        <span>Status</span>
                                    </div>
                                    <div class="text-xs sm:text-sm font-black text-emerald-300 mt-0.5">
                                        Hadir Tepat Waktu
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            `;

            recentActivity.innerHTML = html;
        }

        // Permanent Auto-Focus on RFID input
        const rfidInput = document.getElementById('manual-rfid');

        function keepFocusOnRfid() {
            if (rfidInput && document.activeElement !== rfidInput) {
                rfidInput.focus();
            }
        }

        document.addEventListener('click', function(event) {
            setTimeout(keepFocusOnRfid, 100);
        });

        document.addEventListener('keydown', function(event) {
            if (document.activeElement !== rfidInput && event.key !== 'Tab') {
                rfidInput.focus();
            }
        });

        window.addEventListener('focus', function() {
            setTimeout(keepFocusOnRfid, 100);
        });

        // Event listener for RFID card input
        let inputTimeout;
        if (rfidInput) {
            rfidInput.addEventListener('input', function() {
                clearTimeout(inputTimeout);
                if (this.value.length >= 10) {
                    inputTimeout = setTimeout(() => {
                        handleRfidInput();
                    }, 120);
                }
            });

            rfidInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const code = this.value.trim();
                    if (code) {
                        scanRfid(code);
                        this.value = '';
                    }
                }
            });
        }

        // Auto refresh feed every 30s
        setInterval(refreshRiwayatPresensi, 30000);
    </script>
</body>

</html>

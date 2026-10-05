<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#047857">
    <title>Masuk - {{ $pengaturan && $pengaturan->nama_aplikasi ? $pengaturan->nama_aplikasi : 'SIPREN' }} | {{ $pengaturan && $pengaturan->nama_sekolah ? $pengaturan->nama_sekolah : 'Pesantren Persatuan Islam 80 Al Amin' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/favicon/favicon.ico') }}" />

    <!-- Google Fonts: Plus Jakarta Sans, Noto Sans Arabic & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'spin-slow': 'spin 25s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .arabic-text {
            font-family: 'Noto Sans Arabic', 'Plus Jakarta Sans', sans-serif;
        }

        /* Geometric Islamic Pattern Background Overlay */
        .bg-islamic-pattern {
            background-image: radial-gradient(rgba(16, 185, 129, 0.15) 1.5px, transparent 1.5px),
                              radial-gradient(rgba(255, 255, 255, 0.08) 1.5px, transparent 1.5px);
            background-size: 32px 32px;
            background-position: 0 0, 16px 16px;
        }

        /* Glassmorphism card */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>

    @laravelPWA
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white flex items-center justify-center p-0 sm:p-4 lg:p-6">

    <!-- MAIN CONTAINER (SPLIT 2-COLUMN LUXURY EMERALD CARD) -->
    <div class="w-full max-w-6xl min-h-screen sm:min-h-[640px] lg:min-h-[700px] bg-white sm:rounded-3xl shadow-2xl shadow-emerald-950/20 border border-slate-100 overflow-hidden flex flex-col lg:flex-row relative">

        <!-- ================= LEFT COLUMN: LUXURY EMERALD SHOWCASE (ISLAMIC TECH HERO) ================= -->
        <div class="relative lg:w-[54%] bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-950 text-white p-8 sm:p-12 lg:p-14 flex flex-col justify-between overflow-hidden">
            
            <!-- Dynamic Background Image Layer with Gradient Overlay -->
            @php
                $bgUrl = ($pengaturan && $pengaturan->background_login) 
                    ? asset('storage/' . $pengaturan->background_login) 
                    : asset('images/bgalamin.png');
            @endphp
            <div class="absolute inset-0 bg-cover bg-center opacity-15 mix-blend-overlay pointer-events-none" style="background-image: url('{{ $bgUrl }}')"></div>
            
            <!-- Islamic Geometric Grid Texture -->
            <div class="absolute inset-0 bg-islamic-pattern opacity-60 pointer-events-none"></div>

            <!-- Ambient Glow Orbs -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Geometric Watermark Circle -->
            <div class="absolute -right-20 top-1/2 -translate-y-1/2 w-80 h-80 rounded-full border border-white/10 opacity-40 animate-spin-slow pointer-events-none hidden lg:block">
                <div class="absolute inset-4 rounded-full border border-dashed border-emerald-400/20"></div>
            </div>

            <!-- TOP BRAND HEADER -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md p-2 border border-white/20 shadow-lg shadow-emerald-950/40 flex items-center justify-center shrink-0">
                    @if ($pengaturan && $pengaturan->logo)
                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="w-full h-full object-contain">
                    @else
                        <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo" class="w-full h-full object-contain">
                    @endif
                </div>
                <div>
                    <span class="inline-block px-2 py-0.5 rounded-full bg-emerald-400/15 border border-emerald-300/30 text-[10px] font-bold text-emerald-200 tracking-wider uppercase mb-0.5">
                        Integrated Islamic System
                    </span>
                    <h2 class="text-sm font-bold tracking-tight text-white/90">
                        {{ $pengaturan && $pengaturan->nama_sekolah ? $pengaturan->nama_sekolah : 'Pesantren Persatuan Islam 80 Al Amin' }}
                    </h2>
                </div>
            </div>

            <!-- MIDDLE HERO CONTENT -->
            <div class="relative z-10 my-10 lg:my-0 space-y-6">
                <!-- Arabic Calligraphy Badge -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-inner">
                    <i class="ti ti-sparkles text-amber-300 text-base animate-pulse"></i>
                    <span class="arabic-text text-sm sm:text-base font-semibold text-emerald-100/95 tracking-wide" dir="rtl">
                        معهد الإتحاد الإسلامي ٨٠ الأمين
                    </span>
                </div>

                <!-- Main Application Title -->
                <div class="space-y-2">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                        {{ $pengaturan && $pengaturan->nama_aplikasi ? strtoupper($pengaturan->nama_aplikasi) : 'SIPREN' }}
                        <span class="text-emerald-400 block text-xl sm:text-2xl font-bold tracking-normal mt-1">
                            Sistem Informasi Pesantren Terpadu
                        </span>
                    </h1>
                    <p class="text-emerald-100/80 text-xs sm:text-sm font-normal leading-relaxed max-w-md">
                        Platform manajemen akademik, kepesantrenan, keuangan syariah, dan layanan presensi terintegrasi modern berbasis biometrik.
                    </p>
                </div>

                <!-- Feature Highlights Badges -->
                <div class="grid grid-cols-2 gap-3 pt-2">
                    <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0">
                            <i class="ti ti-shield-check text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">Single Sign-On</div>
                            <div class="text-[10px] text-emerald-200/70 truncate">Aman & Terenkripsi</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition">
                        <div class="w-8 h-8 rounded-lg bg-teal-500/20 text-teal-300 flex items-center justify-center shrink-0">
                            <i class="ti ti-device-laptop text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">Cloud & Realtime</div>
                            <div class="text-[10px] text-emerald-200/70 truncate">Akses Kapan Saja</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOOTER INFO -->
            <div class="relative z-10 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-emerald-200/70 font-medium">
                <div class="flex items-center gap-1.5">
                    <i class="ti ti-map-pin text-emerald-400"></i>
                    <span>Sindangkasih, Ciamis, Jawa Barat</span>
                </div>
                <div class="text-[11px] font-mono text-emerald-300/80">
                    v2.5 &bull; {{ date('Y') }}
                </div>
            </div>
        </div>

        <!-- ================= RIGHT COLUMN: SLEEK LOGIN FORM ================= -->
        <div class="relative lg:w-[46%] bg-white p-8 sm:p-12 lg:p-14 flex flex-col justify-center"
             x-data="{
                showPassword: false,
                form: { id_user: '{{ old('id_user') }}', password: '' },
                errors: {},
                isFocus: '',
                loading: false,
                validate(field) {
                    this.errors[field] = '';
                    if (!this.form[field]) {
                        this.errors[field] = field === 'id_user' ? 'Email atau username wajib diisi.' : 'Password wajib diisi.';
                    }
                },
                submit(e) {
                    this.validate('id_user');
                    this.validate('password');
                    if (this.errors.id_user || this.errors.password) {
                        e.preventDefault();
                    } else {
                        this.loading = true;
                    }
                }
             }">

            <div class="w-full max-w-md mx-auto space-y-7">
                
                <!-- Form Greeting -->
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                        <i class="ti ti-fingerprint text-sm"></i>
                        <span>Portal Autentikasi</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                        Selamat Datang Kembali 👋
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">
                        Masukkan kredensial akun Anda untuk mengakses sistem.
                    </p>
                </div>

                <!-- Flash / Server Errors -->
                @if ($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-start gap-3 animate-shake shadow-xs">
                        <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 text-sm">
                            <i class="ti ti-alert-circle"></i>
                        </div>
                        <div class="space-y-0.5 pt-0.5">
                            @foreach ($errors->all() as $err)
                                <div>{{ $err }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-3 shadow-xs">
                        <i class="ti ti-circle-check text-emerald-600 text-lg shrink-0"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form id="formAuthentication" action="{{ route('login') }}" method="POST" class="space-y-4" @submit="submit" novalidate>
                    @csrf

                    <!-- Identifier Field (Email / Username) -->
                    <div class="space-y-1.5">
                        <label for="id_user" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Email atau Username
                        </label>
                        <div class="relative group">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 transition-colors duration-200"
                                 :class="errors.id_user ? 'text-rose-500' : (isFocus === 'id_user' ? 'text-emerald-600' : 'text-slate-400')">
                                <i class="ti ti-user text-lg"></i>
                            </div>
                            <input 
                                type="text" 
                                id="id_user" 
                                name="id_user" 
                                x-model="form.id_user"
                                @focus="isFocus = 'id_user'"
                                @blur="isFocus = ''; validate('id_user')"
                                value="{{ old('id_user') }}"
                                placeholder="nama@alamin.sch.id / username" 
                                autofocus
                                required
                                class="w-full bg-slate-50 border rounded-xl py-3 pl-11 pr-4 text-sm font-semibold text-slate-900 outline-none transition-all duration-200 focus:bg-white placeholder:text-slate-400 placeholder:font-normal"
                                :class="errors.id_user ? 'border-rose-400 ring-2 ring-rose-500/10 focus:border-rose-500' : 'border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-500/10'"
                            />
                        </div>
                        <p x-show="errors.id_user" x-cloak x-text="errors.id_user" class="text-rose-500 text-[11px] font-semibold ml-1"></p>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Kata Sandi
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline transition">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 transition-colors duration-200"
                                 :class="errors.password ? 'text-rose-500' : (isFocus === 'password' ? 'text-emerald-600' : 'text-slate-400')">
                                <i class="ti ti-lock text-lg"></i>
                            </div>
                            <input 
                                :type="showPassword ? 'text' : 'password'" 
                                id="password" 
                                name="password" 
                                x-model="form.password"
                                @focus="isFocus = 'password'"
                                @blur="isFocus = ''; validate('password')"
                                placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" 
                                required
                                autocomplete="current-password"
                                class="w-full bg-slate-50 border rounded-xl py-3 pl-11 pr-11 text-sm font-semibold text-slate-900 outline-none transition-all duration-200 focus:bg-white placeholder:text-slate-400 placeholder:font-normal"
                                :class="errors.password ? 'border-rose-400 ring-2 ring-rose-500/10 focus:border-rose-500' : 'border-slate-200 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-500/10'"
                            />
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword" 
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none transition p-1"
                                tabindex="-1">
                                <i :class="showPassword ? 'ti ti-eye-off' : 'ti ti-eye'" class="text-lg"></i>
                            </button>
                        </div>
                        <p x-show="errors.password" x-cloak x-text="errors.password" class="text-rose-500 text-[11px] font-semibold ml-1"></p>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input 
                                type="checkbox" 
                                id="remember-me" 
                                name="remember" 
                                class="w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500 focus:ring-offset-0 cursor-pointer"
                            />
                            <span class="text-xs font-semibold text-slate-600 group-hover:text-slate-800 transition">
                                Ingat sesi login saya
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button 
                            type="submit" 
                            :disabled="loading"
                            class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 active:scale-[0.99] text-white font-bold text-sm tracking-wide shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/40 transition duration-200 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed">
                            <template x-if="loading">
                                <i class="ti ti-loader-2 text-lg animate-spin"></i>
                            </template>
                            <template x-if="!loading">
                                <div class="flex items-center gap-2">
                                    <span>Masuk ke Dashboard</span>
                                    <i class="ti ti-arrow-right text-base"></i>
                                </div>
                            </template>
                        </button>
                    </div>
                </form>

                <!-- Help & Quick Links -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-slate-500 hover:text-emerald-700 font-semibold transition">
                        <i class="ti ti-arrow-left text-sm"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                    <div class="flex items-center gap-1.5 text-slate-400 font-medium">
                        <i class="ti ti-help-circle text-sm text-emerald-600"></i>
                        <span>Bantuan Admin TI</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>
</html>

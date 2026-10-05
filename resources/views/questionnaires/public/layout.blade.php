<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kuisioner & Survei') - Pesantren Persis Al-Amin</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
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
                    }
                }
            }
        }
    </script>
    
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col antialiased selection:bg-emerald-500 selection:text-white relative">
    
    <!-- Background Gradient & Subtle Pattern -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-emerald-50/70 via-slate-50 to-teal-50/50 min-h-screen"></div>

    <!-- Header Navbar -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 shadow-2xs">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <a href="{{ route('questionnaires.list') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo Persis Al-Amin" class="w-9 h-9 rounded-xl bg-white border border-slate-200 shadow-2xs object-contain p-0.5 group-hover:scale-105 transition" />
                <div>
                    <span class="text-sm sm:text-base font-black text-slate-900 tracking-tight block">Kuisioner Publik</span>
                    <span class="text-[10px] font-bold text-emerald-600 block uppercase tracking-wider">Pesantren Persis Al-Amin</span>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ route('questionnaires.list') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-xs border border-emerald-200 shadow-2xs transition active:scale-95">
                    <i class="ti ti-list text-sm"></i>
                    <span class="hidden sm:inline">Daftar Survei</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Content Body -->
    <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-6 py-8 flex flex-col justify-center">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200/80 bg-white/60 backdrop-blur-sm py-5 text-center text-xs text-slate-500 mt-auto">
        <p class="font-medium">&copy; {{ date('Y') }} Pesantren Persis Al-Amin. Seluruh hak cipta dilindungi.</p>
    </footer>

    @stack('myscript')
</body>
</html>

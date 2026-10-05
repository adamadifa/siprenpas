<header class="sticky top-0 z-30 h-16 w-full bg-white border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-6 transition-all duration-300">
    
    <!-- Left: Brand Logo & Sidebar Toggle -->
    <div class="flex items-center gap-4">
        <!-- Logo Brand -->
        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-2 group">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-sm shadow-emerald-600/30">
                <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 16a6 6 0 1 1 6-6 6 6 0 0 1-6 6z"/>
                </svg>
            </div>
            <div class="flex items-center">
                <span class="font-extrabold text-lg tracking-tight text-slate-900 leading-none">
                    Smart<span class="text-emerald-600">HR</span>
                </span>
            </div>
        </a>

        <!-- Desktop Sidebar Toggle Button -->
        <button @click="sidebarOpen = !sidebarOpen" 
                type="button" 
                class="hidden lg:flex items-center justify-center w-7 h-7 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
            <i class="ti ti-layout-sidebar-left-collapse text-lg"></i>
        </button>

        <!-- Mobile Sidebar Toggle Button -->
        <button @click="mobileSidebarOpen = !mobileSidebarOpen" 
                type="button" 
                class="lg:hidden flex items-center justify-center w-8 h-8 rounded-lg text-slate-600 hover:bg-slate-100 transition">
            <i class="ti ti-menu-2 text-lg"></i>
        </button>
    </div>

    <!-- Center: Search Input Bar -->
    <div class="hidden md:flex items-center flex-1 max-w-sm mx-6">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <i class="ti ti-search text-sm"></i>
            </div>
            <input type="text" 
                   placeholder="Search in HRMS" 
                   class="w-full pl-8 pr-20 py-1.5 text-xs bg-slate-50 hover:bg-slate-100/80 focus:bg-white border border-slate-200/90 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition duration-150">
            <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center gap-1">
                <kbd class="px-1.5 py-0.5 text-[9px] font-semibold text-slate-400 bg-white border border-slate-200 rounded shadow-2xs">CTRL + /</kbd>
            </div>
        </div>
    </div>

    <!-- Right: Action Icons & User Profile -->
    <div class="flex items-center gap-1.5 sm:gap-2">
        
        <!-- Fullscreen Button -->
        <button type="button" 
                onclick="document.fullscreenElement ? document.exitFullscreen() : document.documentElement.requestFullscreen()"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition" 
                title="Toggle Fullscreen">
            <i class="ti ti-maximize text-sm"></i>
        </button>

        <!-- Dark Mode Toggle Button -->
        <button type="button" 
                class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition" 
                title="Theme Mode">
            <i class="ti ti-moon text-sm"></i>
        </button>

        <!-- Chat / Message Button -->
        <button type="button" 
                class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 relative transition" 
                title="Messages">
            <i class="ti ti-message text-sm"></i>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-emerald-500 rounded-full ring-2 ring-white"></span>
        </button>

        <!-- Notification Bell -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" 
                    type="button" 
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:text-slate-800 hover:bg-slate-100 relative transition">
                <i class="ti ti-bell text-sm"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
            </button>
            <!-- Dropdown Menu -->
            <div x-show="open" 
                 @click.away="open = false" 
                 x-transition 
                 class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">
                <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                    <span class="font-bold text-xs text-slate-800">Notifikasi</span>
                    <span class="text-[10px] text-emerald-600 font-semibold cursor-pointer">Tandai Dibaca</span>
                </div>
                <div class="p-3 text-center text-xs text-slate-400">
                    Tidak ada notifikasi baru
                </div>
            </div>
        </div>

        <!-- Vertical Divider -->
        <div class="h-5 w-px bg-slate-200 mx-1"></div>

        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" 
                    type="button" 
                    class="flex items-center gap-2 p-1 rounded-xl hover:bg-slate-100 transition text-left">
                <div class="relative">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
            </button>

            <!-- User Menu Modal -->
            <div x-show="open" 
                 @click.away="open = false" 
                 x-transition 
                 class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                <div class="px-4 py-2 border-b border-slate-100">
                    <p class="text-xs font-bold text-slate-800">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
                <div class="py-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <i class="ti ti-user text-sm text-slate-400"></i>
                        Profil Saya
                    </a>
                    <a href="{{ route('pengaturan-umum.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <i class="ti ti-settings text-sm text-slate-400"></i>
                        Pengaturan
                    </a>
                </div>
                @if (session()->has('impersonator_id'))
                    <div class="px-2 py-1.5 border-b border-amber-100 bg-amber-50">
                        <a href="{{ route('users.stop-impersonate') }}" class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs font-bold text-amber-800 hover:bg-amber-100 transition">
                            <i class="ti ti-door-exit text-sm text-amber-600"></i>
                            <span>Kembali ke Admin Utama</span>
                        </a>
                    </div>
                @endif
                <div class="border-t border-slate-100 pt-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 transition font-medium">
                            <i class="ti ti-logout text-sm text-rose-500"></i>
                            Keluar (Logout)
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</header>

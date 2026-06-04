<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sipren')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        :root {
            --primary: #064e3b;      /* Deep green */
            --primary-light: #0d6d53;
            --accent: #10b981;       /* Vibrant emerald */
            --background: #f8fafc;
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-main);
            margin: 0;
            padding: 0;
            touch-action: manipulation;
        }

        .app-container {
            max-width: 480px;
            margin: 0 auto;
            background-color: var(--background);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 0 24px rgba(0, 0, 0, 0.08);
            padding-bottom: 80px; /* Space for bottom nav or general padding */
        }

        /* Header Style */
        .app-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--primary);
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            color: #ffffff;
            border-bottom: 3px solid var(--accent);
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.12);
        }

        .app-header a.back-btn {
            color: #ffffff;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .app-header a.back-btn:active {
            opacity: 0.6;
        }

        .app-header .page-title {
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: -0.01em;
        }

        .app-header .header-right {
            width: 24px;
        }

        /* Bottom Nav styling */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            background: var(--surface);
            border-top: 2px solid var(--border-color);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 8px 0;
            padding-bottom: max(8px, env(safe-area-inset-bottom));
            z-index: 1000;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.03);
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            text-decoration: none !important;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-item ion-icon {
            font-size: 22px;
            color: var(--text-muted);
        }

        .nav-item span {
            font-size: 0.65rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .nav-item.active ion-icon {
            color: var(--primary);
        }

        .nav-item.active span {
            color: var(--primary);
            font-weight: 700;
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="app-container">
        
        <!-- Header -->
        @section('header')
            <header class="app-header">
                <a href="@yield('back-url', 'javascript:history.back();')" class="back-btn">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
                <div class="page-title">@yield('header-title', 'Sipren')</div>
                <div class="header-right">
                    @yield('header-right')
                </div>
            </header>
        @show

        <!-- Content Area -->
        @yield('content')

        <!-- Bottom Navigation -->
        @if(View::hasSection('show-bottom-nav'))
            <div class="bottom-nav">
                <a href="{{ route('dashboard.index') }}" class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <ion-icon name="{{ request()->routeIs('dashboard.index') ? 'home' : 'home-outline' }}"></ion-icon>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('jadwal-pelajaran.index') }}" class="nav-item {{ request()->routeIs('jadwal-pelajaran.index') ? 'active' : '' }}">
                    <ion-icon name="{{ request()->routeIs('jadwal-pelajaran.index') ? 'calendar' : 'calendar-outline' }}"></ion-icon>
                    <span>Jadwal</span>
                </a>
                <a href="{{ route('presensi-mapel.index') }}" class="nav-item {{ request()->routeIs('presensi-mapel.index') ? 'active' : '' }}">
                    <ion-icon name="{{ request()->routeIs('presensi-mapel.index') ? 'checkbox' : 'checkbox-outline' }}"></ion-icon>
                    <span>Presensi</span>
                </a>
                <a href="{{ route('users.editpassword', Crypt::encrypt(Auth::user()->id)) }}" class="nav-item {{ request()->routeIs('users.editpassword') ? 'active' : '' }}">
                    <ion-icon name="{{ request()->routeIs('users.editpassword') ? 'person' : 'person-outline' }}"></ion-icon>
                    <span>Profil</span>
                </a>
            </div>
        @endif

    </div>

    <!-- JS Files -->
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Popper & Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Toastr Setup
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-bottom-center",
                "timeOut": "3000"
            };

            @if ($message = Session::get('success'))
                toastr.success("{{ $message }}", "Berhasil");
            @endif

            @if ($message = Session::get('error'))
                toastr.error("{{ $message }}", "Gagal");
            @endif

            @if ($message = Session::get('warning'))
                toastr.warning("{{ $message }}", "Peringatan");
            @endif
        });
    </script>
    @stack('scripts')
    @stack('myscript')
</body>
</html>

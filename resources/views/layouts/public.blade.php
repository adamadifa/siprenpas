<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title') - {{ $pengaturan && $pengaturan->nama_aplikasi ? $pengaturan->nama_aplikasi : 'Got Talent' }}</title>
    <meta name="description" content="Pendaftaran Al Amin Got Talent" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/persisalamin.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <style>
        body {
            background: #f5f5f9;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .public-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .public-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .public-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .logo-section img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .header-text h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .header-text p {
            color: #6c757d;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .logo-section {
                flex-direction: column;
                text-align: center;
            }

            .header-text h1 {
                font-size: 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="public-container">
        <!-- Header -->
        <div class="public-header">
            <div class="logo-section">
                @if ($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo">
                @else
                    <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo">
                @endif
                <div class="header-text">
                    <h1>{{ $pengaturan && $pengaturan->nama_sekolah ? $pengaturan->nama_sekolah : 'Al Amin Gotong Royong' }}</h1>
                    <p>@yield('subtitle', 'Statistik Pendaftaran Al Amin Got Talent')</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="public-content">
            @yield('content')
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('/assets/') }}" data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titlepage')@if ($pengaturan)
            - {{ $pengaturan->nama_sekolah }}
        @endif
    </title>

    <meta name="description"
        content="@if ($pengaturan) {{ $pengaturan->nama_sekolah }} - {{ $pengaturan->alamat_sekolah }}@else{{ config('app.name') }} @endif" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4CAF50">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/favicon/favicon.ico') }}" />

    <!-- Google Fonts: Inter (Tailwind Default) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @include('layouts.fonts')

    @include('layouts.icons')

    @include('layouts.styles')

    <!-- Custom CSS untuk gradasi sidebar dan font Tailwind -->
    <style>
        html,
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji' !important;
        }

        .layout-menu {
            background: linear-gradient(135deg, #1B5E20 0%, #0A3D0A 100%) !important;
            position: fixed !important;
            height: 100vh !important;
            overflow-y: auto !important;
        }

        /* Styling untuk scrollbar sidebar */
        .layout-menu::-webkit-scrollbar {
            width: 6px;
        }

        .layout-menu::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }

        .layout-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .layout-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .menu-inner {
            background: transparent !important;
        }

        .menu-item .menu-link {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .menu-item.active .menu-link {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            border-radius: 4px !important;
            margin: 0 8px !important;
        }

        .menu-item:hover .menu-link {
            background: #FF9800 !important;
            color: #ffffff !important;
            border-radius: 4px !important;
            margin: 0 8px !important;
        }

        .menu-sub {
            background: rgba(0, 0, 0, 0.2) !important;
        }

        .app-brand {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .app-brand-text {
            color: #ffffff !important;
        }
    </style>

    <!-- Helpers -->
    <script src="{{ asset('/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('/assets/js/config.js') }}"></script>

    @laravelPWA
</head>

<body>
    <!-- Layout wrapper -->
    @php
        $agent = new Jenssegers\Agent\Agent();
    @endphp
    <div class="layout-wrapper layout-content-navbar">
        @if (!$agent->isMobile())
            <div class="layout-container">
                <!-- Sidebar -->

                @include('layouts.sidebar')

                <!-- / Sidebar-->
                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->

                    @include('layouts.navbar')

                    <!-- / Navbar -->

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->

                        <div class="container-fluid flex-grow-1 @if (!$agent->isMobile()) container-p-y @endif ">


                            <h4 class="py-3 mb-4">@yield('navigasi')</h4>

                            @yield('content')
                        </div>
                        <!-- / Content -->

                        <!-- Footer -->
                        @include('layouts.footer')
                        <!-- / Footer -->
                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>
            <!-- / Layout wrapper -->
        @else
            <div class="layout-container">
                <!-- Sidebar -->

                @include('layouts.sidebar')
                <div class="layout-page">
                    <!-- Navbar -->
                    @include('layouts.navbar')
                    <!-- / Navbar -->

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <div class="container-fluid flex-grow-1  ">
                            @yield('content')
                        </div>
                    </div>

                </div>


            </div>
        @endif

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->
    {{-- @if ($agent->isMobile())
        <nav class="navbar fixed-bottom navbar-light bg-white shadow d-md-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><i class="ti ti-user" style="font-size: 20px"></i></a>
                <a class="navbar-brand" href="#"><i class="ti ti-file-description {{ request()->is('aktifitassmm') ? 'text-primary' : '' }}"
                        style="font-size: 20px"></i></a>
                <a class="navbar-brand" href="/dashboard"><i class="fa fa-home {{ request()->is('dashboard') ? 'text-primary' : '' }}"
                        style="font-size: 25px; border-radius: 50%;"></i></a>
                <a class="navbar-brand" href="#"><i class="ti ti-mail" style="font-size: 20px"></i></a>
                <a class="navbar-brand" href="#"><i class="ti ti-help" style="font-size: 20px"></i></a>
            </div>
        </nav>
    @endif --}}
    <!-- Core JS -->
    @include('layouts.scripts')
    <!-- Page JS -->
</body>

</html>

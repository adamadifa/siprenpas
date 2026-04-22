@if (auth()->user()->hasAnyPermission(['izinabsen.index', 'izinsakit.index']))
    <style>
        .nav-pills-custom {
            background: #f1f5f9;
            padding: 5px;
            border-radius: 12px;
            display: inline-flex;
            gap: 5px;
        }

        .nav-pills-custom .nav-link {
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 700;
            font-size: 0.8rem;
            color: #64748b;
            transition: all 0.2s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-pills-custom .nav-link:hover {
            color: #064e3b;
            background: rgba(6, 78, 59, 0.05);
        }

        .nav-pills-custom .nav-link.active {
            background: #064e3b !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);
        }

        .nav-pills-custom .nav-link i {
            font-size: 1.1rem;
        }

        .nav-pills-custom .badge {
            font-size: 0.65rem;
            padding: 4px 8px;
        }

        /* Modern Card Styles Shared across Permission Modules */
        .modern-card {
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .modern-card:hover {
            border-color: #064e3b50 !important;
            background: #fdfdfd;
        }

        .avatar-initial-modern {
            width: 38px;
            height: 38px;
            background: #f0fdf4;
            color: #166534;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 0.65rem;
            font-weight: 800;
        }

        .compact-label {
            font-size: 0.6rem;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 0;
        }

        .compact-value {
            font-size: 0.75rem;
            font-weight: 600;
            color: #334155;
        }

        .extra-small {
            font-size: 0.65rem;
        }
    </style>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-2">
        <ul class="nav nav-pills-custom" role="tablist">
            @can('izinabsen.index')
                <li class="nav-item" role="presentation">
                    <a href="{{ route('izinabsen.index') }}"
                        class="nav-link {{ request()->is(['izinabsen']) ? 'active' : '' }}">
                        <i class="ti ti-file-description"></i>
                        <span>Izin Absen</span>
                        @if (auth()->user()->kode_unit == 'U06' && !empty($notifikasi_izinabsen))
                            <span class="badge bg-danger rounded-pill">{{ $notifikasi_izinabsen }}</span>
                        @endif
                    </a>
                </li>
            @endcan
            @can('izinsakit.index')
                <li class="nav-item" role="presentation">
                    <a href="{{ route('izinsakit.index') }}"
                        class="nav-link {{ request()->is(['izinsakit']) ? 'active' : '' }}">
                        <i class="ti ti-first-aid-kit"></i>
                        <span>Izin Sakit</span>
                        @if (auth()->user()->kode_unit == 'U06' && !empty($notifikasi_izinsakit))
                            <span class="badge bg-danger rounded-pill">{{ $notifikasi_izinsakit }}</span>
                        @endif
                    </a>
                </li>
            @endcan
        </ul>
        <div class="d-flex align-items-center">
            @yield('action_button')
        </div>
    </div>
@endif

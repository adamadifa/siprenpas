<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('/assets/') }}"
    data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4CAF50">
    <title>Login Basic </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('/assets/js/config.js') }}"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            width: 100%;
            position: relative;
        }

        .login-left {
            flex: 2.5;
            background: linear-gradient(135deg, rgba(27, 94, 32, 0.95) 0%, rgba(10, 61, 10, 0.95) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background-image: url('{{ asset('images/bgalamin.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
            min-height: 100vh;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(27, 94, 32, 0.95) 0%, rgba(10, 61, 10, 0.95) 100%);
            z-index: 1;
        }

        .login-left-content {
            position: relative;
            z-index: 5;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            position: absolute;
            top: 0;
            left: 0;
        }

        .login-logo {
            width: 120px;
            height: 120px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
            position: relative;
            z-index: 6;
            animation: logoFloat 3s ease-in-out infinite;
        }

        .brand-text {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 3px;
            position: relative;
            text-shadow:
                2px 2px 0 #1B5E20,
                4px 4px 0 rgba(0, 0, 0, 0.2);
            animation: textShine 3s ease-in-out infinite;
            -webkit-text-fill-color: white;
            margin-bottom: 0.3rem;
            line-height: 1.2;
        }

        .brand-description {
            color: white;
            text-align: center;
            line-height: 1.4;
            font-size: 16px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            font-style: italic;
            font-weight: 300;
        }

        .brand-description p {
            margin: 0.2rem 0;
        }

        @keyframes textShine {
            0% {
                text-shadow:
                    2px 2px 0 #1B5E20,
                    4px 4px 0 rgba(0, 0, 0, 0.2),
                    0 0 20px rgba(255, 255, 255, 0.5);
            }

            50% {
                text-shadow:
                    2px 2px 0 #1B5E20,
                    4px 4px 0 rgba(0, 0, 0, 0.2),
                    0 0 30px rgba(255, 255, 255, 0.8);
            }

            100% {
                text-shadow:
                    2px 2px 0 #1B5E20,
                    4px 4px 0 rgba(0, 0, 0, 0.2),
                    0 0 20px rgba(255, 255, 255, 0.5);
            }
        }

        @keyframes logoFloat {
            0% {
                transform: translateY(0) scale(1);
                filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
            }

            50% {
                transform: translateY(-10px) scale(1.05);
                filter: drop-shadow(0 8px 12px rgba(0, 0, 0, 0.3));
            }

            100% {
                transform: translateY(0) scale(1);
                filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
            }
        }

        .login-left-content h1 {
            font-size: 4.5rem;
            font-weight: 700;
            letter-spacing: 2px;

            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            background: linear-gradient(to right, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-left-content p {
            font-size: 1.5rem;
            opacity: 0.95;
            line-height: 1.4;
            margin-bottom: 0;
            font-weight: 400;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: #ffffff;
        }

        .login-form-container {
            width: 100%;
            max-width: 380px;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 2rem;
        }

        .welcome-text h4 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .welcome-text p {
            color: #666;
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        .form-control {
            padding: 0.8rem;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .input-group-text {
            border-radius: 0 8px 8px 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1B5E20 0%, #0A3D0A 100%);
            border: none;
            padding: 0.8rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0A3D0A 0%, #1B5E20 100%);
        }

        .form-control:focus {
            border-color: #1B5E20;
            box-shadow: 0 0 0 0.2rem rgba(27, 94, 32, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .divider-text {
            color: #666;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-left {
                min-height: 300px;
            }

            .login-right {
                padding: 2rem;
            }

            .login-left-content h1 {
                font-size: 3rem;
            }

            .login-left-content p {
                font-size: 1.2rem;
            }
        }
    </style>
    @laravelPWA
</head>

<body>
    <div class="login-container">
        <!-- Left Side -->
        <div class="login-left">
            <div class="login-left-content">
                @if ($pengaturan && $pengaturan->logo)
                    <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo" class="login-logo">
                @else
                    <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo" class="login-logo">
                @endif
                <div class="brand-text">SIPREN</div>
                <div class="brand-description">
                    @if ($pengaturan)
                        <p>{{ $pengaturan->nama_sekolah }}</p>
                        <p>{{ $pengaturan->alamat_sekolah }}</p>
                    @else
                        <p>Sistem Informasi Pesantren Persatuan Islam 80 Al Amin</p>
                        <p>Sindangkasih - Ciamis</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="login-right">
            <div class="login-form-container">
                <!-- Logo -->
                <div class="app-brand justify-content-center mb-4 mt-2">
                    @if ($pengaturan && $pengaturan->logo)
                        <img src="{{ asset('storage/' . $pengaturan->logo) }}" alt="" width="120">
                    @else
                        <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="" width="120">
                    @endif
                </div>
                <!-- /Logo -->
                <div class="welcome-text">
                    <h4>Selamat Datang! 👋</h4>
                    <p>Silahkan login untuk melanjutkan</p>
                </div>

                <x-alert-error :messages="$errors->get('id_user')" class="mt-2" />

                <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id_user" class="form-label">Email atau Username</label>
                        <input type="text" class="form-control" id="id_user" name="id_user" placeholder="Masukkan email atau username"
                            autofocus />
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Password</label>
                            <a href="auth-forgot-password-basic.html">
                                <small>Lupa Password?</small>
                            </a>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"
                                autocomplete="current-password" />
                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember-me" />
                            <label class="form-check-label" for="remember-me"> Ingat Saya </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                    </div>
                </form>

                <div class="divider my-4">
                    <div class="divider-text">atau</div>
                </div>

                <div class="d-flex justify-content-center">
                    <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                        <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                    </a>
                    <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                        <i class="tf-icons fa-brands fa-google fs-5"></i>
                    </a>
                    <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                        <i class="tf-icons fa-brands fa-twitter fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('/assets/js/pages-auth.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.login-left');
            const techBg = document.createElement('div');
            techBg.className = 'tech-background';
            container.appendChild(techBg);

            // Create tech grid
            const grid = document.createElement('div');
            grid.className = 'tech-grid';
            techBg.appendChild(grid);

            // Create polygons
            const createPolygons = () => {
                const polygons = [{
                        points: '50% 0%, 100% 50%, 50% 100%, 0% 50%',
                        size: 120
                    }, // Diamond
                    {
                        points: '50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%',
                        size: 150
                    }, // Hexagon
                    {
                        points: '50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%',
                        size: 180
                    }, // Pentagon
                    {
                        points: '25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%',
                        size: 200
                    } // Octagon
                ];

                polygons.forEach((polygon, i) => {
                    const element = document.createElement('div');
                    element.className = 'tech-polygon';
                    element.style.clipPath = `polygon(${polygon.points})`;
                    element.style.width = `${polygon.size}px`;
                    element.style.height = `${polygon.size}px`;
                    element.style.left = `${Math.random() * 70 + 15}%`;
                    element.style.top = `${Math.random() * 70 + 15}%`;
                    element.style.animationDelay = `${i * 0.5}s`;
                    techBg.appendChild(element);
                });
            };

            // Create tech lines
            const createLines = () => {
                const numLines = 8;
                const lines = [];

                for (let i = 0; i < numLines; i++) {
                    const line = document.createElement('div');
                    line.className = 'tech-line';

                    const angle = (i * 45) % 360;
                    const length = 200 + Math.random() * 100;

                    line.style.width = `${length}px`;
                    line.style.left = `${Math.random() * 80 + 10}%`;
                    line.style.top = `${Math.random() * 80 + 10}%`;
                    line.style.transform = `rotate(${angle}deg)`;
                    line.style.animationDelay = `${i * 0.3}s`;

                    techBg.appendChild(line);
                    lines.push(line);
                }
            };

            createPolygons();
            createLines();
        });
    </script>
</body>

</html>

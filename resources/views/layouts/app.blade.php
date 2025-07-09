<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Indeks Kepuasan Masyarakat') }}</title>
    <link rel="icon" href="{{ asset('logo2.png') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CoreUI & DataTables -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.3.1/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet" />

    {{-- JS SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom minimal CSS -->
    <style>
        html,
        body {
            width: 100%;
            max-width: 100%;
        }

        #sidebar {
            width: 256px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            z-index: 1030;
            overflow-y: auto;
            transition: width 0.3s ease;
        }

        .wrapper {
            margin-left: 256px;
            padding-top: 60px;
            background-color: #f5f7fb;
            min-height: 100vh;
            height: 100%;
            transition: margin-left 0.3s ease;
            overflow: auto;
            /* Prevent horizontal scroll */
            width: calc(100% - 256px);
        }

        .sidebar-unfoldable {
            width: 56px !important;
        }

        .sidebar-unfoldable~.wrapper {
            margin-left: 56px !important;
            width: calc(100% - 56px) !important;
            /* Update width when sidebar is collapsed */
        }

        /* Fix for navbar when sidebar is toggled */
        .sidebar-unfoldable~nav.navbar {
            margin-left: 56px !important;
            width: calc(100% - 56px) !important;
        }

        /* Update navbar styles for proper sizing */
        nav.navbar {
            margin-left: 256px;
            width: calc(100% - 256px);
            z-index: 1040;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        @media (max-width: 991.98px) {
            #sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar-show #sidebar {
                transform: translateX(0);
            }

            .wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                padding-top: 60px;
            }

            nav.navbar {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .mobile-menu-overlay {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 1025;
                background-color: rgba(0, 0, 0, 0.3);
                display: none;
            }

            .sidebar-show .mobile-menu-overlay {
                display: block;
            }
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="sidebar-fixed header-fixed sidebar-lg-show">
    <div class="mobile-menu-overlay" id="mobileOverlay"></div>

    {{-- Sidebar --}}
    <div class="sidebar sidebar-narrow" id="sidebar">
        {{-- Sidebar Header --}}
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark d-flex align-items-center">
                    <img src="{{ asset('logo2.png') }}" alt="Logo" class="w-auto h-20">
                </a>
            </div>
        </div>

        {{-- Navigation --}}
        <ul class="sidebar-nav" data-coreui="navigation">
            <li class="nav-title">Menu</li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pertanyaan.*') ? 'active' : '' }}"
                    href="{{ route('pertanyaan.index') }}">
                    <i class="nav-icon fas fa-list"></i> <span>Pertanyaan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('kategori-pertanyaan.*') ? 'active' : '' }}"
                    href="{{ route('kategori-pertanyaan.index') }}">
                    <i class="nav-icon fas fa-tags"></i> <span>Kategori Pertanyaan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('masyarakat.*') ? 'active' : '' }}"
                    href="{{ route('masyarakat.index') }}">
                    <i class="nav-icon fas fa-users"></i> <span>Masyarakat</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('hasil-kuesioner.*') ? 'active' : '' }}"
                    href="{{ route('hasil-kuesioner.index') }}">
                    <i class="nav-icon fas fa-chart-line"></i> <span>Hasil Kuesioner</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}"
                    href="{{ route('pengaduan.index') }}">
                    <i class="nav-icon fas fa-comment-alt"></i> <span>Pengaduan</span>
                </a>
            </li>

        </ul>

        {{-- Sidebar Footer --}}
        {{-- <div class="sidebar-footer border-top d-flex justify-content-center py-2">
            <button class="sidebar-toggler" type="button" id="sidebarToggler">

            </button>
        </div> --}}
    </div>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white text-dark border-bottom fixed-top">
        <div class="container-fluid d-flex align-items-center justify-content-between h-100 px-3">
            <button class="d-md-none btn btn-link text-dark" type="button" id="mobileSidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <div class="navbar-brand d-none d-md-block">
                @if (isset($header))
                    <h4 class="m-0 p-0">{{ $header }}</h4>
                @endif
            </div>

            <div class="dropdown">
                <button class="btn nav-link dropdown-toggle bg-transparent border-0" type="button" id="userDropdownBtn"
                    aria-expanded="false">
                    <span class="me-2">{{ Auth::user()->name }}</span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdownBtn">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-edit me-2"></i> Profil
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <!-- Update the main wrapper div -->
    <div class="wrapper">
        <div class="container-fluid p-3">
            @if (isset($header) && request()->routeIs('dashboard'))
                <h2 class="h5 mb-4">{{ $header }}</h2>
            @endif

            @yield('content')
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.3.1/dist/js/coreui.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const userDropdownBtn = document.getElementById('userDropdownBtn');
            const userDropdownInstance = new coreui.Dropdown(userDropdownBtn);

            userDropdownBtn.addEventListener('click', function(e) {
                e.preventDefault();
                userDropdownInstance.toggle();
            });


            document.getElementById('mobileSidebarToggle')?.addEventListener('click', () => {
                document.body.classList.toggle('sidebar-show');
            });


            document.getElementById('mobileOverlay')?.addEventListener('click', () => {
                document.body.classList.remove('sidebar-show');
            });


            document.getElementById('sidebarToggler')?.addEventListener('click', () => {
                document.getElementById('sidebar').classList.toggle('sidebar-unfoldable');


                const navbar = document.querySelector('nav.navbar');
                if (document.getElementById('sidebar').classList.contains('sidebar-unfoldable')) {
                    navbar.style.marginLeft = '56px';
                    navbar.style.width = 'calc(100% - 56px)';
                } else {
                    navbar.style.marginLeft = '256px';
                    navbar.style.width = 'calc(100% - 256px)';
                }
            });


            window.addEventListener('resize', function() {
                if (window.Chart && window.chart) {
                    window.chart.resize();
                }
            });


            document.body.style.overflowX = 'hidden';
        });
    </script>

    @stack('scripts')
</body>

</html>

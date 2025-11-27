<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Keuangan - SPMB SMK Bakti Nusantara 666')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/been.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            font-size: 14px;
        }
        .sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand {
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar-brand:hover {
            color: white;
        }
        .sidebar-logo {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: white;
            padding: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .sidebar-menu {
            padding: 1.5rem 0;
        }
        .sidebar-menu-item {
            margin: 0.25rem 1rem;
        }
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
        }
        .sidebar-menu-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(8px);
        }
        .sidebar-menu-link.active {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        }
        .sidebar-menu-icon {
            width: 20px;
            margin-right: 1rem;
            text-align: center;
        }
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        .topbar {
            background: white;
            padding: 1.25rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .content-area {
            padding: 2rem;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }
        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .mobile-toggle {
                display: block !important;
            }
            .content-area {
                padding: 1rem;
            }
        }
        .mobile-toggle {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <img src="{{ asset('images/been.png') }}" alt="Logo" class="sidebar-logo">
                <div>
                    <div style="font-size: 0.9rem;">SMK Bakti Nusantara 666</div>
                    <div style="font-size: 0.7rem; opacity: 0.8;">Keuangan</div>
                </div>
            </a>
        </div>
        
        <div class="sidebar-menu">
            <div class="sidebar-menu-item">
                <a href="{{ route('dashboard.keuangan') }}" class="sidebar-menu-link {{ request()->routeIs('dashboard.keuangan') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave sidebar-menu-icon"></i>
                    Verifikasi Pembayaran
                </a>
            </div>
            <div class="sidebar-menu-item">
                <a href="{{ route('export.keuangan') }}" class="sidebar-menu-link">
                    <i class="fas fa-download sidebar-menu-icon"></i>
                    Export Laporan
                </a>
            </div>
            
            <hr style="border-color: rgba(255,255,255,0.1); margin: 1rem;">
            
            <div class="sidebar-menu-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                    @csrf
                    <button type="submit" class="sidebar-menu-link w-100 border-0 bg-transparent text-start">
                        <i class="fas fa-sign-out-alt sidebar-menu-icon"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link mobile-toggle me-3" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h4 class="mb-0 fw-bold text-gray-900">@yield('page-title', 'Dashboard Keuangan')</h4>
                    <p class="text-sm text-gray-600 mb-0">@yield('page-subtitle', 'Verifikasi pembayaran dan laporan keuangan')</p>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <span class="text-muted me-3">{{ Auth::user()->name }}</span>
                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
    @yield('scripts')
</body>
</html>
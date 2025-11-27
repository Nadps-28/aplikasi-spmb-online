<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPMB SMK Bakti Nusantara 666')</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('images/been.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/been.png') }}" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/logo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/background.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modern-design.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --border-radius: 0.5rem;
            --border-radius-lg: 0.75rem;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            min-height: 100vh;
            color: var(--text-primary);
            font-size: 14px;
            line-height: 1.6;
        }
        
        .main-container {
            min-height: 100vh;
            padding: 3rem 0;
        }
        
        .card {
            background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%);
            border: 1px solid rgba(226, 232, 240, 0.6);
            border-radius: var(--border-radius-lg);
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.06), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }
        
        .stats-card {
            background: var(--bg-primary);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.04);
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -2px rgba(0, 0, 0, 0.04);
        }
        
        .navbar {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            padding: 1.2rem 0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--primary-color) !important;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .navbar-brand:hover {
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
        }
        
        .logo-sekolah {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: white;
            padding: 4px;
        }
        
        .navbar-brand:hover .logo-sekolah {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .school-name {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .school-name-main {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }
        
        .school-name-sub {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin: 0;
            opacity: 0.8;
        }
        
        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            transition: all 0.2s ease;
            padding: 0.5rem 1rem !important;
            border-radius: var(--border-radius);
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
            background: var(--bg-tertiary);
        }
        
        .btn {
            font-weight: 500;
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }
        
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .btn-success {
            background: var(--success-color);
            border-color: var(--success-color);
        }
        
        .btn-warning {
            background: var(--warning-color);
            border-color: var(--warning-color);
        }
        
        .btn-danger {
            background: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .form-control {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 0.75rem;
            transition: all 0.2s ease;
            background: var(--bg-primary);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
            background: var(--bg-primary);
        }
        
        .table {
            background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%);
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        
        .table th {
            background: var(--bg-tertiary);
            border: none;
            font-weight: 600;
            color: var(--text-primary);
            padding: 1rem;
        }
        
        .table td {
            border: none;
            padding: 1rem;
            vertical-align: middle;
        }
        
        .table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: var(--bg-tertiary);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: var(--border-radius);
        }
        
        .alert {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 1rem;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .text-secondary {
            color: var(--text-secondary) !important;
        }
        
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        .bg-light {
            background-color: var(--bg-secondary) !important;
        }
        
        .border-0 {
            border: 0 !important;
        }
        
        .rounded-circle {
            border-radius: 50% !important;
        }
        
        .shadow-sm {
            box-shadow: var(--shadow-sm) !important;
        }
        
        .shadow {
            box-shadow: var(--shadow-md) !important;
        }
        
        .shadow-lg {
            box-shadow: var(--shadow-lg) !important;
        }
        
        /* Page Header */
        .page-header {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--border-color), rgba(226, 232, 240, 0.3));
            border-radius: 2px;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        
        .timeline-marker {
            position: absolute;
            left: -25px;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--border-color);
            border: 4px solid var(--bg-primary);
            box-shadow: 0 0 0 3px var(--border-color), 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .timeline-item.completed .timeline-marker {
            background: var(--success-color);
            box-shadow: 0 0 0 3px var(--success-color), 0 2px 8px rgba(5, 150, 105, 0.3);
            transform: scale(1.1);
        }
        
        .timeline-item.completed::before {
            background: var(--success-color);
        }
        
        /* Dropdown */
        .dropdown-menu {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
        }
        
        .dropdown-item {
            color: var(--text-primary);
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem 0;
                margin-top: 1.5rem !important;
            }
            
            .stats-card {
                padding: 1rem;
            }
            
            .navbar {
                padding: 1rem 0;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
                gap: 0.5rem;
            }
            
            .logo-sekolah {
                width: 35px;
                height: 35px;
            }
            
            .school-name-main {
                font-size: 0.95rem;
            }
            
            .school-name-sub {
                font-size: 0.65rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            /* Navbar responsive */
            .navbar-nav {
                margin-top: 1rem;
                gap: 0.5rem;
                width: 100%;
            }
            
            .navbar-nav .nav-item {
                margin-bottom: 0.5rem;
            }
            
            .navbar-nav .btn {
                width: 100%;
                text-align: center;
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
            
            .navbar-toggler {
                border: none;
                padding: 0.5rem;
                border-radius: 8px;
                background: rgba(37, 99, 235, 0.1);
            }
            
            .navbar-toggler:focus {
                box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
            }
        }
        
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1rem;
            }
            
            .logo-sekolah {
                width: 32px;
                height: 32px;
            }
            
            .school-name-main {
                font-size: 0.85rem;
            }
            
            .school-name-sub {
                font-size: 0.6rem;
            }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/been.png') }}" alt="Logo SMK Bakti Nusantara 666" class="logo-sekolah">
                <div class="school-name">
                    <div class="school-name-main">SMK Bakti Nusantara 666</div>
                    <div class="school-name-sub">Sistem Penerimaan Mahasiswa Baru</div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars" style="color: var(--primary-color); font-size: 1.2rem;"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary px-3 py-2 rounded-3 fw-medium" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary px-3 py-2 rounded-3 fw-medium" href="{{ route('register') }}" style="box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);">
                                <i class="fas fa-user-plus me-1"></i>Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="main-container" style="margin-top: 2rem;">
        <div class="container">
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
    @yield('scripts')
</body>
</html>
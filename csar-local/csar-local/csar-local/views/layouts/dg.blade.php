<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CSAR DG')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #F5F7FA;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Arrière-plan avec logo CSAR */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(34, 197, 94, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(251, 191, 36, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(59, 130, 246, 0.03) 0%, transparent 50%);
            z-index: -2;
        }
        
        /* Logo CSAR en arrière-plan */
        body::after {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-5deg);
            width: 600px;
            height: 600px;
            background-image: url('{{ asset("images/logos/LOGO CSAR vectoriel-01.png") }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.02;
            z-index: -1;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(-50%, -50%) rotate(-5deg) translateY(0px); }
            50% { transform: translate(-50%, -50%) rotate(-5deg) translateY(-20px); }
        }
        
        /* Sidebar */
        .dg-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #22c55e;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 8px;
        }
        
        .brand-info h2 {
            font-size: 18px;
            font-weight: 700;
            color: white;
            margin-bottom: 2px;
        }
        
        .brand-info p {
            font-size: 12px;
            opacity: 0.7;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }
        
        /* Navigation */
        .sidebar-nav {
            padding: 24px 0;
        }
        
        .nav-section {
            margin-bottom: 32px;
        }
        
        .nav-section-title {
            padding: 0 20px 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.6;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
            margin: 0 8px;
            border-radius: 8px;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
        }
        
        .nav-item.active {
            background: rgba(59, 130, 246, 0.2);
            color: white;
            border-left: 3px solid #60a5fa;
        }
        
        .nav-icon {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            font-size: 16px;
        }
        
        .nav-text {
            flex: 1;
            font-size: 14px;
            font-weight: 500;
        }
        
        .nav-badge {
            background: #ef4444;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
            font-weight: 600;
        }
        
        /* Main Content */
        .dg-main {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            background: #F5F7FA;
        }
        
        /* Content Area */
        .dg-content {
            padding: 24px;
            min-height: 100vh;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .dg-sidebar {
                transform: translateX(-100%);
            }
            
            .dg-sidebar.open {
                transform: translateX(0);
            }
            
            .dg-main {
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .dg-sidebar {
                width: 100%;
            }
            
            .dg-content {
                padding: 16px;
            }
        }
        
        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
        
        .sidebar-overlay.open {
            display: block;
        }
        
        /* Custom styles for dashboard */
        @yield('styles')
    </style>
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <aside class="dg-sidebar" id="dgSidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="logo">
                <img src="{{ asset('images/logos/LOGO CSAR vectoriel-01.png') }}" alt="CSAR Logo">
            </div>
            <div class="brand-info">
                <h2>CSAR</h2>
                <p>Interface DG</p>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- TABLEAU DE BORD -->
            <div class="nav-section">
                <div class="nav-section-title">TABLEAU DE BORD</div>
                
                <a href="{{ route('dg.dashboard') }}" class="nav-item {{ request()->routeIs('dg.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <span class="nav-text">Vue d'ensemble</span>
                </a>
            </div>
            
            <!-- CONSULTATION -->
            <div class="nav-section">
                <div class="nav-section-title">CONSULTATION</div>
                
                <a href="{{ route('dg.requests.index') }}" class="nav-item {{ request()->routeIs('dg.requests.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <span class="nav-text">Demandes</span>
                    @if($pendingRequests = \App\Models\PublicRequest::where('status', 'pending')->count())
                        <span class="nav-badge">{{ $pendingRequests }}</span>
                    @endif
                </a>
                
                <a href="{{ route('dg.warehouses.index') }}" class="nav-item {{ request()->routeIs('dg.warehouses.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-warehouse"></i>
                                            <span class="nav-text">Magasins de stockage</span>
                </a>
                
                <a href="{{ route('dg.personnel.index') }}" class="nav-item {{ request()->routeIs('dg.personnel.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <span class="nav-text">Personnel</span>
                </a>
                
                <a href="{{ route('dg.map') }}" class="nav-item {{ request()->routeIs('dg.map') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-map"></i>
                    <span class="nav-text">Carte interactive</span>
                </a>
                
                <a href="{{ route('dg.messages.index') }}" class="nav-item {{ request()->routeIs('dg.messages.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <span class="nav-text">Messages</span>
                </a>
                
                <a href="{{ route('dg.public-content.index') }}" class="nav-item {{ request()->routeIs('dg.public-content.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <span class="nav-text">Contenus publics</span>
                </a>
                
                <a href="{{ route('dg.news.index') }}" class="nav-item {{ request()->routeIs('dg.news.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-newspaper"></i>
                    <span class="nav-text">Actualités</span>
                </a>
                
                <a href="{{ route('dg.newsletter.index') }}" class="nav-item {{ request()->routeIs('dg.newsletter.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <span class="nav-text">Newsletter</span>
                </a>
            </div>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="dg-main">
        <!-- Content Area -->
        <div class="dg-content">
            @if(session('success'))
                <div class="alert alert-success" style="background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #a7f3d0;">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error" style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fca5a5;">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('dgSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            });
        }
        
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            });
        }
        
        // Close sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CSAR Admin')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
            font-family: 'Poppins', 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 50%, #e6fffa 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Motif géométrique subtil et professionnel */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                /* Points subtils */
                radial-gradient(circle at 2px 2px, rgba(5, 150, 105, 0.02) 1px, transparent 1px),
                /* Lignes de grille très légères */
                linear-gradient(90deg, transparent 95%, rgba(5, 150, 105, 0.01) 95%),
                linear-gradient(0deg, transparent 95%, rgba(5, 150, 105, 0.01) 95%);
            background-size: 50px 50px, 100px 100px, 100px 100px;
            z-index: -2;
        }
        
        /* Logo CSAR en filigrane professionnel */
        body::after {
            content: '';
            position: fixed;
            bottom: 50px;
            right: 50px;
            width: 250px;
            height: 250px;
            background-image: url('{{ asset("images/logos/LOGO CSAR vectoriel-01.png") }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.03;
            z-index: -1;
            filter: grayscale(100%);
        }
        
        /* Particules flottantes */
        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(34, 197, 94, 0.3);
            border-radius: 50%;
            animation: particleFloat 8s linear infinite;
        }
        
        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 4s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 6s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 1s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 3s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 5s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 7s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 0.5s; }
        
        @keyframes particleFloat {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }
        
        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
        }
        
        .brand-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .brand-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #059669, #10b981);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }
        
        .brand-text h2 {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 4px;
            letter-spacing: 1px;
        }
        
        .brand-text p {
            font-size: 12px;
            opacity: 0.8;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }
        
        .user-profile {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #059669, #10b981);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3);
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .user-details h4 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .user-role {
            font-size: 12px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Navigation */
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .nav-section {
            margin-bottom: 24px;
        }
        
        .nav-section-title {
            padding: 0 24px 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.7;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 14px 24px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            border-radius: 8px;
            margin: 0 12px 4px 12px;
        }
        
        .nav-item:hover {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.2), rgba(16, 185, 129, 0.2));
            color: white;
            transform: translateX(4px);
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }
        
        .nav-icon {
            width: 20px;
            margin-right: 12px;
            text-align: center;
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
        }
        
        .nav-arrow {
            font-size: 12px;
            transition: transform 0.2s;
        }
        
        .nav-item.has-dropdown .nav-arrow {
            transform: rotate(90deg);
        }
        
        /* Main Content */
        .admin-main {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        /* Content Area */
        .admin-content {
            padding: 24px;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.open {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .menu-toggle {
                display: block;
            }
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                width: 100%;
            }
            
            .admin-header {
                padding: 0 16px;
            }
            
            .admin-content {
                padding: 16px;
            }
            
            .page-title {
                font-size: 20px;
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
    <!-- Particules flottantes -->
    <div class="floating-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="brand-info">
                <div class="logo">
                    <img src="{{ asset('images/csar-logo.png') }}" alt="CSAR">
                </div>
                <div class="brand-text">
                    <h2>CSAR</h2>
                    <p>Plateforme Administrative</p>
                </div>
            </div>
        </div>
        
        <!-- User Profile -->
        <div class="user-profile">
            <div class="user-info">
                <div class="user-avatar">
                    @if(auth()->check() && auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile">
                    @else
                        <i class="fas fa-user-circle"></i>
                    @endif
                </div>
                <div class="user-details">
                    <h4>{{ auth()->check() ? auth()->user()->name : 'Administrateur' }}</h4>
                    <div class="user-role">Administrateur CSAR</div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- Main Navigation -->
            <div class="nav-section">
                <div class="nav-section-title">Navigation principale</div>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <span class="nav-text">Tableau de bord</span>
                </a>
                
                <a href="{{ route('admin.requests.index') }}" class="nav-item {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-hand-holding-heart"></i>
                    <span class="nav-text">Demandes</span>
                    @php($unseenRequests = \App\Models\PublicRequest::where('is_viewed', false)->count())
                    @if($unseenRequests)
                        <span class="nav-badge">{{ $unseenRequests }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.warehouses.index') }}" class="nav-item {{ request()->routeIs('admin.warehouses.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-warehouse"></i>
                                            <span class="nav-text">Magasins de stockage</span>
                </a>
                
                <a href="{{ route('admin.stocks.index') }}" class="nav-item {{ request()->routeIs('admin.stocks.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <span class="nav-text">Stocks</span>
                </a>
                
                <a href="{{ route('admin.personnel.index') }}" class="nav-item {{ request()->routeIs('admin.personnel.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <span class="nav-text">Personnel</span>
                </a>
            </div>
            
            <!-- Content Management -->
            <div class="nav-section">
                <div class="nav-section-title">Gestion du contenu</div>
                
                <a href="{{ route('admin.public-content.index') }}" class="nav-item {{ request()->routeIs('admin.public-content.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-globe"></i>
                    <span class="nav-text">Contenu public</span>
                </a>
                
                <a href="{{ route('admin.news.index') }}" class="nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-newspaper"></i>
                    <span class="nav-text">Actualités</span>
                </a>
                
                <a href="{{ route('admin.speeches.index') }}" class="nav-item {{ request()->routeIs('admin.speeches.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-microphone"></i>
                    <span class="nav-text">Discours officiels</span>
                </a>
                
                <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-images"></i>
                    <span class="nav-text">Galerie</span>
                </a>
            </div>
            
            <!-- Communication -->
            <div class="nav-section">
                <div class="nav-section-title">Communication</div>
                
                <a href="{{ route('admin.contact.index') }}" class="nav-item {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <span class="nav-text">Messages</span>
                    @if($unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count())
                        <span class="nav-badge">{{ $unreadMessages }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.newsletter.index') }}" class="nav-item {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-newspaper"></i>
                    <span class="nav-text">Newsletter</span>
                </a>
                
                                 <a href="{{ route('admin.technical-partners.index') }}" class="nav-item {{ request()->routeIs('admin.technical-partners.*') ? 'active' : '' }}">
                     <i class="nav-icon fas fa-handshake"></i>
                     <span class="nav-text">Partenaires</span>
                 </a>
                 
                 <a href="{{ route('admin.sim-reports.index') }}" class="nav-item {{ request()->routeIs('admin.sim-reports.*') ? 'active' : '' }}">
                     <i class="nav-icon fas fa-chart-line"></i>
                     <span class="nav-text">Rapports SIM</span>
                     @if($draftReports = \App\Models\SimReport::where('status', 'draft')->count())
                         <span class="nav-badge">{{ $draftReports }}</span>
                     @endif
                 </a>
            </div>
            
            <!-- Surveillance & Alertes -->
            <div class="nav-section">
                <div class="nav-section-title">Surveillance & Alertes</div>
                
                <a href="{{ route('admin.price-alerts.index') }}" class="nav-item {{ request()->routeIs('admin.price-alerts.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-exclamation-triangle"></i>
                    <span class="nav-text">Alertes de Prix</span>
                    @if($activeAlerts = \App\Models\PriceAlert::where('status', 'active')->count())
                        <span class="nav-badge">{{ $activeAlerts }}</span>
                    @endif
                </a>
            </div>
            
            <!-- Gestion des Tâches -->
            <div class="nav-section">
                <div class="nav-section-title">Gestion des Tâches</div>
                
                <a href="{{ route('admin.tasks.index') }}" class="nav-item {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tasks"></i>
                    <span class="nav-text">Tableau Kanban</span>
                    @if($pendingTasks = \App\Models\Task::where('status', 'todo')->count())
                        <span class="nav-badge">{{ $pendingTasks }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.weekly-agenda.index') }}" class="nav-item {{ request()->routeIs('admin.weekly-agenda.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-week"></i>
                    <span class="nav-text">Agenda Hebdo</span>
                </a>
            </div>
            
            <!-- Administration -->
            <div class="nav-section">
                <div class="nav-section-title">Administration</div>
                
                <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-cog"></i>
                    <span class="nav-text">Utilisateurs</span>
                </a>
                
                <a href="{{ route('admin.audit.index') }}" class="nav-item {{ request()->routeIs('admin.audit.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-history"></i>
                    <span class="nav-text">Audit</span>
                </a>

                <a href="{{ route('admin.notifications.index') }}" class="nav-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-bell"></i>
                    <span class="nav-text">Notifications</span>
                </a>
                
                <a href="{{ route('admin.profile.edit') }}" class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-edit"></i>
                    <span class="nav-text">Mon profil</span>
                </a>

                <!-- Déconnexion -->
                <a href="#" class="nav-item" onclick="event.preventDefault(); document.getElementById('adminLogoutForm').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <span class="nav-text">Déconnexion</span>
                </a>
                <form id="adminLogoutForm" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-main">
        <!-- Content Area -->
        <div class="admin-content">
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
        const sidebar = document.getElementById('adminSidebar');
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
        
        // Dropdown functionality
        document.querySelectorAll('.nav-item.has-dropdown').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                this.classList.toggle('open');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html> 
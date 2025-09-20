<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CSAR - Commissariat à la Sécurité Alimentaire et à la Résilience')</title>
    
    <!-- Meta tags -->
    <meta name="description" content="Plateforme numérique du CSAR - Commissariat à la Sécurité Alimentaire et à la Résilience du Sénégal">
    <meta name="keywords" content="CSAR, sécurité alimentaire, résilience, Sénégal, entrepôts, stocks">
    <meta name="author" content="CSAR">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logos/LOGO CSAR vectoriel-01.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logos/LOGO CSAR vectoriel-01.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    @stack('styles')
</head>
<body style="display:flex; min-height:100vh; flex-direction:column;">
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="header-content">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo-container">
                    <img src="{{ asset('images/logos/LOGO CSAR vectoriel-01.png') }}" alt="Logo CSAR">
                    <div class="logo-text">
                        <div class="logo-title">CSAR</div>
                        <div class="logo-subtitle">Sécurité Alimentaire et Résilience</div>
                    </div>
                </a>
                
                <!-- Navigation Desktop -->
                <nav class="nav-desktop">
                    <a href="{{ route('home') }}">Accueil</a>
                    <a href="{{ route('about') }}">À propos</a>
                    <a href="{{ route('institution') }}">Institution</a>
                    <a href="{{ route('news') }}">Actualités</a>
                    <a href="{{ route('sim.index') }}">SIM</a>
                    <a href="{{ route('reports') }}">Rapports</a>
                    <a href="{{ route('contact') }}">Contact</a>
                </nav>
                
                <!-- CTA Button -->
                <div>
                    <!-- Bouton supprimé pour éviter la duplication -->
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main style="flex:1 0 auto;">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.public-footer')

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>

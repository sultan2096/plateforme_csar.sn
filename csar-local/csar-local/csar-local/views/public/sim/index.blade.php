@extends('layouts.public')

@section('title', 'Système d\'Information des Marchés (SIM) - CSAR')

@section('content')
<!-- Hero Section -->
<section class="hero-section fade-in" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); min-height: 50vh; display: flex; align-items: center; position: relative; overflow: hidden;">
    <!-- Floating decorative elements -->
    <div style="position: absolute; top: 10%; left: 10%; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
    <div style="position: absolute; top: 20%; right: 15%; width: 100px; height: 100px; background: rgba(255,255,255,0.08); border-radius: 50%; animation: float 8s ease-in-out infinite reverse;"></div>
    <div style="position: absolute; bottom: 15%; left: 20%; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 60px 20px; text-align: center; position: relative; z-index: 2;">
        <h1 class="main-title" style="font-size: 3.5rem; font-weight: 800; color: #fff; margin-bottom: 20px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            Système d'Information des Marchés
        </h1>
        <p class="main-subtitle" style="font-size: 1.4rem; color: rgba(255,255,255,0.9); max-width: 700px; margin: 0 auto; line-height: 1.6; font-weight: 400;">
            Suivi régulier des prix et de l'approvisionnement des marchés agricoles au Sénégal
        </p>
        <div style="margin-top: 30px;">
            <a href="{{ route('sim.dashboard') }}" class="btn btn-light btn-lg" style="margin-right: 15px;">
                <i class="fas fa-chart-dashboard mr-2"></i>
                Tableau de Bord
            </a>
            @if($latestReport)
            <a href="{{ route('sim.show', $latestReport) }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-file-alt mr-2"></i>
                Dernier Rapport
            </a>
            @endif
        </div>
    </div>
</section>

<!-- Latest Report Section -->
@if($latestReport)
<section class="latest-report-section fade-in" style="background: #f8fafc; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Dernier Rapport SIM
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                {{ $latestReport->period }} - {{ $latestReport->report_date->format('d/m/Y') }}
            </p>
        </div>

        <div class="latest-report-card" style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
            <div class="row no-gutters">
                @if($latestReport->cover_image)
                <div class="col-md-4">
                    <div style="height: 300px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $latestReport->cover_image) }}" 
                             alt="{{ $latestReport->title }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                @endif
                <div class="col-md-{{ $latestReport->cover_image ? '8' : '12' }}">
                    <div style="padding: 40px;">
                        <h3 style="font-size: 1.8rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                            {{ $latestReport->title }}
                        </h3>
                        
                        @if($latestReport->summary)
                        <p style="font-size: 1.1rem; color: #4b5563; line-height: 1.6; margin-bottom: 24px;">
                            {{ $latestReport->summary }}
                        </p>
                        @endif

                        <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
                            <div style="display: flex; align-items: center; color: #6b7280;">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>{{ $latestReport->report_date->format('d/m/Y') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; color: #6b7280;">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ $latestReport->published_at ? $latestReport->published_at->format('d/m/Y H:i') : 'Non publié' }}</span>
                            </div>
                            @if($latestReport->document_file)
                            <div style="display: flex; align-items: center; color: #6b7280;">
                                <i class="fas fa-file-pdf mr-2"></i>
                                <span>Document PDF disponible</span>
                            </div>
                            @endif
                        </div>

                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            <a href="{{ route('sim.show', $latestReport) }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-eye mr-2"></i>
                                Lire le Rapport
                            </a>
                            @if($latestReport->document_file)
                            <a href="{{ asset('storage/' . $latestReport->document_file) }}" 
                               target="_blank" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-download mr-2"></i>
                                Télécharger PDF
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Reports List Section -->
<section class="reports-section fade-in" style="background: #fff; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Rapports SIM Disponibles
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                Consultez l'historique des rapports du Système d'Information des Marchés
            </p>
        </div>

        @if($reports->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px;">
            @foreach($reports as $report)
            <article class="report-card zoom-hover" style="background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #f3f4f6; transition: all 0.3s ease;">
                @if($report->cover_image)
                <div style="height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $report->cover_image) }}" 
                         alt="{{ $report->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                @endif
                
                <div style="padding: 24px;">
                    <div style="display: flex; justify-content-between; align-items: start; margin-bottom: 12px;">
                        <span style="background: #059669; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                            {{ $report->period }}
                        </span>
                        <span style="color: #6b7280; font-size: 0.9rem;">
                            {{ $report->report_date->format('d/m/Y') }}
                        </span>
                    </div>
                    
                    <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 12px; line-height: 1.4;">
                        {{ $report->title }}
                    </h3>
                    
                    @if($report->summary)
                    <p style="color: #6b7280; line-height: 1.6; margin-bottom: 20px;">
                        {{ Str::limit($report->summary, 150) }}
                    </p>
                    @endif
                    
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="{{ route('sim.show', $report) }}" class="btn btn-primary">
                            <i class="fas fa-eye mr-2"></i>
                            Lire
                        </a>
                        @if($report->document_file)
                        <a href="{{ asset('storage/' . $report->document_file) }}" 
                           target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-download mr-2"></i>
                            PDF
                        </a>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div style="display: flex; justify-content: center; margin-top: 60px;">
            {{ $reports->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 60px 20px;">
            <i class="fas fa-file-alt fa-4x text-gray-300 mb-4"></i>
            <h3 style="color: #6b7280; margin-bottom: 16px;">Aucun rapport disponible</h3>
            <p style="color: #9ca3af;">Les rapports SIM seront publiés ici dès qu'ils seront disponibles.</p>
        </div>
        @endif
    </div>
</section>

<!-- Information Section -->
<section class="info-section fade-in" style="background: #f8fafc; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                À Propos du SIM
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 700px; margin: 0 auto;">
                Le Système d'Information des Marchés (SIM) est un outil essentiel pour analyser la dynamique des marchés et orienter les réponses en matière de sécurité alimentaire
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                         <a href="{{ route('sim.prices') }}" style="text-decoration: none; color: inherit;">
                 <div style="text-align: center; padding: 30px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; cursor: pointer; border: 2px solid transparent;">
                     <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #059669, #047857); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                         <i class="fas fa-chart-line fa-2x text-white"></i>
                     </div>
                     <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 12px;">
                         Suivi des Prix
                     </h3>
                     <p style="color: #6b7280; line-height: 1.6;">
                         Surveillance régulière des prix de détail des produits agricoles sur les marchés sénégalais
                     </p>
                 </div>
             </a>

                         <a href="{{ route('sim.supply') }}" style="text-decoration: none; color: inherit;">
                 <div style="text-align: center; padding: 30px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; cursor: pointer; border: 2px solid transparent;">
                     <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                         <i class="fas fa-warehouse fa-2x text-white"></i>
                     </div>
                     <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 12px;">
                         Niveau d'Approvisionnement
                     </h3>
                     <p style="color: #6b7280; line-height: 1.6;">
                         Évaluation des volumes disponibles sur les marchés et analyse des tendances d'approvisionnement
                     </p>
                 </div>
             </a>

                         <a href="{{ route('sim.regional') }}" style="text-decoration: none; color: inherit;">
                 <div style="text-align: center; padding: 30px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; cursor: pointer; border: 2px solid transparent;">
                     <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                         <i class="fas fa-map-marked-alt fa-2x text-white"></i>
                     </div>
                     <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 12px;">
                         Répartition Régionale
                     </h3>
                     <p style="color: #6b7280; line-height: 1.6;">
                         Analyse des disparités de prix entre les différentes régions du Sénégal
                     </p>
                 </div>
             </a>
        </div>
    </div>
</section>

@push('styles')
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.fade-in {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s ease forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.zoom-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* Effet de survol pour les cartes SIM */
a[href*="sim.dashboard"] div:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    border-color: #059669;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #059669;
    color: #fff;
    border: none;
}

.btn-primary:hover {
    background: #047857;
    color: #fff;
    transform: translateY(-2px);
}

.btn-outline-primary {
    background: transparent;
    color: #059669;
    border: 2px solid #059669;
}

.btn-outline-primary:hover {
    background: #059669;
    color: #fff;
    transform: translateY(-2px);
}

.btn-light {
    background: #fff;
    color: #1f2937;
    border: none;
}

.btn-light:hover {
    background: #f3f4f6;
    color: #1f2937;
    transform: translateY(-2px);
}

.btn-outline-light {
    background: transparent;
    color: #fff;
    border: 2px solid #fff;
}

.btn-outline-light:hover {
    background: #fff;
    color: #1f2937;
    transform: translateY(-2px);
}
</style>
@endpush
@endsection 

@section('title', 'Système d\'Information des Marchés (SIM) - CSAR')

@section('content')
<!-- Hero Section -->
<section class="hero-section fade-in" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); min-height: 50vh; display: flex; align-items: center; position: relative; overflow: hidden;">
    <!-- Floating decorative elements -->
    <div style="position: absolute; top: 10%; left: 10%; width: 120px; height: 120px; background: rgba(255,255,255,0.1); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
    <div style="position: absolute; top: 20%; right: 15%; width: 100px; height: 100px; background: rgba(255,255,255,0.08); border-radius: 50%; animation: float 8s ease-in-out infinite reverse;"></div>
    <div style="position: absolute; bottom: 15%; left: 20%; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 60px 20px; text-align: center; position: relative; z-index: 2;">
        <h1 class="main-title" style="font-size: 3.5rem; font-weight: 800; color: #fff; margin-bottom: 20px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            Système d'Information des Marchés
        </h1>
        <p class="main-subtitle" style="font-size: 1.4rem; color: rgba(255,255,255,0.9); max-width: 700px; margin: 0 auto; line-height: 1.6; font-weight: 400;">
            Suivi régulier des prix et de l'approvisionnement des marchés agricoles au Sénégal
        </p>
        <div style="margin-top: 30px;">
            <a href="{{ route('sim.dashboard') }}" class="btn btn-light btn-lg" style="margin-right: 15px;">
                <i class="fas fa-chart-dashboard mr-2"></i>
                Tableau de Bord
            </a>
            @if($latestReport)
            <a href="{{ route('sim.show', $latestReport) }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-file-alt mr-2"></i>
                Dernier Rapport
            </a>
            @endif
        </div>
    </div>
</section>

<!-- Latest Report Section -->
@if($latestReport)
<section class="latest-report-section fade-in" style="background: #f8fafc; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Dernier Rapport SIM
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                {{ $latestReport->period }} - {{ $latestReport->report_date->format('d/m/Y') }}
            </p>
        </div>

        <div class="latest-report-card" style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
            <div class="row no-gutters">
                @if($latestReport->cover_image)
                <div class="col-md-4">
                    <div style="height: 300px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $latestReport->cover_image) }}" 
                             alt="{{ $latestReport->title }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                @endif
                <div class="col-md-{{ $latestReport->cover_image ? '8' : '12' }}">
                    <div style="padding: 40px;">
                        <h3 style="font-size: 1.8rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                            {{ $latestReport->title }}
                        </h3>
                        
                        @if($latestReport->summary)
                        <p style="font-size: 1.1rem; color: #4b5563; line-height: 1.6; margin-bottom: 24px;">
                            {{ $latestReport->summary }}
                        </p>
                        @endif

                        <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
                            <div style="display: flex; align-items: center; color: #6b7280;">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>{{ $latestReport->report_date->format('d/m/Y') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; color: #6b7280;">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ $latestReport->published_at ? $latestReport->published_at->format('d/m/Y H:i') : 'Non publié' }}</span>
                            </div>
                            @if($latestReport->document_file)
                            <div style="display: flex; align-items: center; color: #6b7280;">
                                <i class="fas fa-file-pdf mr-2"></i>
                                <span>Document PDF disponible</span>
                            </div>
                            @endif
                        </div>

                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            <a href="{{ route('sim.show', $latestReport) }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-eye mr-2"></i>
                                Lire le Rapport
                            </a>
                            @if($latestReport->document_file)
                            <a href="{{ asset('storage/' . $latestReport->document_file) }}" 
                               target="_blank" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-download mr-2"></i>
                                Télécharger PDF
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Reports List Section -->
<section class="reports-section fade-in" style="background: #fff; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Rapports SIM Disponibles
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                Consultez l'historique des rapports du Système d'Information des Marchés
            </p>
        </div>

        @if($reports->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px;">
            @foreach($reports as $report)
            <article class="report-card zoom-hover" style="background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #f3f4f6; transition: all 0.3s ease;">
                @if($report->cover_image)
                <div style="height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $report->cover_image) }}" 
                         alt="{{ $report->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                @endif
                
                <div style="padding: 24px;">
                    <div style="display: flex; justify-content-between; align-items: start; margin-bottom: 12px;">
                        <span style="background: #059669; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                            {{ $report->period }}
                        </span>
                        <span style="color: #6b7280; font-size: 0.9rem;">
                            {{ $report->report_date->format('d/m/Y') }}
                        </span>
                    </div>
                    
                    <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 12px; line-height: 1.4;">
                        {{ $report->title }}
                    </h3>
                    
                    @if($report->summary)
                    <p style="color: #6b7280; line-height: 1.6; margin-bottom: 20px;">
                        {{ Str::limit($report->summary, 150) }}
                    </p>
                    @endif
                    
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="{{ route('sim.show', $report) }}" class="btn btn-primary">
                            <i class="fas fa-eye mr-2"></i>
                            Lire
                        </a>
                        @if($report->document_file)
                        <a href="{{ asset('storage/' . $report->document_file) }}" 
                           target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-download mr-2"></i>
                            PDF
                        </a>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div style="display: flex; justify-content: center; margin-top: 60px;">
            {{ $reports->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 60px 20px;">
            <i class="fas fa-file-alt fa-4x text-gray-300 mb-4"></i>
            <h3 style="color: #6b7280; margin-bottom: 16px;">Aucun rapport disponible</h3>
            <p style="color: #9ca3af;">Les rapports SIM seront publiés ici dès qu'ils seront disponibles.</p>
        </div>
        @endif
    </div>
</section>

<!-- Information Section -->
<section class="info-section fade-in" style="background: #f8fafc; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                À Propos du SIM
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 700px; margin: 0 auto;">
                Le Système d'Information des Marchés (SIM) est un outil essentiel pour analyser la dynamique des marchés et orienter les réponses en matière de sécurité alimentaire
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                         <a href="{{ route('sim.prices') }}" style="text-decoration: none; color: inherit;">
                 <div style="text-align: center; padding: 30px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; cursor: pointer; border: 2px solid transparent;">
                     <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #059669, #047857); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                         <i class="fas fa-chart-line fa-2x text-white"></i>
                     </div>
                     <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 12px;">
                         Suivi des Prix
                     </h3>
                     <p style="color: #6b7280; line-height: 1.6;">
                         Surveillance régulière des prix de détail des produits agricoles sur les marchés sénégalais
                     </p>
                 </div>
             </a>

                         <a href="{{ route('sim.supply') }}" style="text-decoration: none; color: inherit;">
                 <div style="text-align: center; padding: 30px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; cursor: pointer; border: 2px solid transparent;">
                     <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                         <i class="fas fa-warehouse fa-2x text-white"></i>
                     </div>
                     <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 12px;">
                         Niveau d'Approvisionnement
                     </h3>
                     <p style="color: #6b7280; line-height: 1.6;">
                         Évaluation des volumes disponibles sur les marchés et analyse des tendances d'approvisionnement
                     </p>
                 </div>
             </a>

                         <a href="{{ route('sim.regional') }}" style="text-decoration: none; color: inherit;">
                 <div style="text-align: center; padding: 30px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; cursor: pointer; border: 2px solid transparent;">
                     <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                         <i class="fas fa-map-marked-alt fa-2x text-white"></i>
                     </div>
                     <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 12px;">
                         Répartition Régionale
                     </h3>
                     <p style="color: #6b7280; line-height: 1.6;">
                         Analyse des disparités de prix entre les différentes régions du Sénégal
                     </p>
                 </div>
             </a>
        </div>
    </div>
</section>

@push('styles')
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.fade-in {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s ease forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.zoom-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* Effet de survol pour les cartes SIM */
a[href*="sim.dashboard"] div:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    border-color: #059669;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #059669;
    color: #fff;
    border: none;
}

.btn-primary:hover {
    background: #047857;
    color: #fff;
    transform: translateY(-2px);
}

.btn-outline-primary {
    background: transparent;
    color: #059669;
    border: 2px solid #059669;
}

.btn-outline-primary:hover {
    background: #059669;
    color: #fff;
    transform: translateY(-2px);
}

.btn-light {
    background: #fff;
    color: #1f2937;
    border: none;
}

.btn-light:hover {
    background: #f3f4f6;
    color: #1f2937;
    transform: translateY(-2px);
}

.btn-outline-light {
    background: transparent;
    color: #fff;
    border: 2px solid #fff;
}

.btn-outline-light:hover {
    background: #fff;
    color: #1f2937;
    transform: translateY(-2px);
}
</style>
@endpush
@endsection 
 
 
 
 
 
 
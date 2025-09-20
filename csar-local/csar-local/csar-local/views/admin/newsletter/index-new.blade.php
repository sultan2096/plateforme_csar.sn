@extends('layouts.admin')

@section('title', 'Abonnés Newsletter - Administration')

@section('content')
<style>
/* Variables CSS modernisées avec couleurs vives et visibles */
:root {
    --primary-blue: #3b82f6;
    --primary-blue-dark: #1d4ed8;
    --success-green: #10b981;
    --success-green-dark: #059669;
    --warning-orange: #f59e0b;
    --warning-orange-dark: #d97706;
    --danger-red: #ef4444;
    --danger-red-dark: #dc2626;
    --info-cyan: #06b6d4;
    --info-cyan-dark: #0891b2;
    --gold-yellow: #fbbf24;
    --light-bg: #f8fafc;
    --medium-gray: #e5e7eb;
    --dark-gray: #374151;
    --text-dark: #111827;
    --text-light: #6b7280;
    --shadow-light: 0 4px 20px rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 8px 30px rgba(0, 0, 0, 0.15);
    --border-radius: 16px;
    --transition: all 0.3s ease;
}

/* Container principal avec design clair */
.newsletter-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Header moderne avec couleurs vives */
.newsletter-header {
    background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: 0 15px 40px rgba(16, 185, 129, 0.3);
    position: relative;
    overflow: hidden;
}

.newsletter-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="2" fill="white" opacity="0.15"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    opacity: 0.4;
    pointer-events: none;
}

.newsletter-header > * {
    position: relative;
    z-index: 2;
}

.newsletter-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.newsletter-header .title-accent {
    background: linear-gradient(135deg, var(--gold-yellow) 0%, var(--warning-orange) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.newsletter-header p {
    font-size: 1.1rem;
    opacity: 0.95;
    margin-bottom: 1.5rem;
    color: #f3f4f6;
}

.header-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-header {
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
    backdrop-filter: blur(10px);
}

.btn-header:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.btn-header.primary {
    background: rgba(255, 255, 255, 0.9);
    color: var(--success-green-dark);
    border-color: rgba(255, 255, 255, 0.9);
}

.btn-header.primary:hover {
    background: #fff;
    color: var(--success-green-dark);
}

/* Onglets modernes avec couleurs visibles */
.tabs-container {
    background: #fff;
    border: 2px solid var(--medium-gray);
    border-radius: var(--border-radius);
    padding: 8px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-light);
}

.tabs {
    display: flex;
    gap: 4px;
}

.tab-link {
    padding: 14px 28px;
    border-radius: 12px;
    text-decoration: none;
    color: var(--text-light);
    font-weight: 600;
    font-size: 1rem;
    transition: var(--transition);
    flex: 1;
    text-align: center;
    border: 2px solid transparent;
}

.tab-link.active {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    border-color: var(--primary-blue);
}

.tab-link:hover:not(.active) {
    background: var(--light-bg);
    color: var(--text-dark);
    text-decoration: none;
    border-color: var(--medium-gray);
}

/* Statistiques avec couleurs très visibles */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 2rem;
}

.stat-card {
    background: #fff;
    border: 2px solid var(--medium-gray);
    border-radius: var(--border-radius);
    padding: 24px;
    box-shadow: var(--shadow-light);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
}

.stat-card.success::before {
    background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
}

.stat-card.warning::before {
    background: linear-gradient(135deg, var(--warning-orange) 0%, var(--warning-orange-dark) 100%);
}

.stat-card.info::before {
    background: linear-gradient(135deg, var(--info-cyan) 0%, var(--info-cyan-dark) 100%);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-medium);
    border-color: var(--primary-blue);
}

.stat-content h3 {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-light);
    margin: 0 0 8px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-content .value {
    font-size: 2.4rem;
    font-weight: 900;
    color: var(--text-dark);
    margin: 0;
    line-height: 1;
}

.stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.6rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
}

.stat-icon.success {
    background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
}

.stat-icon.warning {
    background: linear-gradient(135deg, var(--warning-orange) 0%, var(--warning-orange-dark) 100%);
}

.stat-icon.info {
    background: linear-gradient(135deg, var(--info-cyan) 0%, var(--info-cyan-dark) 100%);
}

/* Filtres avec couleurs claires et visibles */
.filter-container {
    background: #fff;
    border: 2px solid var(--medium-gray);
    border-radius: var(--border-radius);
    padding: 24px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-light);
}

.search-group {
    position: relative;
}

.search-input {
    width: 100%;
    padding: 16px 60px 16px 16px;
    border: 2px solid var(--medium-gray);
    border-radius: 12px;
    font-size: 1rem;
    transition: var(--transition);
    background: var(--light-bg);
    color: var(--text-dark);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: #fff;
}

.search-input::placeholder {
    color: var(--text-light);
}

.search-btn {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    border: none;
    color: white;
    padding: 12px 16px;
    border-radius: 8px;
    transition: var(--transition);
    font-size: 1rem;
}

.search-btn:hover {
    transform: translateY(-50%) scale(1.05);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.filter-badges {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 16px;
}

.filter-badge {
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition);
    border: 2px solid var(--medium-gray);
    color: var(--text-light);
    background: #fff;
}

.filter-badge:hover {
    background: var(--light-bg);
    border-color: var(--dark-gray);
    text-decoration: none;
    color: var(--text-dark);
    transform: translateY(-1px);
}

.filter-badge.active {
    background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
    border-color: var(--success-green);
    color: white;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

/* Cartes d'abonnés modernisées avec couleurs claires */
.subscribers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
    gap: 20px;
    margin-bottom: 2rem;
}

.subscriber-card {
    background: #fff;
    border: 2px solid var(--medium-gray);
    border-radius: var(--border-radius);
    padding: 20px;
    box-shadow: var(--shadow-light);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.subscriber-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
}

.subscriber-card.inactive::before {
    background: linear-gradient(135deg, var(--warning-orange) 0%, var(--warning-orange-dark) 100%);
}

.subscriber-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
    border-color: var(--primary-blue);
}

.subscriber-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.subscriber-email {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    color: var(--text-dark);
    font-size: 1rem;
}

.avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.2rem;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.status-badge {
    padding: 8px 16px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: 2px solid;
}

.status-badge.active {
    background: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.status-badge.inactive {
    background: #fef3c7;
    color: #92400e;
    border-color: #fde68a;
}

.subscriber-meta {
    color: var(--text-light);
    font-size: 0.9rem;
    margin-bottom: 16px;
    font-weight: 500;
}

.subscriber-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* Boutons d'action avec couleurs très visibles */
.btn-action {
    padding: 10px 16px;
    border-radius: 10px;
    border: 2px solid;
    font-weight: 600;
    font-size: 0.85rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: var(--transition);
    cursor: pointer;
}

.btn-action.copy {
    border-color: var(--medium-gray);
    color: var(--text-light);
    background: var(--light-bg);
}

.btn-action.copy:hover {
    border-color: var(--primary-blue);
    color: var(--primary-blue);
    background: #eff6ff;
    transform: translateY(-1px);
}

.btn-action.toggle {
    border-color: var(--success-green);
    color: var(--success-green-dark);
    background: #ecfdf5;
}

.btn-action.toggle:hover {
    background: var(--success-green);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-action.toggle.inactive {
    border-color: var(--warning-orange);
    color: var(--warning-orange-dark);
    background: #fffbeb;
}

.btn-action.toggle.inactive:hover {
    background: var(--warning-orange);
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.btn-action.delete {
    border-color: var(--danger-red);
    color: var(--danger-red-dark);
    background: #fef2f2;
}

.btn-action.delete:hover {
    background: var(--danger-red);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* État vide modernisé */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
    border: 2px solid var(--medium-gray);
}

.empty-icon {
    font-size: 4rem;
    color: var(--text-light);
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    font-size: 1.5rem;
    font-weight: 700;
}

.empty-state p {
    color: var(--text-light);
    font-size: 1.1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .newsletter-container {
        padding: 1rem;
    }
    
    .newsletter-header {
        padding: 2rem 1.5rem;
    }
    
    .newsletter-header h1 {
        font-size: 2rem;
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
    }
    
    .subscribers-grid {
        grid-template-columns: 1fr;
    }
    
    .header-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .filter-badges {
        justify-content: center;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeInUp 0.6s ease-out;
}

/* Pagination modernisée */
.pagination {
    justify-content: center;
    margin-top: 2rem;
}

.page-link {
    border-radius: 12px;
    margin: 0 4px;
    border: 2px solid var(--medium-gray);
    color: var(--text-light);
    font-weight: 600;
    padding: 10px 16px;
}

.page-link:hover {
    background: var(--light-bg);
    border-color: var(--primary-blue);
    color: var(--primary-blue);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    border-color: var(--primary-blue);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* Messages flash */
.alert {
    border-radius: var(--border-radius);
    border: 2px solid;
    font-weight: 600;
    padding: 16px 20px;
}

.alert-success {
    background: #dcfce7;
    border-color: var(--success-green);
    color: #166534;
}
</style>

<div class="newsletter-container">
    <!-- Header modernisé -->
    <div class="newsletter-header fade-in">
        <h1>
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="5" width="18" height="14" rx="2" fill="currentColor" opacity="0.8"/>
                <path d="M4 7l8 6 8-6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="title-accent">Abonnés à la Newsletter</span>
        </h1>
        <p>Gestion complète des abonnés et statistiques détaillées</p>
        <div class="header-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-header">
                <i class="fas fa-arrow-left"></i>
                Retour au tableau de bord
            </a>
            <a href="{{ route('admin.newsletter.export-csv') }}" class="btn-header primary" id="exportCsvBtn">
                <i class="fas fa-download"></i>
                Exporter en CSV
            </a>
        </div>
    </div>

    <!-- Onglets modernisés -->
    <div class="tabs-container fade-in">
        <div class="tabs">
            <a href="{{ route('admin.newsletter.index') }}" class="tab-link {{ request('tab') !== 'campaigns' ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Abonnés ({{ $stats['total'] ?? 0 }})
            </a>
            <a href="{{ route('admin.newsletter.index', ['tab' => 'campaigns'] + request()->except('page')) }}" class="tab-link {{ request('tab') === 'campaigns' ? 'active' : '' }}">
                <i class="fas fa-paper-plane"></i>
                Campagnes
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success fade-in">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(request('tab') === 'campaigns')
        <!-- Section Campagnes -->
        <div class="fade-in">
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-paper-plane"></i></div>
                <h3>Campagnes Newsletter</h3>
                <p>Cette section sera bientôt disponible pour gérer vos campagnes email.</p>
            </div>
        </div>
    @else
        <!-- Statistiques modernisées -->
        <div class="stats-container fade-in">
            <div class="stat-card">
                <div class="stat-content">
                    <h3>Total Abonnés</h3>
                    <div class="value">{{ $stats['total'] ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            
            <div class="stat-card success">
                <div class="stat-content">
                    <h3>Actifs</h3>
                    <div class="value">{{ $stats['active'] ?? 0 }}</div>
                </div>
                <div class="stat-icon success">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
            
            <div class="stat-card warning">
                <div class="stat-content">
                    <h3>Inactifs</h3>
                    <div class="value">{{ $stats['inactive'] ?? 0 }}</div>
                </div>
                <div class="stat-icon warning">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
            
            <div class="stat-card info">
                <div class="stat-content">
                    <h3>Taux d'engagement</h3>
                    <div class="value">{{ $stats['total'] > 0 ? round(($stats['active'] / $stats['total']) * 100, 1) : 0 }}%</div>
                </div>
                <div class="stat-icon info">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>

        <!-- Filtres modernisés -->
        <div class="filter-container fade-in">
            <form method="GET" action="{{ route('admin.newsletter.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="color: var(--text-dark); font-size: 1rem;">
                            <i class="fas fa-search me-2"></i>
                            Rechercher un abonné
                        </label>
                        <div class="search-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Tapez l'adresse email..." />
                            <button class="search-btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="color: var(--text-dark); font-size: 1rem;">
                            <i class="fas fa-filter me-2"></i>
                            Filtres rapides
                        </label>
                        <div class="filter-badges">
                            <a href="{{ route('admin.newsletter.index') }}" class="filter-badge {{ request('status') === '' ? 'active' : '' }}">
                                Tous ({{ $stats['total'] ?? 0 }})
                            </a>
                            <a href="{{ route('admin.newsletter.index', ['status' => 'active', 'search' => request('search')]) }}" class="filter-badge {{ request('status') === 'active' ? 'active' : '' }}">
                                Actifs ({{ $stats['active'] ?? 0 }})
                            </a>
                            <a href="{{ route('admin.newsletter.index', ['status' => 'inactive', 'search' => request('search')]) }}" class="filter-badge {{ request('status') === 'inactive' ? 'active' : '' }}">
                                Inactifs ({{ $stats['inactive'] ?? 0 }})
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Liste des abonnés -->
        <div class="fade-in">
            @if($subscribers->count() > 0)
                <div class="subscribers-grid">
                    @foreach($subscribers as $subscriber)
                    <div class="subscriber-card {{ !$subscriber->is_active ? 'inactive' : '' }}">
                        <div class="subscriber-header">
                            <div class="subscriber-email">
                                <div class="avatar">{{ strtoupper(substr($subscriber->email, 0, 1)) }}</div>
                                <span>{{ $subscriber->email }}</span>
                            </div>
                            <span class="status-badge {{ $subscriber->is_active ? 'active' : 'inactive' }}">
                                {{ $subscriber->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                        
                        <div class="subscriber-meta">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Inscrit le {{ optional($subscriber->subscribed_at ?? $subscriber->created_at)->format('d/m/Y à H:i') }}
                        </div>
                        
                        <div class="subscriber-actions">
                            <button type="button" class="btn-action copy" onclick="copyEmail('{{ $subscriber->email }}', this)">
                                <i class="fas fa-copy"></i>
                                Copier
                            </button>
                            
                            <form method="POST" action="{{ route('admin.newsletter.toggle-active', $subscriber->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-action toggle {{ $subscriber->is_active ? '' : 'inactive' }}">
                                    <i class="fas {{ $subscriber->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                    {{ $subscriber->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('admin.newsletter.destroy', $subscriber->id) }}" onsubmit="return confirm('Supprimer cet abonné définitivement ?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete">
                                    <i class="fas fa-trash"></i>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination et infos -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted" style="font-weight: 600; color: var(--text-light) !important;">
                        <i class="fas fa-info-circle me-1"></i>
                        Page {{ $subscribers->currentPage() }} sur {{ $subscribers->lastPage() }} 
                        ({{ $subscribers->total() }} abonnés au total)
                    </div>
                    <div>
                        {{ $subscribers->links() }}
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                    <h3>Aucun abonné trouvé</h3>
                    <p>La liste des abonnés est vide ou aucun résultat ne correspond à votre recherche.</p>
                    @if(request('search') || request('status'))
                        <div class="mt-3">
                            <a href="{{ route('admin.newsletter.index') }}" class="btn-header" style="background: var(--primary-blue); border-color: var(--primary-blue);">
                                <i class="fas fa-refresh me-2"></i>
                                Réinitialiser les filtres
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>

@push('scripts')
<script>
// Fonction pour copier l'email
function copyEmail(text, btn) {
    navigator.clipboard.writeText(text).then(function() {
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copié !';
        btn.style.background = 'var(--success-green)';
        btn.style.color = 'white';
        btn.style.borderColor = 'var(--success-green)';
        
        setTimeout(() => { 
            btn.innerHTML = original; 
            btn.style.background = '';
            btn.style.color = '';
            btn.style.borderColor = '';
        }, 1500);
    }).catch(function() {
        // Fallback pour les navigateurs qui ne supportent pas clipboard API
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copié !';
        btn.style.background = 'var(--success-green)';
        btn.style.color = 'white';
        
        setTimeout(() => { 
            btn.innerHTML = original; 
            btn.style.background = '';
            btn.style.color = '';
        }, 1500);
    });
}

// Toast pour l'export CSV
function showToast(message, type = 'success') {
    let toast = document.getElementById('toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast-notification';
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            padding: 16px 20px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
        `;
        document.body.appendChild(toast);
    }
    
    const colors = {
        success: { bg: 'var(--success-green)', color: 'white' },
        error: { bg: 'var(--danger-red)', color: 'white' },
        info: { bg: 'var(--info-cyan)', color: 'white' }
    };
    
    toast.style.background = colors[type].bg;
    toast.style.color = colors[type].color;
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}-circle me-2"></i>${message}`;
    
    // Animation d'entrée
    requestAnimationFrame(() => {
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';
    });
    
    // Animation de sortie
    setTimeout(() => {
        toast.style.transform = 'translateY(100px)';
        toast.style.opacity = '0';
    }, 3000);
}

// Event listener pour l'export CSV
document.getElementById('exportCsvBtn')?.addEventListener('click', function(e) {
    showToast('✅ Export CSV en cours...', 'success');
});

// Animation au scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animationDelay = '0s';
            entry.target.classList.add('fade-in');
        }
    });
}, observerOptions);

// Observer tous les éléments qui doivent s'animer
document.querySelectorAll('.stat-card, .subscriber-card').forEach(el => {
    observer.observe(el);
});
</script>
@endpush
@endsection


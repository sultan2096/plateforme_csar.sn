@extends('layouts.admin')

@section('title', 'Partenaires Techniques - Administration')

@section('content')
<style>
/* Variables CSS avec couleurs vives pour les partenaires */
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
    --purple: #8b5cf6;
    --purple-dark: #7c3aed;
    --emerald: #10b981;
    --emerald-dark: #047857;
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

/* Container principal */
.partners-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Header avec dégradé emeraude */
.partners-header {
    background: linear-gradient(135deg, var(--emerald) 0%, var(--success-green-dark) 100%);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: 0 15px 40px rgba(16, 185, 129, 0.3);
    position: relative;
    overflow: hidden;
}

.partners-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="partnership" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white" opacity="0.15"/><circle cx="5" cy="15" r="1" fill="white" opacity="0.08"/><circle cx="15" cy="5" r="1" fill="white" opacity="0.08"/></pattern></defs><rect width="100" height="100" fill="url(%23partnership)"/></svg>');
    opacity: 0.4;
    pointer-events: none;
}

.partners-header > * {
    position: relative;
    z-index: 2;
}

.partners-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.partners-header .title-accent {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.partners-header p {
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
    color: var(--emerald-dark);
    border-color: rgba(255, 255, 255, 0.9);
}

.btn-header.primary:hover {
    background: #fff;
    color: var(--emerald-dark);
}

/* Statistiques colorées */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
}

.stat-card.total::before {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
}

.stat-card.active::before {
    background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
}

.stat-card.ong::before {
    background: linear-gradient(135deg, var(--info-cyan) 0%, var(--info-cyan-dark) 100%);
}

.stat-card.agency::before {
    background: linear-gradient(135deg, var(--warning-orange) 0%, var(--warning-orange-dark) 100%);
}

.stat-card.institution::before {
    background: linear-gradient(135deg, var(--purple) 0%, var(--purple-dark) 100%);
}

.stat-card.private::before {
    background: linear-gradient(135deg, var(--danger-red) 0%, var(--danger-red-dark) 100%);
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
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--text-dark);
    margin: 0;
    line-height: 1;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.stat-icon.total {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
}

.stat-icon.active {
    background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
}

.stat-icon.ong {
    background: linear-gradient(135deg, var(--info-cyan) 0%, var(--info-cyan-dark) 100%);
}

.stat-icon.agency {
    background: linear-gradient(135deg, var(--warning-orange) 0%, var(--warning-orange-dark) 100%);
}

.stat-icon.institution {
    background: linear-gradient(135deg, var(--purple) 0%, var(--purple-dark) 100%);
}

.stat-icon.private {
    background: linear-gradient(135deg, var(--danger-red) 0%, var(--danger-red-dark) 100%);
}

/* Filtres modernisés */
.filter-container {
    background: #fff;
    border: 2px solid var(--medium-gray);
    border-radius: var(--border-radius);
    padding: 24px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-light);
}

.search-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid var(--medium-gray);
    border-radius: 12px;
    font-size: 1rem;
    transition: var(--transition);
    background: var(--light-bg);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: #fff;
}

.select-filter {
    padding: 14px 16px;
    border: 2px solid var(--medium-gray);
    border-radius: 12px;
    font-size: 1rem;
    background: var(--light-bg);
    color: var(--text-dark);
    font-weight: 600;
}

.select-filter:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-filter {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    border: none;
    color: white;
    padding: 14px 24px;
    border-radius: 12px;
    font-weight: 600;
    transition: var(--transition);
}

.btn-filter:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-reset {
    background: var(--light-bg);
    border: 2px solid var(--medium-gray);
    color: var(--text-light);
    padding: 12px 22px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
}

.btn-reset:hover {
    background: #f3f4f6;
    border-color: var(--dark-gray);
    color: var(--text-dark);
    text-decoration: none;
}

/* Table modernisée */
.partners-table {
    background: #fff;
    border: 2px solid var(--medium-gray);
    border-radius: var(--border-radius);
    padding: 0;
    box-shadow: var(--shadow-light);
    overflow: hidden;
}

.table {
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table thead th {
    background: linear-gradient(135deg, var(--light-bg) 0%, #f1f5f9 100%);
    border: none;
    color: var(--text-dark);
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 20px 16px;
}

.table tbody tr {
    border-bottom: 1px solid var(--medium-gray);
    transition: var(--transition);
}

.table tbody tr:hover {
    background: linear-gradient(135deg, #fafbff 0%, #f0f9ff 100%);
}

.table tbody td {
    padding: 16px;
    vertical-align: middle;
    color: var(--text-dark);
    font-weight: 500;
    border: none;
}

/* Badges avec couleurs vives */
.badge-modern {
    padding: 8px 16px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: 2px solid;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.badge-ong {
    background: #ecfeff;
    color: #0891b2;
    border-color: #67e8f9;
}

.badge-agency {
    background: #fffbeb;
    color: #d97706;
    border-color: #fde68a;
}

.badge-institution {
    background: #f3e8ff;
    color: #7c3aed;
    border-color: #c4b5fd;
}

.badge-private {
    background: #fef2f2;
    color: #dc2626;
    border-color: #fca5a5;
}

.badge-government {
    background: #eff6ff;
    color: #1d4ed8;
    border-color: #93c5fd;
}

.badge-active {
    background: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.badge-inactive {
    background: #f3f4f6;
    color: #374151;
    border-color: #d1d5db;
}

.badge-pending {
    background: #fef3c7;
    color: #92400e;
    border-color: #fde68a;
}

/* Actions table */
.table-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
}

.btn-action {
    padding: 8px 12px;
    border-radius: 10px;
    border: 2px solid;
    font-weight: 600;
    font-size: 0.85rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: var(--transition);
    cursor: pointer;
    min-width: 40px;
    justify-content: center;
}

.btn-action.view {
    border-color: var(--info-cyan);
    color: var(--info-cyan-dark);
    background: #ecfeff;
}

.btn-action.view:hover {
    background: var(--info-cyan);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
}

.btn-action.edit {
    border-color: var(--warning-orange);
    color: var(--warning-orange-dark);
    background: #fffbeb;
}

.btn-action.edit:hover {
    background: var(--warning-orange);
    color: white;
    transform: translateY(-1px);
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

.btn-action.feature {
    border-color: var(--success-green);
    color: var(--success-green-dark);
    background: #ecfdf5;
}

.btn-action.feature:hover {
    background: var(--success-green);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-action.feature.active {
    background: var(--success-green);
    color: white;
    border-color: var(--success-green-dark);
}

/* Position input */
.position-input {
    width: 80px;
    padding: 6px 8px;
    border: 2px solid var(--medium-gray);
    border-radius: 8px;
    font-weight: 600;
    text-align: center;
}

.position-input:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
}

.btn-save-position {
    padding: 6px 12px;
    border: 2px solid var(--primary-blue);
    background: #eff6ff;
    color: var(--primary-blue-dark);
    border-radius: 8px;
    font-weight: 600;
    transition: var(--transition);
}

.btn-save-position:hover {
    background: var(--primary-blue);
    color: white;
}

/* Empty state */
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
    margin-bottom: 2rem;
}

/* Messages flash */
.alert {
    border-radius: var(--border-radius);
    border: 2px solid;
    font-weight: 600;
    padding: 16px 20px;
    margin-bottom: 2rem;
}

.alert-success {
    background: #dcfce7;
    border-color: var(--success-green);
    color: #166534;
}

/* Responsive */
@media (max-width: 768px) {
    .partners-container {
        padding: 1rem;
    }
    
    .partners-header {
        padding: 2rem 1.5rem;
    }
    
    .partners-header h1 {
        font-size: 2rem;
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
    }
    
    .header-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .table-actions {
        flex-direction: column;
        gap: 4px;
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
</style>

<div class="partners-container">
    <!-- Header modernisé -->
    <div class="partners-header fade-in">
        <h1>
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 4V2C16 1.45 15.55 1 15 1H9C8.45 1 8 1.45 8 2V4H16Z" fill="currentColor" opacity="0.8"/>
                <path d="M21 7H3C2.45 7 2 7.45 2 8C2 8.55 2.45 9 3 9H21C21.55 9 22 8.55 22 8C22 7.45 21.55 7 21 7Z" fill="currentColor"/>
                <path d="M20 10H4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V10Z" fill="currentColor" opacity="0.9"/>
                <circle cx="12" cy="16" r="2" fill="white"/>
            </svg>
            <span class="title-accent">Partenaires Techniques</span>
        </h1>
        <p>Gestion complète des partenaires et acteurs du réseau CSAR</p>
        <div class="header-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-header">
                <i class="fas fa-arrow-left"></i>
                Retour au tableau de bord
            </a>
            <a href="{{ route('admin.technical-partners.export') }}" class="btn-header">
                <i class="fas fa-download"></i>
                Exporter CSV
            </a>
            <a href="{{ route('admin.technical-partners.create') }}" class="btn-header primary">
                <i class="fas fa-plus"></i>
                Nouveau Partenaire
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success fade-in">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
                        </div>
    @endif

    <!-- Statistiques colorées -->
    <div class="stats-container fade-in">
        <div class="stat-card total">
            <div class="stat-content">
                <h3>Total Partenaires</h3>
                <div class="value">{{ $stats['total'] ?? 0 }}</div>
                        </div>
            <div class="stat-icon total">
                <i class="fas fa-handshake"></i>
            </div>
        </div>

        <div class="stat-card active">
            <div class="stat-content">
                <h3>Actifs</h3>
                <div class="value">{{ $stats['active'] ?? 0 }}</div>
                        </div>
            <div class="stat-icon active">
                <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
        
        <div class="stat-card ong">
            <div class="stat-content">
                <h3>ONG</h3>
                <div class="value">{{ $stats['ong'] ?? 0 }}</div>
                </div>
            <div class="stat-icon ong">
                <i class="fas fa-heart"></i>
            </div>
        </div>

        <div class="stat-card agency">
            <div class="stat-content">
                <h3>Agences</h3>
                <div class="value">{{ $stats['agency'] ?? 0 }}</div>
                        </div>
            <div class="stat-icon agency">
                <i class="fas fa-building"></i>
            </div>
        </div>

        <div class="stat-card institution">
            <div class="stat-content">
                <h3>Institutions</h3>
                <div class="value">{{ $stats['institution'] ?? 0 }}</div>
                        </div>
            <div class="stat-icon institution">
                <i class="fas fa-landmark"></i>
            </div>
        </div>

        <div class="stat-card private">
            <div class="stat-content">
                <h3>Privé</h3>
                <div class="value">{{ $stats['private'] ?? 0 }}</div>
                        </div>
            <div class="stat-icon private">
                <i class="fas fa-industry"></i>
                </div>
            </div>
        </div>

    <!-- Filtres modernisés -->
    <div class="filter-container fade-in">
        <form method="GET" action="{{ route('admin.technical-partners.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold" style="color: var(--text-dark);">
                        <i class="fas fa-search me-2"></i>
                        Recherche
                    </label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                           class="search-input" placeholder="Nom ou organisation...">
                        </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold" style="color: var(--text-dark);">
                        <i class="fas fa-layer-group me-2"></i>
                        Type
                    </label>
                    <select name="type" class="select-filter">
                        <option value="">Tous les types</option>
                        @foreach(['ong'=>'ONG','agency'=>'Agence','institution'=>'Institution','private'=>'Privé','government'=>'Gouvernement'] as $value=>$label)
                            <option value="{{ $value }}" {{ ($filters['type'] ?? '')===$value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                        </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold" style="color: var(--text-dark);">
                        <i class="fas fa-filter me-2"></i>
                        Statut
                    </label>
                    <select name="status" class="select-filter">
                        <option value="">Tous les statuts</option>
                        @foreach(['active'=>'Actif','inactive'=>'Inactif','pending'=>'En attente'] as $value=>$label)
                            <option value="{{ $value }}" {{ ($filters['status'] ?? '')===$value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search"></i>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.technical-partners.index') }}" class="btn-reset">
                            <i class="fas fa-refresh"></i>
                        </a>
                </div>
            </div>
        </div>
        </form>
    </div>

    <!-- Table modernisée -->
    <div class="partners-table fade-in">
            @if($partners->count() > 0)
                <div class="table-responsive">
                <table class="table">
                        <thead>
                            <tr>
                            <th><i class="fas fa-image me-2"></i>Logo</th>
                            <th><i class="fas fa-user me-2"></i>Partenaire</th>
                            <th><i class="fas fa-tag me-2"></i>Type</th>
                            <th><i class="fas fa-address-book me-2"></i>Contact</th>
                            <th><i class="fas fa-map-marker-alt me-2"></i>Zone</th>
                            <th><i class="fas fa-toggle-on me-2"></i>Statut</th>
                            <th><i class="fas fa-star me-2"></i>À la une</th>
                            <th><i class="fas fa-sort-numeric-down me-2"></i>Position</th>
                            <th><i class="fas fa-cog me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partners as $partner)
                            <tr>
                                <td>
                                    @if($partner->logo)
                                    <img src="{{ Storage::url($partner->logo) }}" alt="Logo {{ $partner->name }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 12px; border: 2px solid var(--medium-gray);">
                                    @else
                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--medium-gray), #d1d5db); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-light);">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                <div style="font-weight: 700; color: var(--text-dark); font-size: 1rem;">
                                    {{ $partner->name }}
                                </div>
                                @if($partner->organization)
                                    <div style="color: var(--text-light); font-size: 0.85rem; margin-top: 4px;">
                                        {{ $partner->organization }}
                                    </div>
                                @endif
                                    @if($partner->role)
                                    <div style="color: var(--text-light); font-size: 0.8rem; font-style: italic;">
                                        {{ $partner->role }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    @switch($partner->type)
                                        @case('ong')
                                        <span class="badge-modern badge-ong">
                                            <i class="fas fa-heart"></i>
                                            ONG
                                        </span>
                                            @break
                                        @case('agency')
                                        <span class="badge-modern badge-agency">
                                            <i class="fas fa-building"></i>
                                            Agence
                                        </span>
                                            @break
                                        @case('institution')
                                        <span class="badge-modern badge-institution">
                                            <i class="fas fa-landmark"></i>
                                            Institution
                                        </span>
                                            @break
                                        @case('private')
                                        <span class="badge-modern badge-private">
                                            <i class="fas fa-industry"></i>
                                            Privé
                                        </span>
                                            @break
                                        @case('government')
                                        <span class="badge-modern badge-government">
                                            <i class="fas fa-flag"></i>
                                            Gouvernement
                                        </span>
                                            @break
                                    @default
                                        <span class="badge-modern badge-inactive">Non défini</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($partner->contact_person)
                                    <div style="font-weight: 600; color: var(--text-dark);">
                                        <i class="fas fa-user-tie me-1"></i>{{ $partner->contact_person }}
                                    </div>
                                    @endif
                                    @if($partner->email)
                                    <div style="color: var(--text-light); font-size: 0.85rem;">
                                        <i class="fas fa-envelope me-1"></i>{{ $partner->email }}
                                    </div>
                                    @endif
                                    @if($partner->phone)
                                    <div style="color: var(--text-light); font-size: 0.85rem;">
                                        <i class="fas fa-phone me-1"></i>{{ $partner->phone }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                @if($partner->intervention_zone && is_array($partner->intervention_zone))
                                    @foreach(array_slice($partner->intervention_zone, 0, 2) as $zone)
                                        <span style="background: #f0f4ff; color: var(--primary-blue); padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; margin: 2px; display: inline-block;">
                                            {{ $zone }}
                                        </span>
                                        @endforeach
                                    @if(count($partner->intervention_zone) > 2)
                                        <span style="background: #f3f4f6; color: var(--text-light); padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                            +{{ count($partner->intervention_zone) - 2 }}
                                        </span>
                                        @endif
                                    @else
                                    <span style="color: var(--text-light); font-style: italic;">Non spécifiée</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($partner->status)
                                        @case('active')
                                        <span class="badge-modern badge-active">
                                            <i class="fas fa-check-circle"></i>
                                            Actif
                                        </span>
                                            @break
                                        @case('inactive')
                                        <span class="badge-modern badge-inactive">
                                            <i class="fas fa-pause-circle"></i>
                                            Inactif
                                        </span>
                                            @break
                                        @case('pending')
                                        <span class="badge-modern badge-pending">
                                            <i class="fas fa-clock"></i>
                                            En attente
                                        </span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                <form method="POST" action="{{ route('admin.technical-partners.update', $partner) }}" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $partner->name }}">
                                    <input type="hidden" name="slug" value="{{ $partner->slug }}">
                                    <input type="hidden" name="status" value="{{ $partner->status }}">
                                    <input type="hidden" name="type" value="{{ $partner->type }}">
                                    <input type="hidden" name="is_featured" value="{{ $partner->is_featured ? 0 : 1 }}">
                                    <button type="submit" class="btn-action feature {{ $partner->is_featured ? 'active' : '' }}" 
                                            title="{{ $partner->is_featured ? 'Retirer de la une' : 'Marquer à la une' }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.technical-partners.update', $partner) }}" 
                                      style="display: flex; align-items: center; gap: 8px;">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="position" value="{{ $partner->position }}" 
                                           class="position-input" min="1" max="999">
                                    <input type="hidden" name="name" value="{{ $partner->name }}">
                                    <input type="hidden" name="slug" value="{{ $partner->slug }}">
                                    <input type="hidden" name="status" value="{{ $partner->status }}">
                                    <input type="hidden" name="type" value="{{ $partner->type }}">
                                    <button type="submit" class="btn-save-position" title="Sauvegarder position">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.technical-partners.show', $partner) }}" 
                                       class="btn-action view" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    <a href="{{ route('admin.technical-partners.edit', $partner) }}" 
                                       class="btn-action edit" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <form method="POST" action="{{ route('admin.technical-partners.destroy', $partner) }}" 
                                          style="display: inline;" onsubmit="return confirm('Supprimer ce partenaire définitivement ?')">
                                            @csrf
                                            @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            @if($partners->hasPages())
                <div class="d-flex justify-content-between align-items-center p-3" style="background: var(--light-bg); border-top: 1px solid var(--medium-gray);">
                    <div style="color: var(--text-light); font-weight: 600;">
                        <i class="fas fa-info-circle me-1"></i>
                        Page {{ $partners->currentPage() }} sur {{ $partners->lastPage() }} 
                        ({{ $partners->total() }} partenaires au total)
                    </div>
                    <div>
                    {{ $partners->links() }}
                </div>
                </div>
            @endif
            @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-handshake"></i></div>
                <h3>Aucun partenaire trouvé</h3>
                <p>La liste des partenaires est vide ou aucun résultat ne correspond à vos critères de recherche.</p>
                <div class="mt-3">
                    <a href="{{ route('admin.technical-partners.create') }}" class="btn-header primary" 
                       style="background: var(--emerald); border-color: var(--emerald);">
                        <i class="fas fa-plus me-2"></i>
                        Ajouter un Partenaire
                    </a>
                </div>
                </div>
            @endif
        </div>
    </div>

@push('scripts')
<script>
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
document.querySelectorAll('.stat-card, .partners-table tbody tr').forEach(el => {
    observer.observe(el);
});

// Amélioration des interactions
document.querySelectorAll('.btn-action').forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px) scale(1.05)';
    });
    
    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

// Auto-focus sur le champ de recherche avec Ctrl+F
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'f') {
        e.preventDefault();
        document.querySelector('.search-input').focus();
    }
});

// Confirmation améliorée pour les suppressions
document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const partnerName = this.closest('tr').querySelector('td:nth-child(2) div').textContent.trim();
        const confirmed = confirm(`Êtes-vous sûr de vouloir supprimer le partenaire "${partnerName}" ?\n\nCette action est irréversible.`);
        
        if (confirmed) {
            this.submit();
        }
    });
});
</script>
@endpush 
@endsection
 
@extends('layouts.admin')

@section('title', 'Détails du Partenaire - Administration')

@section('content')
<style>
:root {
    --primary-blue: #3b82f6;
    --info-cyan: #06b6d4;
    --success-green: #10b981;
    --warning-orange: #f59e0b;
    --light-bg: #f8fafc;
    --medium-gray: #e5e7eb;
    --text-dark: #111827;
    --text-light: #6b7280;
    --shadow-light: 0 4px 20px rgba(0, 0, 0, 0.1);
    --border-radius: 16px;
    --transition: all 0.3s ease;
}

.partner-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

.partner-header {
    background: linear-gradient(135deg, var(--info-cyan) 0%, #0891b2 100%);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: 0 15px 40px rgba(6, 182, 212, 0.3);
    position: relative;
}

.partner-header-content {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.partner-logo {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    object-fit: cover;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
}

.partner-info h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem;
}

.partner-badges {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 1rem;
}

.header-badge {
    padding: 8px 16px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 0.85rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.1);
}

.info-card {
    background: #fff;
    border: 2px solid var(--medium-gray);
    border-radius: var(--border-radius);
    padding: 2rem;
    box-shadow: var(--shadow-light);
    margin-bottom: 2rem;
}

.info-card h3 {
    color: var(--text-dark);
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 2px solid var(--light-bg);
    padding-bottom: 1rem;
}

.card-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    background: linear-gradient(135deg, var(--info-cyan) 0%, #0891b2 100%);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-label {
    font-weight: 600;
    color: var(--text-light);
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-value {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 1rem;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 0.85rem;
    border: 2px solid;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.status-active {
    background: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.type-ong {
    background: #ecfeff;
    color: #0891b2;
    border-color: #67e8f9;
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
    margin-right: 12px;
}

.btn-header:hover {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .partner-header-content {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<div class="partner-container">
    <!-- Header -->
    <div class="partner-header">
        <div class="partner-header-content">
            <div class="partner-logo">
                @if($technicalPartner->logo)
                    <img src="{{ Storage::url($technicalPartner->logo) }}" alt="Logo {{ $technicalPartner->name }}" class="partner-logo">
                @else
                    <i class="fas fa-handshake"></i>
                @endif
            </div>
            
            <div class="partner-info">
                <h1>{{ $technicalPartner->name }}</h1>
                @if($technicalPartner->organization)
                    <div style="font-size: 1.2rem; opacity: 0.9; margin-bottom: 1rem;">{{ $technicalPartner->organization }}</div>
                @endif
                
                <div class="partner-badges">
                    @switch($technicalPartner->type)
                        @case('ong')
                            <span class="header-badge">🤲 ONG</span>
                            @break
                        @case('agency')
                            <span class="header-badge">🏢 Agence</span>
                            @break
                        @case('institution')
                            <span class="header-badge">🏛️ Institution</span>
                            @break
                        @case('private')
                            <span class="header-badge">💼 Privé</span>
                            @break
                        @case('government')
                            <span class="header-badge">🏛️ Gouvernement</span>
                            @break
                    @endswitch
                    
                    @if($technicalPartner->is_featured)
                        <span class="header-badge">⭐ À la une</span>
                    @endif
                </div>
                
                <div style="margin-top: 1.5rem;">
                    <a href="{{ route('admin.technical-partners.index') }}" class="btn-header">
                        <i class="fas fa-arrow-left"></i>
                        Retour à la liste
                    </a>
                    <a href="{{ route('admin.technical-partners.edit', $technicalPartner) }}" class="btn-header">
                        <i class="fas fa-edit"></i>
                        Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations générales -->
    <div class="info-card">
        <h3>
            <span class="card-icon">
                <i class="fas fa-info-circle"></i>
            </span>
            Informations Générales
        </h3>
        
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Type</div>
                <div class="info-value">
                    @switch($technicalPartner->type)
                        @case('ong')
                            <span class="status-badge type-ong">
                                <i class="fas fa-heart"></i>
                                ONG
                            </span>
                            @break
                        @case('agency')
                            <span class="status-badge" style="background: #fffbeb; color: #d97706; border-color: #fde68a;">
                                <i class="fas fa-building"></i>
                                Agence
                            </span>
                            @break
                        @case('institution')
                            <span class="status-badge" style="background: #f3e8ff; color: #7c3aed; border-color: #c4b5fd;">
                                <i class="fas fa-landmark"></i>
                                Institution
                            </span>
                            @break
                        @case('private')
                            <span class="status-badge" style="background: #fef2f2; color: #dc2626; border-color: #fca5a5;">
                                <i class="fas fa-industry"></i>
                                Privé
                            </span>
                            @break
                        @case('government')
                            <span class="status-badge" style="background: #eff6ff; color: #1d4ed8; border-color: #93c5fd;">
                                <i class="fas fa-flag"></i>
                                Gouvernement
                            </span>
                            @break
                    @endswitch
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Statut</div>
                <div class="info-value">
                    @switch($technicalPartner->status)
                        @case('active')
                            <span class="status-badge status-active">
                                <i class="fas fa-check-circle"></i>
                                Actif
                            </span>
                            @break
                        @case('inactive')
                            <span class="status-badge" style="background: #f3f4f6; color: #374151; border-color: #d1d5db;">
                                <i class="fas fa-pause-circle"></i>
                                Inactif
                            </span>
                            @break
                        @case('pending')
                            <span class="status-badge" style="background: #fef3c7; color: #92400e; border-color: #fde68a;">
                                <i class="fas fa-clock"></i>
                                En attente
                            </span>
                            @break
                    @endswitch
                </div>
            </div>
            
            @if($technicalPartner->role)
                <div class="info-item">
                    <div class="info-label">Rôle</div>
                    <div class="info-value">{{ $technicalPartner->role }}</div>
                </div>
            @endif
            
            @if($technicalPartner->partnership_type)
                <div class="info-item">
                    <div class="info-label">Type de partenariat</div>
                    <div class="info-value">{{ $technicalPartner->partnership_type }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Contact -->
    @if($technicalPartner->contact_person || $technicalPartner->email || $technicalPartner->phone || $technicalPartner->website)
        <div class="info-card">
            <h3>
                <span class="card-icon">
                    <i class="fas fa-address-book"></i>
                </span>
                Contact
            </h3>
            
            <div class="info-grid">
                @if($technicalPartner->contact_person)
                    <div class="info-item">
                        <div class="info-label">Responsable</div>
                        <div class="info-value">{{ $technicalPartner->contact_person }}</div>
                    </div>
                @endif
                
                @if($technicalPartner->email)
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            <a href="mailto:{{ $technicalPartner->email }}" style="color: var(--info-cyan);">{{ $technicalPartner->email }}</a>
                        </div>
                    </div>
                @endif
                
                @if($technicalPartner->phone)
                    <div class="info-item">
                        <div class="info-label">Téléphone</div>
                        <div class="info-value">{{ $technicalPartner->phone }}</div>
                    </div>
                @endif
                
                @if($technicalPartner->website)
                    <div class="info-item">
                        <div class="info-label">Site web</div>
                        <div class="info-value">
                            <a href="{{ $technicalPartner->website }}" target="_blank" style="color: var(--info-cyan);">
                                {{ $technicalPartner->website }}
                                <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Zone d'intervention -->
    @if($technicalPartner->intervention_zone && is_array($technicalPartner->intervention_zone) && count($technicalPartner->intervention_zone) > 0)
        <div class="info-card">
            <h3>
                <span class="card-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </span>
                Zone d'Intervention
            </h3>
            
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                @foreach($technicalPartner->intervention_zone as $zone)
                    <span style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; border: 1px solid #3b82f6;">{{ $zone }}</span>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Description -->
    @if($technicalPartner->description)
        <div class="info-card">
            <h3>
                <span class="card-icon">
                    <i class="fas fa-file-text"></i>
                </span>
                Description
            </h3>
            
            <div style="line-height: 1.7; color: var(--text-dark);">
                {!! nl2br(e($technicalPartner->description)) !!}
            </div>
        </div>
    @endif
</div>
@endsection


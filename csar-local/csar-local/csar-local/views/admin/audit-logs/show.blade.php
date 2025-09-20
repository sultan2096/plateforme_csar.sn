@extends('layouts.admin')

@section('title', 'Détails du Log #' . $auditLog->id . ' - Administration CSAR')
@section('page-title', 'Détails du Log d\'Audit')
@section('page-subtitle', 'Log #' . $auditLog->id)

@section('content')
<style>
:root {
    --audit-primary: #7c3aed;
    --audit-primary-dark: #5b21b6;
    --audit-success: #22c55e;
    --audit-warning: #f59e0b;
    --audit-danger: #ef4444;
    --audit-info: #3b82f6;
}

.audit-detail-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.audit-detail-header {
    background: linear-gradient(135deg, var(--audit-primary), var(--audit-primary-dark));
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.audit-detail-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
    animation: float 20s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.audit-detail-header h1 {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.audit-detail-header p {
    font-size: 1rem;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.audit-detail-header .icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.back-button {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.875rem;
    margin-bottom: 2rem;
}

.back-button:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.info-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.info-card h3 {
    color: var(--audit-primary);
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.info-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.info-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    min-width: 120px;
}

.info-value {
    color: #111827;
    font-size: 0.9rem;
    flex: 1;
    text-align: right;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    justify-content: flex-end;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--audit-primary), var(--audit-primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.875rem;
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    text-align: right;
}

.user-name {
    font-weight: 600;
    color: #111827;
    font-size: 0.9rem;
}

.user-email {
    font-size: 0.75rem;
    color: #6b7280;
}

.action-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.action-create {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    border: 1px solid #6ee7b7;
}

.action-update {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
    border: 1px solid #93c5fd;
}

.action-delete {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.action-login {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    border: 1px solid #fbbf24;
}

.action-logout {
    background: linear-gradient(135deg, #e5e7eb, #d1d5db);
    color: #374151;
    border: 1px solid #9ca3af;
}

.model-type {
    background: #f3f4f6;
    color: #374151;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    font-family: 'Courier New', monospace;
}

.ip-address {
    font-family: 'Courier New', monospace;
    font-size: 0.75rem;
    color: #6b7280;
    background: #f9fafb;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.values-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.values-section h3 {
    color: var(--audit-primary);
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.values-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.values-box {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
}

.values-box h4 {
    color: #374151;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.values-content {
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 0.75rem;
    font-family: 'Courier New', monospace;
    font-size: 0.8rem;
    color: #374151;
    max-height: 200px;
    overflow-y: auto;
    white-space: pre-wrap;
    word-break: break-all;
}

.no-values {
    color: #6b7280;
    font-style: italic;
    text-align: center;
    padding: 1rem;
}

@media (max-width: 768px) {
    .audit-detail-container {
        padding: 1rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .values-grid {
        grid-template-columns: 1fr;
    }
    
    .info-row {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .info-value {
        text-align: left;
    }
    
    .user-info {
        justify-content: flex-start;
    }
    
    .user-details {
        text-align: left;
    }
}
</style>

<div class="audit-detail-container">
    <!-- Bouton retour -->
    <a href="{{ route('admin.audit.index') }}" class="back-button">
        ← Retour aux journaux d'audit
    </a>

    <!-- Header -->
    <div class="audit-detail-header">
        <div class="icon">📋</div>
        <h1>Log d'Audit #{{ $auditLog->id }}</h1>
        <p>Détails complets de l'événement enregistré</p>
    </div>

    <!-- Informations principales -->
    <div class="info-grid">
        <div class="info-card">
            <h3>ℹ️ Informations générales</h3>
            
            <div class="info-row">
                <span class="info-label">ID du log</span>
                <span class="info-value">
                    <strong>#{{ $auditLog->id }}</strong>
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Action</span>
                <span class="info-value">
                    <span class="action-badge action-{{ $auditLog->action }}">
                        {{ ucfirst($auditLog->action) }}
                    </span>
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Type de modèle</span>
                <span class="info-value">
                    @if($auditLog->model_type)
                        <span class="model-type">{{ $auditLog->model_type }}</span>
                    @else
                        <span class="text-muted">Non spécifié</span>
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">ID du modèle</span>
                <span class="info-value">
                    @if($auditLog->model_id)
                        <strong>#{{ $auditLog->model_id }}</strong>
                    @else
                        <span class="text-muted">Non spécifié</span>
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Date et heure</span>
                <span class="info-value">
                    {{ $auditLog->created_at->format('d/m/Y à H:i:s') }}<br>
                    <small class="text-muted">
                        ({{ $auditLog->created_at->diffForHumans() }})
                    </small>
                </span>
            </div>
        </div>

        <div class="info-card">
            <h3>👤 Informations utilisateur</h3>
            
            <div class="info-row">
                <span class="info-label">Utilisateur</span>
                <span class="info-value">
                    @if($auditLog->user)
                        <div class="user-info">
                            <div class="user-avatar">
                                {{ strtoupper(substr($auditLog->user->name, 0, 1)) }}
                            </div>
                            <div class="user-details">
                                <div class="user-name">{{ $auditLog->user->name }}</div>
                                <div class="user-email">{{ $auditLog->user->email }}</div>
                            </div>
                        </div>
                    @else
                        <div class="user-info">
                            <div class="user-avatar" style="background: #6b7280;">
                                ?
                            </div>
                            <div class="user-details">
                                <div class="user-name">Utilisateur supprimé</div>
                                <div class="user-email">N/A</div>
                            </div>
                        </div>
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Adresse IP</span>
                <span class="info-value">
                    @if($auditLog->ip_address)
                        <span class="ip-address">{{ $auditLog->ip_address }}</span>
                    @else
                        <span class="text-muted">Non enregistrée</span>
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">User Agent</span>
                <span class="info-value">
                    @if($auditLog->user_agent)
                        <small class="text-muted" style="word-break: break-all;">
                            {{ Str::limit($auditLog->user_agent, 100) }}
                        </small>
                    @else
                        <span class="text-muted">Non enregistré</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if($auditLog->description)
    <div class="info-card">
        <h3>📝 Description</h3>
        <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1rem; color: #374151;">
            {{ $auditLog->description }}
        </div>
    </div>
    @endif

    <!-- Valeurs anciennes et nouvelles -->
    @if($auditLog->old_values || $auditLog->new_values)
    <div class="values-section">
        <h3>🔄 Modifications des données</h3>
        <div class="values-grid">
            <div class="values-box">
                <h4>🔙 Anciennes valeurs</h4>
                <div class="values-content">
                    @if($auditLog->old_values && !empty($auditLog->old_values))
                        {{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                    @else
                        <div class="no-values">Aucune ancienne valeur enregistrée</div>
                    @endif
                </div>
            </div>

            <div class="values-box">
                <h4>🆕 Nouvelles valeurs</h4>
                <div class="values-content">
                    @if($auditLog->new_values && !empty($auditLog->new_values))
                        {{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                    @else
                        <div class="no-values">Aucune nouvelle valeur enregistrée</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection


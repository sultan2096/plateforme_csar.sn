@extends('layouts.admin')

@section('title', 'Journaux d\'Audit - Administration CSAR')
@section('page-title', 'Journaux d\'Audit')
@section('page-subtitle', 'Suivi des actions et événements système')

@section('content')
<style>
:root {
    --audit-primary: #7c3aed;
    --audit-primary-dark: #5b21b6;
    --audit-secondary: #f3f4f6;
    --audit-accent: #10b981;
    --audit-warning: #f59e0b;
    --audit-danger: #ef4444;
    --audit-info: #3b82f6;
    --audit-success: #22c55e;
}

.audit-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.audit-header {
    background: linear-gradient(135deg, var(--audit-primary), var(--audit-primary-dark));
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.audit-header::before {
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

.audit-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.audit-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.audit-header .icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.success-message {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border: 1px solid var(--audit-success);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(34, 197, 94, 0.1);
}

.success-message p {
    color: #065f46;
    margin: 0;
    font-weight: 600;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
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
    background: linear-gradient(90deg, var(--audit-primary), var(--audit-primary-dark));
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(124, 58, 237, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--audit-primary), var(--audit-primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: var(--audit-primary);
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-label {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filters-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
}

.filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.filters-header h2 {
    color: var(--audit-primary);
    margin: 0;
    font-size: 1.3rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filters-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-input, .filter-select {
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s;
    background: #fafafa;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: var(--audit-primary);
    background: white;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.filter-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.btn {
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
}

.btn-primary {
    background: linear-gradient(135deg, var(--audit-primary), var(--audit-primary-dark));
    color: white;
    box-shadow: 0 4px 6px rgba(124, 58, 237, 0.2);
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--audit-primary-dark), #4c1d95);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(124, 58, 237, 0.3);
}

.btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-1px);
}

.btn-success {
    background: linear-gradient(135deg, var(--audit-success), #16a34a);
    color: white;
}

.btn-success:hover {
    background: linear-gradient(135deg, #16a34a, #15803d);
    transform: translateY(-1px);
}

.btn-warning {
    background: linear-gradient(135deg, var(--audit-warning), #d97706);
    color: white;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #d97706, #b45309);
    transform: translateY(-1px);
}

.btn-danger {
    background: linear-gradient(135deg, var(--audit-danger), #dc2626);
    color: white;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-1px);
}

.logs-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
}

.logs-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.logs-header h2 {
    color: var(--audit-primary);
    margin: 0;
    font-size: 1.3rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.logs-count {
    color: #6b7280;
    font-weight: 600;
    background: #f3f4f6;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
}

.logs-table {
    overflow-x: auto;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.logs-table table {
    width: 100%;
    border-collapse: collapse;
}

.logs-table th {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 1rem;
    text-align: left;
    font-weight: 700;
    color: #374151;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #e5e7eb;
}

.logs-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.logs-table tr:hover {
    background: #f9fafb;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
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

.description-text {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #374151;
    font-size: 0.875rem;
}

.ip-address {
    font-family: 'Courier New', monospace;
    font-size: 0.75rem;
    color: #6b7280;
    background: #f9fafb;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.date-time {
    color: #6b7280;
    font-size: 0.875rem;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    min-width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-info {
    background: linear-gradient(135deg, var(--audit-info), #2563eb);
    color: white;
}

.btn-info:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}

.empty-state .icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h3 {
    margin-bottom: 0.5rem;
    color: #374151;
}

.actions-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
}

.actions-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.actions-header h2 {
    color: var(--audit-primary);
    margin: 0;
    font-size: 1.3rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.actions-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .audit-container {
        padding: 1rem;
    }
    
    .filters-form {
        grid-template-columns: 1fr;
    }
    
    .filter-actions {
        flex-direction: column;
    }
    
    .logs-header, .actions-header, .filters-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .actions-buttons {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="audit-container">
    <!-- Header -->
    <div class="audit-header">
        <div class="icon">🔍</div>
        <h1>Journaux d'Audit</h1>
        <p>Suivi complet des actions et événements système de la plateforme CSAR</p>
    </div>

    @if(session('success'))
    <div class="success-message">
        <p>✅ {{ session('success') }}</p>
    </div>
    @endif

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-value">{{ number_format($stats['total_logs']) }}</div>
            <div class="stat-label">Total des logs</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-value">{{ number_format($stats['today_logs']) }}</div>
            <div class="stat-label">Aujourd'hui</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📈</div>
            <div class="stat-value">{{ number_format($stats['this_week_logs']) }}</div>
            <div class="stat-label">Cette semaine</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔐</div>
            <div class="stat-value">{{ number_format($stats['login_logs']) }}</div>
            <div class="stat-label">Connexions</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">➕</div>
            <div class="stat-value">{{ number_format($stats['create_logs']) }}</div>
            <div class="stat-label">Créations</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✏️</div>
            <div class="stat-value">{{ number_format($stats['update_logs']) }}</div>
            <div class="stat-label">Modifications</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🗑️</div>
            <div class="stat-value">{{ number_format($stats['delete_logs']) }}</div>
            <div class="stat-label">Suppressions</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📆</div>
            <div class="stat-value">{{ number_format($stats['this_month_logs']) }}</div>
            <div class="stat-label">Ce mois</div>
        </div>
    </div>

    <!-- Actions -->
    <div class="actions-section">
        <div class="actions-header">
            <h2>⚡ Actions rapides</h2>
            <div class="actions-buttons">
                <a href="{{ route('admin.audit.exportCsv', request()->all()) }}" class="btn btn-success">
                    📥 Exporter CSV
                </a>
                <button type="button" class="btn btn-warning" onclick="showClearModal()">
                    🧹 Nettoyer les anciens logs
                </button>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <div class="filters-header">
            <h2>🔍 Filtres de recherche</h2>
        </div>
        
        <form method="GET" action="{{ route('admin.audit.index') }}">
            <div class="filters-form">
                <div class="filter-group">
                    <label for="search">🔍 Recherche globale</label>
                    <input type="text" id="search" name="search" 
                           class="filter-input" placeholder="Description, IP, utilisateur..."
                           value="{{ request('search') }}">
                </div>
                
                <div class="filter-group">
                    <label for="user_id">👤 Utilisateur</label>
                    <select id="user_id" name="user_id" class="filter-select">
                        <option value="">Tous les utilisateurs</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="action">⚡ Action</label>
                    <select id="action" name="action" class="filter-select">
                        <option value="">Toutes les actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="model_type">📋 Type de modèle</label>
                    <select id="model_type" name="model_type" class="filter-select">
                        <option value="">Tous les types</option>
                        @foreach($modelTypes as $type)
                            <option value="{{ $type }}" {{ request('model_type') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="date_from">📅 Date de début</label>
                    <input type="date" id="date_from" name="date_from" 
                           class="filter-input" value="{{ request('date_from') }}">
                </div>
                
                <div class="filter-group">
                    <label for="date_to">📅 Date de fin</label>
                    <input type="date" id="date_to" name="date_to" 
                           class="filter-input" value="{{ request('date_to') }}">
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    🔍 Filtrer
                </button>
                <a href="{{ route('admin.audit.index') }}" class="btn btn-secondary">
                    ❌ Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Liste des logs -->
    <div class="logs-section">
        <div class="logs-header">
            <h2>📋 Journaux d'audit</h2>
            <span class="logs-count">{{ $auditLogs->total() }} log(s)</span>
        </div>

        @if($auditLogs->count() > 0)
            <div class="logs-table">
                <table>
                    <thead>
                <tr>
                    <th>#</th>
                            <th>👤 Utilisateur</th>
                            <th>⚡ Action</th>
                            <th>📋 Modèle</th>
                            <th>📝 Description</th>
                            <th>🌐 IP</th>
                            <th>📅 Date</th>
                            <th>🔧 Actions</th>
                </tr>
            </thead>
            <tbody>
                        @foreach($auditLogs as $log)
                            <tr>
                                <td>
                                    <strong>{{ $log->id }}</strong>
                                </td>
                                <td>
                                    <div class="user-info">
                                        @if($log->user)
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($log->user->name, 0, 1)) }}
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">{{ $log->user->name }}</div>
                                                <div class="user-email">{{ $log->user->email }}</div>
                                            </div>
                                        @else
                                            <div class="user-avatar" style="background: #6b7280;">
                                                ?
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">Utilisateur supprimé</div>
                                                <div class="user-email">N/A</div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="action-badge action-{{ $log->action }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td>
                                    @if($log->model_type)
                                        <span class="model-type">{{ $log->model_type }}</span>
                                        @if($log->model_id)
                                            <br><small class="text-muted">#{{ $log->model_id }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="description-text" title="{{ $log->description }}">
                                        {{ $log->description ?? 'Aucune description' }}
                                    </div>
                                </td>
                                <td>
                                    @if($log->ip_address)
                                        <span class="ip-address">{{ $log->ip_address }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="date-time">
                                        {{ $log->created_at->format('d/m/Y') }}<br>
                                        <small>{{ $log->created_at->format('H:i:s') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.audit.show', $log) }}" 
                                           class="btn btn-info btn-sm" title="Voir les détails">
                                            👁️
                                        </a>
                                    </div>
                                </td>
                </tr>
                        @endforeach
            </tbody>
        </table>
            </div>

            <div class="pagination-wrapper">
                {{ $auditLogs->appends(request()->query())->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon">📝</div>
                <h3>Aucun log trouvé</h3>
                <p>Aucun journal d'audit ne correspond aux critères de recherche.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal pour nettoyer les anciens logs -->
<div class="modal fade" id="clearLogsModal" tabindex="-1" aria-labelledby="clearLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clearLogsModalLabel">Nettoyer les anciens logs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.audit.clearOld') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="days" class="form-label">Supprimer les logs de plus de :</label>
                        <select class="form-select" id="days" name="days" required>
                            <option value="7">7 jours</option>
                            <option value="30" selected>30 jours</option>
                            <option value="60">60 jours</option>
                            <option value="90">90 jours</option>
                            <option value="365">1 an</option>
                        </select>
                    </div>
                    <div class="alert alert-warning">
                        <strong>⚠️ Attention :</strong> Cette action est irréversible. Les logs supprimés ne pourront pas être récupérés.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showClearModal() {
    var modal = new bootstrap.Modal(document.getElementById('clearLogsModal'));
    modal.show();
}

// Animation pour les cartes de stats
document.addEventListener('DOMContentLoaded', function() {
    const statCards = document.querySelectorAll('.stat-card');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';
                entry.target.style.transition = 'all 0.6s ease';
                
                setTimeout(function() {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, Math.random() * 200);
            }
        });
    }, observerOptions);
    
    statCards.forEach(function(card) {
        observer.observe(card);
    });
});
</script>
@endsection


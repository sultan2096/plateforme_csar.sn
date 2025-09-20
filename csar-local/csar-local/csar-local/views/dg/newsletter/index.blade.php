@extends('layouts.dg')

@section('title', 'Gestion de la Newsletter - CSAR DG')

@section('content')
<div class="dg-container">
    <!-- Header -->
    <div class="dg-header">
        <h1>Gestion de la Newsletter</h1>
        <p>Consultez et gérez tous les abonnés à la newsletter du CSAR</p>
    </div>

    <!-- Statistiques -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
        margin: 32px 0 24px 0;
    }
    .stat-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(30,41,59,0.08);
        padding: 24px 20px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30,41,59,0.12);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        margin: 0 auto 16px;
        background: linear-gradient(135deg, #3b82f6 60%, #2563eb 100%);
    }
    .stat-card:nth-child(2) .stat-icon {
        background: linear-gradient(135deg, #22c55e 60%, #16a34a 100%);
    }
    .stat-card:nth-child(3) .stat-icon {
        background: linear-gradient(135deg, #f59e0b 60%, #d97706 100%);
    }
    .stat-card:nth-child(4) .stat-icon {
        background: linear-gradient(135deg, #ef4444 60%, #dc2626 100%);
    }
    .stat-card:nth-child(5) .stat-icon {
        background: linear-gradient(135deg, #8b5cf6 60%, #7c3aed 100%);
    }
    .stat-card:nth-child(6) .stat-icon {
        background: linear-gradient(135deg, #06b6d4 60%, #0891b2 100%);
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }
    .stat-label {
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .dg-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .dg-header h1 {
        color: #1e40af;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .dg-header p {
        color: #6b7280;
        font-size: 1.1rem;
    }

    .filters-section {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(30,41,59,0.08);
        border: 1px solid #f1f5f9;
    }

    .filters-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
    }

    .filter-select, .filter-input {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: white;
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-1px);
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .btn-info {
        background: #06b6d4;
        color: white;
    }

    .btn-info:hover {
        background: #0891b2;
        transform: translateY(-1px);
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
        transform: translateY(-1px);
    }

    .btn-sm {
        padding: 8px 12px;
        font-size: 0.75rem;
    }

    .subscribers-section {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(30,41,59,0.08);
        border: 1px solid #f1f5f9;
    }

    .subscribers-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .subscribers-header h2 {
        color: #1e40af;
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .subscribers-count {
        color: #64748b;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .subscribers-table {
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .subscribers-table table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .subscribers-table th,
    .subscribers-table td {
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
    }

    .subscribers-table th {
        background: #f8fafc;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .subscribers-table tr:hover {
        background: #f8fafc;
    }

    .subscriber-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .subscriber-email {
        color: #64748b;
        font-size: 0.875rem;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-active {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pagination-wrapper {
        margin-top: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
    }

    .pagination-info {
        color: #64748b;
        font-size: 0.875rem;
    }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #64748b;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 16px;
        opacity: 0.5;
        color: #94a3b8;
    }

    .empty-state h3 {
        margin-bottom: 8px;
        color: #374151;
        font-size: 1.25rem;
    }

    .empty-state p {
        color: #64748b;
        font-size: 0.875rem;
    }

    .quick-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .quick-action-btn {
        padding: 12px 20px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #374151;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quick-action-btn:hover {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        
        .filter-row {
            grid-template-columns: 1fr;
        }
        
        .filter-actions {
            flex-direction: column;
            align-items: stretch;
        }
        
        .subscribers-header {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
        }
        
        .actions {
            flex-direction: column;
        }
        
        .quick-actions {
            flex-direction: column;
        }
    }
    </style>

    <div class="stats-grid animate__animated animate__fadeInUp animate__delay-1s">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-value">{{ $stats['total_subscribers'] ?? 0 }}</div>
            <div class="stat-label">Total abonnés</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-user-check"></i></div>
            <div class="stat-value">{{ $stats['active_subscribers'] ?? 0 }}</div>
            <div class="stat-label">Abonnés actifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-user-times"></i></div>
            <div class="stat-value">{{ $stats['inactive_subscribers'] ?? 0 }}</div>
            <div class="stat-label">Abonnés inactifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-value">{{ $stats['new_this_month'] ?? 0 }}</div>
            <div class="stat-label">Nouveaux ce mois</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
            <div class="stat-value">{{ $stats['new_this_week'] ?? 0 }}</div>
            <div class="stat-label">Nouveaux cette semaine</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            <div class="stat-value">{{ $stats['growth_rate'] ?? 0 }}%</div>
            <div class="stat-label">Taux de croissance</div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="quick-actions">
        <button type="button" class="quick-action-btn" disabled title="Fonctionnalité en développement">
            <i class="fas fa-plus"></i>
            Nouvel abonné
        </button>
        <button type="button" class="quick-action-btn" disabled title="Fonctionnalité en développement">
            <i class="fas fa-paper-plane"></i>
            Envoyer newsletter
        </button>
        <button type="button" class="quick-action-btn" disabled title="Fonctionnalité en développement">
            <i class="fas fa-file-alt"></i>
            Modèles
        </button>
        <button type="button" class="quick-action-btn" disabled title="Fonctionnalité en développement">
            <i class="fas fa-history"></i>
            Historique
        </button>
        <button type="button" class="quick-action-btn" disabled title="Fonctionnalité en développement">
            <i class="fas fa-download"></i>
            Exporter
        </button>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <form method="GET" action="{{ route('dg.newsletter.index') }}" class="filters-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="status">Statut</label>
                    <select name="status" id="status" class="filter-select">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actifs</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="date_from">Date début</label>
                    <input type="date" name="date_from" id="date_from" class="filter-input" 
                           value="{{ request('date_from') }}">
                </div>

                <div class="filter-group">
                    <label for="date_to">Date fin</label>
                    <input type="date" name="date_to" id="date_to" class="filter-input" 
                           value="{{ request('date_to') }}">
                </div>

                <div class="filter-group">
                    <label for="search">Recherche</label>
                    <input type="text" name="search" id="search" class="filter-input" 
                           placeholder="Email ou nom..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filtrer
                </button>
                <a href="{{ route('dg.newsletter.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Réinitialiser
                </a>
                <button type="button" class="btn btn-success" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-download"></i>
                    Exporter CSV
                </button>
                <button type="button" class="btn btn-info" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-upload"></i>
                    Importer
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des abonnés -->
    <div class="subscribers-section">
        <div class="subscribers-header">
            <h2>Liste des abonnés à la newsletter</h2>
            <span class="subscribers-count">{{ $subscribers->total() }} abonné(s)</span>
        </div>

        @if($subscribers->count() > 0)
            <div class="subscribers-table">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Date d'inscription</th>
                            <th>Dernière activité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscribers as $subscriber)
                            <tr>
                                <td>
                                    <div class="subscriber-name">{{ $subscriber->name ?? 'Anonyme' }}</div>
                                </td>
                                <td>
                                    <div class="subscriber-email">{{ $subscriber->email }}</div>
                                </td>
                                <td>
                                    @if($subscriber->is_active)
                                        <span class="badge badge-active">Actif</span>
                                    @else
                                        <span class="badge badge-inactive">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="content-date">{{ $subscriber->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td>
                                    <div class="content-date">{{ $subscriber->updated_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('dg.newsletter.show', $subscriber->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dg.newsletter.edit', $subscriber->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($subscriber->is_active)
                                            <a href="{{ route('dg.newsletter.deactivate', $subscriber->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('dg.newsletter.activate', $subscriber->id) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @endif
                                        <form method="POST" action="{{ route('dg.newsletter.destroy', $subscriber->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet abonné ?')">
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

            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Affichage de {{ $subscribers->firstItem() ?? 0 }} à {{ $subscribers->lastItem() ?? 0 }} 
                    sur {{ $subscribers->total() }} résultats
                </div>
                {{ $subscribers->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>Aucun abonné trouvé</h3>
                <p>Aucun abonné ne correspond aux critères de recherche.</p>
                <a href="{{ route('dg.newsletter.create') }}" class="btn btn-primary" style="margin-top: 16px;">
                    <i class="fas fa-plus"></i>
                    Ajouter un abonné
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 
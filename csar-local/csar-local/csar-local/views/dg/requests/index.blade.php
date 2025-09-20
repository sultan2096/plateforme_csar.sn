@extends('layouts.dg')

@section('title', 'Gestion des Demandes - CSAR DG')

@section('content')
<div class="dg-container">
    <!-- Header -->
    <div class="dg-header">
        <h1>Gestion des Demandes</h1>
        <p>Consultez et gérez toutes les demandes reçues par la CSAR</p>
    </div>

    <!-- Statistiques & Graphique -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 26px;
        margin: 32px 0 24px 0;
    }
    .stat-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 28px rgba(30,41,59,0.11), 0 1.5px 6px rgba(30,41,59,0.07);
        padding: 22px 18px 18px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: box-shadow 0.2s;
        position: relative;
        min-height: 95px;
    }
    .stat-card:hover {
        box-shadow: 0 8px 32px rgba(30,41,59,0.17), 0 2px 10px rgba(30,41,59,0.12);
    }
    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        background: linear-gradient(135deg, #3b82f6 60%, #2563eb 100%);
        box-shadow: 0 2px 8px rgba(59,130,246,0.11);
        flex-shrink: 0;
    }
    .stat-card:nth-child(2) .stat-icon {
        background: linear-gradient(135deg, #22c55e 60%, #16a34a 100%);
    }
    .stat-card:nth-child(3) .stat-icon {
        background: linear-gradient(135deg, #f59e0b 60%, #d97706 100%);
    }
    .stat-card:nth-child(4) .stat-icon {
        background: linear-gradient(135deg, #f43f5e 60%, #be123c 100%);
    }
    .stat-content h3 {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 2px;
        color: #0f172a;
        letter-spacing: -1px;
    }
    .stat-content p {
        font-size: 1.02rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0;
    }
    @media (max-width: 700px) {
        .stats-grid { grid-template-columns: 1fr; }
        .stat-card { flex-direction: column; align-items: flex-start; gap: 10px; }
        .stat-icon { margin-bottom: 4px; }
    }
    .chart-container-requests {
        margin: 0 0 32px 0;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(30,41,59,0.10);
        padding: 24px 18px 10px 18px;
    }
    .chart-container-requests h3 {
        font-size: 1.13rem;
        color: #0f172a;
        font-weight: 700;
        margin-bottom: 14px;
    }
    .chart-container-requests canvas {
        width: 100% !important;
        height: 290px !important;
        max-width: 100%;
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
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .filters-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-weight: 600;
        color: #374151;
    }

    .filter-select, .filter-input {
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: border-color 0.3s;
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .filter-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
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
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    .btn-info {
        background: #06b6d4;
        color: white;
    }

    .btn-info:hover {
        background: #0891b2;
    }

    .requests-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .requests-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .requests-header h2 {
        color: #1e40af;
        margin: 0;
    }

    .requests-count {
        color: #6b7280;
        font-weight: 600;
    }

    .requests-table {
        overflow-x: auto;
    }

    .requests-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .requests-table th,
    .requests-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .requests-table th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
    }

    .request-name {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .request-name small {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-primary {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-info {
        background: #cffafe;
        color: #0e7490;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .actions {
        display: flex;
        gap: 0.5rem;
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

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        margin-bottom: 0.5rem;
        color: #374151;
    }

    @media (max-width: 768px) {
        .dg-container {
            padding: 1rem;
        }
        
        .filter-row {
            grid-template-columns: 1fr;
        }
        
        .filter-actions {
            flex-direction: column;
        }
        
        .requests-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }
    </style>
    
    <div class="chart-container-requests animate__animated animate__fadeInDown">
        <h3>Répartition des demandes par type</h3>
        <canvas id="requestsTypeChart"></canvas>
    </div>
    
    <div class="stats-grid animate__animated animate__fadeInUp animate__delay-1s">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
            <div class="stat-content">
                <h3>{{ $stats['total'] }}</h3>
                <p>Total Demandes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-hand-holding-heart"></i></div>
            <div class="stat-content">
                <h3>{{ $stats['aide'] }}</h3>
                <p>Demandes d'Aide</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-handshake"></i></div>
            <div class="stat-content">
                <h3>{{ $stats['partenariat'] }}</h3>
                <p>Partenariats</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-content">
                <h3>{{ $stats['pending'] }}</h3>
                <p>En Attente</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <form method="GET" action="{{ route('dg.requests.index') }}" class="filters-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="type">Type de demande</label>
                    <select name="type" id="type" class="filter-select">
                        <option value="">Tous les types</option>
                        <option value="aide" {{ request('type') == 'aide' ? 'selected' : '' }}>Aide</option>
                        <option value="partenariat" {{ request('type') == 'partenariat' ? 'selected' : '' }}>Partenariat</option>
                        <option value="audience" {{ request('type') == 'audience' ? 'selected' : '' }}>Audience</option>
                        <option value="autre" {{ request('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status">Statut</label>
                    <select name="status" id="status" class="filter-select">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvé</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filtrer
                </button>
                <a href="{{ route('dg.requests.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Liste des demandes -->
    <div class="requests-section">
        <div class="requests-header">
            <h2>Liste des demandes</h2>
            <span class="requests-count">{{ $requests->total() }} demande(s)</span>
        </div>

        @if($requests->count() > 0)
            <div class="requests-table">
                <table>
                    <thead>
                        <tr>
                            <th>Demande</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                            <tr>
                                <td>
                                    <div class="request-name">
                                        <strong>{{ $request->name }}</strong>
                                        <small>{{ Str::limit($request->description, 100) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ ucfirst($request->type) }}</span>
                                </td>
                                <td>
                                    @switch($request->status)
                                        @case('pending')
                                            <span class="badge badge-warning">En attente</span>
                                            @break
                                        @case('approved')
                                            <span class="badge badge-success">Approuvé</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge badge-danger">Rejeté</span>
                                            @break
                                        @case('completed')
                                            <span class="badge badge-info">Terminé</span>
                                            @break
                                        @default
                                            <span class="badge badge-primary">{{ ucfirst($request->status) }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('dg.requests.show', $request->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($request->status == 'pending')
                                            <form method="POST" action="{{ route('dg.requests.approve', $request->id) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir approuver cette demande ?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('dg.requests.reject', $request->id) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette demande ?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $requests->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Aucune demande trouvée</h3>
                <p>Aucune demande ne correspond aux critères de recherche.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('requestsTypeChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Aide', 'Partenariat', 'Audience', 'Autre'],
            datasets: [{
                data: [
                    {{ $stats['aide'] }},
                    {{ $stats['partenariat'] }},
                    {{ $stats['audience'] ?? 0 }},
                    {{ $stats['autre'] ?? 0 }}
                ],
                backgroundColor: [
                    '#3b82f6',
                    '#22c55e',
                    '#f59e0b',
                    '#ef4444'
                ],
                borderWidth: 0,
                cutout: '60%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12 }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection 
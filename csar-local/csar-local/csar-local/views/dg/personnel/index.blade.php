@extends('layouts.dg')

@section('title', 'Consultation du Personnel - Interface DG')

@section('content')
<div class="dg-content">
    <div class="content-header">
        <h1><i class="fas fa-users"></i> Consultation du Personnel</h1>
        <div class="header-actions">
            <a href="{{ route('dg.personnel.export-pdf') }}" class="btn btn-secondary">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('dg.personnel.export-excel') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <form method="GET" action="{{ route('dg.personnel.index') }}" class="filters-form">
            <div class="filters-row">
                <div class="filter-group">
                    <label for="search">Recherche</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                           placeholder="Nom, matricule, email...">
                </div>
                
                <div class="filter-group">
                    <label for="direction">Direction / Service</label>
                    <select id="direction" name="direction">
                        <option value="">Toutes les directions</option>
                        @foreach($directions as $direction)
                            <option value="{{ $direction }}" {{ request('direction') == $direction ? 'selected' : '' }}>
                                {{ $direction }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="poste">Fonction</label>
                    <select id="poste" name="poste">
                        <option value="">Toutes les fonctions</option>
                        @foreach($postes as $poste)
                            <option value="{{ $poste }}" {{ request('poste') == $poste ? 'selected' : '' }}>
                                {{ $poste }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="statut_validation">Statut</label>
                    <select id="statut_validation" name="statut_validation">
                        <option value="">Tous les statuts</option>
                        <option value="En attente" {{ request('statut_validation') == 'En attente' ? 'selected' : '' }}>En attente</option>
                        <option value="Valide" {{ request('statut_validation') == 'Valide' ? 'selected' : '' }}>Validé</option>
                        <option value="Rejete" {{ request('statut_validation') == 'Rejete' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                    <a href="{{ route('dg.personnel.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistiques -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $personnel->total() }}</div>
                    <div class="stat-label">Total Personnel</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $personnel->where('statut_validation', 'Valide')->count() }}</div>
                    <div class="stat-label">Validés</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $personnel->where('statut_validation', 'En attente')->count() }}</div>
                    <div class="stat-label">En attente</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $personnel->where('statut_validation', 'Rejete')->count() }}</div>
                    <div class="stat-label">Rejetés</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste du personnel -->
    <div class="content-body">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Matricule</th>
                        <th>Nom et Prénoms</th>
                        <th>Poste</th>
                        <th>Direction</th>
                        <th>Contact</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($personnel as $p)
                    <tr>
                        <td>
                            <div class="personnel-photo">
                                <img src="{{ $p->photo_url }}" alt="Photo de {{ $p->prenoms_nom }}" 
                                     onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                            </div>
                        </td>
                        <td>
                            <strong>{{ $p->matricule }}</strong>
                        </td>
                        <td>
                            <div class="personnel-info">
                                <div class="personnel-name">{{ $p->prenoms_nom }}</div>
                                <div class="personnel-email">{{ $p->email }}</div>
                            </div>
                        </td>
                        <td>{{ $p->poste_actuel }}</td>
                        <td>{{ $p->direction_service }}</td>
                        <td>
                            <div class="contact-info">
                                <div><i class="fas fa-phone"></i> {{ $p->contact_telephonique }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $p->statut_validation)) }}">
                                {{ $p->statut_validation }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('dg.personnel.show', $p) }}" class="btn btn-sm btn-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <p>Aucun personnel trouvé</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $personnel->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<style>
.dg-content {
    padding: 20px;
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header-actions {
    display: flex;
    gap: 10px;
}

.filters-section {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filters-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr auto;
    gap: 15px;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-weight: 500;
    margin-bottom: 5px;
    color: #374151;
}

.filter-group input,
.filter-group select {
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
}

.filter-actions {
    display: flex;
    gap: 10px;
}

.stats-section {
    margin-bottom: 20px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    line-height: 1;
}

.stat-label {
    font-size: 14px;
    color: #6b7280;
    margin-top: 4px;
}

.table-container {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.data-table th {
    background: #f9fafb;
    font-weight: 600;
    color: #374151;
}

.personnel-photo img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.personnel-info {
    display: flex;
    flex-direction: column;
}

.personnel-name {
    font-weight: 500;
    color: #111827;
}

.personnel-email {
    font-size: 12px;
    color: #6b7280;
}

.contact-info {
    font-size: 12px;
    color: #6b7280;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.status-en-attente {
    background: #fef3c7;
    color: #92400e;
}

.status-valide {
    background: #d1fae5;
    color: #065f46;
}

.status-rejete {
    background: #fee2e2;
    color: #991b1b;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 12px;
}

.empty-state {
    text-align: center;
    padding: 40px;
    color: #6b7280;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 10px;
}

.pagination-container {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-primary {
    background: #22c55e;
    color: white;
}

.btn-primary:hover {
    background: #16a34a;
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

.btn-info {
    background: #3b82f6;
    color: white;
}

.btn-info:hover {
    background: #2563eb;
}
</style>
@endsection 
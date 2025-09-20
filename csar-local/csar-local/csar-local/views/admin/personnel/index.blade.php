@extends('layouts.admin')

@section('title', 'Gestion du Personnel - Administration CSAR')

@section('content')
<div class="personnel-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <div class="header-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="header-text">
                    <h1>Gestion du Personnel</h1>
                    <p>Administrer le personnel du CSAR</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.personnel.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Nouvelle fiche
                </a>
                <a href="{{ route('admin.personnel.export-pdf') }}" class="btn btn-secondary">
                    <i class="fas fa-file-pdf"></i>
                    Export PDF
                </a>
                <a href="{{ route('admin.personnel.export-excel') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i>
                    Export Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards (only total) -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalPersonnel ?? 0 }}</h3>
                    <p>Total personnel</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-card">
            <div class="filters-header">
                <h3><i class="fas fa-filter"></i> Filtres</h3>
                <button class="btn btn-sm btn-outline" onclick="toggleFilters()">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div class="filters-content" id="filtersContent">
                <form method="GET" class="filters-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="search">Recherche</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Nom, matricule, email..." class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="direction">Direction / Service</label>
                            <select name="direction" id="direction" class="form-select">
                                <option value="">Toutes les directions</option>
                                @foreach($directions ?? [] as $direction)
                                    <option value="{{ $direction }}" {{ request('direction') == $direction ? 'selected' : '' }}>
                                        {{ $direction }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="poste">Fonction</label>
                            <select name="poste" id="poste" class="form-select">
                                <option value="">Toutes les fonctions</option>
                                @foreach($postes ?? [] as $poste)
                                    <option value="{{ $poste }}" {{ request('poste') == $poste ? 'selected' : '' }}>
                                        {{ $poste }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sort">Trier par</label>
                            <select name="sort" id="sort" class="form-select">
                                <option value="name" {{ ($sort ?? '') === 'name' ? 'selected' : '' }}>Nom</option>
                                <option value="poste" {{ ($sort ?? '') === 'poste' ? 'selected' : '' }}>Poste</option>
                                <option value="date" {{ ($sort ?? '') === 'date' ? 'selected' : '' }}>Date de recrutement</option>
                            </select>
                        </div>
                        
                        <!-- Statut retiré (plus de workflow d'approbation) -->
                    </div>
                    
                    <div class="filters-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.personnel.index') }}" class="btn btn-outline">
                            <i class="fas fa-undo"></i>
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick department chips -->
    <div style="max-width:1200px;margin:0 auto 12px; padding:0 2rem; display:flex; flex-wrap:wrap; gap:8px;">
        <a href="{{ route('admin.personnel.index', array_merge(request()->except('page'), ['direction' => null])) }}" class="btn btn-outline {{ request('direction') ? '' : 'btn-primary' }}">Tous</a>
        @foreach(($directions ?? []) as $dir)
            @if($dir)
            <a href="{{ route('admin.personnel.index', array_merge(request()->except('page'), ['direction' => $dir])) }}" class="btn btn-outline {{ request('direction') === $dir ? 'btn-primary' : '' }}">{{ $dir }}</a>
            @endif
        @endforeach
    </div>

    @if(isset($postesForDirection) && count($postesForDirection) > 0)
    <div style="max-width:1200px;margin:0 auto 16px; padding:0 2rem; display:flex; flex-wrap:wrap; gap:8px;">
        <span style="align-self:center;color:#6b7280;font-size:0.9rem;">Hiérarchie:</span>
        @foreach($postesForDirection as $poste => $count)
            @if($poste)
            <a href="{{ route('admin.personnel.index', array_merge(request()->except('page'), ['poste' => $poste])) }}" class="btn btn-outline {{ request('poste') === $poste ? 'btn-primary' : '' }}">{{ $poste }} ({{ $count }})</a>
            @endif
        @endforeach
    </div>
    @endif

    <!-- Hint banner -->
    <div style="max-width:1200px;margin:0 auto 8px; padding:0 2rem;">
        @if(!request('direction'))
            <div style="background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;padding:12px 14px;border-radius:10px;font-size:0.95rem;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-info-circle"></i>
                Sélectionnez un département pour afficher la liste du personnel.
            </div>
        @endif
    </div>

    <!-- Personnel Directory Layout -->
    <div class="personnel-section directory-layout">
        @if(isset($personnel) && count($personnel) > 0)
            <div class="directory-grid">
                <!-- Sidebar: Directions with counters -->
                <aside class="directory-sidebar">
                    <div class="sidebar-card">
                        <div class="sidebar-header">
                            <i class="fas fa-sitemap"></i>
                            <span>Départements</span>
                        </div>
                        <ul class="sidebar-list">
                            <li class="sidebar-item {{ request('direction') ? '' : 'active' }}">
                                <a href="{{ route('admin.personnel.index', array_merge(request()->except('page'), ['direction' => null])) }}">
                                    <span>Tous</span>
                                    <span class="badge">{{ ($directionCounts?->sum() ?? 0) }}</span>
                                </a>
                            </li>
                            @foreach(($directions ?? []) as $dir)
                                <li class="sidebar-item {{ request('direction') === $dir ? 'active' : '' }}">
                                    <a href="{{ route('admin.personnel.index', array_merge(request()->except('page'), ['direction' => $dir])) }}">
                                        <span>{{ $dir }}</span>
                                        <span class="badge">{{ $directionCounts[$dir] ?? 0 }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

                <!-- Main list -->
                @if(!request('direction'))
                    <div class="empty-state" style="max-width:1200px;margin:16px auto;padding:0 2rem;">
                        <div class="empty-icon"><i class="fas fa-users"></i></div>
                        <h3>Choisissez un département</h3>
                        <p>Utilisez les boutons au-dessus (AC, CIA, …) pour afficher les profils.</p>
                    </div>
                @else
                    <div class="directory-list">
                        <div class="personnel-grid">
                            @foreach($personnel as $p)
                            <div class="personnel-card" style="text-decoration:none;color:inherit;">
                                <div class="personnel-header">
                                    <div class="personnel-photo">
                                        <img src="{{ $p->photo_url }}" alt="Photo de {{ $p->prenoms_nom }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($p->prenoms_nom) }}&background=059669&color=ffffff'">
                                    </div>
                                    <div class="personnel-info">
                                        <h3 class="personnel-name">{{ $p->prenoms_nom }}</h3>
                                        <p class="personnel-matricule">{{ $p->direction_service }} • Mat: <strong>{{ $p->matricule }}</strong></p>
                                        <p class="personnel-poste">{{ $p->poste_actuel }}</p>
                                    </div>
                                </div>
                                <div class="personnel-actions" style="padding:0 1.5rem 1.25rem; display:flex; gap:.5rem;">
                                    <a href="{{ route('admin.personnel.show', $p) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> Voir</a>
                                    <a href="{{ route('admin.personnel.edit', $p) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Modifier</a>
                                    <a href="{{ route('admin.personnel.export-fiche-pdf', $p) }}" class="btn btn-secondary btn-sm"><i class="fas fa-file-pdf"></i> Fiche PDF</a>
                                    <form method="POST" action="{{ route('admin.personnel.destroy', $p) }}" style="display: inline;" id="delete-personnel-{{ $p->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeletePersonnel({{ $p->id }}, '{{ $p->prenoms_nom }}')">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Pagination -->
            @if($personnel->hasPages())
            <div class="pagination-section">
                {{ $personnel->links() }}
            </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Aucun personnel trouvé</h3>
                <p>Aucun membre du personnel ne correspond aux critères de recherche.</p>
                <a href="{{ route('admin.personnel.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Créer une fiche
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function toggleFilters() {
    const content = document.getElementById('filtersContent');
    const button = document.querySelector('.filters-header button');
    const icon = button.querySelector('i');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.className = 'fas fa-chevron-up';
    } else {
        content.style.display = 'none';
        icon.className = 'fas fa-chevron-down';
    }
}

// Workflow approbation supprimé

function confirmDeletePersonnel(id, name) {
    if (confirm(`Supprimer la fiche du personnel "${name}" ?`)) {
        const f = document.getElementById(`delete-personnel-${id}`);
        if (f) f.submit();
    }
}
</script>
@endsection

@section('styles')
<style>
.personnel-container {
    padding: 0;
    background: #f8fafc;
    min-height: 100vh;
}

/* Header Section */
.page-header {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.header-text h1 {
    color: white;
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.header-text p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

/* Statistics Section */
.stats-section {
    max-width: 1200px;
    margin: 0 auto 2rem;
    padding: 0 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid rgba(5, 150, 105, 0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.stat-icon.total { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
.stat-icon.validated { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
.stat-icon.pending { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.stat-icon.rejected { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }

.stat-content h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    color: #1f2937;
}

.stat-content p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

/* Filters Section */
.filters-section {
    max-width: 1200px;
    margin: 0 auto 2rem;
    padding: 0 2rem;
}

.filters-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(5, 150, 105, 0.1);
}

.filters-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filters-header h3 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filters-content {
    padding: 1.5rem;
}

.filters-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
}

.form-select, .form-input {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    background: white;
}

.form-select:focus, .form-input:focus {
    outline: none;
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
}

.filters-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

/* Personnel Section */
.personnel-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem 2rem;
}

.personnel-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.personnel-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(5, 150, 105, 0.1);
    transition: all 0.3s ease;
}

.personnel-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.personnel-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.personnel-photo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.personnel-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.personnel-info {
    flex: 1;
}

.personnel-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
}

.personnel-matricule {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0 0 0.25rem 0;
}

.personnel-poste {
    font-size: 0.875rem;
    color: #059669;
    font-weight: 500;
    margin: 0;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-badge.validated {
    background: #d1fae5;
    color: #065f46;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.rejected {
    background: #fee2e2;
    color: #991b1b;
}

.personnel-content {
    padding: 1.5rem;
}

.personnel-details {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.detail-item i {
    width: 16px;
    color: #059669;
}

.personnel-comments {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
}

.personnel-comments h4 {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.personnel-comments p {
    font-size: 0.875rem;
    color: #6b7280;
    line-height: 1.5;
    margin: 0;
}

.personnel-actions {
    padding: 1.5rem;
    border-top: 1px solid #f3f4f6;
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.btn-secondary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.btn-secondary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-outline {
    background: transparent;
    color: #059669;
    border: 2px solid #059669;
}

.btn-outline:hover {
    background: #059669;
    color: white;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
}

.btn-success {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: #9ca3af;
    margin: 0 auto 1.5rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: #6b7280;
    margin: 0 0 2rem 0;
}

/* Pagination */
.pagination-section {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .header-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .personnel-grid {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .filters-actions {
        flex-direction: column;
    }
    
    .personnel-actions {
        flex-direction: column;
    }
    
    .personnel-header {
        flex-direction: column;
        text-align: center;
    }
}
</style>
<style>
.directory-grid { display:grid; grid-template-columns: 260px 1fr; gap:1.5rem; align-items:start; }
.directory-sidebar { position:sticky; top:1rem; }
.sidebar-card { background:#fff; border-radius:16px; border:1px solid #e5e7eb; box-shadow:0 4px 20px rgba(0,0,0,.06); }
.sidebar-header { display:flex; align-items:center; gap:.5rem; padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; font-weight:600; color:#111827; }
.sidebar-header i { color:#059669; }
.sidebar-list { list-style:none; margin:0; padding:.5rem 0; }
.sidebar-item a { display:flex; justify-content:space-between; align-items:center; padding:.625rem 1rem; color:#374151; text-decoration:none; border-left:3px solid transparent; }
.sidebar-item a:hover { background:#f9fafb; }
.sidebar-item.active a { background:#ecfdf5; color:#065f46; border-left-color:#059669; }
.badge { background:#f3f4f6; color:#374151; border-radius:999px; padding:.125rem .5rem; font-size:.75rem; }

@media (max-width: 992px) { .directory-grid { grid-template-columns: 1fr; } .directory-sidebar { position:static; } }
</style>
@endsection 
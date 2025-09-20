@extends('layouts.admin')

@section('title', 'Gestion des Magasins de Stockage - Administration CSAR')

@section('content')
<div class="warehouses-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <div class="header-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="header-text">
                    <h1>Gestion des Magasins de Stockage</h1>
                    <p>Administrer les magasins de stockage du CSAR</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Nouveau magasin
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon active">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $activeCount ?? 0 }}</h3>
                    <p>Magasins actifs</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon inactive">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $inactiveCount ?? 0 }}</h3>
                    <p>Magasins inactifs</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon capacity">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($totalCapacity ?? 0) }}</h3>
                    <p>Capacité totale (tonnes)</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stock">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($totalStock ?? 0) }}</h3>
                    <p>Stock total (tonnes)</p>
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
                            <label for="status">Statut</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="region">Région</label>
                            <select name="region" id="region" class="form-select">
                                <option value="">Toutes les régions</option>
                                @foreach($regions ?? [] as $region)
                                    <option value="{{ $region }}" {{ request('region') === $region ? 'selected' : '' }}>{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="search">Recherche</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Nom, adresse, responsable..." class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="capacity">Capacité minimale</label>
                            <input type="number" name="min_capacity" id="min_capacity" value="{{ request('min_capacity') }}" 
                                   placeholder="Capacité en tonnes" class="form-input">
                        </div>
                    </div>
                    
                    <div class="filters-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline">
                            <i class="fas fa-undo"></i>
                            Réinitialiser
                        </a>
                    </div>
                </form>
        </div>
    </div>
</div>

<!-- Warehouses List -->
    <div class="warehouses-section">
        @if(isset($warehouses) && count($warehouses) > 0)
            <div class="warehouses-grid">
            @foreach($warehouses as $warehouse)
                <div class="warehouse-card">
                    <div class="warehouse-header">
                        <div class="warehouse-info">
                            <h3 class="warehouse-name">{{ $warehouse->name }}</h3>
                            <p class="warehouse-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $warehouse->address }}, {{ $warehouse->city }}, {{ $warehouse->region }}
                            </p>
                            </div>
                        <div class="warehouse-status">
                                @if($warehouse->is_active)
                                <span class="status-badge active">
                                    <i class="fas fa-check"></i>
                                    Actif
                                </span>
                                @else
                                <span class="status-badge inactive">
                                    <i class="fas fa-times"></i>
                                    Inactif
                                </span>
                                @endif
                            </div>
                        </div>
                        
                    <div class="warehouse-content">
                        <div class="warehouse-stats">
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Responsable</span>
                                    <span class="stat-value">{{ $warehouse->manager_name ?? 'Non assigné' }}</span>
                                </div>
                            </div>
                            
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Téléphone</span>
                                    <span class="stat-value">{{ $warehouse->phone ?? 'Non renseigné' }}</span>
                                </div>
                            </div>
                            
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Capacité</span>
                                    <span class="stat-value">{{ number_format($warehouse->capacity) }} tonnes</span>
                                </div>
                            </div>
                            
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Stock actuel</span>
                                    <span class="stat-value">{{ number_format($warehouse->current_stock ?? 0) }} tonnes</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($warehouse->description)
                        <div class="warehouse-description">
                            <h4>Description</h4>
                            <p>{{ Str::limit($warehouse->description, 200) }}</p>
                        </div>
                        @endif
                        
                        <!-- Stock Progress Bar -->
                        <div class="stock-progress">
                            <div class="progress-header">
                                <span>Taux de remplissage</span>
                                <span>{{ $warehouse->capacity > 0 ? number_format(($warehouse->current_stock / $warehouse->capacity) * 100, 1) : 0 }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $warehouse->capacity > 0 ? min(($warehouse->current_stock / $warehouse->capacity) * 100, 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="warehouse-actions">
                        <a href="{{ route('admin.warehouses.show', $warehouse) }}" class="btn btn-sm btn-outline">
                            <i class="fas fa-eye"></i>
                            Voir
                        </a>
                        <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                            Modifier
                        </a>
                        <a href="{{ route('admin.stocks.index', ['warehouse' => $warehouse->id]) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-boxes"></i>
                            Stocks
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="deleteWarehouse('{{ $warehouse->id }}', '{{ $warehouse->name }}')">
                            <i class="fas fa-trash"></i>
                                Supprimer
                            </button>
                        <form id="delete-form-{{ $warehouse->id }}" action="{{ route('admin.warehouses.destroy', $warehouse) }}" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($warehouses->hasPages())
            <div class="pagination-section">
                {{ $warehouses->links() }}
        </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <h3>Aucun magasin trouvé</h3>
                <p>Aucun magasin de stockage ne correspond aux critères de recherche.</p>
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

function deleteWarehouse(warehouseId, warehouseName) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le magasin "${warehouseName}" ?`)) {
        const form = document.getElementById(`delete-form-${warehouseId}`);
        if (form) form.submit();
    }
}
</script>
@endsection

@section('styles')
<style>
.warehouses-container {
    padding: 0;
    background: #f8fafc;
    min-height: 100vh;
}

/* Header Section */
.page-header {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    padding: 2rem 0;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
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
    overflow: hidden;
}

.header-logo {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 12px;
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

.stat-icon.active { 
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
}
.stat-icon.inactive { 
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
}
.stat-icon.capacity { 
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}
.stat-icon.stock { 
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
}

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

/* Warehouses Section */
.warehouses-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem 2rem;
}

.warehouses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.warehouse-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(5, 150, 105, 0.1);
    transition: all 0.3s ease;
}

.warehouse-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.warehouse-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.warehouse-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.warehouse-location {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
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

.status-badge.active {
    background: #d1fae5;
    color: #065f46;
}

.status-badge.inactive {
    background: #fee2e2;
    color: #991b1b;
}

.warehouse-content {
    padding: 1.5rem;
}

.warehouse-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.stat-item .stat-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: #059669;
}

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-label {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 500;
}

.stat-value {
    font-size: 0.875rem;
    color: #1f2937;
    font-weight: 600;
}

.warehouse-description {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.warehouse-description h4 {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.warehouse-description p {
    font-size: 0.875rem;
    color: #6b7280;
    line-height: 1.5;
    margin: 0;
}

.stock-progress {
    margin-bottom: 1rem;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.warehouse-actions {
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
    
    .warehouses-grid {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .filters-actions {
        flex-direction: column;
    }
    
    .warehouse-actions {
        flex-direction: column;
    }
    
    .warehouse-stats {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection 
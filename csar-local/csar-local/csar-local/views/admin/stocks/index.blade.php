@extends('layouts.admin')

@section('title', 'Gestion des Stocks - Administration CSAR')

@section('content')
<div class="stocks-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <div class="header-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="header-text">
                    <h1>Gestion des Stocks</h1>
                    <p>Suivre et gérer les stocks des magasins de stockage</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.stocks.movements') }}" class="btn btn-secondary">
                    <i class="fas fa-history"></i>
                    Historique des reçus
                </a>
                <a href="{{ route('admin.stocks.create', request()->only('warehouse')) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Nouveau stock
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>

    @if(session('receipt_url'))
    <div style="max-width:1200px;margin:0 auto 16px; padding:0 2rem;">
        <div style="background:#ecfdf5;border:1px solid rgba(5,150,105,.25);border-radius:12px;padding:14px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;color:#065f46;">
                <i class="fas fa-receipt"></i>
                <div>
                    <div style="font-weight:700;">Reçu de mouvement prêt</div>
                    <div style="font-size:.875rem;opacity:.9;">Référence: {{ session('receipt_ref') }}</div>
                </div>
            </div>
            <div style="display:flex;gap:8px;">
                <a class="btn btn-outline" href="{{ session('receipt_url') }}" target="_blank" rel="noopener">
                    <i class="fas fa-download"></i>
                    Télécharger le PDF
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['total_stock'] ?? 0, 2) }}</h3>
                    <p>Stock total (toutes unités)</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon low">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['low_stock_items'] ?? 0 }}</h3>
                    <p>Produits en stock faible</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon critical">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['critical_stock_items'] ?? 0 }}</h3>
                    <p>Stock critique</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warehouses">
                    <i class="fas fa-gas-pump"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['fuel_used_month'] ?? 0, 2) }} L</h3>
                    <p>Carburant utilisé (mois en cours)</p>
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
                            <label for="warehouse">Magasin</label>
                            <select name="warehouse" id="warehouse" class="form-select">
                                <option value="">Tous les magasins</option>
                                @foreach($warehouses ?? [] as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ request('warehouse') == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Statut du stock</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="normal" {{ request('status') === 'normal' ? 'selected' : '' }}>Stock normal</option>
                                <option value="low" {{ request('status') === 'low' ? 'selected' : '' }}>Stock faible</option>
                                <option value="critical" {{ request('status') === 'critical' ? 'selected' : '' }}>Stock critique</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="search">Recherche</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Nom du produit..." class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="category">Catégorie</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">Toutes les catégories</option>
                                <option value="cereales" {{ request('category') === 'cereales' ? 'selected' : '' }}>Céréales</option>
                                <option value="legumes" {{ request('category') === 'legumes' ? 'selected' : '' }}>Légumes</option>
                                <option value="fruits" {{ request('category') === 'fruits' ? 'selected' : '' }}>Fruits</option>
                                <option value="autres" {{ request('category') === 'autres' ? 'selected' : '' }}>Autres</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="filters-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline">
                            <i class="fas fa-undo"></i>
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Stocks List -->
    <div class="stocks-section">
        @if(isset($stocks) && count($stocks) > 0)
            <div class="stocks-grid">
                @foreach($stocks as $stock)
                <div class="stock-card">
                    <div class="stock-header">
                        <div class="stock-info">
                            <h3 class="stock-name">{{ $stock->item_name }}</h3>
                            <p class="stock-warehouse">
                                <i class="fas fa-warehouse"></i>
                                {{ $stock->warehouse->name }} • {{ optional($stock->stockType)->display_name }} ({{ optional($stock->stockType)->unit }})
                            </p>
                        </div>
                        <div class="stock-status">
                            @php $isLow = $stock->quantity <= $stock->min_quantity; @endphp
                            <span class="status-badge {{ $isLow ? 'critical' : 'normal' }}">
                                <i class="fas fa-{{ $isLow ? 'exclamation-triangle' : 'check' }}"></i>
                                {{ $isLow ? 'Stock faible' : 'Stock OK' }}
                            </span>
                        </div>
                    </div>
                    <div class="stock-content">
                        <div class="stock-stats">
                            <div class="stat-item">
                                <div class="stat-icon"><i class="fas fa-box"></i></div>
                                <div class="stat-info">
                                    <span class="stat-label">Quantité actuelle</span>
                                    <span class="stat-value">{{ number_format($stock->quantity, 2) }} {{ optional($stock->stockType)->unit }}</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                <div class="stat-info">
                                    <span class="stat-label">Seuil minimum</span>
                                    <span class="stat-value">{{ number_format($stock->min_quantity, 2) }} {{ optional($stock->stockType)->unit }}</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                                <div class="stat-info">
                                    <span class="stat-label">Capacité max</span>
                                    <span class="stat-value">{{ number_format($stock->max_quantity, 2) }} {{ optional($stock->stockType)->unit }}</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon"><i class="fas fa-calendar"></i></div>
                                <div class="stat-info">
                                    <span class="stat-label">Dernière mise à jour</span>
                                    <span class="stat-value">{{ $stock->updated_at?->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="stock-progress">
                            @php 
                                $percent = $stock->max_quantity > 0 ? min(($stock->quantity / $stock->max_quantity) * 100, 100) : 0; 
                                $percentWidth = $percent.'%';
                            @endphp
                            <div class="progress-header">
                                <span>Taux de remplissage</span>
                                <span>{{ number_format($percent, 1) }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill {{ $isLow ? 'critical' : 'normal' }}" data-width="{{ $percent }}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="stock-actions">
                        <form action="{{ route('admin.stocks.add', $stock) }}" method="POST" style="display:inline-flex; gap:6px; align-items:center;">
                            @csrf
                            <input type="number" step="0.01" min="0.01" name="quantity" placeholder="+ Quantité" style="width:130px;">
                            <button class="btn btn-sm btn-success" type="submit"><i class="fas fa-plus"></i> Ajouter</button>
                        </form>
                        <form action="{{ route('admin.stocks.remove', $stock) }}" method="POST" style="display:inline-flex; gap:6px; align-items:center;">
                            @csrf
                            <input type="number" step="0.01" min="0.01" name="quantity" placeholder="- Quantité" style="width:130px;">
                            <button class="btn btn-sm btn-warning" type="submit"><i class="fas fa-minus"></i> Retirer</button>
                        </form>
                        <a href="{{ route('admin.stocks.edit', $stock) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Modifier</a>
                    </div>
                </div>
                @endforeach
            </div>
            @if($stocks->hasPages())
            <div class="pagination-section">{{ $stocks->links() }}</div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <h3>Aucun stock trouvé</h3>
                <p>Aucun stock ne correspond aux critères de recherche.</p>
                <a href="{{ route('admin.stocks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Créer un stock
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function toggleFilters(){
    const content=document.getElementById('filtersContent');
    const icon=document.querySelector('.filters-header button i');
    const isHidden=getComputedStyle(content).display==='none';
    content.style.display=isHidden?'block':'none';
    icon.className=isHidden?'fas fa-chevron-up':'fas fa-chevron-down';
}
</script>
@endsection

@section('styles')
<style>
.stocks-container {
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
.stat-icon.low { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.stat-icon.critical { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
.stat-icon.warehouses { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
.stat-icon.fuel-used { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }

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

/* Stocks Section */
.stocks-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem 2rem;
}

.stocks-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.stock-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(5, 150, 105, 0.1);
    transition: all 0.3s ease;
}

.stock-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stock-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.stock-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.stock-warehouse {
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

.status-badge.normal {
    background: #d1fae5;
    color: #065f46;
}

.status-badge.critical {
    background: #fee2e2;
    color: #991b1b;
}

.stock-content {
    padding: 1.5rem;
}

.stock-stats {
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

.stock-description {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.stock-description h4 {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.stock-description p {
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
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-fill.normal {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
}

.progress-fill.critical {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
}

.stock-actions {
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

.btn-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
    
    .stocks-grid {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .filters-actions {
        flex-direction: column;
    }
    
    .stock-actions {
        flex-direction: column;
    }
    
    .stock-stats {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection 

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.progress-fill').forEach(function(el){
        var p = el.getAttribute('data-width');
        if (p) { el.style.width = p + '%'; }
    });
});
</script>
@endpush
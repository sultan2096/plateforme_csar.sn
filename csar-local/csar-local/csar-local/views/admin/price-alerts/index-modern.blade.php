@extends('layouts.admin')

@section('title', 'Alertes de Prix - Administration')

@section('content')
<style>
/* Variables CSS avec couleurs vives pour les alertes de prix */
:root {
    --primary-red: #dc2626;
    --primary-red-dark: #991b1b;
    --warning-orange: #f59e0b;
    --warning-orange-dark: #d97706;
    --success-green: #10b981;
    --success-green-dark: #059669;
    --info-blue: #3b82f6;
    --info-blue-dark: #1d4ed8;
    --gray-light: #f3f4f6;
    --gray-medium: #e5e7eb;
    --gray-dark: #374151;
    --text-dark: #111827;
    --text-light: #6b7280;
    --shadow-light: 0 4px 20px rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 8px 30px rgba(0, 0, 0, 0.15);
    --border-radius: 16px;
    --transition: all 0.3s ease;
}

/* Container principal */
.alerts-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Header avec dégradé rouge pour les alertes */
.alerts-header {
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: 0 15px 40px rgba(220, 38, 38, 0.3);
    position: relative;
    overflow: hidden;
}

.alerts-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="alert-pattern" width="25" height="25" patternUnits="userSpaceOnUse"><circle cx="12.5" cy="12.5" r="2" fill="white" opacity="0.15"/><circle cx="6" cy="18" r="1" fill="white" opacity="0.08"/><circle cx="18" cy="6" r="1" fill="white" opacity="0.08"/></pattern></defs><rect width="100" height="100" fill="url(%23alert-pattern)"/></svg>');
    opacity: 0.4;
    pointer-events: none;
}

.alerts-header > * {
    position: relative;
    z-index: 2;
}

.alerts-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alerts-header .title-accent {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.alerts-header p {
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
    color: var(--primary-red-dark);
    border-color: rgba(255, 255, 255, 0.9);
}

.btn-header.primary:hover {
    background: #fff;
    color: var(--primary-red-dark);
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
    border: 2px solid var(--gray-medium);
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
    background: linear-gradient(135deg, var(--info-blue) 0%, var(--info-blue-dark) 100%);
}

.stat-card.critical::before {
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
}

.stat-card.high::before {
    background: linear-gradient(135deg, var(--warning-orange) 0%, var(--warning-orange-dark) 100%);
}

.stat-card.active::before {
    background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-medium);
    border-color: var(--primary-red);
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
    background: linear-gradient(135deg, var(--info-blue) 0%, var(--info-blue-dark) 100%);
}

.stat-icon.critical {
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
}

.stat-icon.high {
    background: linear-gradient(135deg, var(--warning-orange) 0%, var(--warning-orange-dark) 100%);
}

.stat-icon.active {
    background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
}

/* Table modernisée */
.alerts-table {
    background: #fff;
    border: 2px solid var(--gray-medium);
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
    background: linear-gradient(135deg, var(--gray-light) 0%, #f1f5f9 100%);
    border: none;
    color: var(--text-dark);
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 20px 16px;
}

.table tbody tr {
    border-bottom: 1px solid var(--gray-medium);
    transition: var(--transition);
}

.table tbody tr:hover {
    background: linear-gradient(135deg, #fafbff 0%, #fef2f2 100%);
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

.badge-critical {
    background: #fef2f2;
    color: #991b1b;
    border-color: #fca5a5;
}

.badge-high {
    background: #fffbeb;
    color: #92400e;
    border-color: #fde68a;
}

.badge-medium {
    background: #eff6ff;
    color: #1e40af;
    border-color: #93c5fd;
}

.badge-low {
    background: #f3f4f6;
    color: #374151;
    border-color: #d1d5db;
}

.badge-active {
    background: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.badge-inactive {
    background: #f3f4f6;
    color: #6b7280;
    border-color: #d1d5db;
}

/* Product info styling */
.product-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.product-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
    background: linear-gradient(135deg, var(--warning-orange) 0%, var(--warning-orange-dark) 100%);
}

.product-details h6 {
    margin: 0;
    font-weight: 700;
    color: var(--text-dark);
}

.product-details small {
    color: var(--text-light);
    font-size: 0.85rem;
}

/* Price change styling */
.price-change {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}

.price-percentage {
    font-size: 1.1rem;
    font-weight: 800;
}

.price-percentage.positive {
    color: var(--primary-red);
}

.price-percentage.negative {
    color: var(--success-green);
}

/* Actions table */
.table-actions {
    display: flex;
    gap: 8px;
    align-items: center;
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
    border-color: var(--info-blue);
    color: var(--info-blue-dark);
    background: #eff6ff;
}

.btn-action.view:hover {
    background: var(--info-blue);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
    border-color: var(--primary-red);
    color: var(--primary-red-dark);
    background: #fef2f2;
}

.btn-action.delete:hover {
    background: var(--primary-red);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
    border: 2px solid var(--gray-medium);
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
    .alerts-container {
        padding: 1rem;
    }
    
    .alerts-header {
        padding: 2rem 1.5rem;
    }
    
    .alerts-header h1 {
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

@keyframes pulseAlert {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(220, 38, 38, 0);
    }
}

.badge-critical {
    animation: pulseAlert 2s infinite;
}
</style>

<div class="alerts-container">
    <!-- Header modernisé -->
    <div class="alerts-header fade-in">
        <h1>
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1Z" fill="currentColor" opacity="0.8"/>
                <path d="M12 7V13M12 17H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="title-accent">Alertes de Prix</span>
        </h1>
        <p>Surveillance et gestion des hausses de prix inhabituelles des produits alimentaires</p>
        <div class="header-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-header">
                <i class="fas fa-arrow-left"></i>
                Retour au tableau de bord
            </a>
            <a href="{{ route('admin.price-alerts.create') }}" class="btn-header primary">
                <i class="fas fa-plus"></i>
                Nouvelle Alerte
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
                <h3>Total Alertes</h3>
                <div class="value">{{ $alerts->total() ?? $alerts->count() }}</div>
            </div>
            <div class="stat-icon total">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
        
        <div class="stat-card critical">
            <div class="stat-content">
                <h3>Critiques</h3>
                <div class="value">{{ $alerts->where('alert_level', 'critical')->count() }}</div>
            </div>
            <div class="stat-icon critical">
                <i class="fas fa-fire"></i>
            </div>
        </div>
        
        <div class="stat-card high">
            <div class="stat-content">
                <h3>Élevées</h3>
                <div class="value">{{ $alerts->where('alert_level', 'high')->count() }}</div>
            </div>
            <div class="stat-icon high">
                <i class="fas fa-exclamation"></i>
            </div>
        </div>
        
        <div class="stat-card active">
            <div class="stat-content">
                <h3>Actives</h3>
                <div class="value">{{ $stats['active'] ?? 0 }}</div>
            </div>
            <div class="stat-icon active">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <!-- Table modernisée -->
    <div class="alerts-table fade-in">
        @if($alerts->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-shopping-basket me-2"></i>Produit</th>
                            <th><i class="fas fa-map-marker-alt me-2"></i>Marché / Région</th>
                            <th><i class="fas fa-chart-line me-2"></i>Variation</th>
                            <th><i class="fas fa-thermometer-half me-2"></i>Niveau</th>
                            <th><i class="fas fa-toggle-on me-2"></i>Statut</th>
                            <th><i class="fas fa-cog me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alerts as $alert)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <div class="product-icon">
                                        <i class="fas fa-seedling"></i>
                                    </div>
                                    <div class="product-details">
                                        <h6>{{ $alert->product_name }}</h6>
                                        @if($alert->market_name)
                                            <small>{{ $alert->market_name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--text-dark);">
                                    {{ $alert->market_name ?? 'Non spécifié' }}
                                </div>
                                @if($alert->region)
                                    <div style="color: var(--text-light); font-size: 0.85rem;">
                                        <i class="fas fa-map-pin me-1"></i>{{ $alert->region }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="price-change">
                                    <div class="price-percentage positive">
                                        +{{ number_format($alert->increase_percentage ?? 0, 1, ',', ' ') }}%
                                    </div>
                                    @if(isset($alert->current_price) && isset($alert->previous_price))
                                        <small style="color: var(--text-light);">
                                            {{ number_format($alert->previous_price, 0, ',', ' ') }} → 
                                            {{ number_format($alert->current_price, 0, ',', ' ') }} FCFA
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @switch($alert->alert_level)
                                    @case('critical')
                                        <span class="badge-modern badge-critical">
                                            <i class="fas fa-fire"></i>
                                            Critique
                                        </span>
                                        @break
                                    @case('high')
                                        <span class="badge-modern badge-high">
                                            <i class="fas fa-exclamation"></i>
                                            Élevé
                                        </span>
                                        @break
                                    @case('medium')
                                        <span class="badge-modern badge-medium">
                                            <i class="fas fa-info-circle"></i>
                                            Moyen
                                        </span>
                                        @break
                                    @case('low')
                                        <span class="badge-modern badge-low">
                                            <i class="fas fa-minus-circle"></i>
                                            Faible
                                        </span>
                                        @break
                                    @default
                                        <span class="badge-modern badge-low">Non défini</span>
                                @endswitch
                            </td>
                            <td>
                                @php
                                    $status = $alert->status ?? ($alert->is_active ? 'active' : 'inactive');
                                    $isActive = $status === 'active' || ($alert->is_active ?? false);
                                @endphp
                                @if($isActive)
                                    <span class="badge-modern badge-active">
                                        <i class="fas fa-check-circle"></i>
                                        Active
                                    </span>
                                @else
                                    <span class="badge-modern badge-inactive">
                                        <i class="fas fa-pause-circle"></i>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.price-alerts.show', $alert) }}" 
                                       class="btn-action view" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.price-alerts.edit', $alert) }}" 
                                       class="btn-action edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.price-alerts.destroy', $alert) }}" 
                                          style="display: inline;" onsubmit="return confirm('Supprimer cette alerte définitivement ?')">
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
            
            @if(method_exists($alerts, 'hasPages') && $alerts->hasPages())
                <div class="d-flex justify-content-between align-items-center p-3" style="background: var(--gray-light); border-top: 1px solid var(--gray-medium);">
                    <div style="color: var(--text-light); font-weight: 600;">
                        <i class="fas fa-info-circle me-1"></i>
                        Page {{ $alerts->currentPage() }} sur {{ $alerts->lastPage() }} 
                        ({{ $alerts->total() }} alertes au total)
                    </div>
                    <div>
                        {{ $alerts->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <h3>Aucune alerte enregistrée</h3>
                <p>Commencez par créer votre première alerte de prix pour surveiller les hausses inhabituelles.</p>
                <div class="mt-3">
                    <a href="{{ route('admin.price-alerts.create') }}" class="btn-header primary" 
                       style="background: var(--primary-red); border-color: var(--primary-red);">
                        <i class="fas fa-plus me-2"></i>
                        Créer une Alerte
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
document.querySelectorAll('.stat-card, .alerts-table tbody tr').forEach(el => {
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

// Confirmation améliorée pour les suppressions
document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productName = this.closest('tr').querySelector('.product-details h6').textContent.trim();
        const confirmed = confirm(`Êtes-vous sûr de vouloir supprimer l'alerte pour "${productName}" ?\n\nCette action est irréversible.`);
        
        if (confirmed) {
            this.submit();
        }
    });
});

// Highlight des alertes critiques avec effet pulsant
setInterval(() => {
    document.querySelectorAll('.badge-critical').forEach(badge => {
        badge.style.transform = 'scale(1.05)';
        setTimeout(() => {
            badge.style.transform = 'scale(1)';
        }, 150);
    });
}, 3000);
</script>
@endpush
@endsection

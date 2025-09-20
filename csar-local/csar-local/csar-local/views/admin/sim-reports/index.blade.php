@extends('layouts.admin')

@section('title', 'Rapports SIM - Administration')

@section('content')
<style>
/* Variables CSS avec couleurs vives et contrastées */
:root {
    --primary-blue: #3b82f6;
    --primary-blue-dark: #1d4ed8;
    --success-green: #10b981;
    --success-green-dark: #059669;
    --warning-orange: #f59e0b;
    --warning-orange-dark: #d97706;
    --danger-red: #ef4444;
    --danger-red-dark: #dc2626;
    --info-cyan: #06b6d4;
    --info-cyan-dark: #0891b2;
    --purple: #8b5cf6;
    --purple-dark: #7c3aed;
    --indigo: #6366f1;
    --indigo-dark: #4f46e5;
    --light-bg: #f8fafc;
    --medium-gray: #e5e7eb;
    --dark-gray: #374151;
    --text-dark: #111827;
    --text-light: #6b7280;
    --shadow-light: 0 4px 20px rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 8px 30px rgba(0, 0, 0, 0.15);
    --border-radius: 16px;
    --transition: all 0.3s ease;
}

/* Container principal avec design moderne */
.sim-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Header avec couleurs vives et visibles */
.sim-header {
    background: linear-gradient(135deg, var(--indigo) 0%, var(--purple) 100%);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: 0 15px 40px rgba(99, 102, 241, 0.3);
    position: relative;
    overflow: hidden;
}

.sim-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="sim-pattern" width="25" height="25" patternUnits="userSpaceOnUse"><circle cx="12.5" cy="12.5" r="2" fill="white" opacity="0.15"/><circle cx="6" cy="18" r="1" fill="white" opacity="0.08"/><circle cx="18" cy="6" r="1" fill="white" opacity="0.08"/></pattern></defs><rect width="100" height="100" fill="url(%23sim-pattern)"/></svg>');
    opacity: 0.4;
    pointer-events: none;
}

.sim-header > * {
    position: relative;
    z-index: 2;
}

.sim-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.sim-header .title-accent {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.sim-header p {
    font-size: 1.1rem;
    opacity: 0.95;
    margin-bottom: 1.5rem;
    color: #f3f4f6;
}

.sim-actions {
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
    color: var(--indigo-dark);
    border-color: rgba(255, 255, 255, 0.9);
}

.btn-header.primary:hover {
    background: #fff;
    color: var(--indigo-dark);
}

/* Statistiques avec couleurs vives */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 2rem;
}

.stat-card {
    background: #fff;
    border: 2px solid var(--medium-gray);
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
    background: linear-gradient(135deg, var(--indigo) 0%, var(--purple) 100%);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-medium);
    border-color: var(--indigo);
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
    background: linear-gradient(135deg, var(--indigo) 0%, var(--purple) 100%);
}

/* Table modernisée avec couleurs contrastées */
.reports-table {
    background: #fff;
    border: 2px solid var(--medium-gray);
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
    background: linear-gradient(135deg, var(--light-bg) 0%, #f1f5f9 100%);
    border: none;
    color: var(--text-dark);
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 20px 16px;
}

.table tbody tr {
    border-bottom: 1px solid var(--medium-gray);
    transition: var(--transition);
}

.table tbody tr:hover {
    background: linear-gradient(135deg, #fafbff 0%, #f0f4ff 100%);
}

.table tbody td {
    padding: 16px;
    vertical-align: middle;
    color: var(--text-dark);
    font-weight: 500;
    border: none;
}

/* Badges avec couleurs très visibles */
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

.badge-published {
    background: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.badge-draft {
    background: #fef3c7;
    color: #92400e;
    border-color: #fde68a;
}

.badge-review {
    background: #dbeafe;
    color: #1e40af;
    border-color: #93c5fd;
}

/* Boutons d'action modernisés */
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
    border-color: var(--info-cyan);
    color: var(--info-cyan-dark);
    background: #ecfeff;
}

.btn-action.view:hover {
    background: var(--info-cyan);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
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
    border-color: var(--danger-red);
    color: var(--danger-red-dark);
    background: #fef2f2;
}

.btn-action.delete:hover {
    background: var(--danger-red);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* État vide modernisé */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
    border: 2px solid var(--medium-gray);
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
    .sim-container {
        padding: 1rem;
    }
    
    .sim-header {
        padding: 2rem 1.5rem;
    }
    
    .sim-header h1 {
        font-size: 2rem;
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
    }
    
    .sim-actions {
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

/* Pagination modernisée */
.pagination {
    justify-content: center;
    margin-top: 2rem;
}

.page-link {
    border-radius: 12px;
    margin: 0 4px;
    border: 2px solid var(--medium-gray);
    color: var(--text-light);
    font-weight: 600;
    padding: 10px 16px;
}

.page-link:hover {
    background: var(--light-bg);
    border-color: var(--indigo);
    color: var(--indigo);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, var(--indigo) 0%, var(--purple) 100%);
    border-color: var(--indigo);
    color: white;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}
</style>

<div class="sim-container">
    <!-- Header modernisé -->
    <div class="sim-header fade-in">
        <h1>
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="2" y="3" width="20" height="14" rx="2" fill="currentColor" opacity="0.8"/>
                <path d="M8 7h8M8 10h6M8 13h4" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="title-accent">Rapports SIM</span>
        </h1>
        <p>Suivi et gestion des rapports du Système d'Information des Marchés</p>
        <div class="sim-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-header">
                <i class="fas fa-arrow-left"></i>
                Retour au tableau de bord
            </a>
            <a href="{{ route('admin.sim-reports.create') }}" class="btn-header primary">
                <i class="fas fa-plus"></i>
            Nouveau Rapport
        </a>
        </div>
    </div>

    <!-- Statistiques avec couleurs vives -->
    <div class="stats-container fade-in">
        <div class="stat-card">
            <div class="stat-content">
                <h3>Total Rapports</h3>
                <div class="value">{{ $reports->total() ?? 0 }}</div>
                            </div>
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <h3>Publiés</h3>
                <div class="value">{{ $reports->where('is_published', true)->count() }}</div>
                            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <h3>Brouillons</h3>
                <div class="value">{{ $reports->where('is_published', false)->count() }}</div>
                            </div>
            <div class="stat-icon">
                <i class="fas fa-edit"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <h3>Ce mois</h3>
                <div class="value">{{ $reports->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                            </div>
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success fade-in">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Table modernisée -->
    <div class="reports-table fade-in">
            <div class="table-responsive">
            <table class="table">
                    <thead>
                        <tr>
                        <th><i class="fas fa-file-alt me-2"></i>Titre du Rapport</th>
                        <th><i class="fas fa-calendar me-2"></i>Date</th>
                        <th><i class="fas fa-tag me-2"></i>Période</th>
                        <th><i class="fas fa-eye me-2"></i>Statut</th>
                        <th><i class="fas fa-cog me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>
                            <div style="font-weight: 700; color: var(--text-dark); font-size: 1rem;">
                                {{ $report->title }}
                            </div>
                                @if($report->summary)
                                <div style="color: var(--text-light); font-size: 0.85rem; margin-top: 4px;">
                                    {{ Str::limit($report->summary, 60) }}
                                </div>
                                @endif
                            </td>
                        <td style="font-weight: 600;">
                            {{ optional($report->report_date)->format('d/m/Y') ?? 'Non définie' }}
                        </td>
                        <td style="font-weight: 600;">
                            <span style="background: #f0f4ff; color: var(--indigo); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                {{ $report->period ?? 'Non spécifiée' }}
                            </span>
                            </td>
                            <td>
                            @if($report->is_published ?? false)
                                <span class="badge-modern badge-published">
                                    <i class="fas fa-check-circle"></i>
                                    Publié
                                    </span>
                                @else
                                <span class="badge-modern badge-draft">
                                    <i class="fas fa-edit"></i>
                                    Brouillon
                                    </span>
                                @endif
                            </td>
                            <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.sim-reports.show', $report) }}" class="btn-action view" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                <a href="{{ route('admin.sim-reports.edit', $report) }}" class="btn-action edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <form method="POST" action="{{ route('admin.sim-reports.destroy', $report) }}" style="display: inline;" onsubmit="return confirm('Supprimer ce rapport définitivement ?')">
                                        @csrf
                                        @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-file-alt"></i></div>
                                <h3>Aucun rapport SIM</h3>
                                <p>Commencez par créer votre premier rapport d'analyse des marchés.</p>
                                <div class="mt-3">
                                    <a href="{{ route('admin.sim-reports.create') }}" class="btn-header primary" style="background: var(--indigo); border-color: var(--indigo);">
                                        <i class="fas fa-plus me-2"></i>
                    Créer un Rapport
                </a>
            </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
        @if($reports->hasPages())
            <div class="d-flex justify-content-between align-items-center p-3" style="background: var(--light-bg); border-top: 1px solid var(--medium-gray);">
                <div style="color: var(--text-light); font-weight: 600;">
                    <i class="fas fa-info-circle me-1"></i>
                    Page {{ $reports->currentPage() }} sur {{ $reports->lastPage() }} 
                    ({{ $reports->total() }} rapports au total)
                </div>
                <div>
                {{ $reports->links() }}
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
document.querySelectorAll('.stat-card, .reports-table tbody tr').forEach(el => {
    observer.observe(el);
});

// Amélioration des tooltips
document.querySelectorAll('[title]').forEach(el => {
    el.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
    });
    
    el.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
});
</script>
@endpush
@endsection 

 
 
 
 
 
 
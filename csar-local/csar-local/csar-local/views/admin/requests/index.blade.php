@extends('layouts.admin')

@section('title', 'Gestion des Demandes - Administration CSAR')

@section('content')
<div class="requests-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <div class="header-icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div class="header-text">
                    <h1>Gestion des Demandes</h1>
                    <p>Traiter les demandes d'aide des citoyens</p>
                </div>
            </div>
            <div class="header-actions">
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
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $pendingCount ?? 0 }}</h3>
                    <p>En attente</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon approved">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $approvedCount ?? 0 }}</h3>
                    <p>Approuvées</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon rejected">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $rejectedCount ?? 0 }}</h3>
                    <p>Rejetées</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalCount ?? 0 }}</h3>
                    <p>Total</p>
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
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvée</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejetée</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">Tous les types</option>
                                <option value="aide" {{ request('type') === 'aide' ? 'selected' : '' }}>Aide</option>
                                <option value="audience" {{ request('type') === 'audience' ? 'selected' : '' }}>Audience</option>
                                <option value="partenariat" {{ request('type') === 'partenariat' ? 'selected' : '' }}>Partenariat</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="region">Région</label>
                            <input type="text" name="region" id="region" value="{{ request('region') }}" 
                                   placeholder="Rechercher par région" class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="search">Recherche</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Nom, email, téléphone..." class="form-input">
                        </div>
                    </div>
                    
                    <div class="filters-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.requests.index') }}" class="btn btn-outline">
                            <i class="fas fa-undo"></i>
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Requests List -->
    <div class="requests-section">
        @if(isset($requests) && count($requests) > 0)
            <div class="requests-grid">
                @foreach($requests as $request)
                <div class="request-card">
                    <div class="request-header">
                        <div class="request-info">
                            <h3 class="request-name">{{ $request->full_name }}</h3>
                            <p class="request-code">Code: <strong>{{ $request->tracking_code }}</strong></p>
                            <p class="request-meta">{{ $request->type }} • {{ $request->region }}</p>
                        </div>
                        <div class="request-status">
                            @if($request->status === 'pending')
                                <span class="status-badge pending">
                                    <i class="fas fa-clock"></i>
                                    En attente
                                </span>
                            @elseif($request->status === 'approved')
                                <span class="status-badge approved">
                                    <i class="fas fa-check"></i>
                                    Approuvée
                                </span>
                            @else
                                <span class="status-badge rejected">
                                    <i class="fas fa-times"></i>
                                    Rejetée
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="request-content">
                        <div class="request-description">
                            <h4>Description</h4>
                            <p>{{ Str::limit($request->description, 150) }}</p>
                        </div>
                        
                        <div class="request-details">
                            <div class="detail-item">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $request->email }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-phone"></i>
                                <span>{{ $request->phone }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $request->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="request-actions">
                        <a href="{{ route('admin.requests.show', $request) }}" class="btn btn-sm btn-outline">
                            <i class="fas fa-eye"></i>
                            Voir
                        </a>
                        <a href="{{ route('admin.requests.edit', $request) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                            Modifier
                        </a>
                        @if($request->status === 'pending')
                            <button class="btn btn-sm btn-success" onclick="updateStatus('{{ $request->id }}', 'approved')">
                                <i class="fas fa-check"></i>
                                Approuver
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="updateStatus('{{ $request->id }}', 'rejected')">
                                <i class="fas fa-times"></i>
                                Rejeter
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($requests->hasPages())
            <div class="pagination-section">
                {{ $requests->links() }}
            </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3>Aucune demande trouvée</h3>
                <p>Aucune demande ne correspond aux critères de recherche.</p>
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

function updateStatus(requestId, status) {
    if (confirm('Êtes-vous sûr de vouloir ' + (status === 'approved' ? 'approuver' : 'rejeter') + ' cette demande ?')) {
        fetch(`/admin/requests/${requestId}/update-status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors de la mise à jour du statut');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la mise à jour du statut');
        });
    }
}
</script>
@endsection

@section('styles')
<style>
.requests-container {
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

.stat-icon.pending { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.stat-icon.approved { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
.stat-icon.rejected { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
.stat-icon.total { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }

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

/* Requests Section */
.requests-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem 2rem;
}

.requests-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.request-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(5, 150, 105, 0.1);
    transition: all 0.3s ease;
}

.request-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.request-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.request-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.request-code {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0 0 0.25rem 0;
}

.request-meta {
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

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.approved {
    background: #d1fae5;
    color: #065f46;
}

.status-badge.rejected {
    background: #fee2e2;
    color: #991b1b;
}

.request-content {
    padding: 1.5rem;
}

.request-description h4 {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.request-description p {
    font-size: 0.875rem;
    color: #6b7280;
    line-height: 1.5;
    margin: 0 0 1rem 0;
}

.request-details {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
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

.request-actions {
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
    
    .requests-grid {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .filters-actions {
        flex-direction: column;
    }
    
    .request-actions {
        flex-direction: column;
    }
}
</style>
@endsection 
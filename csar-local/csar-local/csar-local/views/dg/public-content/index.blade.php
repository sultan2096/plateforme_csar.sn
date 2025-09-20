@extends('layouts.dg')

@section('title', 'Gestion des Contenus Publics - CSAR DG')

@section('content')
<div class="dg-container">
    <!-- Header -->
    <div class="dg-header">
        <h1>Gestion des Contenus Publics</h1>
        <p>Consultez et gérez tous les contenus publics du CSAR</p>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-label">Total contenus</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-info-circle"></i></div>
            <div class="stat-value">{{ $stats['about'] ?? 0 }}</div>
            <div class="stat-label">Pages À propos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-building"></i></div>
            <div class="stat-value">{{ $stats['institution'] ?? 0 }}</div>
            <div class="stat-label">Pages Institution</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-newspaper"></i></div>
            <div class="stat-value">{{ $stats['news'] ?? 0 }}</div>
            <div class="stat-label">Articles d'actualité</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-microphone"></i></div>
            <div class="stat-value">{{ $stats['speeches'] ?? 0 }}</div>
            <div class="stat-label">Discours officiels</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-images"></i></div>
            <div class="stat-value">{{ $stats['gallery'] ?? 0 }}</div>
            <div class="stat-label">Images galerie</div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <h3 style="color: #1e40af; margin-bottom: 1.5rem; font-size: 1.25rem;">🔍 Filtres de recherche</h3>
        <form method="GET" action="{{ route('dg.public-content.index') }}" class="filters-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="type">Type de contenu</label>
                    <select name="type" id="type" class="filter-select">
                        <option value="">Tous les types</option>
                        <option value="about" {{ request('type') === 'about' ? 'selected' : '' }}>À propos</option>
                        <option value="institution" {{ request('type') === 'institution' ? 'selected' : '' }}>Institution</option>
                        <option value="news" {{ request('type') === 'news' ? 'selected' : '' }}>Actualités</option>
                        <option value="speeches" {{ request('type') === 'speeches' ? 'selected' : '' }}>Discours</option>
                        <option value="gallery" {{ request('type') === 'gallery' ? 'selected' : '' }}>Galerie</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="search">Recherche</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="filter-input" placeholder="Rechercher...">
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filtrer
                </button>
                <a href="{{ route('dg.public-content.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Réinitialiser
                </a>
                <button type="button" class="btn btn-success" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-plus"></i>
                    Nouveau contenu
                </button>
            </div>
        </form>
    </div>

    <!-- Navigation rapide -->
    <div class="quick-nav-section">
        <h3 style="color: #1e40af; margin-bottom: 1rem; font-size: 1.25rem;">🚀 Navigation rapide</h3>
        <div class="quick-nav-grid">
            <a href="#" class="quick-nav-item">
                <i class="fas fa-newspaper"></i>
                <span>Actualités</span>
            </a>
            <a href="#" class="quick-nav-item">
                <i class="fas fa-microphone"></i>
                <span>Discours officiels</span>
            </a>
            <a href="#" class="quick-nav-item">
                <i class="fas fa-images"></i>
                <span>Galerie d'images</span>
            </a>
            <a href="#" class="quick-nav-item">
                <i class="fas fa-file-pdf"></i>
                <span>Rapports & Documents</span>
            </a>
        </div>
    </div>

    <!-- Liste des contenus -->
    <div class="content-section">
        <div class="content-header">
            <h2>Liste des contenus publics</h2>
            <span class="content-count">{{ $contents->total() }} contenu(s)</span>
        </div>

        @if($contents->count() > 0)
            <div class="content-table">
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Date de création</th>
                            <th>Dernière modification</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contents as $content)
                            <tr>
                                <td>
                                    <div class="content-title">{{ $content->title ?? 'Sans titre' }}</div>
                                    <div class="content-subtitle">{{ Str::limit($content->description ?? '', 50) }}</div>
                                </td>
                                <td>
                                    <span class="content-type-badge">{{ ucfirst($content->type ?? 'Contenu') }}</span>
                                </td>
                                <td>
                                    <div class="content-date">{{ $content->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td>
                                    <div class="content-date">{{ $content->updated_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td>
                                    @if($content->is_active)
                                        <span class="badge badge-active">Actif</span>
                                    @else
                                        <span class="badge badge-inactive">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('dg.public-content.show', $content->id) }}" class="btn btn-info btn-sm" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-primary btn-sm" disabled title="Fonctionnalité en développement">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" disabled title="Fonctionnalité en développement">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Affichage de {{ $contents->firstItem() ?? 0 }} à {{ $contents->lastItem() ?? 0 }} 
                    sur {{ $contents->total() }} résultats
                </div>
                {{ $contents->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <h3>Aucun contenu trouvé</h3>
                <p>Aucun contenu ne correspond aux critères de recherche.</p>
            </div>
        @endif
    </div>
</div>

<style>
.dg-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

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
    gap: 1.5rem;
}

.filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
    font-size: 0.875rem;
}

.filter-select, .filter-input {
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: border-color 0.3s;
    background: white;
}

.filter-select:focus, .filter-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.filter-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
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
    background: #3b82f6;
    color: white;
}

.btn-primary:hover:not(:disabled) {
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

.btn-success:hover:not(:disabled) {
    background: #059669;
}

.btn:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    opacity: 0.6;
}

.quick-nav-section {
    background: white;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(30,41,59,0.08);
    border: 1px solid #f1f5f9;
}

.quick-nav-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.quick-nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1.5rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    text-decoration: none;
    color: #374151;
    transition: all 0.3s;
}

.quick-nav-item:hover {
    background: #f1f5f9;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.quick-nav-item i {
    font-size: 1.5rem;
    color: #3b82f6;
}

.quick-nav-item span {
    font-weight: 600;
    text-align: center;
}

.content-section {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(30,41,59,0.08);
    border: 1px solid #f1f5f9;
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.content-header h2 {
    color: #1e40af;
    margin: 0;
    font-size: 1.5rem;
}

.content-count {
    color: #6b7280;
    font-weight: 600;
    font-size: 0.875rem;
}

.content-table {
    overflow-x: auto;
}

.content-table table {
    width: 100%;
    border-collapse: collapse;
}

.content-table th, .content-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.content-table th {
    background: #f9fafb;
    font-weight: 600;
    color: #374151;
}

.content-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.content-subtitle {
    color: #6b7280;
    font-size: 0.875rem;
}

.content-type-badge {
    background: #dbeafe;
    color: #1e40af;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.content-date {
    color: #6b7280;
    font-size: 0.875rem;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-active {
    background: #d1fae5;
    color: #065f46;
}

.badge-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
}

.btn-info {
    background: #06b6d4;
    color: white;
}

.btn-info:hover {
    background: #0891b2;
}

.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 1rem;
}

.pagination-info {
    color: #6b7280;
    font-size: 0.875rem;
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
    
    .content-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .quick-nav-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
        flex-direction: column;
        gap: 20px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

    .btn-sm {
        padding: 8px 12px;
        font-size: 0.75rem;
    }

    .content-section {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(30,41,59,0.08);
        border: 1px solid #f1f5f9;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .content-header h2 {
        color: #1e40af;
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .content-count {
        color: #64748b;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .content-table {
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .content-table table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .content-table th,
    .content-table td {
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
    }

    .content-table th {
        background: #f8fafc;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .content-table tr:hover {
        background: #f8fafc;
    }

    .content-title {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .content-type {
        font-size: 0.75rem;
        color: #64748b;
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
    }

    .content-date {
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

    .badge-draft {
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

    .quick-nav {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .quick-nav-btn {
        padding: 8px 16px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        color: #374151;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .quick-nav-btn:hover {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
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
        
        .content-header {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
        }
        
        .actions {
            flex-direction: column;
        }
        
        .quick-nav {
            flex-direction: column;
        }
    }
    </style>

    <div class="stats-grid animate__animated animate__fadeInUp animate__delay-1s">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
            <div class="stat-value">{{ $stats['total_contents'] ?? 0 }}</div>
            <div class="stat-label">Total contenus</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-info-circle"></i></div>
            <div class="stat-value">{{ $stats['about_pages'] ?? 0 }}</div>
            <div class="stat-label">Pages À propos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-building"></i></div>
            <div class="stat-value">{{ $stats['institution_pages'] ?? 0 }}</div>
            <div class="stat-label">Pages Institution</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-newspaper"></i></div>
            <div class="stat-value">{{ $stats['news_articles'] ?? 0 }}</div>
            <div class="stat-label">Articles d'actualité</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-microphone"></i></div>
            <div class="stat-value">{{ $stats['speeches'] ?? 0 }}</div>
            <div class="stat-label">Discours officiels</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-images"></i></div>
            <div class="stat-value">{{ $stats['gallery_images'] ?? 0 }}</div>
            <div class="stat-label">Images galerie</div>
        </div>
    </div>

    <!-- Navigation rapide -->
    <div class="quick-nav">
        <a href="#" class="quick-nav-btn">
            <i class="fas fa-newspaper"></i>
            Actualités
        </a>
        <a href="#" class="quick-nav-btn">
            <i class="fas fa-microphone"></i>
            Discours officiels
        </a>
        <a href="#" class="quick-nav-btn">
            <i class="fas fa-images"></i>
            Galerie d'images
        </a>
        <a href="#" class="quick-nav-btn">
            <i class="fas fa-file-pdf"></i>
            Rapports & Documents
        </a>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <form method="GET" action="{{ route('dg.public-content.index') }}" class="filters-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="type">Type de contenu</label>
                    <select name="type" id="type" class="filter-select">
                        <option value="">Tous les types</option>
                        <option value="about" {{ request('type') == 'about' ? 'selected' : '' }}>À propos</option>
                        <option value="institution" {{ request('type') == 'institution' ? 'selected' : '' }}>Institution</option>
                        <option value="news" {{ request('type') == 'news' ? 'selected' : '' }}>Actualités</option>
                        <option value="speech" {{ request('type') == 'speech' ? 'selected' : '' }}>Discours</option>
                        <option value="gallery" {{ request('type') == 'gallery' ? 'selected' : '' }}>Galerie</option>
                        <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Document</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="search">Recherche</label>
                    <input type="text" name="search" id="search" class="filter-input" 
                           placeholder="Rechercher dans les contenus..." 
                           value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label for="status">Statut</label>
                    <select name="status" id="status" class="filter-select">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filtrer
                </button>
                <a href="{{ route('dg.public-content.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Réinitialiser
                </a>
                <!-- Route temporairement désactivée - Fonctionnalité en développement -->
                <button type="button" class="btn btn-success" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-plus"></i>
                    Nouveau contenu
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des contenus -->
    <div class="content-section">
        <div class="content-header">
            <h2>Liste des contenus publics</h2>
            <span class="content-count">{{ $contents->total() }} contenu(s)</span>
        </div>

        @if($contents->count() > 0)
            <div class="content-table">
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Date de création</th>
                            <th>Dernière modification</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contents as $content)
                            <tr>
                                <td>
                                    <div class="content-title">{{ $content->title ?? 'Sans titre' }}</div>
                                    <div class="content-type">{{ ucfirst($content->type ?? 'Contenu') }}</div>
                                </td>
                                <td>
                                    <span class="content-type">{{ ucfirst($content->type ?? 'Contenu') }}</span>
                                </td>
                                <td>
                                    <div class="content-date">{{ $content->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td>
                                    <div class="content-date">{{ $content->updated_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td>
                                    @if($content->is_active)
                                        <span class="badge badge-active">Actif</span>
                                    @else
                                        <span class="badge badge-inactive">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('dg.public-content.show', $content->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- Routes temporairement désactivées - Fonctionnalités en développement -->
                                        <button type="button" class="btn btn-primary btn-sm" disabled title="Fonctionnalité en développement">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" disabled title="Fonctionnalité en développement">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Affichage de {{ $contents->firstItem() ?? 0 }} à {{ $contents->lastItem() ?? 0 }} 
                    sur {{ $contents->total() }} résultats
                </div>
                {{ $contents->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <h3>Aucun contenu trouvé</h3>
                <p>Aucun contenu ne correspond aux critères de recherche.</p>
            </div>
        @endif
    </div>
</div>
@endsection 
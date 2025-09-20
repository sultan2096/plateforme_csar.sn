@extends('layouts.admin')

@section('title', 'Gestion des Actualités')
@section('page-title', 'Gestion des Actualités')
@section('page-subtitle', 'Gérez les actualités de la plateforme CSAR')

@section('content')
<style>
    .news-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }

    .news-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.3);
        position: relative;
        overflow: hidden;
    }

    .news-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .news-header-content {
        position: relative;
        z-index: 1;
    }

    .news-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .news-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .news-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 0.5rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #60a5fa;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.8;
        margin-top: 0.25rem;
    }

    .success-notification {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideInDown 0.5s ease;
    }

    .success-notification i {
        font-size: 1.25rem;
    }

    .news-controls {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(15, 23, 42, 0.1);
    }

    .controls-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .controls-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .add-news-btn {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.3);
    }

    .add-news-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.4);
        color: white;
        text-decoration: none;
    }

    .filters-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
    }

    .filter-input {
        padding: 0.5rem 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .filter-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-select {
        padding: 0.5rem 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background: white;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .news-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(15, 23, 42, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .news-card:hover .card-image {
        transform: scale(1.05);
    }

    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(30, 41, 59, 0.8) 100%);
        opacity: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .news-card:hover .card-overlay {
        opacity: 1;
    }

    .overlay-btn {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .overlay-btn.edit {
        background: #3b82f6;
        color: white;
    }

    .overlay-btn.delete {
        background: #ef4444;
        color: white;
    }

    .overlay-btn:hover {
        transform: scale(1.1);
    }

    .card-content {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .card-type {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .card-type.article {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
    }

    .card-type.communique {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .card-type.evenement {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .card-excerpt {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
    }

    .card-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .card-btn.edit {
        background: #3b82f6;
        color: white;
    }

    .card-btn.delete {
        background: #ef4444;
        color: white;
    }

    .card-btn.publish {
        background: #10b981;
        color: white;
    }

    .card-btn.unpublish {
        background: #6b7280;
        color: white;
    }

    .card-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .news-table {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(15, 23, 42, 0.1);
        display: none;
    }

    .news-table.show {
        display: block;
        animation: slideInUp 0.3s ease;
    }

    .table-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 1rem 1.5rem;
        font-weight: 600;
    }

    .table-content {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background: #f8fafc;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    .table tr:hover {
        background: #f9fafb;
    }

    .table-image {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .table-actions {
        display: flex;
        gap: 0.5rem;
    }

    .table-btn {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    .table-btn.edit {
        background: #3b82f6;
        color: white;
    }

    .table-btn.delete {
        background: #ef4444;
        color: white;
    }

    .table-btn:hover {
        transform: scale(1.1);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
    }

    .empty-description {
        margin-bottom: 2rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-badge.published {
        background: #dcfce7;
        color: #166534;
    }

    .status-badge.draft {
        background: #fef3c7;
        color: #92400e;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .news-container {
            padding: 1rem;
        }
        
        .news-header h1 {
            font-size: 2rem;
        }
        
        .controls-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .news-grid {
            grid-template-columns: 1fr;
        }
        
        .filters-section {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="news-container">
    <!-- En-tête avec statistiques -->
    <div class="news-header">
        <div class="news-header-content">
            <h1>📰 Gestion des Actualités</h1>
            <p>Gérez les actualités, communiqués et événements de la plateforme CSAR</p>
            
            <div class="news-stats">
                <div class="stat-card">
                    <div class="stat-number">{{ $news->total() }}</div>
                    <div class="stat-label">Actualités totales</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $news->where('is_published', true)->count() }}</div>
                    <div class="stat-label">Publiées</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $news->where('is_published', false)->count() }}</div>
                    <div class="stat-label">Brouillons</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $news->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                    <div class="stat-label">Cette semaine</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification de succès -->
    @if(session('success'))
        <div class="success-notification">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Contrôles et filtres -->
    <div class="news-controls">
        <div class="controls-header">
            <div class="controls-title">
                <i class="fas fa-newspaper"></i>
                Gestion des actualités
            </div>
            <a href="{{ route('admin.news.create') }}" class="add-news-btn">
                <i class="fas fa-plus"></i>
                Ajouter une actualité
            </a>
        </div>

        <div class="filters-section">
            <div class="filter-group">
                <label class="filter-label">🔍 Recherche</label>
                <input type="text" id="searchInput" class="filter-input" placeholder="Rechercher par titre...">
            </div>
            <div class="filter-group">
                <label class="filter-label">📂 Type</label>
                <select id="typeFilter" class="filter-select">
                    <option value="">Tous les types</option>
                    <option value="article">Article</option>
                    <option value="communique">Communiqué</option>
                    <option value="evenement">Événement</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">📅 Statut</label>
                <select id="statusFilter" class="filter-select">
                    <option value="">Tous les statuts</option>
                    <option value="published">Publiées</option>
                    <option value="draft">Brouillons</option>
                </select>
            </div>
        </div>

        <div class="view-toggle">
            <button class="view-btn active" onclick="switchView('grid')">
                <i class="fas fa-th"></i>
                Grille
            </button>
            <button class="view-btn" onclick="switchView('table')">
                <i class="fas fa-list"></i>
                Liste
            </button>
        </div>
    </div>

    <!-- Vue Grille -->
    <div id="gridView" class="news-grid">
        @forelse($news as $item)
            <div class="news-card" data-title="{{ strtolower($item->title) }}" data-type="{{ strtolower($item->type) }}" data-status="{{ $item->is_published ? 'published' : 'draft' }}">
                <div style="position: relative;">
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="card-image">
                    @else
                        <div class="card-image" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                            <i class="fas fa-newspaper" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <div class="card-overlay">
                        <button class="overlay-btn edit" onclick="window.location.href='{{ route('admin.news.edit', $item) }}'">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="overlay-btn delete" onclick="deleteNews({{ $item->id }}, '{{ $item->title }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <h3 class="card-title">{{ $item->title }}</h3>
                    <span class="card-type {{ $item->type }}">{{ ucfirst($item->type) }}</span>
                    <p class="card-excerpt">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                    <div class="card-meta">
                        <span>{{ $item->created_at->format('d/m/Y') }}</span>
                        <div class="card-actions">
                            <a href="{{ route('admin.news.edit', $item) }}" class="card-btn edit">
                                <i class="fas fa-edit"></i>
                                Modifier
                            </a>
                            @if($item->is_published)
                                <button class="card-btn unpublish" onclick="togglePublish({{ $item->id }})">
                                    <i class="fas fa-eye-slash"></i>
                                    Dépublier
                                </button>
                            @else
                                <button class="card-btn publish" onclick="togglePublish({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                    Publier
                                </button>
                            @endif
                            <button class="card-btn delete" onclick="deleteNews({{ $item->id }}, '{{ $item->title }}')">
                                <i class="fas fa-trash"></i>
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state" style="grid-column: 1 / -1;">
                <div class="empty-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3 class="empty-title">Aucune actualité</h3>
                <p class="empty-description">Commencez par ajouter votre première actualité</p>
                <a href="{{ route('admin.news.create') }}" class="add-news-btn">
                    <i class="fas fa-plus"></i>
                    Ajouter une actualité
                </a>
            </div>
        @endforelse
    </div>

    <!-- Vue Tableau -->
    <div id="tableView" class="news-table">
        <div class="table-header">
            <i class="fas fa-list"></i>
            Vue en liste
        </div>
        <div class="table-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr data-title="{{ strtolower($item->title) }}" data-type="{{ strtolower($item->type) }}" data-status="{{ $item->is_published ? 'published' : 'draft' }}">
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="table-image">
                                @else
                                    <div class="table-image" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->title }}</strong>
                            </td>
                            <td>
                                <span class="card-type {{ $item->type }}">{{ ucfirst($item->type) }}</span>
                            </td>
                            <td>
                                <span class="status-badge {{ $item->is_published ? 'published' : 'draft' }}">
                                    {{ $item->is_published ? 'Publiée' : 'Brouillon' }}
                                </span>
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="table-actions">
                                    <button class="table-btn edit" onclick="window.location.href='{{ route('admin.news.edit', $item) }}'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="table-btn delete" onclick="deleteNews({{ $item->id }}, '{{ $item->title }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                <h3 class="empty-title">Aucune actualité</h3>
                                <p class="empty-description">Commencez par ajouter votre première actualité</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($news->hasPages())
        <div class="pagination-wrapper">
            {{ $news->links() }}
        </div>
    @endif
</div>

<script>
let currentView = 'grid';

// Changement de vue
function switchView(view) {
    currentView = view;
    
    // Mise à jour des boutons
    document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.view-btn').classList.add('active');
    
    // Affichage de la vue appropriée
    if (view === 'grid') {
        document.getElementById('gridView').style.display = 'grid';
        document.getElementById('tableView').classList.remove('show');
    } else {
        document.getElementById('gridView').style.display = 'none';
        document.getElementById('tableView').classList.add('show');
    }
}

// Filtrage en temps réel
document.getElementById('searchInput').addEventListener('input', filterNews);
document.getElementById('typeFilter').addEventListener('change', filterNews);
document.getElementById('statusFilter').addEventListener('change', filterNews);

function filterNews() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
    
    // Filtrage des cartes
    const cards = document.querySelectorAll('.news-card');
    cards.forEach(card => {
        const title = card.dataset.title;
        const type = card.dataset.type;
        const status = card.dataset.status;
        
        const matchesSearch = title.includes(searchTerm);
        const matchesType = !typeFilter || type === typeFilter;
        const matchesStatus = !statusFilter || status === statusFilter;
        
        if (matchesSearch && matchesType && matchesStatus) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    
    // Filtrage des lignes du tableau
    const rows = document.querySelectorAll('#tableView tbody tr');
    rows.forEach(row => {
        const title = row.dataset.title;
        const type = row.dataset.type;
        const status = row.dataset.status;
        
        const matchesSearch = title.includes(searchTerm);
        const matchesType = !typeFilter || type === typeFilter;
        const matchesStatus = !statusFilter || status === statusFilter;
        
        if (matchesSearch && matchesType && matchesStatus) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
}

// Suppression d'actualité
function deleteNews(id, title) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer l'actualité "${title}" ?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/news/${id}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Toggle publication
function togglePublish(id) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/news/${id}/toggle-publish`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    
    form.appendChild(csrfToken);
    document.body.appendChild(form);
    form.submit();
}

// Animation des cartes au chargement
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.news-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection 
@extends('layouts.admin')

@section('title', 'Galerie - Missions en images')
@section('page-title', 'Galerie - Missions en images')
@section('page-subtitle', 'Gérez la galerie d\'images de la plateforme CSAR')

@section('content')
<style>
:root {
    --primary-color: #22c55e;
    --primary-dark: #16a34a;
    --secondary-color: #3b82f6;
    --dark-color: #0f172a;
    --gray-light: #f8fafc;
    --gray-medium: #6b7280;
    --gray-dark: #374151;
    --text-dark: #1f2937;
    --border-light: #e5e7eb;
    --shadow-light: 0 4px 15px rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 10px 25px rgba(0, 0, 0, 0.15);
    --shadow-heavy: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.gallery-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

/* Header moderne */
.gallery-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-heavy);
    position: relative;
    overflow: hidden;
}

.gallery-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.2;
}

.gallery-header-content {
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.gallery-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.gallery-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

.add-image-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 1rem 2rem;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    backdrop-filter: blur(10px);
}

.add-image-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

/* Filtres et contrôles */
.controls-section {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: var(--shadow-light);
    margin-bottom: 2rem;
    border: 1px solid var(--border-light);
}

.controls-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.controls-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.view-toggle {
    display: flex;
    gap: 0.5rem;
}

.view-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid var(--border-light);
    background: white;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--gray-medium);
}

.view-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
}

.view-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.filters-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-label {
    font-weight: 600;
    color: var(--gray-dark);
    font-size: 0.9rem;
}

.filter-input, .filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-light);
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

/* Grid des images */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.gallery-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-light);
    border: 1px solid var(--border-light);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.gallery-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-heavy);
}

.card-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.4s ease;
}

.gallery-card:hover .card-image img {
    transform: scale(1.1);
}

.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.1) 0%, rgba(34,197,94,0.2) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-card:hover .card-overlay {
    opacity: 1;
}

.card-badges {
    position: absolute;
    top: 15px;
    left: 15px;
    display: flex;
    gap: 8px;
    z-index: 3;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-status {
    background: rgba(34, 197, 94, 0.2);
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.badge-status.inactive {
    background: rgba(239, 68, 68, 0.2);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.badge-featured {
    background: rgba(245, 158, 11, 0.2);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.card-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 3;
}

.gallery-card:hover .card-actions {
    opacity: 1;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.action-btn.edit {
    background: rgba(59, 130, 246, 0.2);
    color: #3b82f6;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.action-btn.delete {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.action-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.card-content {
    padding: 1.5rem;
}

.card-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.card-category {
    color: var(--primary-color);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.card-description {
    color: var(--gray-medium);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border-light);
    font-size: 0.85rem;
    color: var(--gray-medium);
}

.card-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-size {
    font-weight: 600;
}

/* Vue liste */
.gallery-list {
    display: none;
}

.gallery-list.active {
    display: block;
}

.list-item {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-light);
    border: 1px solid var(--border-light);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.3s ease;
}

.list-item:hover {
    transform: translateX(5px);
    box-shadow: var(--shadow-medium);
}

.list-image {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}

.list-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.list-content {
    flex: 1;
}

.list-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.list-meta {
    display: flex;
    gap: 1rem;
    color: var(--gray-medium);
    font-size: 0.9rem;
}

.list-actions {
    display: flex;
    gap: 0.5rem;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-light);
    border: 2px dashed var(--border-light);
}

.empty-icon {
    font-size: 4rem;
    color: var(--gray-medium);
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-dark);
    margin-bottom: 1rem;
}

.empty-text {
    color: var(--gray-medium);
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-container {
        padding: 1rem;
    }
    
    .gallery-header-content {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .filters-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .gallery-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .list-item {
        flex-direction: column;
        text-align: center;
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

.gallery-card, .list-item {
    animation: fadeInUp 0.6s ease forwards;
}

.gallery-card:nth-child(1) { animation-delay: 0.1s; }
.gallery-card:nth-child(2) { animation-delay: 0.2s; }
.gallery-card:nth-child(3) { animation-delay: 0.3s; }
.gallery-card:nth-child(4) { animation-delay: 0.4s; }
.gallery-card:nth-child(5) { animation-delay: 0.5s; }
.gallery-card:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="gallery-container">
    <!-- Header modernisé -->
    <div class="gallery-header">
        <div class="gallery-header-content">
            <div>
                <h1>
                    <i class="fas fa-images"></i>
                    Galerie Photos
                </h1>
                <p>Gérez les images de la galerie publique - {{ $images->total() }} image(s) au total</p>
            </div>
            <a href="{{ route('admin.gallery.create') }}" class="add-image-btn">
                <i class="fas fa-plus"></i>
                Ajouter une Image
            </a>
        </div>
    </div>

    <!-- Section des contrôles -->
    <div class="controls-section">
        <div class="controls-header">
            <h3 class="controls-title">
                <i class="fas fa-filter"></i>
                Filtres et options d'affichage
            </h3>
            <div class="view-toggle">
                <button class="view-btn active" data-view="grid">
                    <i class="fas fa-th-large"></i>
                    Grille
                </button>
                <button class="view-btn" data-view="list">
                    <i class="fas fa-list"></i>
                    Liste
                </button>
            </div>
        </div>

        <div class="filters-row">
            <div class="filter-group">
                <label class="filter-label">🔍 Recherche</label>
                <input type="text" id="searchInput" class="filter-input" placeholder="Rechercher par titre...">
            </div>
            <div class="filter-group">
                <label class="filter-label">🏷️ Catégorie</label>
                <select id="categoryFilter" class="filter-select">
                    <option value="">Toutes les catégories</option>
                    @foreach(\App\Models\GalleryImage::getCategories() as $key => $category)
                        <option value="{{ $key }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">📊 Trier par</label>
                <select id="sortFilter" class="filter-select">
                    <option value="newest">Plus récentes</option>
                    <option value="oldest">Plus anciennes</option>
                    <option value="name">Nom A-Z</option>
                    <option value="category">Catégorie</option>
                </select>
            </div>
        </div>
    </div>

    @if($images->count() > 0)
        <!-- Vue grille -->
        <div class="gallery-grid" id="gridView">
            @foreach($images as $image)
                <div class="gallery-card" data-title="{{ strtolower($image->title ?? '') }}" data-category="{{ $image->category }}" data-date="{{ $image->created_at->format('Y-m-d') }}">
                    <div class="card-image">
                        <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->alt_text ?? $image->title }}">
                        <div class="card-overlay"></div>
                        
                        <div class="card-badges">
                            <span class="badge badge-status {{ $image->status === 'active' ? '' : 'inactive' }}">
                                {{ $image->status === 'active' ? 'Actif' : 'Inactif' }}
                            </span>
                            @if($image->is_featured)
                                <span class="badge badge-featured">⭐ En vedette</span>
                            @endif
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('admin.gallery.edit', $image) }}" class="action-btn edit" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $image->id }})" class="action-btn delete" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-content">
                        <div class="card-category">{{ $image->category }}</div>
                        <h3 class="card-title">{{ $image->title ?: 'Sans titre' }}</h3>
                        
                        @if($image->description)
                            <p class="card-description">
                                {{ Str::limit($image->description, 100) }}
                            </p>
                        @endif

                        <div class="card-meta">
                            <div class="card-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $image->created_at->format('d/m/Y') }}
                            </div>
                            <div class="card-size">
                                {{ $image->formatted_file_size }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Vue liste -->
        <div class="gallery-list" id="listView">
            @foreach($images as $image)
                <div class="list-item" data-title="{{ strtolower($image->title ?? '') }}" data-category="{{ $image->category }}" data-date="{{ $image->created_at->format('Y-m-d') }}">
                    <div class="list-image">
                        <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->alt_text ?? $image->title }}">
                    </div>
                    
                    <div class="list-content">
                        <h3 class="list-title">{{ $image->title ?: 'Sans titre' }}</h3>
                        <div class="list-meta">
                            <span>📂 {{ $image->category }}</span>
                            <span>📅 {{ $image->created_at->format('d/m/Y à H:i') }}</span>
                            <span>📊 {{ $image->formatted_file_size }}</span>
                            <span class="badge badge-status {{ $image->status === 'active' ? '' : 'inactive' }}">
                                {{ $image->status === 'active' ? 'Actif' : 'Inactif' }}
                            </span>
                            @if($image->is_featured)
                                <span class="badge badge-featured">⭐</span>
                            @endif
                        </div>
                    </div>

                    <div class="list-actions">
                        <a href="{{ route('admin.gallery.edit', $image) }}" class="action-btn edit" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="confirmDelete({{ $image->id }})" class="action-btn delete" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 3rem; display: flex; justify-content: center;">
            {{ $images->links() }}
        </div>
    @else
        <!-- État vide -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-images"></i>
            </div>
            <h3 class="empty-title">Aucune image dans la galerie</h3>
            <p class="empty-text">
                Commencez par ajouter des images pour enrichir la galerie publique.<br>
                Les visiteurs pourront découvrir les actions et missions du CSAR.
            </p>
            <a href="{{ route('admin.gallery.create') }}" class="add-image-btn" style="display: inline-flex; background: var(--primary-color); border-color: var(--primary-color);">
                <i class="fas fa-plus"></i>
                Ajouter la première image
            </a>
        </div>
    @endif
</div>

<!-- JavaScript pour les interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des vues (grille/liste)
    const viewButtons = document.querySelectorAll('.view-btn');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');

    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            viewButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            if (this.dataset.view === 'grid') {
                gridView.style.display = 'grid';
                listView.style.display = 'none';
            } else {
                gridView.style.display = 'none';
                listView.style.display = 'block';
            }
        });
    });

    // Filtrage par recherche
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');

    function filterImages() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        const sortOption = sortFilter.value;
        
        let items = [...document.querySelectorAll('.gallery-card, .list-item')];
        
        // Filtrage
        items.forEach(item => {
            const title = item.dataset.title || '';
            const category = item.dataset.category || '';
            
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            
            if (matchesSearch && matchesCategory) {
                item.style.display = '';
                item.style.opacity = '1';
            } else {
                item.style.display = 'none';
                item.style.opacity = '0';
            }
        });
        
        // Tri
        if (sortOption) {
            const visibleItems = items.filter(item => item.style.display !== 'none');
            const container = gridView.style.display !== 'none' ? gridView : listView;
            
            visibleItems.sort((a, b) => {
                switch (sortOption) {
                    case 'newest':
                        return new Date(b.dataset.date) - new Date(a.dataset.date);
                    case 'oldest':
                        return new Date(a.dataset.date) - new Date(b.dataset.date);
                    case 'name':
                        return a.dataset.title.localeCompare(b.dataset.title);
                    case 'category':
                        return a.dataset.category.localeCompare(b.dataset.category);
                    default:
                        return 0;
                }
            });
            
            visibleItems.forEach(item => container.appendChild(item));
        }
    }

    // Événements de filtrage
    searchInput.addEventListener('input', filterImages);
    categoryFilter.addEventListener('change', filterImages);
    sortFilter.addEventListener('change', filterImages);
});

// Fonction de confirmation de suppression
function confirmDelete(imageId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ? Cette action est irréversible.')) {
        // Créer un formulaire pour la suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/gallery/${imageId}`;
        form.style.display = 'none';
        
        // CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        // Method spoofing
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Animation au scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
});

document.querySelectorAll('.gallery-card, .list-item').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    card.style.transition = 'all 0.6s ease';
    observer.observe(card);
});
</script>
@endsection
@extends('layouts.admin')

@section('title', 'Discours Officiels - Administration CSAR')
@section('page-title', 'Discours Officiels')
@section('page-subtitle', 'Gestion des discours de la DG et du Ministère')

@section('content')
<style>
.admin-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.admin-header {
    text-align: center;
    margin-bottom: 3rem;
    animation: slideInDown 0.8s ease-out;
}

.admin-header h1 {
    color: #1e40af;
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.admin-header p {
    color: #6b7280;
    font-size: 1.1rem;
}

.success-message {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border: 1px solid #10b981;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);
}

.success-message p {
    color: #065f46;
    margin: 0;
    font-weight: 600;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
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
    background: linear-gradient(90deg, #3b82f6, #1e40af);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.75rem;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e40af;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-label {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.actions-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
}

.actions-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.actions-header h2 {
    color: #1e40af;
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.actions-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
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
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1e3a8a);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-1px);
}

.filters-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
}

.filters-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
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
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-input, .filter-select {
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s;
    background: #fafafa;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.filter-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.speeches-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
}

.speeches-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.speeches-header h2 {
    color: #1e40af;
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.speeches-count {
    color: #6b7280;
    font-weight: 600;
    background: #f3f4f6;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
}

.speeches-table {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.speeches-table table {
    width: 100%;
    border-collapse: collapse;
}

.speeches-table th {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 1rem;
    text-align: left;
    font-weight: 700;
    color: #374151;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #e5e7eb;
}

.speeches-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.speeches-table tr:hover {
    background: #f9fafb;
}

.speech-author {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.875rem;
}

.author-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.author-name {
    font-weight: 600;
    color: #111827;
    font-size: 0.9rem;
}

.author-role {
    font-size: 0.75rem;
    color: #6b7280;
}

.speech-title {
    font-weight: 600;
    color: #111827;
    font-size: 0.9rem;
    line-height: 1.4;
}

.speech-date {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
}

.speech-excerpt {
    color: #374151;
    font-size: 0.875rem;
    line-height: 1.5;
    max-width: 300px;
}

.speech-status {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-published {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    border: 1px solid #6ee7b7;
}

.status-draft {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    border: 1px solid #fbbf24;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    min-width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    color: white;
}

.btn-info:hover {
    background: linear-gradient(135deg, #0891b2, #0e7490);
}

.btn-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #d97706, #b45309);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
}

.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
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

/* Animations */
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }
    
    .filter-row {
        grid-template-columns: 1fr;
    }
    
    .filter-actions {
        flex-direction: column;
    }
    
    .actions-header, .speeches-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .actions-buttons {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1>🎤 Discours Officiels</h1>
        <p>Gestion des discours de la DG et du Ministère</p>
    </div>

    @if(session('success'))
    <div class="success-message">
        <p>✅ {{ session('success') }}</p>
    </div>
    @endif

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-value">{{ $speeches->total() }}</div>
            <div class="stat-label">Total discours</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👤</div>
            <div class="stat-value">{{ $speeches->unique('author')->count() }}</div>
            <div class="stat-label">Auteurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-value">{{ $speeches->where('date', '>=', now()->subDays(30))->count() }}</div>
            <div class="stat-label">Ce mois</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⭐</div>
            <div class="stat-value">{{ $speeches->where('is_featured', true)->count() }}</div>
            <div class="stat-label">Mis en avant</div>
        </div>
    </div>

    <!-- Actions -->
    <div class="actions-section">
        <div class="actions-header">
            <h2>Actions rapides</h2>
            <div class="actions-buttons">
                <a href="{{ route('admin.speeches.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Ajouter un discours
                </a>
                <button type="button" class="btn btn-secondary" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-download"></i>
                    Export PDF
                </button>
                <button type="button" class="btn btn-secondary" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-file-excel"></i>
                    Export Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.speeches.index') }}" class="filters-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="search">🔍 Recherche</label>
                    <input type="text" id="search" name="search" 
                           class="filter-input" placeholder="Titre, auteur, contenu..."
                           value="{{ request('search') }}">
                </div>
                
                <div class="filter-group">
                    <label for="author">👤 Auteur</label>
                    <select id="author" name="author" class="filter-select">
                        <option value="">Tous les auteurs</option>
                        @foreach($speeches->pluck('author')->unique() as $author)
                            <option value="{{ $author }}" {{ request('author') == $author ? 'selected' : '' }}>
                                {{ $author }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="date">📅 Période</label>
                    <select id="date" name="date" class="filter-select">
                        <option value="">Toutes les dates</option>
                        <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                        <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                        <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>Ce mois</option>
                        <option value="year" {{ request('date') == 'year' ? 'selected' : '' }}>Cette année</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filtrer
                </button>
                <a href="{{ route('admin.speeches.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Liste des discours -->
    <div class="speeches-section">
        <div class="speeches-header">
            <h2>Liste des discours</h2>
            <span class="speeches-count">{{ $speeches->total() }} discours</span>
        </div>

        @if($speeches->count() > 0)
            <div class="speeches-table">
                <table>
                    <thead>
                        <tr>
                            <th>👤 Auteur</th>
                            <th>📝 Titre</th>
                            <th>📅 Date</th>
                            <th>📄 Extrait</th>
                            <th>⚡ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($speeches as $speech)
                            <tr>
                                <td>
                                    <div class="speech-author">
                                        <div class="author-avatar">
                                            {{ strtoupper(substr($speech->author, 0, 1)) }}
                                        </div>
                                        <div class="author-info">
                                            <div class="author-name">{{ $speech->author }}</div>
                                            <div class="author-role">
                                                @if(str_contains($speech->author, 'DG'))
                                                    Directrice Générale
                                                @elseif(str_contains($speech->author, 'Ministre'))
                                                    Ministre
                                                @else
                                                    Responsable
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="speech-title">{{ $speech->title }}</div>
                                </td>
                                <td>
                                    <div class="speech-date">
                                        @if($speech->date)
                                            {{ \Carbon\Carbon::parse($speech->date)->format('d/m/Y') }}
                                            <br>
                                            <small style="color: #9ca3af;">
                                                {{ \Carbon\Carbon::parse($speech->date)->diffForHumans() }}
                                            </small>
                                        @else
                                            <span style="color: #9ca3af;">Non définie</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="speech-excerpt">
                                        {{ Str::limit($speech->excerpt, 80) }}
                                        @if(strlen($speech->excerpt) > 80)
                                            <span style="color: #3b82f6; cursor: pointer;" title="Voir plus">...</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.speeches.show', $speech) }}" 
                                           class="btn btn-info btn-sm" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.speeches.edit', $speech) }}" 
                                           class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.speeches.destroy', $speech) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce discours ?')"
                                                    title="Supprimer">
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

            <div class="pagination-wrapper">
                {{ $speeches->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-microphone-slash"></i>
                <h3>Aucun discours trouvé</h3>
                <p>Aucun discours ne correspond aux critères de recherche.</p>
            </div>
        @endif
    </div>
</div>
@endsection 
@extends('layouts.dg')

@section('title', 'Détails du Contenu Public - CSAR DG')

@section('content')
<div class="dg-container">
    <!-- Header -->
    <div class="dg-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>Détails du Contenu Public</h1>
                <p>Consultation détaillée du contenu public</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('dg.public-content.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Contenu détaillé -->
    <div class="content-details">
        <div class="content-header">
            <div class="content-meta">
                <span class="content-type-badge">{{ ucfirst($content->type ?? 'Contenu') }}</span>
                @if($content->is_active)
                    <span class="status-badge active">Actif</span>
                @else
                    <span class="status-badge inactive">Inactif</span>
                @endif
            </div>
            <h2 class="content-title">{{ $content->title ?? 'Sans titre' }}</h2>
        </div>

        <div class="content-info-grid">
            <div class="info-card">
                <h3>📋 Informations générales</h3>
                <div class="info-item">
                    <label>ID du contenu</label>
                    <span>#{{ $content->id }}</span>
                </div>
                <div class="info-item">
                    <label>Type de contenu</label>
                    <span>{{ ucfirst($content->type ?? 'Non spécifié') }}</span>
                </div>
                <div class="info-item">
                    <label>Statut</label>
                    <span class="{{ $content->is_active ? 'text-success' : 'text-danger' }}">
                        {{ $content->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                <div class="info-item">
                    <label>Date de création</label>
                    <span>{{ $content->created_at ? $content->created_at->format('d/m/Y à H:i') : 'Non spécifiée' }}</span>
                </div>
                <div class="info-item">
                    <label>Dernière modification</label>
                    <span>{{ $content->updated_at ? $content->updated_at->format('d/m/Y à H:i') : 'Non spécifiée' }}</span>
                </div>
            </div>

            <div class="info-card">
                <h3>📝 Contenu</h3>
                <div class="content-body">
                    @if($content->content)
                        <div class="content-text">
                            {!! nl2br(e($content->content)) !!}
                        </div>
                    @else
                        <p class="text-muted">Aucun contenu disponible</p>
                    @endif
                </div>
            </div>
        </div>

        @if($content->description)
        <div class="content-section">
            <h3>📄 Description</h3>
            <div class="content-description">
                {{ $content->description }}
            </div>
        </div>
        @endif

        @if($content->keywords)
        <div class="content-section">
            <h3>🏷️ Mots-clés</h3>
            <div class="keywords-list">
                @foreach(explode(',', $content->keywords) as $keyword)
                    <span class="keyword-tag">{{ trim($keyword) }}</span>
                @endforeach
            </div>
        </div>
        @endif

        @if($content->meta_title || $content->meta_description)
        <div class="content-section">
            <h3>🔍 Métadonnées SEO</h3>
            @if($content->meta_title)
            <div class="meta-item">
                <label>Meta Title</label>
                <span>{{ $content->meta_title }}</span>
            </div>
            @endif
            @if($content->meta_description)
            <div class="meta-item">
                <label>Meta Description</label>
                <span>{{ $content->meta_description }}</span>
            </div>
            @endif
        </div>
        @endif

        <!-- Actions -->
        <div class="actions-section">
            <h3>🔧 Actions</h3>
            <div class="actions-grid">
                <a href="{{ route('dg.public-content.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i>
                    Retour à la liste
                </a>
                
                <!-- Actions temporairement désactivées -->
                <button type="button" class="btn btn-primary" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-edit"></i>
                    Modifier
                </button>
                
                <button type="button" class="btn btn-danger" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-trash"></i>
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.content-details {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(30,41,59,0.08);
    border: 1px solid #f1f5f9;
}

.content-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.content-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.content-type-badge {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-badge.active {
    background: #d1fae5;
    color: #065f46;
}

.status-badge.inactive {
    background: #fee2e2;
    color: #991b1b;
}

.content-title {
    color: #1e293b;
    font-size: 2rem;
    margin: 0;
    font-weight: 700;
}

.content-info-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.info-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
}

.info-card h3 {
    color: #1e40af;
    margin-bottom: 1rem;
    font-size: 1.125rem;
    font-weight: 600;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.info-item:last-child {
    border-bottom: none;
}

.info-item label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
}

.info-item span {
    color: #1f2937;
    font-size: 0.875rem;
}

.content-body {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
    min-height: 200px;
}

.content-text {
    line-height: 1.6;
    color: #374151;
}

.content-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.content-section h3 {
    color: #1e40af;
    margin-bottom: 1rem;
    font-size: 1.125rem;
    font-weight: 600;
}

.content-description {
    color: #374151;
    line-height: 1.6;
}

.keywords-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.keyword-tag {
    background: #dbeafe;
    color: #1e40af;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.meta-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.meta-item:last-child {
    border-bottom: none;
}

.meta-item label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    min-width: 150px;
}

.meta-item span {
    color: #1f2937;
    font-size: 0.875rem;
    flex: 1;
    margin-left: 1rem;
}

.actions-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 2rem;
}

.actions-section h3 {
    color: #1e40af;
    margin-bottom: 1rem;
    font-size: 1.125rem;
    font-weight: 600;
}

.actions-grid {
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

.btn-danger {
    background: #dc2626;
    color: white;
}

.btn-danger:hover:not(:disabled) {
    background: #b91c1c;
}

.btn:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    opacity: 0.6;
}

.text-success {
    color: #059669;
}

.text-danger {
    color: #dc2626;
}

.text-muted {
    color: #6b7280;
    font-style: italic;
}

@media (max-width: 768px) {
    .content-info-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        flex-direction: column;
    }
    
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .meta-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .meta-item span {
        margin-left: 0;
    }
}
</style>
@endsection 
@extends('layouts.dg')

@section('title', 'Détail de l\'Actualité')
@section('page-title', 'Détail de l\'Actualité')
@section('page-subtitle', $news->title)

@section('content')
<style>
    .show-news-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
    }

    .show-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.3);
        position: relative;
        overflow: hidden;
    }

    .show-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .show-header-content {
        position: relative;
        z-index: 1;
    }

    .show-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .show-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .news-content {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(15, 23, 42, 0.1);
        margin-bottom: 2rem;
    }

    .news-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .meta-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .meta-value {
        font-size: 1rem;
        color: #1e293b;
    }

    .type-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .type-badge.article {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
    }

    .type-badge.communique {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .type-badge.evenement {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        font-size: 0.875rem;
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

    .news-body {
        line-height: 1.7;
        color: #374151;
        font-size: 1rem;
    }

    .news-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .news-video {
        width: 100%;
        aspect-ratio: 16/9;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .news-document {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .document-icon {
        font-size: 2rem;
        color: #ef4444;
    }

    .document-info {
        flex: 1;
    }

    .document-title {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .document-desc {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .document-download {
        background: #3b82f6;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .document-download:hover {
        background: #2563eb;
        transform: translateY(-1px);
        color: white;
        text-decoration: none;
    }

    .actions-section {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(15, 23, 42, 0.1);
    }

    .actions-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .action-btn {
        padding: 1rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .action-btn.back {
        background: #6b7280;
        color: white;
    }

    .action-btn.back:hover {
        background: #4b5563;
        transform: translateY(-1px);
        color: white;
        text-decoration: none;
    }

    .empty-content {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .show-news-container {
            padding: 1rem;
        }
        
        .show-header h1 {
            font-size: 2rem;
        }
        
        .news-meta {
            grid-template-columns: 1fr;
        }
        
        .actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="show-news-container">
    <!-- En-tête -->
    <div class="show-header">
        <div class="show-header-content">
            <h1>📰 Détail de l'Actualité</h1>
            <p>Consultez les informations complètes de cette actualité</p>
        </div>
    </div>

    <!-- Contenu de l'actualité -->
    <div class="news-content">
        <!-- Métadonnées -->
        <div class="news-meta">
            <div class="meta-item">
                <div class="meta-label">Titre</div>
                <div class="meta-value">{{ $news->title }}</div>
            </div>
            
            <div class="meta-item">
                <div class="meta-label">Type</div>
                <div class="meta-value">
                    <span class="type-badge {{ $news->type }}">{{ ucfirst($news->type) }}</span>
                </div>
            </div>
            
            <div class="meta-item">
                <div class="meta-label">Statut</div>
                <div class="meta-value">
                    <span class="status-badge {{ $news->is_published ? 'published' : 'draft' }}">
                        {{ $news->is_published ? 'Publiée' : 'Brouillon' }}
                    </span>
                </div>
            </div>
            
            <div class="meta-item">
                <div class="meta-label">Date de création</div>
                <div class="meta-value">{{ $news->created_at->format('d/m/Y à H:i') }}</div>
            </div>
            
            @if($news->published_at)
            <div class="meta-item">
                <div class="meta-label">Date de publication</div>
                <div class="meta-value">{{ $news->published_at->format('d/m/Y à H:i') }}</div>
            </div>
            @endif
            
            <div class="meta-item">
                <div class="meta-label">Créé par</div>
                <div class="meta-value">{{ $news->creator->name ?? 'Utilisateur' }}</div>
            </div>
        </div>

        <!-- Image d'illustration -->
        @if($news->image)
            <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}" class="news-image">
        @endif

        <!-- Vidéo -->
        @if($news->video_url)
            <div style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem; color: #1e293b; font-weight: 600;">🎥 Vidéo associée</h3>
                <iframe src="{{ $news->video_url }}" class="news-video" frameborder="0" allowfullscreen></iframe>
            </div>
        @endif

        <!-- Document associé -->
        @if($news->document)
            <div class="news-document">
                <div class="document-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div class="document-info">
                    <div class="document-title">Document associé</div>
                    <div class="document-desc">Document PDF ou autre format</div>
                </div>
                <a href="{{ asset('storage/'.$news->document) }}" class="document-download" target="_blank">
                    <i class="fas fa-download"></i>
                    Télécharger
                </a>
            </div>
        @endif

        <!-- Contenu -->
        <div class="news-body">
            {!! nl2br(e($news->content)) !!}
        </div>
    </div>

    <!-- Actions -->
    <div class="actions-section">
        <h3 class="actions-title">
            <i class="fas fa-cogs"></i>
            Actions disponibles
        </h3>
        
        <div class="actions-grid">
            <a href="{{ route('dg.news.index') }}" class="action-btn back">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection 
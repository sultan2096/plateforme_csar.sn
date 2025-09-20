@extends('layouts.admin')

@section('title', 'Gestion du Contenu Public - Administration CSAR')
@section('page-title', 'Gestion du Contenu Public')
@section('page-subtitle', 'Modification des contenus de la plateforme publique')

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
}

.admin-header h1 {
    color: #1e40af;
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    font-weight: 700;
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

.admin-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
    transition: all 0.3s ease;
}

.admin-card:hover {
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.admin-section-title {
    color: #1e40af;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.admin-grid {
    display: grid;
    gap: 1.5rem;
}

.admin-grid-2 {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
}

.admin-grid-3 {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
}

.form-input, .form-select, .form-textarea {
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fafafa;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.admin-btn {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
}

.admin-btn:hover {
    background: linear-gradient(135deg, #2563eb, #1e3a8a);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
}

.admin-btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
}

.admin-btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
}

.documents-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.documents-table th {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

.documents-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.documents-table tr:hover {
    background: #f9fafb;
}

.badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-pdf {
    background: #fee2e2;
    color: #991b1b;
}

.badge-video {
    background: #dbeafe;
    color: #1e40af;
}

.badge-image {
    background: #d1fae5;
    color: #065f46;
}

.document-actions {
    display: flex;
    gap: 0.5rem;
}

.document-action {
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.document-action-view {
    background: #dbeafe;
    color: #1e40af;
}

.document-action-view:hover {
    background: #bfdbfe;
}

.document-action-download {
    background: #d1fae5;
    color: #065f46;
}

.document-action-download:hover {
    background: #a7f3d0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }
    
    .admin-grid-2 {
        grid-template-columns: 1fr;
    }
    
    .documents-table {
        font-size: 0.875rem;
    }
    
    .document-actions {
        flex-direction: column;
    }
}
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1>Gestion du Contenu Public</h1>
        <p>Modification des contenus de la plateforme publique CSAR</p>
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
            <div class="stat-value">{{ $contents->count() }}</div>
            <div class="stat-label">Contenus totaux</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📄</div>
            <div class="stat-value">{{ $contents->where('type', 'pdf')->count() }}</div>
            <div class="stat-label">Documents PDF</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎥</div>
            <div class="stat-value">{{ $contents->where('type', 'video')->count() }}</div>
            <div class="stat-label">Vidéos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🖼️</div>
            <div class="stat-value">{{ $contents->where('type', 'image')->count() }}</div>
            <div class="stat-label">Images</div>
        </div>
    </div>

    <!-- Page À propos -->
    <div class="admin-card">
        <h2 class="admin-section-title">
            <span>📌</span>
            Page "À propos" - Chiffres clés
        </h2>
    
    <form action="{{ route('admin.public-content.update-about') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="admin-grid admin-grid-2">
            <div class="form-group">
                <label for="agents_count" class="form-label">👥 Nombre d'agents</label>
                <input type="number" id="agents_count" name="agents_count" 
                        value="{{ (
                            $contents['about.agents_count']->value 
                            ?? ($contents['about.about_agents_count']->value 
                            ?? ($contents['agents_count']->value 
                            ?? ($contents['about_agents_count']->value ?? 137)))
                        ) }}" required
                       class="form-input" min="0" placeholder="Ex: 137">
            </div>
            
            <div class="form-group">
                <label for="warehouses_count" class="form-label">🏢 Nombre d'entrepôts</label>
                <input type="number" id="warehouses_count" name="warehouses_count" 
                        value="{{ (
                            $contents['about.warehouses_count']->value 
                            ?? ($contents['about.about_warehouses_count']->value 
                            ?? ($contents['warehouses_count']->value 
                            ?? ($contents['about_warehouses_count']->value ?? 50)))
                        ) }}" required
                       class="form-input" min="0" placeholder="Ex: 50">
            </div>
            
            <div class="form-group">
                <label for="capacity_tonnes" class="form-label">⚖️ Capacité (tonnes)</label>
                <input type="number" id="capacity_tonnes" name="capacity_tonnes" 
                        value="{{ (
                            $contents['about.capacity_count']->value 
                            ?? ($contents['about.about_capacity_tonnes']->value 
                            ?? ($contents['capacity_count']->value 
                            ?? ($contents['about_capacity_tonnes']->value ?? 86000)))
                        ) }}" required
                       class="form-input" min="0" placeholder="Ex: 86000">
            </div>
            
            <div class="form-group">
                <label for="regions_count" class="form-label">🗺️ Nombre de régions</label>
                <input type="number" id="regions_count" name="regions_count" 
                        value="{{ (
                            $contents['about.regions_count']->value 
                            ?? ($contents['about.about_regions_count']->value 
                            ?? ($contents['regions_count']->value 
                            ?? ($contents['about_regions_count']->value ?? 14)))
                        ) }}" required
                       class="form-input" min="1" max="14" placeholder="Ex: 14">
            </div>
            
            <div class="form-group">
                <label for="years_experience" class="form-label">📅 Années d'expérience</label>
                <input type="number" id="years_experience" name="years_experience" 
                        value="{{ (
                            $contents['about.experience_count']->value 
                            ?? ($contents['about.about_years_experience']->value 
                            ?? ($contents['experience_count']->value 
                            ?? ($contents['about_years_experience']->value ?? 15)))
                        ) }}" required
                       class="form-input" min="1" placeholder="Ex: 15">
            </div>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="admin-btn">
                <span>💾</span>
                Mettre à jour la page "À propos"
            </button>
        </div>
    </form>
</div>

<!-- Page Institution -->
<div class="admin-card">
    <h2 class="admin-section-title">
        <span>🏛️</span>
        Page "Institution" - Structure organisationnelle
    </h2>
    
    <form action="{{ route('admin.public-content.update-institution') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="admin-grid admin-grid-2">
            <div class="form-group">
                <label for="magasins_count" class="form-label">🏪 Nombre de magasins</label>
                <input type="number" id="magasins_count" name="magasins_count" 
                        value="{{ ($contents['institution.magasins_count']->value ?? ($contents['magasins_count']->value ?? 70)) }}" required
                       class="form-input" min="0" placeholder="Ex: 70">
            </div>
            
            <div class="form-group">
                <label for="institution_regions_count" class="form-label">🗺️ Nombre de régions</label>
                <input type="number" id="institution_regions_count" name="regions_count" 
                        value="{{ ($contents['institution.regions_count']->value ?? ($contents['institution_regions_count']->value ?? 14)) }}" required
                       class="form-input" min="1" max="14" placeholder="Ex: 14">
            </div>
            
            <div class="form-group">
                <label for="functionnaires_count" class="form-label">👨‍💼 Nombre de fonctionnaires</label>
                <input type="number" id="functionnaires_count" name="functionnaires_count" 
                        value="{{ ($contents['institution.functionnaires_count']->value ?? ($contents['functionnaires_count']->value ?? 250)) }}" required
                       class="form-input" min="0" placeholder="Ex: 250">
            </div>
            
            <div class="form-group">
                <label for="budget_annuel" class="form-label">💰 Budget annuel</label>
                <input type="text" id="budget_annuel" name="budget_annuel" 
                        value="{{ ($contents['institution.budget_annuel']->value ?? ($contents['budget_annuel']->value ?? '5 milliards FCFA')) }}" required
                       class="form-input" placeholder="Ex: 5 milliards FCFA">
            </div>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="admin-btn">
                <span>💾</span>
                Mettre à jour la page "Institution"
            </button>
        </div>
    </form>
</div>

<!-- Upload de documents -->
<div class="admin-card">
    <h2 class="admin-section-title">
        <span>📎</span>
        Upload de documents
    </h2>
    
    <form action="{{ route('admin.public-content.upload-document') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="admin-grid admin-grid-2">
            <div class="form-group">
                <label for="document_type" class="form-label">📄 Type de document *</label>
                <select id="document_type" name="document_type" required class="form-select">
                    <option value="">Sélectionner un type</option>
                    <option value="pdf">📄 Document PDF</option>
                    <option value="video">🎥 Vidéo</option>
                    <option value="image">🖼️ Image</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="title" class="form-label">📝 Titre du document *</label>
                <input type="text" id="title" name="title" required
                       class="form-input" placeholder="Ex: Rapport annuel 2024">
            </div>
            
            <div class="form-group">
                <label for="file" class="form-label">📁 Fichier *</label>
                <input type="file" id="file" name="file" required
                       class="form-input" accept=".pdf,.mp4,.avi,.mov,.jpg,.jpeg,.png,.gif">
                <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">📏 Taille max: 10MB</p>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">📋 Description</label>
                <textarea id="description" name="description" rows="3"
                          class="form-textarea" placeholder="Description détaillée du document..."></textarea>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="admin-btn">
                <span>📤</span>
                Uploader le document
            </button>
        </div>
    </form>
</div>

<!-- Documents existants -->
<div class="admin-card">
    <h2 class="admin-section-title">
        <span>📚</span>
        Documents publiés
    </h2>
    
    <div style="overflow-x: auto;">
        <table class="documents-table">
            <thead>
                <tr>
                    <th>📄 Type</th>
                    <th>📝 Titre</th>
                    <th>📋 Description</th>
                    <th>📅 Date</th>
                    <th>⚡ Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contents->where('type', '!=', 'text') as $content)
                <tr>
                    <td>
                        @if($content->type === 'pdf')
                            <span class="badge badge-pdf">📄 PDF</span>
                        @elseif($content->type === 'video')
                            <span class="badge badge-video">🎥 VIDÉO</span>
                        @else
                            <span class="badge badge-image">🖼️ IMAGE</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #111827;">{{ $content->title ?? 'Sans titre' }}</div>
                    </td>
                    <td>
                        <div style="color: #6b7280; font-size: 0.875rem;">{{ $content->description ?? 'Aucune description' }}</div>
                    </td>
                    <td>
                        <div style="color: #374151; font-size: 0.875rem;">{{ $content->updated_at->format('d/m/Y H:i') }}</div>
                    </td>
                    <td>
                        <div class="document-actions">
                            <a href="{{ asset('storage/' . $content->value) }}" target="_blank" 
                               class="document-action document-action-view" title="Voir le document">
                                👁️ Voir
                            </a>
                            <a href="{{ asset('storage/' . $content->value) }}" download 
                               class="document-action document-action-download" title="Télécharger">
                                ⬇️ Télécharger
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 3rem; text-align: center; color: #6b7280;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
                        <h3 style="color: #374151; margin-bottom: 0.5rem;">Aucun document publié</h3>
                        <p style="font-size: 0.875rem;">Commencez par uploader votre premier document.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: border-color 0.2s;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
}

textarea.form-input {
    resize: vertical;
    min-height: 80px;
}
</style>
@endsection 
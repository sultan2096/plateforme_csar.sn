@extends('layouts.admin')

@section('title', 'Ajouter une Actualité')
@section('page-title', 'Ajouter une Actualité')
@section('page-subtitle', 'Créez une nouvelle actualité pour la plateforme CSAR')

@section('content')
<style>
    .create-news-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .create-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.3);
        position: relative;
        overflow: hidden;
    }

    .create-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .create-header-content {
        position: relative;
        z-index: 1;
    }

    .create-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .create-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .form-container {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(15, 23, 42, 0.1);
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
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

    .form-input {
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-select {
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        background: white;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-textarea {
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #f9fafb;
    }

    .file-upload-area:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .file-upload-area.dragover {
        border-color: #3b82f6;
        background: #eff6ff;
        transform: scale(1.02);
    }

    .file-upload-icon {
        font-size: 3rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }

    .file-upload-text {
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .file-upload-hint {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .file-preview {
        margin-top: 1rem;
        padding: 1rem;
        background: #f3f4f6;
        border-radius: 0.5rem;
        display: none;
    }

    .file-preview.show {
        display: block;
        animation: slideInUp 0.3s ease;
    }

    .file-preview-image {
        max-width: 200px;
        max-height: 150px;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .file-preview-info {
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .checkbox-input {
        width: 1.25rem;
        height: 1.25rem;
        accent-color: #3b82f6;
    }

    .checkbox-label {
        font-weight: 500;
        color: #374151;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.4);
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-1px);
    }

    .progress-bar {
        width: 100%;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        overflow: hidden;
        margin-top: 1rem;
        display: none;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        width: 0%;
        transition: width 0.3s ease;
    }

    .error-message {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 0.75rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }

    .success-message {
        background: #dcfce7;
        border: 1px solid #bbf7d0;
        color: #166534;
        padding: 0.75rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }

    .character-count {
        font-size: 0.75rem;
        color: #6b7280;
        text-align: right;
        margin-top: 0.25rem;
    }

    .character-count.warning {
        color: #f59e0b;
    }

    .character-count.danger {
        color: #ef4444;
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
        .create-news-container {
            padding: 1rem;
        }
        
        .create-header h1 {
            font-size: 2rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<div class="create-news-container">
    <!-- En-tête -->
    <div class="create-header">
        <div class="create-header-content">
            <h1>📝 Ajouter une Actualité</h1>
            <p>Créez une nouvelle actualité pour informer les utilisateurs de la plateforme CSAR</p>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="form-container">
        @if($errors->any())
            <div class="error-message">
                <strong>Erreurs de validation :</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="newsForm">
            @csrf
            
            <!-- Informations de base -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Informations de base
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="title" class="form-label">📝 Titre de l'actualité *</label>
                        <input type="text" id="title" name="title" class="form-input" value="{{ old('title') }}" placeholder="Ex: Nouvelle politique de stockage CSAR" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="type" class="form-label">📂 Type d'actualité *</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="">Sélectionner un type</option>
                            <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>Article</option>
                            <option value="communique" {{ old('type') == 'communique' ? 'selected' : '' }}>Communiqué</option>
                            <option value="evenement" {{ old('type') == 'evenement' ? 'selected' : '' }}>Événement</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Contenu -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-file-alt"></i>
                    Contenu de l'actualité
                </h3>
                
                <div class="form-group">
                    <label for="content" class="form-label">📄 Contenu *</label>
                    <textarea id="content" name="content" class="form-textarea" placeholder="Rédigez le contenu de votre actualité..." required>{{ old('content') }}</textarea>
                    <div class="character-count" id="charCount">0 caractères</div>
                </div>
            </div>

            <!-- Médias -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-images"></i>
                    Médias (optionnel)
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="image" class="form-label">🖼️ Image d'illustration</label>
                        <div class="file-upload-area" onclick="document.getElementById('image').click()" id="imageUploadArea">
                            <div class="file-upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="file-upload-text">Cliquez ou glissez une image ici</div>
                            <div class="file-upload-hint">Formats acceptés: JPEG, PNG, JPG, GIF (max 2MB)</div>
                        </div>
                        <input type="file" id="image" name="image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                        <div class="file-preview" id="imagePreview">
                            <img id="previewImage" src="#" alt="Aperçu" class="file-preview-image">
                            <div class="file-preview-info" id="imageInfo"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="video_url" class="form-label">🎥 URL de vidéo</label>
                        <input type="url" id="video_url" name="video_url" class="form-input" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                        <small style="color: #6b7280; font-size: 0.75rem;">Lien YouTube, Vimeo ou autre plateforme vidéo</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="document" class="form-label">📎 Document associé</label>
                    <div class="file-upload-area" onclick="document.getElementById('document').click()" id="documentUploadArea">
                        <div class="file-upload-icon">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <div class="file-upload-text">Cliquez ou glissez un document ici</div>
                        <div class="file-upload-hint">Formats acceptés: PDF, DOC, DOCX (max 5MB)</div>
                    </div>
                    <input type="file" id="document" name="document" accept=".pdf,.doc,.docx" style="display: none;" onchange="previewDocument(event)">
                    <div class="file-preview" id="documentPreview">
                        <div class="file-preview-info" id="documentInfo"></div>
                    </div>
                </div>
            </div>

            <!-- Options de publication -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-cog"></i>
                    Options de publication
                </h3>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="is_published" name="is_published" class="checkbox-input" {{ old('is_published') ? 'checked' : '' }}>
                    <label for="is_published" class="checkbox-label">Publier immédiatement</label>
                </div>
                
                <small style="color: #6b7280; font-size: 0.75rem;">
                    Si coché, l'actualité sera visible publiquement. Sinon, elle sera sauvegardée comme brouillon.
                </small>
            </div>

            <!-- Barre de progression -->
            <div class="progress-bar" id="progressBar">
                <div class="progress-fill" id="progressFill"></div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    Créer l'actualité
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Compteur de caractères
const contentTextarea = document.getElementById('content');
const charCount = document.getElementById('charCount');

contentTextarea.addEventListener('input', function() {
    const count = this.value.length;
    charCount.textContent = `${count} caractères`;
    
    if (count > 2000) {
        charCount.className = 'character-count danger';
    } else if (count > 1500) {
        charCount.className = 'character-count warning';
    } else {
        charCount.className = 'character-count';
    }
});

// Prévisualisation d'image
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImage');
    const info = document.getElementById('imageInfo');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            info.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
            preview.classList.add('show');
        }
        reader.readAsDataURL(file);
    }
}

// Prévisualisation de document
function previewDocument(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('documentPreview');
    const info = document.getElementById('documentInfo');
    
    if (file) {
        info.textContent = `📄 ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
        preview.classList.add('show');
    }
}

// Drag and drop pour les images
const imageUploadArea = document.getElementById('imageUploadArea');
const imageInput = document.getElementById('image');

imageUploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

imageUploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

imageUploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        imageInput.files = files;
        previewImage({ target: { files: files } });
    }
});

// Drag and drop pour les documents
const documentUploadArea = document.getElementById('documentUploadArea');
const documentInput = document.getElementById('document');

documentUploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

documentUploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

documentUploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        documentInput.files = files;
        previewDocument({ target: { files: files } });
    }
});

// Validation du formulaire
document.getElementById('newsForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();
    const type = document.getElementById('type').value;
    
    if (!title || !content || !type) {
        e.preventDefault();
        alert('Veuillez remplir tous les champs obligatoires.');
        return;
    }
    
    // Afficher la barre de progression
    const progressBar = document.getElementById('progressBar');
    const progressFill = document.getElementById('progressFill');
    const submitBtn = document.getElementById('submitBtn');
    
    progressBar.style.display = 'block';
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Création en cours...';
    
    // Simulation de progression
    let progress = 0;
    const interval = setInterval(() => {
        progress += 10;
        progressFill.style.width = progress + '%';
        
        if (progress >= 100) {
            clearInterval(interval);
        }
    }, 100);
});

// Initialisation du compteur de caractères
if (contentTextarea.value) {
    contentTextarea.dispatchEvent(new Event('input'));
}
</script>
@endsection 
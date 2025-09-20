@extends('layouts.admin')

@section('title', 'Ajouter une Image - Galerie CSAR')
@section('page-title', 'Ajouter une Image')
@section('page-subtitle', 'Enrichir la galerie avec de nouvelles images captivantes')

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

.create-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem;
}

/* Header */
.create-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-heavy);
    text-align: center;
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
    opacity: 0.2;
}

.create-header-content {
    position: relative;
    z-index: 1;
}

.create-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.create-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    max-width: 600px;
    margin: 0 auto;
}

/* Formulaire */
.form-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
    position: relative;
}

.form-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--gray-dark);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 1rem;
    border: 2px solid var(--border-light);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    box-sizing: border-box;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
    transform: translateY(-2px);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

/* Zone de upload */
.upload-zone {
    border: 3px dashed var(--border-light);
    border-radius: 15px;
    padding: 3rem 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
}

.upload-zone:hover {
    border-color: var(--primary-color);
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.05) 0%, rgba(34, 197, 94, 0.02) 100%);
}

.upload-zone.dragover {
    border-color: var(--primary-color);
    background: rgba(34, 197, 94, 0.1);
    transform: scale(1.02);
}

.upload-icon {
    font-size: 3rem;
    color: var(--gray-medium);
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.upload-zone:hover .upload-icon {
    color: var(--primary-color);
    transform: scale(1.1);
}

.upload-text {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--gray-dark);
    margin-bottom: 0.5rem;
}

.upload-hint {
    color: var(--gray-medium);
    font-size: 0.9rem;
}

.file-input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

/* Prévisualisation de l'image */
.image-preview {
    display: none;
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    border: 2px solid var(--border-light);
    position: relative;
}

.image-preview.show {
    display: block;
}

.preview-image {
    width: 100%;
    max-width: 400px;
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
    margin: 0 auto;
    display: block;
    box-shadow: var(--shadow-light);
}

.preview-info {
    margin-top: 1rem;
    padding: 1rem;
    background: var(--gray-light);
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.file-name {
    font-weight: 600;
    color: var(--text-dark);
}

.file-size {
    color: var(--gray-medium);
    font-size: 0.9rem;
}

.remove-image {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.remove-image:hover {
    background: #dc2626;
    transform: scale(1.05);
}

/* Boutons d'action */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-light);
}

.btn {
    padding: 1rem 2rem;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    border-color: var(--primary-color);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
}

.btn-secondary {
    background: white;
    color: var(--gray-medium);
    border-color: var(--border-light);
}

.btn-secondary:hover {
    border-color: var(--gray-medium);
    color: var(--gray-dark);
}

/* Messages d'erreur */
.error-message {
    color: #ef4444;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group.error .form-input,
.form-group.error .form-select,
.form-group.error .form-textarea {
    border-color: #ef4444;
}

/* Responsive */
@media (max-width: 768px) {
    .create-container {
        padding: 1rem;
    }
    
    .form-card {
        padding: 2rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .upload-zone {
        padding: 2rem 1rem;
    }
}

/* Animations */
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

.form-card {
    animation: slideInUp 0.6s ease forwards;
}

.form-section {
    opacity: 0;
    animation: slideInUp 0.6s ease forwards;
}

.form-section:nth-child(1) { animation-delay: 0.1s; }
.form-section:nth-child(2) { animation-delay: 0.2s; }
.form-section:nth-child(3) { animation-delay: 0.3s; }
.form-section:nth-child(4) { animation-delay: 0.4s; }
</style>

<div class="create-container">
    <!-- Header -->
    <div class="create-header">
        <div class="create-header-content">
            <h1>
                <i class="fas fa-camera"></i>
                Ajouter une Image
            </h1>
            <p>Enrichir la galerie avec de nouvelles images captivantes</p>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="form-card">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" id="imageForm">
            @csrf

            <!-- Section 1: Informations de base -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Informations de base
                </h3>

                <div class="form-group {{ $errors->has('title') ? 'error' : '' }}">
                    <label for="title" class="form-label">📝 Titre de l'image</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           class="form-input" 
                           placeholder="Ex: Action humanitaire, Entrepôt, etc."
                           value="{{ old('title') }}">
                    @error('title')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group {{ $errors->has('category') ? 'error' : '' }}">
                    <label for="category" class="form-label">🏷️ Catégorie</label>
                    <select id="category" name="category" class="form-select">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach(\App\Models\GalleryImage::getCategories() as $key => $category)
                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Section 2: Upload de l'image -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-upload"></i>
                    Image *
                </h3>

                <div class="form-group {{ $errors->has('file') ? 'error' : '' }}">
                    <div class="upload-zone" id="uploadZone">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">Cliquez ou glissez-déposez votre image ici</div>
                        <div class="upload-hint">Formats acceptés : JPG, JPEG, PNG, WEBP • Taille max : 2 Mo</div>
                        <input type="file" 
                               id="file" 
                               name="file" 
                               class="file-input" 
                               accept="image/*" 
                               required>
                    </div>
                    @error('file')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Prévisualisation -->
                <div class="image-preview" id="imagePreview">
                    <img id="previewImage" src="" alt="Prévisualisation" class="preview-image">
                    <div class="preview-info">
                        <div>
                            <div class="file-name" id="fileName"></div>
                            <div class="file-size" id="fileSize"></div>
                        </div>
                        <button type="button" class="remove-image" id="removeImage">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Section 3: Description -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-align-left"></i>
                    Description
                </h3>

                <div class="form-group {{ $errors->has('description') ? 'error' : '' }}">
                    <label for="description" class="form-label">📄 Description</label>
                    <textarea id="description" 
                              name="description" 
                              class="form-textarea" 
                              placeholder="Décrivez le contexte, l'action ou l'événement représenté dans cette image..."
                              rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Enregistrer l'image
                </button>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript pour les interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('file');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeImage = document.getElementById('removeImage');

    // Gestion du drag & drop
    uploadZone.addEventListener('click', () => fileInput.click());

    uploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });

    uploadZone.addEventListener('dragleave', () => {
        uploadZone.classList.remove('dragover');
    });

    uploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(files[0]);
        }
    });

    // Gestion de la sélection de fichier
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });

    // Fonction de gestion du fichier sélectionné
    function handleFileSelect(file) {
        // Vérification du type de fichier
        if (!file.type.startsWith('image/')) {
            alert('Veuillez sélectionner un fichier image valide.');
            return;
        }

        // Vérification de la taille (2 Mo max)
        const maxSize = 2 * 1024 * 1024; // 2 Mo en octets
        if (file.size > maxSize) {
            alert('Le fichier est trop volumineux. Taille maximum : 2 Mo.');
            return;
        }

        // Affichage de la prévisualisation
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            uploadZone.style.display = 'none';
            imagePreview.classList.add('show');
        };
        reader.readAsDataURL(file);
    }

    // Fonction de formatage de la taille de fichier
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Suppression de l'image
    removeImage.addEventListener('click', () => {
        fileInput.value = '';
        previewImage.src = '';
        fileName.textContent = '';
        fileSize.textContent = '';
        
        imagePreview.classList.remove('show');
        uploadZone.style.display = 'block';
    });

    // Auto-resize pour la textarea
    const textarea = document.getElementById('description');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Validation du formulaire
    const form = document.getElementById('imageForm');
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Vérification du fichier
        if (!fileInput.files.length) {
            e.preventDefault();
            alert('Veuillez sélectionner une image.');
            isValid = false;
        }
        
        // Vérification du titre (optionnel mais recommandé)
        const title = document.getElementById('title').value.trim();
        if (!title) {
            const confirmSubmit = confirm('Aucun titre n\'a été saisi. Voulez-vous continuer sans titre ?');
            if (!confirmSubmit) {
                e.preventDefault();
                isValid = false;
            }
        }
        
        if (isValid) {
            // Affichage d'un loader (optionnel)
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
            submitBtn.disabled = true;
        }
    });

    console.log('✅ Page d\'ajout d\'image initialisée avec succès !');
});
</script>
@endsection
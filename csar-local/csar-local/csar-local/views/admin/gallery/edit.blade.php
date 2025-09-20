@extends('layouts.admin')

@section('title', 'Modifier l\'Image - Galerie CSAR')
@section('page-title', 'Modifier l\'Image')
@section('page-subtitle', 'Mettre à jour les informations de l\'image')

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

.edit-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 2rem;
}

/* Header */
.edit-header {
    background: linear-gradient(135deg, var(--secondary-color) 0%, #1d4ed8 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-heavy);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.edit-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.2;
}

.edit-header-content {
    position: relative;
    z-index: 1;
}

.edit-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.edit-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

/* Layout principal */
.edit-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
}

/* Formulaire */
.form-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
    height: fit-content;
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
    border-color: var(--secondary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-2px);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

/* Zone de remplacement d'image */
.image-replace-zone {
    border: 2px dashed var(--border-light);
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    background: var(--gray-light);
    margin-top: 1rem;
}

.image-replace-zone:hover {
    border-color: var(--secondary-color);
    background: rgba(59, 130, 246, 0.05);
}

.replace-text {
    color: var(--gray-medium);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.replace-hint {
    color: var(--gray-medium);
    font-size: 0.8rem;
}

/* Card d'aperçu */
.preview-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
    position: sticky;
    top: 2rem;
}

.preview-header {
    background: linear-gradient(135deg, var(--gray-dark) 0%, var(--text-dark) 100%);
    color: white;
    padding: 1.5rem;
    text-align: center;
}

.preview-header h3 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.current-image {
    position: relative;
}

.current-image img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    object-position: center;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    display: flex;
    align-items: flex-end;
    padding: 1.5rem;
}

.image-info {
    color: white;
}

.image-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.image-category {
    font-size: 0.9rem;
    opacity: 0.9;
}

.preview-details {
    padding: 1.5rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-light);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: var(--gray-dark);
    font-size: 0.9rem;
}

.detail-value {
    color: var(--gray-medium);
    font-size: 0.9rem;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: rgba(34, 197, 94, 0.2);
    color: #16a34a;
}

.status-inactive {
    background: rgba(239, 68, 68, 0.2);
    color: #dc2626;
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
    background: linear-gradient(135deg, var(--secondary-color) 0%, #1d4ed8 100%);
    color: white;
    border-color: var(--secondary-color);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
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

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border-color: #ef4444;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
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
@media (max-width: 1024px) {
    .edit-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .preview-card {
        position: static;
    }
}

@media (max-width: 768px) {
    .edit-container {
        padding: 1rem;
    }
    
    .form-card {
        padding: 2rem;
    }
    
    .form-actions {
        flex-direction: column;
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

.form-card, .preview-card {
    animation: slideInUp 0.6s ease forwards;
}

.preview-card {
    animation-delay: 0.2s;
}
</style>

<div class="edit-container">
    <!-- Header -->
    <div class="edit-header">
        <div class="edit-header-content">
            <h1>
                <i class="fas fa-edit"></i>
                Modifier l'Image
            </h1>
            <p>Mettre à jour les informations de l'image "{{ $galleryImage->title ?: 'Sans titre' }}"</p>
        </div>
    </div>

    <!-- Layout principal -->
    <div class="edit-layout">
        <!-- Formulaire -->
        <div class="form-card">
            <form action="{{ route('admin.gallery.update', $galleryImage) }}" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')
        
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
                               value="{{ old('title', $galleryImage->title) }}">
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
                    <option value="{{ $key }}" {{ old('category', $galleryImage->category) == $key ? 'selected' : '' }}>
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

                <!-- Section 2: Description -->
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
                                  rows="4">{{ old('description', $galleryImage->description) }}</textarea>
                        @error('description')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Section 3: Remplacer l'image (optionnel) -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-image"></i>
                        Remplacer l'image (optionnel)
                    </h3>

                    <div class="form-group {{ $errors->has('file') ? 'error' : '' }}">
                        <label for="file" class="form-label">🖼️ Nouvelle image</label>
                        
                        <div class="image-replace-zone" onclick="document.getElementById('file').click()">
                            <div class="replace-text">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                                Cliquez pour remplacer l'image actuelle
                            </div>
                            <div class="replace-hint">Formats acceptés : JPG, JPEG, PNG, WEBP • Taille max : 2 Mo</div>
                        </div>
                        
                        <input type="file" 
                               id="file" 
                               name="file" 
                               style="display: none;" 
                               accept="image/*">
                        
                        @error('file')
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
                        Mettre à jour
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Retour
                    </a>
                    <button type="button" onclick="confirmDelete()" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Supprimer
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Card d'aperçu -->
        <div class="preview-card">
            <div class="preview-header">
                <h3>
                    <i class="fas fa-eye"></i>
                    Aperçu actuel
                </h3>
            </div>

            <div class="current-image">
                <img src="{{ asset('storage/' . $galleryImage->file_path) }}" alt="{{ $galleryImage->alt_text ?? $galleryImage->title }}">
                <div class="image-overlay">
                    <div class="image-info">
                        <div class="image-title">{{ $galleryImage->title ?: 'Sans titre' }}</div>
                        <div class="image-category">{{ $galleryImage->category }}</div>
                    </div>
                </div>
            </div>

            <div class="preview-details">
                <div class="detail-row">
                    <span class="detail-label">Statut</span>
                    <span class="status-badge {{ $galleryImage->status === 'active' ? 'status-active' : 'status-inactive' }}">
                        {{ $galleryImage->status === 'active' ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Nom du fichier</span>
                    <span class="detail-value">{{ $galleryImage->file_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Taille</span>
                    <span class="detail-value">{{ $galleryImage->formatted_file_size }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Type</span>
                    <span class="detail-value">{{ strtoupper(pathinfo($galleryImage->file_name, PATHINFO_EXTENSION)) }}</span>
        </div>
        
                <div class="detail-row">
                    <span class="detail-label">Ajoutée le</span>
                    <span class="detail-value">{{ $galleryImage->created_at->format('d/m/Y à H:i') }}</span>
        </div>
        
                @if($galleryImage->is_featured)
                    <div class="detail-row">
                        <span class="detail-label">En vedette</span>
                        <span class="detail-value">⭐ Oui</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- JavaScript pour les interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du remplacement d'image
    const fileInput = document.getElementById('file');
    
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            
            // Vérification du type de fichier
            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner un fichier image valide.');
                e.target.value = '';
                return;
            }

            // Vérification de la taille (2 Mo max)
            const maxSize = 2 * 1024 * 1024; // 2 Mo en octets
            if (file.size > maxSize) {
                alert('Le fichier est trop volumineux. Taille maximum : 2 Mo.');
                e.target.value = '';
                return;
            }

            // Confirmation du remplacement
            const confirmReplace = confirm(`Remplacer l'image actuelle par "${file.name}" ?`);
            if (!confirmReplace) {
                e.target.value = '';
                return;
            }

            // Prévisualisation (optionnel)
        const reader = new FileReader();
        reader.onload = function(e) {
                const currentImage = document.querySelector('.current-image img');
                currentImage.src = e.target.result;
                
                // Mise à jour des informations
                const fileName = document.querySelector('.detail-value');
                if (fileName) {
                    fileName.textContent = file.name;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Auto-resize pour la textarea
    const textarea = document.getElementById('description');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Validation du formulaire
    const form = document.getElementById('editForm');
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mise à jour...';
        submitBtn.disabled = true;
    });

    console.log('✅ Page d\'édition d\'image initialisée avec succès !');
});

// Fonction de confirmation de suppression
function confirmDelete() {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ? Cette action est irréversible.')) {
        // Créer un formulaire pour la suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.gallery.destroy", $galleryImage) }}';
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
</script>
@endsection
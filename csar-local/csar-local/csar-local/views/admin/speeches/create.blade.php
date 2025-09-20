@extends('layouts.admin')

@section('title', 'Ajouter un discours')
@section('page-title', 'Ajouter un discours officiel')
@section('page-subtitle', 'Créer un nouveau discours pour la plateforme CSAR')

@section('content')
<style>
    .speech-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .speech-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.3);
        position: relative;
        overflow: hidden;
    }

    .speech-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .speech-header-content {
        position: relative;
        z-index: 1;
    }

    .speech-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .speech-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .speech-steps {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        backdrop-filter: blur(10px);
    }

    .step.active {
        background: rgba(96, 165, 250, 0.2);
        border: 1px solid rgba(96, 165, 250, 0.3);
    }

    .speech-form {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid rgba(15, 23, 42, 0.1);
    }

    .form-section {
        padding: 2rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        position: relative;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }

    .form-input.error {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-textarea {
        width: 100%;
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-family: 'Inter', sans-serif;
        resize: vertical;
        min-height: 120px;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        background: #f9fafb;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
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
        font-size: 2rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }

    .file-upload-text {
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .file-upload-hint {
        font-size: 0.875rem;
        color: #9ca3af;
    }

    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .preview-section {
        margin-top: 1rem;
        display: none;
    }

    .preview-section.show {
        display: block;
        animation: slideInUp 0.3s ease;
    }

    .preview-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .preview-actions {
        margin-top: 1rem;
        display: flex;
        gap: 0.5rem;
    }

    .preview-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .preview-btn.rotate {
        background: #3b82f6;
        color: white;
    }

    .preview-btn.remove {
        background: #ef4444;
        color: white;
    }

    .preview-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: none;
    }

    .error-message.show {
        display: block;
        animation: shake 0.5s ease;
    }

    .form-actions {
        padding: 2rem;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .btn {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
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

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    .progress-bar {
        width: 100%;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        overflow: hidden;
        margin-top: 1rem;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        width: 0%;
        transition: width 0.3s ease;
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

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @media (max-width: 768px) {
        .speech-container {
            padding: 1rem;
        }
        
        .speech-header h1 {
            font-size: 2rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="speech-container">
    <!-- En-tête avec étapes -->
    <div class="speech-header">
        <div class="speech-header-content">
            <h1>🎤 Nouveau Discours Officiel</h1>
            <p>Créez un discours officiel pour la plateforme CSAR avec tous les détails nécessaires</p>
            
            <div class="speech-steps">
                <div class="step active">
                    <i class="fas fa-edit"></i>
                    <span>Informations</span>
                </div>
                <div class="step">
                    <i class="fas fa-image"></i>
                    <span>Portrait</span>
                </div>
                <div class="step">
                    <i class="fas fa-file-text"></i>
                    <span>Contenu</span>
                </div>
                <div class="step">
                    <i class="fas fa-check"></i>
                    <span>Validation</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages d'erreur -->
    @if($errors->any())
        <div class="speech-form" style="margin-bottom: 2rem;">
            <div class="form-section" style="background: #fef2f2; border-left: 4px solid #ef4444;">
                <div class="section-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Erreurs de validation
                </div>
                <ul style="color: #991b1b; margin: 0; padding-left: 1rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Formulaire principal -->
    <div class="speech-form">
        <form action="{{ route('admin.speeches.store') }}" method="POST" enctype="multipart/form-data" id="speechForm">
            @csrf
            
            <!-- Section Informations de base -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user"></i>
                    Informations de base
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="author" class="form-label">👤 Auteur *</label>
                        <input type="text" id="author" name="author" value="{{ old('author') }}" 
                               required class="form-input" placeholder="Ex: Directrice Générale, Ministre, etc."
                               oninput="validateField(this)">
                        <div class="error-message" id="author-error">Veuillez saisir le nom de l'auteur</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="title" class="form-label">📝 Titre *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" 
                               required class="form-input" placeholder="Titre du discours officiel"
                               oninput="validateField(this)">
                        <div class="error-message" id="title-error">Veuillez saisir le titre du discours</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="date" class="form-label">📅 Date du discours</label>
                        <input type="date" id="date" name="date" value="{{ old('date') }}" 
                               class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="excerpt" class="form-label">💬 Extrait (citation)</label>
                        <textarea id="excerpt" name="excerpt" rows="3" class="form-textarea" 
                                  placeholder="Extrait ou citation marquante du discours">{{ old('excerpt') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section Portrait -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-camera"></i>
                    Portrait de l'auteur
                </div>
                
                <div class="file-upload-area" id="uploadArea">
                    <div class="file-upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="file-upload-text">
                        <strong>Cliquez ou glissez-déposez</strong> pour ajouter un portrait
                    </div>
                    <div class="file-upload-hint">
                        Formats acceptés : JPG, PNG, WEBP • Taille max : 2 MB
                    </div>
                    <input type="file" id="portrait" name="portrait" class="file-input" 
                           accept="image/*" onchange="handleFileSelect(this)">
                </div>
                
                <div class="preview-section" id="previewSection">
                    <img id="previewImage" class="preview-image" alt="Aperçu">
                    <div class="preview-actions">
                        <button type="button" class="preview-btn rotate" onclick="rotateImage()">
                            <i class="fas fa-redo"></i> Rotation
                        </button>
                        <button type="button" class="preview-btn remove" onclick="removeImage()">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Section Contenu -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-file-text"></i>
                    Contenu du discours
                </div>
                
                <div class="form-group">
                    <label for="content" class="form-label">📄 Contenu complet *</label>
                    <textarea id="content" name="content" rows="12" required class="form-textarea" 
                              placeholder="Saisissez le texte complet du discours officiel..."
                              oninput="validateField(this); updateCharCount(this)">{{ old('content') }}</textarea>
                    <div class="error-message" id="content-error">Veuillez saisir le contenu du discours</div>
                    <div style="text-align: right; margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;">
                        <span id="charCount">0</span> caractères
                    </div>
                </div>
            </div>

            <!-- Barre de progression -->
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.speeches.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la liste
                </a>
                
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    <span id="submitText">Enregistrer le discours</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentRotation = 0;
let selectedFile = null;

// Validation des champs
function validateField(field) {
    const errorElement = document.getElementById(field.id + '-error');
    const isValid = field.value.trim().length > 0;
    
    if (isValid) {
        field.classList.remove('error');
        errorElement.classList.remove('show');
    } else {
        field.classList.add('error');
        errorElement.classList.add('show');
    }
    
    updateProgress();
}

// Gestion de la sélection de fichier
function handleFileSelect(input) {
    const file = input.files[0];
    if (file) {
        selectedFile = file;
        
        // Validation du fichier
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        
        if (file.size > maxSize) {
            showError('Le fichier est trop volumineux (max 2MB)');
            return;
        }
        
        if (!allowedTypes.includes(file.type)) {
            showError('Format de fichier non supporté');
            return;
        }
        
        // Aperçu de l'image
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImage = document.getElementById('previewImage');
            previewImage.src = e.target.result;
            document.getElementById('previewSection').classList.add('show');
        };
        reader.readAsDataURL(file);
        
        // Animation de l'upload
        const uploadArea = document.getElementById('uploadArea');
        uploadArea.innerHTML = `
            <div class="file-upload-icon pulse">
                <i class="fas fa-check-circle" style="color: #10b981;"></i>
            </div>
            <div class="file-upload-text">
                <strong>Fichier sélectionné :</strong> ${file.name}
            </div>
            <div class="file-upload-hint">
                Taille : ${(file.size / 1024 / 1024).toFixed(2)} MB
            </div>
        `;
    }
    
    updateProgress();
}

// Rotation de l'image
function rotateImage() {
    currentRotation += 90;
    const previewImage = document.getElementById('previewImage');
    previewImage.style.transform = `rotate(${currentRotation}deg)`;
}

// Suppression de l'image
function removeImage() {
    selectedFile = null;
    document.getElementById('portrait').value = '';
    document.getElementById('previewSection').classList.remove('show');
    
    const uploadArea = document.getElementById('uploadArea');
    uploadArea.innerHTML = `
        <div class="file-upload-icon">
            <i class="fas fa-cloud-upload-alt"></i>
        </div>
        <div class="file-upload-text">
            <strong>Cliquez ou glissez-déposez</strong> pour ajouter un portrait
        </div>
        <div class="file-upload-hint">
            Formats acceptés : JPG, PNG, WEBP • Taille max : 2 MB
        </div>
        <input type="file" id="portrait" name="portrait" class="file-input" 
               accept="image/*" onchange="handleFileSelect(this)">
    `;
    
    updateProgress();
}

// Compteur de caractères
function updateCharCount(textarea) {
    const charCount = document.getElementById('charCount');
    charCount.textContent = textarea.value.length;
}

// Mise à jour de la barre de progression
function updateProgress() {
    const requiredFields = ['author', 'title', 'content'];
    const filledFields = requiredFields.filter(field => 
        document.getElementById(field).value.trim().length > 0
    );
    
    const progress = (filledFields.length / requiredFields.length) * 100;
    document.getElementById('progressFill').style.width = progress + '%';
}

// Gestion du drag & drop
const uploadArea = document.getElementById('uploadArea');

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('dragover');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('portrait').files = files;
        handleFileSelect(document.getElementById('portrait'));
    }
});

// Soumission du formulaire
document.getElementById('speechForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    
    // Validation finale
    const requiredFields = ['author', 'title', 'content'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (element.value.trim().length === 0) {
            element.classList.add('error');
            document.getElementById(field + '-error').classList.add('show');
            isValid = false;
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        showError('Veuillez corriger les erreurs avant de soumettre');
        return;
    }
    
    // Animation de soumission
    submitBtn.disabled = true;
    submitText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
});

// Affichage des erreurs
function showError(message) {
    // Créer une notification d'erreur temporaire
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ef4444;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        animation: slideInRight 0.3s ease;
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    updateProgress();
    updateCharCount(document.getElementById('content'));
});
</script>
@endsection 
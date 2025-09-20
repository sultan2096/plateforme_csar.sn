@extends('layouts.admin')

@section('title', 'Mon Profil - Administration CSAR')

@section('content')
<div class="profile-container">
    <!-- Header Section -->
    <div class="profile-header">
        <div class="header-content">
            <div class="user-info">
                <div class="user-avatar-large">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="avatar-img">
                    @else
                        <div class="avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                <div class="user-details">
                    <h1 class="user-name">{{ auth()->user()->name }}</h1>
                    <p class="user-role">{{ auth()->user()->role->display_name ?? 'Administrateur' }}</p>
                    <p class="user-email">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.dashboard') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour au tableau de bord</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="profile-content">
        <div class="profile-grid">
            <!-- Informations personnelles -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div class="header-text">
                        <h2>Informations personnelles</h2>
                        <p>Modifiez vos informations de base</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.profile.password') }}" method="POST" class="profile-form">
                    @csrf
                    @method('PUT')
                    
                    @if($errors->any())
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div class="alert-content">
                                <h4>Erreurs de validation</h4>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <div class="alert-content">
                                <h4>Succès</h4>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i>
                            Nom complet *
                        </label>
                        <input type="text" id="name" name="name" 
                               value="{{ old('name', auth()->user()->name) }}" 
                               class="form-input @error('name') error @enderror"
                               placeholder="Votre nom complet">
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Adresse email *
                        </label>
                        <input type="email" id="email" name="email" 
                               value="{{ old('email', auth()->user()->email) }}" 
                               class="form-input @error('email') error @enderror"
                               placeholder="votre.email@csar.sn">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">
                            <i class="fas fa-phone"></i>
                            Téléphone
                        </label>
                        <input type="tel" id="phone" name="phone" 
                               value="{{ old('phone', auth()->user()->phone) }}" 
                               class="form-input @error('phone') error @enderror"
                               placeholder="+221 77 XXX XX XX">
                        @error('phone')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Adresse
                        </label>
                        <textarea id="address" name="address" rows="3"
                                  class="form-input @error('address') error @enderror"
                                  placeholder="Votre adresse complète">{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>

            <!-- Changement de mot de passe -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="header-text">
                        <h2>Changer le mot de passe</h2>
                        <p>Sécurisez votre compte</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.profile.update') }}" method="POST" class="profile-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="current_password" class="form-label">
                            <i class="fas fa-key"></i>
                            Mot de passe actuel
                        </label>
                        <input type="password" id="current_password" name="current_password"
                               class="form-input @error('current_password') error @enderror"
                               placeholder="Votre mot de passe actuel">
                        @error('current_password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Nouveau mot de passe
                        </label>
                        <input type="password" id="new_password" name="new_password"
                               class="form-input @error('new_password') error @enderror"
                               placeholder="Nouveau mot de passe (min. 8 caractères)">
                        @error('new_password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i>
                            Confirmer le nouveau mot de passe
                        </label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                               class="form-input @error('new_password_confirmation') error @enderror"
                               placeholder="Confirmez le nouveau mot de passe">
                        @error('new_password_confirmation')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-key"></i>
                            Changer le mot de passe
                        </button>
                    </div>
                </form>
            </div>

            <!-- Photo de profil -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="header-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="header-text">
                        <h2>Photo de profil</h2>
                        <p>Personnalisez votre avatar</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="avatar-section">
                        <div class="current-avatar">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar actuel" class="avatar-preview">
                            @else
                                <div class="avatar-placeholder-large">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="avatar-upload">
                            <div class="upload-area" id="uploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Cliquez pour choisir une nouvelle photo</p>
                                <span class="upload-hint">Formats acceptés : JPEG, PNG, JPG, GIF (max. 2MB)</span>
                            </div>
                            <input type="file" id="avatar" name="avatar" 
                                   accept="image/*" class="file-input" style="display: none;">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i>
                            Mettre à jour la photo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload handling
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('avatar');
    
    uploadArea.addEventListener('click', function() {
        fileInput.click();
    });
    
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.querySelector('.avatar-preview') || document.querySelector('.avatar-placeholder-large');
                if (preview) {
                    if (preview.classList.contains('avatar-placeholder-large')) {
                        preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
                    } else {
                        preview.src = e.target.result;
                    }
                }
            };
            
            reader.readAsDataURL(file);
        }
    });
    
    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endsection

@section('styles')
<style>
.profile-container {
    padding: 0;
    background: #f8fafc;
    min-height: 100vh;
}

/* Header Section */
.profile-header {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.user-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: white;
    overflow: hidden;
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-details h1 {
    color: white;
    font-size: 1.875rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.user-role {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    margin: 0 0 0.25rem 0;
}

.user-email {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.875rem;
    margin: 0;
}

.back-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    text-decoration: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-1px);
}

/* Main Content */
.profile-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem 2rem;
}

.profile-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(5, 150, 105, 0.1);
}

.card-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.header-text h2 {
    margin: 0 0 0.25rem 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

.header-text p {
    margin: 0;
    font-size: 0.875rem;
    color: #6b7280;
}

/* Forms */
.profile-form {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-label i {
    color: #059669;
    width: 16px;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus {
    outline: none;
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
}

.form-input.error {
    border-color: #dc2626;
}

.error-message {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: #dc2626;
}

/* Alerts */
.alert {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.alert i {
    margin-top: 0.125rem;
    flex-shrink: 0;
}

.alert-content h4 {
    margin: 0 0 0.5rem 0;
    font-size: 0.875rem;
    font-weight: 600;
}

.alert-content p {
    margin: 0;
    font-size: 0.875rem;
}

.alert-content ul {
    margin: 0.5rem 0 0 0;
    padding-left: 1rem;
    font-size: 0.875rem;
}

/* Buttons */
.form-actions {
    margin-top: 2rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.btn-secondary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.btn-secondary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* Avatar Section */
.avatar-section {
    text-align: center;
}

.current-avatar {
    margin-bottom: 1.5rem;
}

.avatar-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e5e7eb;
}

.avatar-placeholder-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: #9ca3af;
    border: 4px solid #e5e7eb;
    margin: 0 auto;
}

.upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.upload-area:hover {
    border-color: #059669;
    background: #f0fdf4;
}

.upload-area.drag-over {
    border-color: #059669;
    background: #f0fdf4;
}

.upload-area i {
    font-size: 2rem;
    color: #059669;
    margin-bottom: 1rem;
}

.upload-area p {
    margin: 0 0 0.5rem 0;
    font-weight: 600;
    color: #374151;
}

.upload-hint {
    font-size: 0.75rem;
    color: #6b7280;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .profile-grid {
        grid-template-columns: 1fr;
    }
    
    .profile-content {
        padding: 0 1rem 2rem;
    }
    
    .user-info {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endsection 
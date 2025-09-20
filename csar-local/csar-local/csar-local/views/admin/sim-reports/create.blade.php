@extends('layouts.admin')

@section('title', 'Créer un Rapport SIM - Administration')

@section('content')
<style>
/* Variables CSS personnalisées */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
    --dark-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    --light-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    --dark-shadow: 0 10px 30px rgba(15, 23, 42, 0.3);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Container principal */
.create-sim-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

/* Header avec dégradé */
.create-header {
    background: var(--dark-gradient);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: var(--dark-shadow);
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
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    opacity: 0.3;
    pointer-events: none;
}

.create-header > * {
    position: relative;
    z-index: 2;
}

.create-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem;
    background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: none;
}

.create-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

/* Boutons stylisés */
.btn-cool {
    background: var(--primary-gradient);
    border: none;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-cool:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
    color: white;
    text-decoration: none;
}

.btn-secondary-cool {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
}

.btn-secondary-cool:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
    color: white;
    text-decoration: none;
}

/* Carte de formulaire */
.form-container {
    background: #fff;
    border-radius: var(--border-radius);
    padding: 3rem;
    box-shadow: var(--light-shadow);
    border: 1px solid rgba(15, 23, 42, 0.08);
    position: relative;
    overflow: hidden;
}

.form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
}

/* Sections du formulaire */
.form-section {
    margin-bottom: 2.5rem;
    padding: 2rem;
    background: #f8fafc;
    border-radius: var(--border-radius);
    border-left: 4px solid #667eea;
}

.form-section-title {
    color: #1e293b;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 12px;
}

.form-section-icon {
    width: 24px;
    height: 24px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
}

/* Champs de formulaire améliorés */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}

.form-control-cool {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: var(--transition);
    background: #fff;
}

.form-control-cool:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: #fafbff;
}

.form-control-cool.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Upload de fichiers stylisé */
.file-upload-container {
    position: relative;
    border: 2px dashed #d1d5db;
    border-radius: var(--border-radius);
    padding: 2rem;
    text-align: center;
    transition: var(--transition);
    background: #f9fafb;
    cursor: pointer;
    user-select: none;
}

.file-upload-container:hover {
    border-color: #667eea;
    background: #f0f4ff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.file-upload-container.dragover {
    border-color: #667eea;
    background: #eef2ff;
    transform: scale(1.02);
}

.file-upload-icon {
    font-size: 3rem;
    color: #9ca3af;
    margin-bottom: 1rem;
}

.file-upload-text {
    color: #6b7280;
    font-weight: 500;
}

/* Textarea améliorée */
.textarea-cool {
    width: 100%;
    padding: 16px;
    border: 2px solid #e5e7eb;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    resize: vertical;
    min-height: 120px;
    font-family: inherit;
}

.textarea-cool:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Select stylisé */
.select-cool {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    background: #fff;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px;
    padding-right: 48px;
    appearance: none;
    transition: var(--transition);
}

.select-cool:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Alert info stylisée */
.alert-info-cool {
    background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
    border: 1px solid #0ea5e9;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    color: #0c4a6e;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.alert-info-cool .icon {
    color: #0ea5e9;
    font-size: 1.2rem;
    margin-top: 2px;
}

/* Boutons d'action */
.action-buttons {
    display: flex;
    gap: 16px;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
    margin-top: 2rem;
}

.btn-primary-cool {
    background: var(--primary-gradient);
    border: none;
    color: white;
    padding: 14px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-primary-cool:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
    color: white;
}

.btn-secondary-form {
    background: #f3f4f6;
    border: 2px solid #d1d5db;
    color: #6b7280;
    padding: 12px 26px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
}

.btn-secondary-form:hover {
    background: #e5e7eb;
    border-color: #9ca3af;
    color: #374151;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 768px) {
    .create-sim-container {
        padding: 1rem;
    }
    
    .create-header {
        padding: 2rem 1.5rem;
    }
    
    .create-header h1 {
        font-size: 2rem;
    }
    
    .form-container {
        padding: 2rem 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
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

.form-container {
    animation: fadeInUp 0.6s ease-out;
}

.create-header {
    animation: fadeInUp 0.6s ease-out 0.1s both;
}
</style>

<div class="create-sim-container">
    <!-- Header -->
    <div class="create-header">
        <h1>📝 Créer un Rapport SIM</h1>
        <p>Ajoutez un nouveau rapport et ses pièces jointes pour le système d'information du marché</p>
        <div>
            <a href="{{ route('admin.sim-reports.index') }}" class="btn-secondary-cool">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="form-container">
        <form action="{{ route('admin.sim-reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Section: Informations générales -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">
                        <i class="fas fa-info-circle"></i>
                    </span>
                    Informations du Rapport
                </h3>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="title" class="form-label">Titre du rapport *</label>
                            <input type="text" class="form-control-cool @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Ex: Rapport SIM - Analyse des prix des céréales" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="period" class="form-label">Période *</label>
                            <input type="text" class="form-control-cool @error('period') is-invalid @enderror" 
                                   id="period" name="period" value="{{ old('period') }}" 
                                   placeholder="ex: Juillet 2025" required>
                            @error('period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="report_date" class="form-label">Date du rapport *</label>
                            <input type="date" class="form-control-cool @error('report_date') is-invalid @enderror" 
                                   id="report_date" name="report_date" value="{{ old('report_date') }}" required>
                            @error('report_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Statut *</label>
                            <select class="select-cool @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>📝 Brouillon</option>
                                <option value="review" {{ old('status') == 'review' ? 'selected' : '' }}>👀 En révision</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>✅ Publié</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>📦 Archivé</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Fichiers -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">
                        <i class="fas fa-file-upload"></i>
                    </span>
                    Documents et Fichiers
                </h3>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="document_file" class="form-label">Document PDF</label>
                            <div class="file-upload-container">
                                <div class="file-upload-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="file-upload-text">
                                    <strong>Cliquez pour sélectionner</strong> ou glissez votre fichier PDF
                                    <br><small style="color: #667eea; font-weight: 600;">💡 Zone cliquable</small>
                                </div>
                                <input type="file" class="form-control-cool @error('document_file') is-invalid @enderror" 
                                       id="document_file" name="document_file" accept=".pdf" style="display: none;">
                                <small class="text-muted d-block mt-2">Taille maximale : 10 MB</small>
                            </div>
                            @error('document_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="cover_image" class="form-label">Image de couverture</label>
                            <div class="file-upload-container">
                                <div class="file-upload-icon">
                                    <i class="fas fa-image"></i>
                                </div>
                                <div class="file-upload-text">
                                    <strong>Cliquez pour sélectionner</strong> ou glissez votre image
                                    <br><small style="color: #667eea; font-weight: 600;">💡 Zone cliquable</small>
                                </div>
                                <input type="file" class="form-control-cool @error('cover_image') is-invalid @enderror" 
                                       id="cover_image" name="cover_image" accept="image/*" style="display: none;">
                                <small class="text-muted d-block mt-2">Formats : JPG, PNG. Taille max : 2 MB</small>
                            </div>
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Contenu -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">
                        <i class="fas fa-edit"></i>
                    </span>
                    Contenu du Rapport
                </h3>
                
                <div class="form-group">
                    <label for="summary" class="form-label">Résumé exécutif</label>
                    <textarea class="textarea-cool @error('summary') is-invalid @enderror" 
                              id="summary" name="summary" rows="4" 
                              placeholder="Résumé exécutif du rapport...">{{ old('summary') }}</textarea>
                    @error('summary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="context_objectives" class="form-label">Contexte et objectifs</label>
                    <textarea class="textarea-cool @error('context_objectives') is-invalid @enderror" 
                              id="context_objectives" name="context_objectives" rows="5" 
                              placeholder="Contexte et objectifs du rapport...">{{ old('context_objectives') }}</textarea>
                    @error('context_objectives')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="methodology" class="form-label">Note méthodologique</label>
                    <textarea class="textarea-cool @error('methodology') is-invalid @enderror" 
                              id="methodology" name="methodology" rows="4" 
                              placeholder="Méthodologie utilisée pour la collecte et l'analyse des données...">{{ old('methodology') }}</textarea>
                    @error('methodology')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Champs cachés pour les données JSON -->
            <input type="hidden" name="supply_level" value="{{ old('supply_level', '{}') }}">
            <input type="hidden" name="price_analysis" value="{{ old('price_analysis', '{}') }}">
            <input type="hidden" name="regional_distribution" value="{{ old('regional_distribution', '{}') }}">
            <input type="hidden" name="key_trends" value="{{ old('key_trends', '{}') }}">
            <input type="hidden" name="recommendations" value="{{ old('recommendations', '{}') }}">
            <input type="hidden" name="annexes" value="{{ old('annexes', '{}') }}">

            <!-- Note d'information -->
            <div class="alert-info-cool">
                <i class="fas fa-lightbulb icon"></i>
                <div>
                    <strong>Note importante :</strong> Les données détaillées (niveaux d'approvisionnement, analyse des prix, distribution régionale, etc.) 
                    peuvent être ajoutées après la création du rapport via l'interface d'édition avancée.
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="action-buttons">
                <button type="submit" class="btn-primary-cool">
                    <i class="fas fa-save"></i>
                    Créer le Rapport
                </button>
                <a href="{{ route('admin.sim-reports.index') }}" class="btn-secondary-form">
                    <i class="fas fa-times"></i>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion des uploads de fichiers
    function setupFileUpload(inputId, containerId) {
        const input = $(inputId);
        const container = $(containerId);
        
        // Clic sur le container pour ouvrir le sélecteur
        container.on('click', function(e) {
            if (e.target === this || $(e.target).hasClass('file-upload-text') || $(e.target).hasClass('file-upload-icon')) {
                input.click();
            }
        });
        
        // Drag & drop
        container.on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('dragover');
        });
        
        container.on('dragleave', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
        });
        
        container.on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('dragover');
            
            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                input[0].files = files;
                input.trigger('change');
            }
        });
        
        // Changement de fichier
        input.on('change', function() {
            const file = this.files[0];
            if (file) {
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                container.find('.file-upload-text').html(
                    `<strong>✅ ${fileName}</strong><br><small>${fileSize} MB</small>`
                );
            }
        });
    }
    
    // Initialiser les uploads
    setupFileUpload('#document_file', $('#document_file').closest('.file-upload-container'));
    setupFileUpload('#cover_image', $('#cover_image').closest('.file-upload-container'));
    
    // Prévisualisation de l'image
    $('#cover_image').change(function() {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Supprimer l'ancienne prévisualisation
                $('#image-preview').remove();
                
                // Créer la nouvelle prévisualisation
                const preview = $(`
                    <div id="image-preview" class="mt-3">
                        <img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    </div>
                `);
                $('#cover_image').closest('.file-upload-container').after(preview);
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Validation du formulaire
    $('form').on('submit', function(e) {
        const title = $('#title').val().trim();
        const period = $('#period').val().trim();
        const reportDate = $('#report_date').val();
        
        if (!title || !period || !reportDate) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires (*)');
            return false;
        }
    });
    
    // Auto-resize des textareas
    $('textarea').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endpush
@endsection



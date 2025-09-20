@extends('layouts.admin')

@section('title', 'Nouveau Partenaire Technique - Administration')

@section('content')
<style>
/* Variables CSS personnalisées */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --warning-gradient: linear-gradient(135deg, #ff9500 0%, #ff5e3a 100%);
    --dark-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    --light-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    --dark-shadow: 0 10px 30px rgba(15, 23, 42, 0.3);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Container principal */
.create-partner-container {
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
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="partnership" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white" opacity="0.1"/><circle cx="5" cy="15" r="1" fill="white" opacity="0.05"/><circle cx="15" cy="5" r="1" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23partnership)"/></svg>');
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
}

.create-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

/* Boutons stylisés */
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
    width: 28px;
    height: 28px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
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
}

.file-upload-container:hover {
    border-color: #667eea;
    background: #f0f4ff;
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

/* Zone d'intervention stylisée */
.intervention-zone {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.zone-tag {
    background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
    color: #0c4a6e;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    border: 1px solid #0ea5e9;
    display: flex;
    align-items: center;
    gap: 6px;
}

.zone-tag .remove-zone {
    color: #ef4444;
    cursor: pointer;
    font-weight: bold;
}

.zone-tag .remove-zone:hover {
    color: #dc2626;
}

/* Checkbox et radio stylisés */
.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.form-check-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
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
    .create-partner-container {
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

<div class="create-partner-container">
    <!-- Header -->
    <div class="create-header">
        <h1>🤝 Nouveau Partenaire Technique</h1>
        <p>Ajoutez un nouveau partenaire technique au réseau du CSAR</p>
        <div>
            <a href="{{ route('admin.technical-partners.index') }}" class="btn-secondary-cool">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="form-container">
        <form action="{{ route('admin.technical-partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Section: Informations générales -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">
                        <i class="fas fa-info-circle"></i>
                    </span>
                    Informations Générales
                </h3>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom du partenaire *</label>
                            <input type="text" class="form-control-cool @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Ex: ONG Action Humanitaire" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="organization" class="form-label">Organisation</label>
                            <input type="text" class="form-control-cool @error('organization') is-invalid @enderror" 
                                   id="organization" name="organization" value="{{ old('organization') }}" 
                                   placeholder="Nom complet de l'organisation">
                            @error('organization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">Rôle/Fonction</label>
                            <input type="text" class="form-control-cool @error('role') is-invalid @enderror" 
                                   id="role" name="role" value="{{ old('role') }}" 
                                   placeholder="Ex: Partenaire stratégique, Fournisseur, etc.">
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="type" class="form-label">Type de partenaire *</label>
                            <select class="select-cool @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">Sélectionner un type...</option>
                                <option value="ong" {{ old('type') == 'ong' ? 'selected' : '' }}>🤲 ONG</option>
                                <option value="agency" {{ old('type') == 'agency' ? 'selected' : '' }}>🏢 Agence</option>
                                <option value="institution" {{ old('type') == 'institution' ? 'selected' : '' }}>🏛️ Institution</option>
                                <option value="private" {{ old('type') == 'private' ? 'selected' : '' }}>💼 Privé</option>
                                <option value="government" {{ old('type') == 'government' ? 'selected' : '' }}>🏛️ Gouvernement</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Statut *</label>
                            <select class="select-cool @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>✅ Actif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>⏸️ Inactif</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="logo" class="form-label">Logo du partenaire</label>
                            <div class="file-upload-container">
                                <div class="file-upload-icon">
                                    <i class="fas fa-image"></i>
                                </div>
                                <div class="file-upload-text">
                                    <strong>Cliquez pour sélectionner</strong> ou glissez le logo
                                </div>
                                <input type="file" class="form-control-cool @error('logo') is-invalid @enderror" 
                                       id="logo" name="logo" accept="image/*" style="display: none;">
                                <small class="text-muted d-block mt-2">Formats : JPG, PNG. Taille max : 2 MB</small>
                            </div>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Contact -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">
                        <i class="fas fa-address-book"></i>
                    </span>
                    Informations de Contact
                </h3>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="contact_person" class="form-label">Responsable/Contact</label>
                            <input type="text" class="form-control-cool @error('contact_person') is-invalid @enderror" 
                                   id="contact_person" name="contact_person" value="{{ old('contact_person') }}" 
                                   placeholder="Nom du responsable">
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control-cool @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="contact@partenaire.org">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control-cool @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" 
                                   placeholder="+221 XX XXX XX XX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website" class="form-label">Site web</label>
                            <input type="url" class="form-control-cool @error('website') is-invalid @enderror" 
                                   id="website" name="website" value="{{ old('website') }}" 
                                   placeholder="https://www.partenaire.org">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Adresse</label>
                    <input type="text" class="form-control-cool @error('address') is-invalid @enderror" 
                           id="address" name="address" value="{{ old('address') }}" 
                           placeholder="Adresse complète du partenaire">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Section: Zone d'intervention -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </span>
                    Zone d'Intervention
                </h3>
                
                <div class="form-group">
                    <label for="intervention_zone_input" class="form-label">Zones d'intervention</label>
                    <input type="text" class="form-control-cool" 
                           id="intervention_zone_input" 
                           placeholder="Saisissez une région et appuyez sur Entrée">
                    <small class="text-muted">Tapez le nom d'une région et appuyez sur Entrée pour l'ajouter</small>
                    <div id="intervention_zones" class="intervention-zone">
                        <!-- Les zones seront ajoutées ici dynamiquement -->
                    </div>
                    <input type="hidden" name="intervention_zone" id="intervention_zone_hidden" value="{{ old('intervention_zone', '[]') }}">
                </div>
            </div>

            <!-- Section: Description -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">
                        <i class="fas fa-edit"></i>
                    </span>
                    Description du Partenariat
                </h3>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="textarea-cool @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="5" 
                              placeholder="Décrivez le partenaire, ses activités, et la nature du partenariat avec le CSAR...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="partnership_type" class="form-label">Type de partenariat</label>
                    <input type="text" class="form-control-cool @error('partnership_type') is-invalid @enderror" 
                           id="partnership_type" name="partnership_type" value="{{ old('partnership_type') }}" 
                           placeholder="Ex: Technique, Financier, Logistique, etc.">
                    @error('partnership_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Options avancées -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <span class="form-section-icon">
                        <i class="fas fa-cog"></i>
                    </span>
                    Options Avancées
                </h3>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <strong>⭐ Partenaire à la une</strong>
                                <br><small class="text-muted">Afficher ce partenaire en priorité sur le site public</small>
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="position" class="form-label">Position d'affichage</label>
                            <input type="number" class="form-control-cool @error('position') is-invalid @enderror" 
                                   id="position" name="position" value="{{ old('position', 100) }}" 
                                   placeholder="Ordre d'affichage (plus petit = priorité)">
                            <small class="text-muted">Les partenaires avec un numéro plus petit apparaissent en premier</small>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="action-buttons">
                <button type="submit" class="btn-primary-cool">
                    <i class="fas fa-save"></i>
                    Créer le Partenaire
                </button>
                <a href="{{ route('admin.technical-partners.index') }}" class="btn-secondary-form">
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
    let interventionZones = [];
    
    try {
        const oldZones = {!! old('intervention_zone', '[]') !!};
        if (Array.isArray(oldZones)) {
            interventionZones = oldZones;
            updateZoneDisplay();
        }
    } catch (e) {
        console.log('No old zones to restore');
    }
    
    // Gestion de l'upload de logo avec drag & drop
    const logoInput = $('#logo');
    const logoContainer = logoInput.closest('.file-upload-container');
    
    logoContainer.on('click', function(e) {
        if (e.target === this || $(e.target).hasClass('file-upload-text') || $(e.target).hasClass('file-upload-icon')) {
            logoInput.click();
        }
    });
    
    logoContainer.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });
    
    logoContainer.on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });
    
    logoContainer.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            logoInput[0].files = files;
            logoInput.trigger('change');
        }
    });
    
    // Prévisualisation du logo
    logoInput.on('change', function() {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#logo-preview').remove();
                
                const preview = $(`
                    <div id="logo-preview" class="mt-3">
                        <img src="${e.target.result}" class="img-thumbnail" style="max-height: 120px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    </div>
                `);
                logoContainer.after(preview);
            }
            reader.readAsDataURL(file);
            
            const fileName = file.name;
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            logoContainer.find('.file-upload-text').html(
                `<strong>✅ ${fileName}</strong><br><small>${fileSize} MB</small>`
            );
        }
    });
    
    // Gestion des zones d'intervention
    function addZone(zoneName) {
        if (zoneName.trim() && !interventionZones.includes(zoneName.trim())) {
            interventionZones.push(zoneName.trim());
            updateZoneDisplay();
            updateHiddenInput();
        }
    }
    
    function removeZone(zoneName) {
        interventionZones = interventionZones.filter(zone => zone !== zoneName);
        updateZoneDisplay();
        updateHiddenInput();
    }
    
    function updateZoneDisplay() {
        const container = $('#intervention_zones');
        container.empty();
        
        interventionZones.forEach(zone => {
            const tag = $(`
                <span class="zone-tag">
                    ${zone}
                    <span class="remove-zone" data-zone="${zone}">×</span>
                </span>
            `);
            container.append(tag);
        });
    }
    
    function updateHiddenInput() {
        $('#intervention_zone_hidden').val(JSON.stringify(interventionZones));
    }
    
    // Ajouter zone avec Entrée
    $('#intervention_zone_input').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            const zoneName = $(this).val();
            addZone(zoneName);
            $(this).val('');
        }
    });
    
    // Supprimer zone
    $(document).on('click', '.remove-zone', function() {
        const zoneName = $(this).data('zone');
        removeZone(zoneName);
    });
    
    // Validation du formulaire
    $('form').on('submit', function(e) {
        const name = $('#name').val().trim();
        const type = $('#type').val();
        const status = $('#status').val();
        
        if (!name || !type || !status) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires (*)');
            return false;
        }
        
        updateHiddenInput(); // S'assurer que les zones sont bien envoyées
    });
    
    // Auto-resize des textareas
    $('textarea').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Auto-génération du slug depuis le nom
    $('#name').on('input', function() {
        const name = $(this).val();
        // Optionnel: générer un slug automatiquement
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .trim();
        // On pourrait ajouter un champ slug si nécessaire
    });
});
</script>
@endpush
@endsection




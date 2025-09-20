@extends('layouts.admin')

@section('title', 'Modifier Partenaire Technique - Administration')

@section('content')
<style>
/* Utilisation des mêmes styles que la page de création */
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

.edit-partner-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.edit-header {
    background: var(--warning-gradient);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: var(--dark-shadow);
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
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="edit-pattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white" opacity="0.1"/><circle cx="5" cy="15" r="1" fill="white" opacity="0.05"/><circle cx="15" cy="5" r="1" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23edit-pattern)"/></svg>');
    opacity: 0.3;
    pointer-events: none;
}

.edit-header > * {
    position: relative;
    z-index: 2;
}

.edit-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.edit-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
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
    background: var(--warning-gradient);
}

.form-section {
    margin-bottom: 2.5rem;
    padding: 2rem;
    background: #f8fafc;
    border-radius: var(--border-radius);
    border-left: 4px solid #f59e0b;
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
    background: var(--warning-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

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
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    background: #fefbf7;
}

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
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

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
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

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
    border-color: #f59e0b;
    background: #fffbeb;
}

.current-logo {
    max-width: 200px;
    max-height: 150px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    margin-bottom: 1rem;
}

.btn-primary-cool {
    background: var(--warning-gradient);
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
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
}

.btn-primary-cool:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.6);
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

.action-buttons {
    display: flex;
    gap: 16px;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
    margin-top: 2rem;
}

.intervention-zone {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.zone-tag {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    border: 1px solid #f59e0b;
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

.edit-header {
    animation: fadeInUp 0.6s ease-out 0.1s both;
}
</style>

<div class="edit-partner-container">
    <!-- Header -->
    <div class="edit-header">
        <h1>
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 4H4C3.45 4 3 4.45 3 5V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V8L15 2H11V4Z" fill="currentColor" opacity="0.8"/>
                <path d="M15 2V8H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M7 14H17M7 10H12M7 18H17" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Modifier le Partenaire
        </h1>
        <p>Modification des informations de <strong>{{ $technicalPartner->name }}</strong></p>
        <div>
            <a href="{{ route('admin.technical-partners.index') }}" class="btn-secondary-cool">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="form-container">
        <form action="{{ route('admin.technical-partners.update', $technicalPartner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
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
                                   id="name" name="name" value="{{ old('name', $technicalPartner->name) }}" 
                                   placeholder="Ex: ONG Action Humanitaire" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="organization" class="form-label">Organisation</label>
                            <input type="text" class="form-control-cool @error('organization') is-invalid @enderror" 
                                   id="organization" name="organization" value="{{ old('organization', $technicalPartner->organization) }}" 
                                   placeholder="Nom complet de l'organisation">
                            @error('organization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">Rôle/Fonction</label>
                            <input type="text" class="form-control-cool @error('role') is-invalid @enderror" 
                                   id="role" name="role" value="{{ old('role', $technicalPartner->role) }}" 
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
                                <option value="ong" {{ old('type', $technicalPartner->type) == 'ong' ? 'selected' : '' }}>🤲 ONG</option>
                                <option value="agency" {{ old('type', $technicalPartner->type) == 'agency' ? 'selected' : '' }}>🏢 Agence</option>
                                <option value="institution" {{ old('type', $technicalPartner->type) == 'institution' ? 'selected' : '' }}>🏛️ Institution</option>
                                <option value="private" {{ old('type', $technicalPartner->type) == 'private' ? 'selected' : '' }}>💼 Privé</option>
                                <option value="government" {{ old('type', $technicalPartner->type) == 'government' ? 'selected' : '' }}>🏛️ Gouvernement</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Statut *</label>
                            <select class="select-cool @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="active" {{ old('status', $technicalPartner->status) == 'active' ? 'selected' : '' }}>✅ Actif</option>
                                <option value="inactive" {{ old('status', $technicalPartner->status) == 'inactive' ? 'selected' : '' }}>⏸️ Inactif</option>
                                <option value="pending" {{ old('status', $technicalPartner->status) == 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="logo" class="form-label">Logo du partenaire</label>
                            @if($technicalPartner->logo)
                                <div class="mb-3">
                                    <img src="{{ Storage::url($technicalPartner->logo) }}" alt="Logo actuel" class="current-logo">
                                    <br><small class="text-muted">Logo actuel - Sélectionnez un nouveau fichier pour le remplacer</small>
                                </div>
                            @endif
                            <div class="file-upload-container">
                                <div class="file-upload-icon">
                                    <i class="fas fa-image"></i>
                                </div>
                                <div class="file-upload-text">
                                    <strong>Cliquez pour sélectionner</strong> ou glissez le nouveau logo
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
                                   id="contact_person" name="contact_person" value="{{ old('contact_person', $technicalPartner->contact_person) }}" 
                                   placeholder="Nom du responsable">
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control-cool @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $technicalPartner->email) }}" 
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
                                   id="phone" name="phone" value="{{ old('phone', $technicalPartner->phone) }}" 
                                   placeholder="+221 XX XXX XX XX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website" class="form-label">Site web</label>
                            <input type="url" class="form-control-cool @error('website') is-invalid @enderror" 
                                   id="website" name="website" value="{{ old('website', $technicalPartner->website) }}" 
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
                           id="address" name="address" value="{{ old('address', $technicalPartner->address) }}" 
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
                        <!-- Les zones seront affichées ici -->
                    </div>
                    <input type="hidden" name="intervention_zone" id="intervention_zone_hidden" 
                           value="{{ old('intervention_zone', json_encode($technicalPartner->intervention_zone ?? [])) }}">
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
                              placeholder="Décrivez le partenaire, ses activités, et la nature du partenariat avec le CSAR...">{{ old('description', $technicalPartner->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="partnership_type" class="form-label">Type de partenariat</label>
                    <input type="text" class="form-control-cool @error('partnership_type') is-invalid @enderror" 
                           id="partnership_type" name="partnership_type" value="{{ old('partnership_type', $technicalPartner->partnership_type) }}" 
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
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $technicalPartner->is_featured) ? 'checked' : '' }}>
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
                                   id="position" name="position" value="{{ old('position', $technicalPartner->position) }}" 
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
                    Enregistrer les Modifications
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
    // Initialiser les zones d'intervention existantes
    let interventionZones = [];
    
    try {
        const existingZones = {!! json_encode($technicalPartner->intervention_zone ?? []) !!};
        if (Array.isArray(existingZones)) {
            interventionZones = existingZones;
            updateZoneDisplay();
        }
    } catch (e) {
        console.log('No existing zones');
    }
    
    // Fonctions pour gérer les zones
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
    
    // Gestion de l'upload de logo
    const logoInput = $('#logo');
    const logoContainer = logoInput.closest('.file-upload-container');
    
    logoContainer.on('click', function(e) {
        if (e.target === this || $(e.target).hasClass('file-upload-text') || $(e.target).hasClass('file-upload-icon')) {
            logoInput.click();
        }
    });
    
    logoInput.on('change', function() {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#logo-preview').remove();
                
                const preview = $(`
                    <div id="logo-preview" class="mt-3">
                        <img src="${e.target.result}" class="img-thumbnail" style="max-height: 120px; border-radius: 8px;">
                    </div>
                `);
                logoContainer.after(preview);
            }
            reader.readAsDataURL(file);
            
            const fileName = file.name;
            logoContainer.find('.file-upload-text').html(
                `<strong>✅ ${fileName}</strong><br><small>Nouveau logo sélectionné</small>`
            );
        }
    });
    
    // Validation du formulaire
    $('form').on('submit', function(e) {
        updateHiddenInput(); // S'assurer que les zones sont bien envoyées
    });
});
</script>
@endpush
@endsection
@extends('layouts.admin')

@section('title', 'Nouvelle Fiche Personnel - Interface Admin')

@section('content')
<div class="personnel-form-container fiche-personnel">
    <div class="form-wrapper">
        <!-- Header Section -->
        <div class="form-header">
            <div class="header-content">
                <div class="header-info">
                    <div class="header-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="header-text">
                        <h1>Nouvelle Fiche Personnel</h1>
                        <p>Renseignez les informations du personnel. Les champs marqués d'un <span class="required-mark">*</span> sont obligatoires.</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.personnel.index') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i>
                        <span>Retour à la liste</span>
                    </a>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.personnel.store') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            
            <!-- I. Informations personnelles -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="section-title">
                        <h2>I. Informations personnelles</h2>
                        <p>Données de base du personnel</p>
                    </div>
                </div>
                
                <div class="form-grid">
                    <!-- Photo de profil -->
                    <div class="photo-section">
                        <label class="form-label">Photo de profil</label>
                        <div class="photo-upload">
                            <div class="photo-preview">
                                <img id="photoPreview" src="https://ui-avatars.com/api/?name=Photo&background=059669&color=fff" alt="Aperçu">
                            </div>
                            <div class="photo-input">
                                <input type="file" id="photo_personnelle" name="photo_personnelle" accept="image/*" onchange="previewPhoto(event)">
                                <label for="photo_personnelle" class="file-label">
                                    <i class="fas fa-camera"></i>
                                    <span>Choisir une photo</span>
                                </label>
                            </div>
                            @error('photo_personnelle')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Informations personnelles -->
                    <div class="form-fields">
                        <div class="field-group">
                            <label for="prenoms_nom" class="form-label">Prénoms et Nom <span class="required-mark">*</span></label>
                            <input type="text" id="prenoms_nom" name="prenoms_nom" value="{{ old('prenoms_nom') }}" placeholder="Ex. Abdoulaye Ndiaye" required>
                            @error('prenoms_nom')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="date_naissance" class="form-label">Date de naissance <span class="required-mark">*</span></label>
                            <input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}" required>
                            @error('date_naissance')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="lieu_naissance" class="form-label">Lieu de naissance <span class="required-mark">*</span></label>
                            <input type="text" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance') }}" placeholder="Ville, pays" required>
                            @error('lieu_naissance')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="tranche_age" class="form-label">Tranche d'âge (18 - 60 ans) <span class="required-mark">*</span></label>
                            <select id="tranche_age" name="tranche_age" required>
                                <option value="">Sélectionner</option>
                                <option value="18-25" {{ old('tranche_age') == '18-25' ? 'selected' : '' }}>18 - 25 ans</option>
                                <option value="26-35" {{ old('tranche_age') == '26-35' ? 'selected' : '' }}>26 - 35 ans</option>
                                <option value="36-45" {{ old('tranche_age') == '36-45' ? 'selected' : '' }}>36 - 45 ans</option>
                                <option value="46-55" {{ old('tranche_age') == '46-55' ? 'selected' : '' }}>46 - 55 ans</option>
                                <option value="56-60" {{ old('tranche_age') == '56-60' ? 'selected' : '' }}>56 - 60 ans</option>
                            </select>
                            @error('tranche_age')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="nationalite" class="form-label">Nationalité <span class="required-mark">*</span></label>
                            <input type="text" id="nationalite" name="nationalite" value="{{ old('nationalite') }}" placeholder="Ex. Sénégalaise" required>
                            @error('nationalite')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="numero_cni" class="form-label">Numéro carte d'identité nationale <span class="required-mark">*</span></label>
                            <input type="text" id="numero_cni" name="numero_cni" value="{{ old('numero_cni') }}" placeholder="Ex. 1 234 567 890" required>
                            @error('numero_cni')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="sexe" class="form-label">Sexe <span class="required-mark">*</span></label>
                            <select id="sexe" name="sexe" required>
                                <option value="">Sélectionner</option>
                                <option value="Masculin" {{ old('sexe') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                <option value="Feminin" {{ old('sexe') == 'Feminin' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @error('sexe')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="situation_matrimoniale" class="form-label">Situation matrimoniale <span class="required-mark">*</span></label>
                            <select id="situation_matrimoniale" name="situation_matrimoniale" required>
                                <option value="">Sélectionner</option>
                                <option value="Celibataire" {{ old('situation_matrimoniale') == 'Celibataire' ? 'selected' : '' }}>Célibataire</option>
                                <option value="Marie" {{ old('situation_matrimoniale') == 'Marie' ? 'selected' : '' }}>Marié(e)</option>
                                <option value="Divorce" {{ old('situation_matrimoniale') == 'Divorce' ? 'selected' : '' }}>Divorcé(e)</option>
                                <option value="Veuf" {{ old('situation_matrimoniale') == 'Veuf' ? 'selected' : '' }}>Veuf</option>
                                <option value="Veuve" {{ old('situation_matrimoniale') == 'Veuve' ? 'selected' : '' }}>Veuve</option>
                            </select>
                            @error('situation_matrimoniale')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="nombre_enfants" class="form-label">Nombre d'enfants <span class="required-mark">*</span></label>
                            <select id="nombre_enfants" name="nombre_enfants" required>
                                @for($i = 0; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('nombre_enfants') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('nombre_enfants')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="contact_telephonique" class="form-label">Contact téléphonique <span class="required-mark">*</span></label>
                            <input type="tel" id="contact_telephonique" name="contact_telephonique" value="{{ old('contact_telephonique') }}" placeholder="Ex. +221 77 123 45 67" required>
                            @error('contact_telephonique')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="email" class="form-label">Email <span class="required-mark">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="exemple@csar.sn" required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label for="groupe_sanguin" class="form-label">Groupe sanguin <span class="required-mark">*</span></label>
                            <select id="groupe_sanguin" name="groupe_sanguin" required>
                                <option value="">Sélectionner</option>
                                <option value="A+" {{ old('groupe_sanguin') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('groupe_sanguin') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('groupe_sanguin') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('groupe_sanguin') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('groupe_sanguin') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('groupe_sanguin') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('groupe_sanguin') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('groupe_sanguin') == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                            @error('groupe_sanguin')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field-group full-width">
                            <label for="adresse_complete" class="form-label">Adresse complète <span class="required-mark">*</span></label>
                            <textarea id="adresse_complete" name="adresse_complete" rows="3" placeholder="Rue, quartier, ville" required>{{ old('adresse_complete') }}</textarea>
                            @error('adresse_complete')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                                                 </div>
                     </div>
                 </div>
             </div>

            <!-- II. Situation administrative -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="section-title">
                        <h2>II. Situation administrative</h2>
                        <p>Informations professionnelles</p>
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="field-group">
                        <label for="date_recrutement_csar" class="form-label">Date de recrutement au CSAR <span class="required-mark">*</span></label>
                        <input type="date" id="date_recrutement_csar" name="date_recrutement_csar" value="{{ old('date_recrutement_csar') }}" required>
                        @error('date_recrutement_csar')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="field-group">
                        <label for="date_prise_service_csar" class="form-label">Date prise de service au CSAR <span class="required-mark">*</span></label>
                        <input type="date" id="date_prise_service_csar" name="date_prise_service_csar" value="{{ old('date_prise_service_csar') }}" required>
                        @error('date_prise_service_csar')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="field-group">
                        <label for="statut" class="form-label">Statut <span class="required-mark">*</span></label>
                        <select id="statut" name="statut" required>
                            <option value="">Sélectionner</option>
                            <option value="Fonctionnaire" {{ old('statut') == 'Fonctionnaire' ? 'selected' : '' }}>Fonctionnaire</option>
                            <option value="Contractuel" {{ old('statut') == 'Contractuel' ? 'selected' : '' }}>Contractuel</option>
                            <option value="Stagiaire" {{ old('statut') == 'Stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                            <option value="Journalier" {{ old('statut') == 'Journalier' ? 'selected' : '' }}>Journalier</option>
                            <option value="Autre" {{ old('statut') == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('statut')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="field-group">
                        <label for="poste_actuel" class="form-label">Poste actuel <span class="required-mark">*</span></label>
                        <select id="poste_actuel" name="poste_actuel" required>
                            <option value="">Sélectionner</option>
                            <option value="Directeur Général" {{ old('poste_actuel') == 'Directeur Général' ? 'selected' : '' }}>Directeur Général</option>
                            <option value="Secrétaire général" {{ old('poste_actuel') == 'Secrétaire général' ? 'selected' : '' }}>Secrétaire général</option>
                            <option value="Directeur" {{ old('poste_actuel') == 'Directeur' ? 'selected' : '' }}>Directeur</option>
                            <option value="Agent Comptable" {{ old('poste_actuel') == 'Agent Comptable' ? 'selected' : '' }}>Agent Comptable</option>
                            <option value="Conseiller technique" {{ old('poste_actuel') == 'Conseiller technique' ? 'selected' : '' }}>Conseiller technique</option>
                            <option value="Chef de cellule" {{ old('poste_actuel') == 'Chef de cellule' ? 'selected' : '' }}>Chef de cellule</option>
                            <option value="Inspecteur régional" {{ old('poste_actuel') == 'Inspecteur régional' ? 'selected' : '' }}>Inspecteur régional</option>
                            <option value="Chef de division" {{ old('poste_actuel') == 'Chef de division' ? 'selected' : '' }}>Chef de division</option>
                            <option value="Adjoint inspecteur régional" {{ old('poste_actuel') == 'Adjoint inspecteur régional' ? 'selected' : '' }}>Adjoint inspecteur régional</option>
                            <option value="Comptable" {{ old('poste_actuel') == 'Comptable' ? 'selected' : '' }}>Comptable</option>
                            <option value="Comptable des Matières" {{ old('poste_actuel') == 'Comptable des Matières' ? 'selected' : '' }}>Comptable des Matières</option>
                            <option value="Chef de bureau" {{ old('poste_actuel') == 'Chef de bureau' ? 'selected' : '' }}>Chef de bureau</option>
                            <option value="Agent technique" {{ old('poste_actuel') == 'Agent technique' ? 'selected' : '' }}>Agent technique</option>
                            <option value="Agent administratif" {{ old('poste_actuel') == 'Agent administratif' ? 'selected' : '' }}>Agent administratif</option>
                            <option value="Assistante de direction" {{ old('poste_actuel') == 'Assistante de direction' ? 'selected' : '' }}>Assistante de direction</option>
                            <option value="Assistant administratif" {{ old('poste_actuel') == 'Assistant administratif' ? 'selected' : '' }}>Assistant administratif</option>
                            <option value="Secrétaire" {{ old('poste_actuel') == 'Secrétaire' ? 'selected' : '' }}>Secrétaire</option>
                            <option value="Magasinier" {{ old('poste_actuel') == 'Magasinier' ? 'selected' : '' }}>Magasinier</option>
                            <option value="Gérant de complexe" {{ old('poste_actuel') == 'Gérant de complexe' ? 'selected' : '' }}>Gérant de complexe</option>
                            <option value="Technicien supérieur" {{ old('poste_actuel') == 'Technicien supérieur' ? 'selected' : '' }}>Technicien supérieur</option>
                            <option value="Chauffeur" {{ old('poste_actuel') == 'Chauffeur' ? 'selected' : '' }}>Chauffeur</option>
                            <option value="Chef de parc" {{ old('poste_actuel') == 'Chef de parc' ? 'selected' : '' }}>Chef de parc</option>
                            <option value="Manœuvre" {{ old('poste_actuel') == 'Manœuvre' ? 'selected' : '' }}>Manœuvre</option>
                            <option value="Planton" {{ old('poste_actuel') == 'Planton' ? 'selected' : '' }}>Planton</option>
                            <option value="Coursier" {{ old('poste_actuel') == 'Coursier' ? 'selected' : '' }}>Coursier</option>
                            <option value="Technicien de surface" {{ old('poste_actuel') == 'Technicien de surface' ? 'selected' : '' }}>Technicien de surface</option>
                            <option value="Gardien" {{ old('poste_actuel') == 'Gardien' ? 'selected' : '' }}>Gardien</option>
                            <option value="Autre" {{ old('poste_actuel') == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('poste_actuel')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="field-group">
                        <label for="direction_service" class="form-label">Direction / Service d'affectation <span class="required-mark">*</span></label>
                        <select id="direction_service" name="direction_service" required>
                            <option value="">Sélectionner</option>
                            <option value="Conseil administration" {{ old('direction_service') == 'Conseil administration' ? 'selected' : '' }}>Conseil d'administration</option>
                            <option value="Direction Generale" {{ old('direction_service') == 'Direction Generale' ? 'selected' : '' }}>Direction Générale</option>
                            <option value="Secretariat general" {{ old('direction_service') == 'Secretariat general' ? 'selected' : '' }}>Secrétariat général</option>
                            <option value="DSAR" {{ old('direction_service') == 'DSAR' ? 'selected' : '' }}>DSAR</option>
                            <option value="DFC" {{ old('direction_service') == 'DFC' ? 'selected' : '' }}>DFC</option>
                            <option value="DPSE" {{ old('direction_service') == 'DPSE' ? 'selected' : '' }}>DPSE</option>
                            <option value="DRH" {{ old('direction_service') == 'DRH' ? 'selected' : '' }}>DRH</option>
                            <option value="DTL" {{ old('direction_service') == 'DTL' ? 'selected' : '' }}>DTL</option>
                            <option value="CCG" {{ old('direction_service') == 'CCG' ? 'selected' : '' }}>CCG</option>
                            <option value="CPM" {{ old('direction_service') == 'CPM' ? 'selected' : '' }}>CPM</option>
                            <option value="CI" {{ old('direction_service') == 'CI' ? 'selected' : '' }}>CI</option>
                            <option value="CIA" {{ old('direction_service') == 'CIA' ? 'selected' : '' }}>CIA</option>
                            <option value="AC" {{ old('direction_service') == 'AC' ? 'selected' : '' }}>AC</option>
                            <option value="IR" {{ old('direction_service') == 'IR' ? 'selected' : '' }}>IR</option>
                        </select>
                        @error('direction_service')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="field-group">
                        <label for="localisation_region" class="form-label">Localisation (si en région)</label>
                        <select id="localisation_region" name="localisation_region">
                            <option value="">Sélectionner</option>
                            <option value="Dakar" {{ old('localisation_region') == 'Dakar' ? 'selected' : '' }}>Dakar</option>
                            <option value="Thies" {{ old('localisation_region') == 'Thies' ? 'selected' : '' }}>Thies</option>
                            <option value="Diourbel" {{ old('localisation_region') == 'Diourbel' ? 'selected' : '' }}>Diourbel</option>
                            <option value="Fatick" {{ old('localisation_region') == 'Fatick' ? 'selected' : '' }}>Fatick</option>
                            <option value="Kaffrine" {{ old('localisation_region') == 'Kaffrine' ? 'selected' : '' }}>Kaffrine</option>
                            <option value="Matam" {{ old('localisation_region') == 'Matam' ? 'selected' : '' }}>Matam</option>
                            <option value="Kaolack" {{ old('localisation_region') == 'Kaolack' ? 'selected' : '' }}>Kaolack</option>
                            <option value="Kedougou" {{ old('localisation_region') == 'Kedougou' ? 'selected' : '' }}>Kedougou</option>
                            <option value="Louga" {{ old('localisation_region') == 'Louga' ? 'selected' : '' }}>Louga</option>
                            <option value="Saint-Louis" {{ old('localisation_region') == 'Saint-Louis' ? 'selected' : '' }}>Saint-Louis</option>
                            <option value="Tambacounda" {{ old('localisation_region') == 'Tambacounda' ? 'selected' : '' }}>Tambacounda</option>
                            <option value="Kolda Sedhiou" {{ old('localisation_region') == 'Kolda Sedhiou' ? 'selected' : '' }}>Kolda / Sédhiou</option>
                            <option value="Ziguinchor" {{ old('localisation_region') == 'Ziguinchor' ? 'selected' : '' }}>Ziguinchor</option>
                        </select>
                        @error('localisation_region')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                                         </div>
                 </div>
             </div>

            <!-- III. Parcours professionnel -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="section-title">
                        <h2>III. Parcours professionnel</h2>
                        <p>Expérience et formation</p>
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="field-group">
                        <label for="dernier_poste_avant_csar" class="form-label">Dernier poste occupé avant le CSAR</label>
                        <input type="text" id="dernier_poste_avant_csar" name="dernier_poste_avant_csar" value="{{ old('dernier_poste_avant_csar') }}" placeholder="Ex. Comptable à la DFC (2019-2024)">
                        @error('dernier_poste_avant_csar')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="field-group">
                        <label for="formations_professionnelles" class="form-label">Formations professionnelles suivies</label>
                        <textarea id="formations_professionnelles" name="formations_professionnelles" rows="3" placeholder="Formations suivies, années, organismes...">{{ old('formations_professionnelles') }}</textarea>
                        @error('formations_professionnelles')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                                                            <div class="field-group">
                                            <label for="diplome_academique" class="form-label">Diplômes académiques <span class="required-mark">*</span></label>
                                            <select id="diplome_academique" name="diplome_academique" required>
                                                <option value="">Sélectionner</option>
                                                <option value="Doctorat" {{ old('diplome_academique') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                                                <option value="Master" {{ old('diplome_academique') == 'Master' ? 'selected' : '' }}>Master</option>
                                                <option value="DESS" {{ old('diplome_academique') == 'DESS' ? 'selected' : '' }}>DESS</option>
                                                <option value="Maitrise" {{ old('diplome_academique') == 'Maitrise' ? 'selected' : '' }}>Maîtrise</option>
                                                <option value="Licence" {{ old('diplome_academique') == 'Licence' ? 'selected' : '' }}>Licence</option>
                                                <option value="DEUG" {{ old('diplome_academique') == 'DEUG' ? 'selected' : '' }}>DEUG</option>
                                                <option value="Baccalaureat" {{ old('diplome_academique') == 'Baccalaureat' ? 'selected' : '' }}>Baccalauréat</option>
                                                <option value="BFEM" {{ old('diplome_academique') == 'BFEM' ? 'selected' : '' }}>BFEM</option>
                                                <option value="CFEE" {{ old('diplome_academique') == 'CFEE' ? 'selected' : '' }}>CFEE</option>
                                                <option value="Sans diplome" {{ old('diplome_academique') == 'Sans diplome' ? 'selected' : '' }}>Sans diplôme</option>
                                                <option value="Autre" {{ old('diplome_academique') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                            </select>
                                            @error('diplome_academique')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="field-group">
                                            <label for="autres_diplomes_certifications" class="form-label">Autres diplômes et Certifications</label>
                                            <textarea id="autres_diplomes_certifications" name="autres_diplomes_certifications" rows="3" placeholder="Certifications, attestations, etc.">{{ old('autres_diplomes_certifications') }}</textarea>
                                            @error('autres_diplomes_certifications')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                </div>
            </div>

            <!-- IV. Compétences spécifiques -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="section-title">
                        <h2>IV. Compétences spécifiques</h2>
                        <p>Logiciels et langues</p>
                    </div>
                </div>
                
                <div class="form-grid">
                                                        <div class="field-group">
                                        <label class="form-label">Logiciels ou outils maîtrisés</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="logiciels_maitrises[]" value="PowerPoint" {{ in_array('PowerPoint', old('logiciels_maitrises', [])) ? 'checked' : '' }}>
                                                <span>PowerPoint</span>
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="logiciels_maitrises[]" value="Excel" {{ in_array('Excel', old('logiciels_maitrises', [])) ? 'checked' : '' }}>
                                                <span>Excel</span>
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="logiciels_maitrises[]" value="Word" {{ in_array('Word', old('logiciels_maitrises', [])) ? 'checked' : '' }}>
                                                <span>Word</span>
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="logiciels_maitrises[]" value="Programmation" {{ in_array('Programmation', old('logiciels_maitrises', [])) ? 'checked' : '' }}>
                                                <span>Programmation (C,C++,HTML,…)</span>
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="logiciels_maitrises[]" value="SAARI" {{ in_array('SAARI', old('logiciels_maitrises', [])) ? 'checked' : '' }}>
                                                <span>SAARI</span>
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="logiciels_maitrises[]" value="Autre" {{ in_array('Autre', old('logiciels_maitrises', [])) ? 'checked' : '' }}>
                                                <span>Autre</span>
                                            </label>
                                        </div>
                                        @error('logiciels_maitrises')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="field-group">
                                        <label class="form-label">Langues parlées / écrites</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="langues_parlees[]" value="Français" {{ in_array('Français', old('langues_parlees', [])) ? 'checked' : '' }}>
                                                <span>Français</span>
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="langues_parlees[]" value="Anglais" {{ in_array('Anglais', old('langues_parlees', [])) ? 'checked' : '' }}>
                                                <span>Anglais</span>
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="langues_parlees[]" value="Autre" {{ in_array('Autre', old('langues_parlees', [])) ? 'checked' : '' }}>
                                                <span>Autre</span>
                                            </label>
                                        </div>
                                        @error('langues_parlees')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="field-group full-width">
                                        <label for="autres_aptitudes" class="form-label">Autres aptitudes spécifiques</label>
                                        <textarea id="autres_aptitudes" name="autres_aptitudes" rows="3" placeholder="Compétences clés, outils, soft skills...">{{ old('autres_aptitudes') }}</textarea>
                                        @error('autres_aptitudes')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                </div>
            </div>

            <!-- V. Aspirations professionnelles -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="section-title">
                        <h2>V. Aspirations professionnelles</h2>
                        <p>Objectifs et ambitions</p>
                    </div>
                </div>
                
                <div class="form-grid">
                                                        <div class="field-group full-width">
                                        <label for="aspirations_professionnelles" class="form-label">Donnez plus de détails concernant vos aspirations professionnelles</label>
                                        <textarea id="aspirations_professionnelles" name="aspirations_professionnelles" rows="4" placeholder="Formation, Spécialisation, Mobilité...">{{ old('aspirations_professionnelles') }}</textarea>
                                        @error('aspirations_professionnelles')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="field-group">
                                        <label for="interet_nouvelles_responsabilites" class="form-label">Intérêt pour de nouvelles responsabilités <span class="required-mark">*</span></label>
                                        <select id="interet_nouvelles_responsabilites" name="interet_nouvelles_responsabilites" required>
                                            <option value="">Sélectionner</option>
                                            <option value="Oui" {{ old('interet_nouvelles_responsabilites') == 'Oui' ? 'selected' : '' }}>Oui</option>
                                            <option value="Non" {{ old('interet_nouvelles_responsabilites') == 'Non' ? 'selected' : '' }}>Non</option>
                                            <option value="Neutre" {{ old('interet_nouvelles_responsabilites') == 'Neutre' ? 'selected' : '' }}>Neutre</option>
                                        </select>
                                        @error('interet_nouvelles_responsabilites')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                </div>
            </div>

            <!-- VI. Informations complémentaires -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <div class="section-title">
                        <h2>VI. Informations complémentaires</h2>
                        <p>Détails vestimentaires</p>
                    </div>
                </div>
                
                <div class="form-grid">
                                                        <div class="field-group">
                                        <label for="taille_vetements" class="form-label">Taille Lacoste / T-shirts / Gilet <span class="required-mark">*</span></label>
                                        <select id="taille_vetements" name="taille_vetements" required>
                                            <option value="">Sélectionner</option>
                                            <option value="S" {{ old('taille_vetements') == 'S' ? 'selected' : '' }}>S</option>
                                            <option value="M" {{ old('taille_vetements') == 'M' ? 'selected' : '' }}>M</option>
                                            <option value="L" {{ old('taille_vetements') == 'L' ? 'selected' : '' }}>L</option>
                                            <option value="XL" {{ old('taille_vetements') == 'XL' ? 'selected' : '' }}>XL</option>
                                            <option value="XXL" {{ old('taille_vetements') == 'XXL' ? 'selected' : '' }}>XXL</option>
                                            <option value="XXXL" {{ old('taille_vetements') == 'XXXL' ? 'selected' : '' }}>XXXL</option>
                                            <option value="Autre" {{ old('taille_vetements') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                        </select>
                                        @error('taille_vetements')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                </div>
            </div>

            <!-- VIII. Notification d'urgence -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="section-title">
                        <h2>VIII. Notification d'urgence</h2>
                        <p>Contact en cas d'urgence</p>
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="field-group">
                        <label for="contact_urgence_nom" class="form-label">Prénom et Nom de la personne à contacter en cas d'urgence <span class="required-mark">*</span></label>
                        <input type="text" id="contact_urgence_nom" name="contact_urgence_nom" value="{{ old('contact_urgence_nom') }}" placeholder="Nom et prénom" required>
                        @error('contact_urgence_nom')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="field-group">
                        <label for="contact_urgence_telephone" class="form-label">Numéro téléphone de la personne à contacter en cas d'urgence <span class="required-mark">*</span></label>
                        <input type="tel" id="contact_urgence_telephone" name="contact_urgence_telephone" value="{{ old('contact_urgence_telephone') }}" placeholder="Ex. +221 76 987 65 43" required>
                        @error('contact_urgence_telephone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                                                        <div class="field-group">
                                        <label for="contact_urgence_lien_parente" class="form-label">Lien de parenté avec la personne <span class="required-mark">*</span></label>
                                        <input type="text" id="contact_urgence_lien_parente" name="contact_urgence_lien_parente" value="{{ old('contact_urgence_lien_parente') }}" placeholder="Ex. Conjoint(e), Frère/Soeur" required>
                                        @error('contact_urgence_lien_parente')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                </div>
            </div>

            <!-- IX. Observations personnelles -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-sticky-note"></i>
                    </div>
                    <div class="section-title">
                        <h2>IX. Observations personnelles</h2>
                        <p>Commentaires et précisions</p>
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="field-group full-width">
                        <label for="observations_personnelles" class="form-label">Commentaires ou précisions utiles</label>
                        <textarea id="observations_personnelles" name="observations_personnelles" rows="4" placeholder="Commentaires ou précisions utiles">{{ old('observations_personnelles') }}</textarea>
                        @error('observations_personnelles')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

             <!-- Actions -->
            <div class="form-actions">
                <div class="actions-content">
                    <a href="{{ route('admin.personnel.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        <span>Annuler</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        <span>Créer la fiche</span>
                    </button>
                </div>
            </div>
                 </form>
     </div>
 </div>

<style>
/* Variables CSS */
:root {
    --csar-green: #059669;
    --csar-green-dark: #047857;
    --csar-green-light: #10b981;
    --csar-text: #1f2937;
    --csar-text-light: #6b7280;
    --csar-border: #e5e7eb;
    --csar-bg: #f8fafc;
    --csar-white: #ffffff;
    --csar-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --csar-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

                /* Police Times New Roman avec taille améliorée */
                .fiche-personnel * {
                    font-family: 'Times New Roman', Times, serif;
                    font-size: 16px;
                }

/* Container principal */
.personnel-form-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
    padding: 2rem 0;
}

.form-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Header moderne */
.form-header {
    background: var(--csar-white);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--csar-shadow);
    border: 1px solid var(--csar-border);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.header-info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--csar-green), var(--csar-green-light));
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

                .header-text h1 {
                    font-size: 2.5rem;
                    font-weight: 700;
                    color: var(--csar-text);
                    margin-bottom: 0.5rem;
                }

                .header-text p {
                    color: var(--csar-text-light);
                    font-size: 1.1rem;
                    margin: 0;
                }

.required-mark {
    color: var(--csar-green);
    font-weight: 700;
}

/* Boutons */
                .btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                    padding: 1rem 2rem;
                    border-radius: 12px;
                    font-weight: 600;
                    font-size: 1.1rem;
                    text-decoration: none;
                    border: none;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

.btn-outline {
    background: transparent;
    color: var(--csar-green);
    border: 2px solid var(--csar-green);
}

.btn-outline:hover {
    background: var(--csar-green);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.btn-primary {
    background: linear-gradient(135deg, var(--csar-green), var(--csar-green-light));
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--csar-green-dark), var(--csar-green));
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.4);
}

.btn-secondary {
    background: var(--csar-text-light);
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

/* Sections du formulaire */
.form-section {
    background: var(--csar-white);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--csar-shadow);
    border: 1px solid var(--csar-border);
    transition: all 0.3s ease;
}

.form-section:hover {
    box-shadow: var(--csar-shadow-lg);
    transform: translateY(-2px);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--csar-border);
}

.section-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--csar-green), var(--csar-green-light));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

                .section-title h2 {
                    font-size: 1.8rem;
                    font-weight: 700;
                    color: var(--csar-text);
                    margin-bottom: 0.25rem;
                }

                .section-title p {
                    color: var(--csar-text-light);
                    font-size: 1.05rem;
                    margin: 0;
                }

/* Grille du formulaire */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 2rem;
    align-items: start;
}

/* Section photo */
.photo-section {
    text-align: center;
}

.photo-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.photo-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid var(--csar-border);
    box-shadow: var(--csar-shadow);
    background: var(--csar-bg);
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-input {
    position: relative;
}

.photo-input input[type="file"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.file-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--csar-green);
    color: white;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(5, 150, 105, 0.3);
}

.file-label:hover {
    background: var(--csar-green-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.4);
}

/* Champs du formulaire */
.form-fields {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.field-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.field-group.full-width {
    grid-column: 1 / -1;
}

                .form-label {
                    font-weight: 600;
                    color: var(--csar-text);
                    font-size: 1.1rem;
                }

                .form-label input,
                .form-label select,
                .form-label textarea {
                    padding: 1rem 1.25rem;
                    border: 2px solid var(--csar-border);
                    border-radius: 12px;
                    font-size: 1rem;
                    transition: all 0.3s ease;
                    background: var(--csar-white);
                }

.form-label input:focus,
.form-label select:focus,
.form-label textarea:focus {
    outline: none;
    border-color: var(--csar-green);
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    transform: translateY(-1px);
}

.form-label textarea {
    resize: vertical;
    min-height: 100px;
}

/* Messages d'erreur */
.error-message {
    color: #dc2626;
    font-size: 0.8rem;
    margin-top: 0.25rem;
    font-weight: 500;
}

/* Actions du formulaire */
.form-actions {
    background: var(--csar-white);
    border-radius: 20px;
    padding: 1.5rem 2rem;
    margin-top: 2rem;
    box-shadow: var(--csar-shadow);
    border: 1px solid var(--csar-border);
}

.actions-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

/* Checkboxes */
.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.checkbox-item:hover {
    background: rgba(5, 150, 105, 0.05);
}

.checkbox-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--csar-green);
    cursor: pointer;
}

                .checkbox-item span {
                    font-weight: 500;
                    color: var(--csar-text);
                    font-size: 1rem;
                }

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .actions-content {
        flex-direction: column;
    }
    
    .form-wrapper {
        padding: 0 0.5rem;
    }
    
    .form-header,
    .form-section {
        padding: 1.5rem;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-section {
    animation: fadeInUp 0.6s ease-out;
}

.form-section:nth-child(2) {
    animation-delay: 0.1s;
}

.form-section:nth-child(3) {
    animation-delay: 0.2s;
}
</style>

<script>
function previewPhoto(event) {
    const input = event.target;
    const preview = document.getElementById('photoPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.borderColor = '#059669';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = 'https://ui-avatars.com/api/?name=Photo&background=059669&color=fff';
        preview.style.borderColor = '#e5e7eb';
    }
}

// Animation des champs au focus
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection

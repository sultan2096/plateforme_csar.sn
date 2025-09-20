@extends('layouts.admin')

@section('title', 'Modifier Fiche Personnel - Interface Admin')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4 w-100" style="max-width: 900px; border-radius: 18px;">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <h2 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>Modifier Fiche Personnel</h2>
            <a href="{{ route('admin.personnel.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>
        <form method="POST" action="{{ route('admin.personnel.update', $personnel) }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('PUT')
            
            <!-- I. Informations personnelles -->
            <div class="form-section">
                <h2><i class="fas fa-user"></i> I. Informations personnelles</h2>
                <div class="form-grid" style="align-items: flex-start;">
                    <!-- Photo de profil -->
                    <div class="form-group" style="max-width:220px;min-width:180px;text-align:center;">
                        <label for="photo_personnelle" style="font-weight:600;">Photo de profil</label>
                        <div style="margin-bottom:10px;">
                            <img id="photoPreview" src="{{ $personnel->photo_url }}" data-default="{{ $personnel->photo_url }}" alt="Aperçu" style="width:110px;height:110px;border-radius:12px;object-fit:cover;border:2px solid #e5e7eb;box-shadow:0 1px 4px #0001;">
                        </div>
                        <input type="file" id="photo_personnelle" name="photo_personnelle" accept="image/*" onchange="previewPhoto(event)" style="padding:8px 0;">
                        @error('photo_personnelle')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Infos personnelles (suite du grid) -->
                    <div class="form-group">
                        <label for="prenoms_nom">Prénoms et Nom *</label>
                        <input type="text" id="prenoms_nom" name="prenoms_nom" value="{{ old('prenoms_nom', $personnel->prenoms_nom) }}" required>
                        @error('prenoms_nom')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_naissance">Date de naissance *</label>
                        <input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $personnel->date_naissance->format('Y-m-d')) }}" required>
                        @error('date_naissance')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lieu_naissance">Lieu de naissance *</label>
                        <input type="text" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $personnel->lieu_naissance) }}" required>
                        @error('lieu_naissance')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tranche_age">Tranche d'âge (18 - 60 ans) *</label>
                        <select id="tranche_age" name="tranche_age" required>
                            <option value="">Sélectionner</option>
                            <option value="18-25" {{ old('tranche_age', $personnel->tranche_age) == '18-25' ? 'selected' : '' }}>18 - 25 ans</option>
                            <option value="26-35" {{ old('tranche_age', $personnel->tranche_age) == '26-35' ? 'selected' : '' }}>26 - 35 ans</option>
                            <option value="36-45" {{ old('tranche_age', $personnel->tranche_age) == '36-45' ? 'selected' : '' }}>36 - 45 ans</option>
                            <option value="46-55" {{ old('tranche_age', $personnel->tranche_age) == '46-55' ? 'selected' : '' }}>46 - 55 ans</option>
                            <option value="56-60" {{ old('tranche_age', $personnel->tranche_age) == '56-60' ? 'selected' : '' }}>56 - 60 ans</option>
                        </select>
                        @error('tranche_age')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nationalite">Nationalité *</label>
                        <input type="text" id="nationalite" name="nationalite" value="{{ old('nationalite', $personnel->nationalite) }}" required>
                        @error('nationalite')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="numero_cni">Numéro carte d'identité nationale *</label>
                        <input type="text" id="numero_cni" name="numero_cni" value="{{ old('numero_cni', $personnel->numero_cni) }}" required>
                        @error('numero_cni')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sexe">Sexe *</label>
                        <select id="sexe" name="sexe" required>
                            <option value="">Sélectionner</option>
                            <option value="Masculin" {{ old('sexe', $personnel->sexe) == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                            <option value="Féminin" {{ old('sexe', $personnel->sexe) == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                        </select>
                        @error('sexe')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="situation_matrimoniale">Situation matrimoniale *</label>
                        <select id="situation_matrimoniale" name="situation_matrimoniale" required>
                            <option value="">Sélectionner</option>
                            <option value="Celibataire" {{ old('situation_matrimoniale', $personnel->situation_matrimoniale) == 'Celibataire' ? 'selected' : '' }}>Célibataire</option>
                            <option value="Marie" {{ old('situation_matrimoniale', $personnel->situation_matrimoniale) == 'Marie' ? 'selected' : '' }}>Marié(e)</option>
                            <option value="Divorce" {{ old('situation_matrimoniale', $personnel->situation_matrimoniale) == 'Divorce' ? 'selected' : '' }}>Divorcé(e)</option>
                            <option value="Veuf" {{ old('situation_matrimoniale', $personnel->situation_matrimoniale) == 'Veuf' ? 'selected' : '' }}>Veuf</option>
                            <option value="Veuve" {{ old('situation_matrimoniale', $personnel->situation_matrimoniale) == 'Veuve' ? 'selected' : '' }}>Veuve</option>
                        </select>
                        @error('situation_matrimoniale')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre_enfants">Nombre d'enfants *</label>
                        <select id="nombre_enfants" name="nombre_enfants" required>
                            @for($i = 0; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('nombre_enfants', $personnel->nombre_enfants) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('nombre_enfants')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_telephonique">Contact téléphonique *</label>
                        <input type="tel" id="contact_telephonique" name="contact_telephonique" value="{{ old('contact_telephonique', $personnel->contact_telephonique) }}" required>
                        @error('contact_telephonique')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $personnel->email) }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="groupe_sanguin">Groupe sanguin *</label>
                        <select id="groupe_sanguin" name="groupe_sanguin" required>
                            <option value="">Sélectionner</option>
                            <option value="A+" {{ old('groupe_sanguin', $personnel->groupe_sanguin) == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('groupe_sanguin', $personnel->groupe_sanguin) == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('groupe_sanguin', $personnel->groupe_sanguin) == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('groupe_sanguin', $personnel->groupe_sanguin) == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('groupe_sanguin', $personnel->groupe_sanguin) == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('groupe_sanguin', $personnel->groupe_sanguin) == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('groupe_sanguin', $personnel->groupe_sanguin) == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('groupe_sanguin', $personnel->groupe_sanguin) == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                        @error('groupe_sanguin')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="adresse_complete">Adresse complète *</label>
                        <textarea id="adresse_complete" name="adresse_complete" rows="3" required>{{ old('adresse_complete', $personnel->adresse_complete) }}</textarea>
                        @error('adresse_complete')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- II. Situation administrative -->
            <div class="form-section">
                <h2><i class="fas fa-briefcase"></i> II. Situation administrative</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="date_recrutement_csar">Date de recrutement au CSAR *</label>
                        <input type="date" id="date_recrutement_csar" name="date_recrutement_csar" value="{{ old('date_recrutement_csar', $personnel->date_recrutement_csar->format('Y-m-d')) }}" required>
                        @error('date_recrutement_csar')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_prise_service_csar">Date prise de service au CSAR *</label>
                        <input type="date" id="date_prise_service_csar" name="date_prise_service_csar" value="{{ old('date_prise_service_csar', $personnel->date_prise_service_csar->format('Y-m-d')) }}" required>
                        @error('date_prise_service_csar')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="statut">Statut *</label>
                        <select id="statut" name="statut" required>
                            <option value="">Sélectionner</option>
                            <option value="Fonctionnaire" {{ old('statut', $personnel->statut) == 'Fonctionnaire' ? 'selected' : '' }}>Fonctionnaire</option>
                            <option value="Contractuel" {{ old('statut', $personnel->statut) == 'Contractuel' ? 'selected' : '' }}>Contractuel</option>
                            <option value="Stagiaire" {{ old('statut', $personnel->statut) == 'Stagiaire' ? 'selected' : '' }}>Stagiaire</option>
                            <option value="Journalier" {{ old('statut', $personnel->statut) == 'Journalier' ? 'selected' : '' }}>Journalier</option>
                            <option value="Autre" {{ old('statut', $personnel->statut) == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('statut')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="poste_actuel">Poste actuel *</label>
                        <select id="poste_actuel" name="poste_actuel" required>
                            <option value="">Sélectionner</option>
                            <option value="Directeur Général" {{ old('poste_actuel', $personnel->poste_actuel) == 'Directeur Général' ? 'selected' : '' }}>Directeur Général</option>
                            <option value="Secrétaire général" {{ old('poste_actuel', $personnel->poste_actuel) == 'Secrétaire général' ? 'selected' : '' }}>Secrétaire général</option>
                            <option value="Directeur" {{ old('poste_actuel', $personnel->poste_actuel) == 'Directeur' ? 'selected' : '' }}>Directeur</option>
                            <option value="Agent Comptable" {{ old('poste_actuel', $personnel->poste_actuel) == 'Agent Comptable' ? 'selected' : '' }}>Agent Comptable</option>
                            <option value="Conseiller technique" {{ old('poste_actuel', $personnel->poste_actuel) == 'Conseiller technique' ? 'selected' : '' }}>Conseiller technique</option>
                            <option value="Chef de cellule" {{ old('poste_actuel', $personnel->poste_actuel) == 'Chef de cellule' ? 'selected' : '' }}>Chef de cellule</option>
                            <option value="Inspecteur régional" {{ old('poste_actuel', $personnel->poste_actuel) == 'Inspecteur régional' ? 'selected' : '' }}>Inspecteur régional</option>
                            <option value="Chef de division" {{ old('poste_actuel', $personnel->poste_actuel) == 'Chef de division' ? 'selected' : '' }}>Chef de division</option>
                            <option value="Adjoint inspecteur régional" {{ old('poste_actuel', $personnel->poste_actuel) == 'Adjoint inspecteur régional' ? 'selected' : '' }}>Adjoint inspecteur régional</option>
                            <option value="Comptable" {{ old('poste_actuel', $personnel->poste_actuel) == 'Comptable' ? 'selected' : '' }}>Comptable</option>
                            <option value="Comptable des Matières" {{ old('poste_actuel', $personnel->poste_actuel) == 'Comptable des Matières' ? 'selected' : '' }}>Comptable des Matières</option>
                            <option value="Chef de bureau" {{ old('poste_actuel', $personnel->poste_actuel) == 'Chef de bureau' ? 'selected' : '' }}>Chef de bureau</option>
                            <option value="Agent technique" {{ old('poste_actuel', $personnel->poste_actuel) == 'Agent technique' ? 'selected' : '' }}>Agent technique</option>
                            <option value="Agent administratif" {{ old('poste_actuel', $personnel->poste_actuel) == 'Agent administratif' ? 'selected' : '' }}>Agent administratif</option>
                            <option value="Assistante de direction" {{ old('poste_actuel', $personnel->poste_actuel) == 'Assistante de direction' ? 'selected' : '' }}>Assistante de direction</option>
                            <option value="Assistant administratif" {{ old('poste_actuel', $personnel->poste_actuel) == 'Assistant administratif' ? 'selected' : '' }}>Assistant administratif</option>
                            <option value="Secrétaire" {{ old('poste_actuel', $personnel->poste_actuel) == 'Secrétaire' ? 'selected' : '' }}>Secrétaire</option>
                            <option value="Magasinier" {{ old('poste_actuel', $personnel->poste_actuel) == 'Magasinier' ? 'selected' : '' }}>Magasinier</option>
                            <option value="Gérant de complexe" {{ old('poste_actuel', $personnel->poste_actuel) == 'Gérant de complexe' ? 'selected' : '' }}>Gérant de complexe</option>
                            <option value="Technicien supérieur" {{ old('poste_actuel', $personnel->poste_actuel) == 'Technicien supérieur' ? 'selected' : '' }}>Technicien supérieur</option>
                            <option value="Chauffeur" {{ old('poste_actuel', $personnel->poste_actuel) == 'Chauffeur' ? 'selected' : '' }}>Chauffeur</option>
                            <option value="Chef de parc" {{ old('poste_actuel', $personnel->poste_actuel) == 'Chef de parc' ? 'selected' : '' }}>Chef de parc</option>
                            <option value="Manœuvre" {{ old('poste_actuel', $personnel->poste_actuel) == 'Manœuvre' ? 'selected' : '' }}>Manœuvre</option>
                            <option value="Planton" {{ old('poste_actuel', $personnel->poste_actuel) == 'Planton' ? 'selected' : '' }}>Planton</option>
                            <option value="Coursier" {{ old('poste_actuel', $personnel->poste_actuel) == 'Coursier' ? 'selected' : '' }}>Coursier</option>
                            <option value="Technicien de surface" {{ old('poste_actuel', $personnel->poste_actuel) == 'Technicien de surface' ? 'selected' : '' }}>Technicien de surface</option>
                            <option value="Gardien" {{ old('poste_actuel', $personnel->poste_actuel) == 'Gardien' ? 'selected' : '' }}>Gardien</option>
                            <option value="Autre" {{ old('poste_actuel', $personnel->poste_actuel) == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('poste_actuel')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="direction_service">Direction / Service d'affectation *</label>
                        <select id="direction_service" name="direction_service" required>
                            <option value="">Sélectionner</option>
                            <option value="Conseil administration" {{ old('direction_service', $personnel->direction_service) == 'Conseil administration' ? 'selected' : '' }}>Conseil d'administration</option>
                            <option value="Direction Generale" {{ old('direction_service', $personnel->direction_service) == 'Direction Generale' ? 'selected' : '' }}>Direction Générale</option>
                            <option value="Secretariat general" {{ old('direction_service', $personnel->direction_service) == 'Secretariat general' ? 'selected' : '' }}>Secrétariat général</option>
                            <option value="DSAR" {{ old('direction_service', $personnel->direction_service) == 'DSAR' ? 'selected' : '' }}>DSAR</option>
                            <option value="DFC" {{ old('direction_service', $personnel->direction_service) == 'DFC' ? 'selected' : '' }}>DFC</option>
                            <option value="DPSE" {{ old('direction_service', $personnel->direction_service) == 'DPSE' ? 'selected' : '' }}>DPSE</option>
                            <option value="DRH" {{ old('direction_service', $personnel->direction_service) == 'DRH' ? 'selected' : '' }}>DRH</option>
                            <option value="DTL" {{ old('direction_service', $personnel->direction_service) == 'DTL' ? 'selected' : '' }}>DTL</option>
                            <option value="CCG" {{ old('direction_service', $personnel->direction_service) == 'CCG' ? 'selected' : '' }}>CCG</option>
                            <option value="CPM" {{ old('direction_service', $personnel->direction_service) == 'CPM' ? 'selected' : '' }}>CPM</option>
                            <option value="CI" {{ old('direction_service', $personnel->direction_service) == 'CI' ? 'selected' : '' }}>CI</option>
                            <option value="CIA" {{ old('direction_service', $personnel->direction_service) == 'CIA' ? 'selected' : '' }}>CIA</option>
                            <option value="AC" {{ old('direction_service', $personnel->direction_service) == 'AC' ? 'selected' : '' }}>AC</option>
                            <option value="IR" {{ old('direction_service', $personnel->direction_service) == 'IR' ? 'selected' : '' }}>IR</option>
                        </select>
                        @error('direction_service')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="localisation_region">Localisation (si en région)</label>
                        <select id="localisation_region" name="localisation_region">
                            <option value="">Sélectionner</option>
                            <option value="Dakar" {{ old('localisation_region', $personnel->localisation_region) == 'Dakar' ? 'selected' : '' }}>Dakar</option>
                            <option value="Thies" {{ old('localisation_region', $personnel->localisation_region) == 'Thies' ? 'selected' : '' }}>Thies</option>
                            <option value="Diourbel" {{ old('localisation_region', $personnel->localisation_region) == 'Diourbel' ? 'selected' : '' }}>Diourbel</option>
                            <option value="Fatick" {{ old('localisation_region', $personnel->localisation_region) == 'Fatick' ? 'selected' : '' }}>Fatick</option>
                            <option value="Kaffrine" {{ old('localisation_region', $personnel->localisation_region) == 'Kaffrine' ? 'selected' : '' }}>Kaffrine</option>
                            <option value="Matam" {{ old('localisation_region', $personnel->localisation_region) == 'Matam' ? 'selected' : '' }}>Matam</option>
                            <option value="Kaolack" {{ old('localisation_region', $personnel->localisation_region) == 'Kaolack' ? 'selected' : '' }}>Kaolack</option>
                            <option value="Kedougou" {{ old('localisation_region', $personnel->localisation_region) == 'Kedougou' ? 'selected' : '' }}>Kedougou</option>
                            <option value="Louga" {{ old('localisation_region', $personnel->localisation_region) == 'Louga' ? 'selected' : '' }}>Louga</option>
                            <option value="Saint-Louis" {{ old('localisation_region', $personnel->localisation_region) == 'Saint-Louis' ? 'selected' : '' }}>Saint-Louis</option>
                            <option value="Tambacounda" {{ old('localisation_region', $personnel->localisation_region) == 'Tambacounda' ? 'selected' : '' }}>Tambacounda</option>
                            <option value="Kolda Sedhiou" {{ old('localisation_region', $personnel->localisation_region) == 'Kolda Sedhiou' ? 'selected' : '' }}>Kolda / Sedhiou</option>
                            <option value="Ziguinchor" {{ old('localisation_region', $personnel->localisation_region) == 'Ziguinchor' ? 'selected' : '' }}>Ziguinchor</option>
                        </select>
                        @error('localisation_region')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
                <a href="{{ route('admin.personnel.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.admin-content {
    padding: 20px;
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.personnel-form {
    max-width: 1200px;
    margin: 0 auto;
}

.form-section {
    background: white;
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-section h2 {
    color: #22c55e;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    font-weight: 500;
    margin-bottom: 8px;
    color: #374151;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

.error-message {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 30px;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-primary {
    background: #22c55e;
    color: white;
}

.btn-primary:hover {
    background: #16a34a;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
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
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = preview.getAttribute('data-default');
    }
}
</script>
@endsection 
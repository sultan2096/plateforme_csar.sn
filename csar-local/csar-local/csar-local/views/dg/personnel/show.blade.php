@extends('layouts.dg')

@section('title', 'Détails Personnel - Interface DG')

@section('content')
<div class="dg-content">
    <div class="content-header">
        <h1><i class="fas fa-user"></i> Détails du Personnel</h1>
        <div class="header-actions">
            <a href="{{ route('dg.personnel.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="content-body">
        <div class="personnel-details">
            <!-- En-tête avec photo et informations principales -->
            <div class="personnel-header">
                <div class="personnel-photo">
                    <img src="{{ $personnel->photo_url }}" alt="Photo de {{ $personnel->prenoms_nom }}" 
                         onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                </div>
                <div class="personnel-main-info">
                    <h2>{{ $personnel->prenoms_nom }}</h2>
                    <p class="matricule">{{ $personnel->matricule }}</p>
                    <p class="poste">{{ $personnel->poste_actuel }}</p>
                    <p class="direction">{{ $personnel->direction_service }}</p>
                    <div class="status-badge status-{{ strtolower(str_replace(' ', '-', $personnel->statut_validation)) }}">
                        {{ $personnel->statut_validation }}
                    </div>
                </div>
            </div>

            <!-- Sections d'informations -->
            <div class="info-sections">
                <!-- I. Informations personnelles -->
                <div class="info-section">
                    <h3><i class="fas fa-user"></i> I. Informations personnelles</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Date de naissance</label>
                            <span>{{ $personnel->date_naissance->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <label>Lieu de naissance</label>
                            <span>{{ $personnel->lieu_naissance }}</span>
                        </div>
                        <div class="info-item">
                            <label>Tranche d'âge</label>
                            <span>{{ $personnel->tranche_age }} ans</span>
                        </div>
                        <div class="info-item">
                            <label>Nationalité</label>
                            <span>{{ $personnel->nationalite }}</span>
                        </div>
                        <div class="info-item">
                            <label>Numéro CNI</label>
                            <span>{{ $personnel->numero_cni }}</span>
                        </div>
                        <div class="info-item">
                            <label>Sexe</label>
                            <span>{{ $personnel->sexe }}</span>
                        </div>
                        <div class="info-item">
                            <label>Situation matrimoniale</label>
                            <span>{{ $personnel->situation_matrimoniale }}</span>
                        </div>
                        <div class="info-item">
                            <label>Nombre d'enfants</label>
                            <span>{{ $personnel->nombre_enfants }}</span>
                        </div>
                        <div class="info-item">
                            <label>Contact téléphonique</label>
                            <span>{{ $personnel->contact_telephonique }}</span>
                        </div>
                        <div class="info-item">
                            <label>Email</label>
                            <span>{{ $personnel->email }}</span>
                        </div>
                        <div class="info-item">
                            <label>Groupe sanguin</label>
                            <span>{{ $personnel->groupe_sanguin }}</span>
                        </div>
                        <div class="info-item full-width">
                            <label>Adresse complète</label>
                            <span>{{ $personnel->adresse_complete }}</span>
                        </div>
                    </div>
                </div>

                <!-- II. Situation administrative -->
                <div class="info-section">
                    <h3><i class="fas fa-briefcase"></i> II. Situation administrative</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Date de recrutement</label>
                            <span>{{ $personnel->date_recrutement_csar->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <label>Date de prise de service</label>
                            <span>{{ $personnel->date_prise_service_csar->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <label>Statut</label>
                            <span>{{ $personnel->statut }}</span>
                        </div>
                        <div class="info-item">
                            <label>Poste actuel</label>
                            <span>{{ $personnel->poste_actuel }}</span>
                        </div>
                        <div class="info-item">
                            <label>Direction/Service</label>
                            <span>{{ $personnel->direction_service }}</span>
                        </div>
                        @if($personnel->localisation_region)
                        <div class="info-item">
                            <label>Localisation</label>
                            <span>{{ $personnel->localisation_region }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- III. Parcours professionnel -->
                <div class="info-section">
                    <h3><i class="fas fa-graduation-cap"></i> III. Parcours professionnel</h3>
                    <div class="info-grid">
                        @if($personnel->dernier_poste_avant_csar)
                        <div class="info-item full-width">
                            <label>Dernier poste avant CSAR</label>
                            <span>{{ $personnel->dernier_poste_avant_csar }}</span>
                        </div>
                        @endif
                        @if($personnel->formations_professionnelles)
                        <div class="info-item full-width">
                            <label>Formations professionnelles</label>
                            <span>{{ $personnel->formations_professionnelles }}</span>
                        </div>
                        @endif
                        <div class="info-item">
                            <label>Diplôme académique</label>
                            <span>{{ $personnel->diplome_academique }}</span>
                        </div>
                        @if($personnel->autres_diplomes_certifications)
                        <div class="info-item full-width">
                            <label>Autres diplômes</label>
                            <span>{{ $personnel->autres_diplomes_certifications }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- IV. Compétences spécifiques -->
                <div class="info-section">
                    <h3><i class="fas fa-tools"></i> IV. Compétences spécifiques</h3>
                    <div class="info-grid">
                        @if($personnel->logiciels_maitrises)
                        <div class="info-item full-width">
                            <label>Logiciels maîtrisés</label>
                            <span>{{ implode(', ', $personnel->logiciels_maitrises) }}</span>
                        </div>
                        @endif
                        @if($personnel->langues_parlees)
                        <div class="info-item full-width">
                            <label>Langues parlées</label>
                            <span>{{ implode(', ', $personnel->langues_parlees) }}</span>
                        </div>
                        @endif
                        @if($personnel->autres_aptitudes)
                        <div class="info-item full-width">
                            <label>Autres aptitudes</label>
                            <span>{{ $personnel->autres_aptitudes }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- V. Aspirations professionnelles -->
                <div class="info-section">
                    <h3><i class="fas fa-chart-line"></i> V. Aspirations professionnelles</h3>
                    <div class="info-grid">
                        @if($personnel->aspirations_professionnelles)
                        <div class="info-item full-width">
                            <label>Aspirations professionnelles</label>
                            <span>{{ $personnel->aspirations_professionnelles }}</span>
                        </div>
                        @endif
                        <div class="info-item">
                            <label>Intérêt nouvelles responsabilités</label>
                            <span>{{ $personnel->interet_nouvelles_responsabilites }}</span>
                        </div>
                    </div>
                </div>

                <!-- VI. Photo et vêtements -->
                <div class="info-section">
                    <h3><i class="fas fa-tshirt"></i> VI. Informations vestimentaires</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Taille vêtements</label>
                            <span>{{ $personnel->taille_vetements }}</span>
                        </div>
                    </div>
                </div>

                <!-- VIII. Contact d'urgence -->
                <div class="info-section">
                    <h3><i class="fas fa-phone-alt"></i> VIII. Contact d'urgence</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nom du contact</label>
                            <span>{{ $personnel->contact_urgence_nom }}</span>
                        </div>
                        <div class="info-item">
                            <label>Téléphone</label>
                            <span>{{ $personnel->contact_urgence_telephone }}</span>
                        </div>
                        <div class="info-item">
                            <label>Lien de parenté</label>
                            <span>{{ $personnel->contact_urgence_lien_parente }}</span>
                        </div>
                    </div>
                </div>

                <!-- IX. Observations -->
                @if($personnel->observations_personnelles)
                <div class="info-section">
                    <h3><i class="fas fa-comment"></i> IX. Observations personnelles</h3>
                    <div class="info-grid">
                        <div class="info-item full-width">
                            <label>Observations</label>
                            <span>{{ $personnel->observations_personnelles }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Informations de validation -->
                @if($personnel->statut_validation != 'En attente')
                <div class="info-section">
                    <h3><i class="fas fa-check-circle"></i> Informations de validation</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Validé par</label>
                            <span>{{ $personnel->validateur ? $personnel->validateur->name : 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Date de validation</label>
                            <span>{{ $personnel->date_validation ? $personnel->date_validation->format('d/m/Y H:i') : 'N/A' }}</span>
                        </div>
                        @if($personnel->commentaire_validation)
                        <div class="info-item full-width">
                            <label>Commentaire</label>
                            <span>{{ $personnel->commentaire_validation }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.dg-content {
    padding: 20px;
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header-actions {
    display: flex;
    gap: 10px;
}

.personnel-details {
    max-width: 1200px;
    margin: 0 auto;
}

.personnel-header {
    background: white;
    padding: 30px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 30px;
}

.personnel-photo img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e5e7eb;
}

.personnel-main-info h2 {
    margin: 0 0 10px 0;
    color: #111827;
    font-size: 28px;
}

.personnel-main-info .matricule {
    font-size: 16px;
    color: #6b7280;
    margin: 0 0 5px 0;
}

.personnel-main-info .poste {
    font-size: 18px;
    color: #374151;
    margin: 0 0 5px 0;
    font-weight: 500;
}

.personnel-main-info .direction {
    font-size: 14px;
    color: #6b7280;
    margin: 0 0 15px 0;
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

.status-en-attente {
    background: #fef3c7;
    color: #92400e;
}

.status-valide {
    background: #d1fae5;
    color: #065f46;
}

.status-rejete {
    background: #fee2e2;
    color: #991b1b;
}

.info-sections {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-section {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.info-section h3 {
    color: #22c55e;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-item label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 5px;
    font-size: 14px;
}

.info-item span {
    color: #111827;
    font-size: 16px;
    line-height: 1.5;
}

.btn {
    padding: 10px 20px;
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

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}
</style>
@endsection 
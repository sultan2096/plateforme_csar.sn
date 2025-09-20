@extends('layouts.admin')

@section('title', 'Nouveau Document RH - Interface Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-plus me-2"></i>
                    Nouveau Document RH
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.hr.documents.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="personnel_id" class="form-label">Personnel *</label>
                                    <select name="personnel_id" id="personnel_id" class="form-select @error('personnel_id') is-invalid @enderror" required>
                                        <option value="">Sélectionner un personnel</option>
                                        @foreach($personnel as $p)
                                        <option value="{{ $p->id }}" {{ old('personnel_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->prenoms_nom }} ({{ $p->matricule }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('personnel_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type de document *</label>
                                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Sélectionner le type</option>
                                        <option value="contrat_travail" {{ old('type') == 'contrat_travail' ? 'selected' : '' }}>Contrat de travail</option>
                                        <option value="bulletin_salaire" {{ old('type') == 'bulletin_salaire' ? 'selected' : '' }}>Bulletin de salaire</option>
                                        <option value="certificat_medical" {{ old('type') == 'certificat_medical' ? 'selected' : '' }}>Certificat médical</option>
                                        <option value="arret_maladie" {{ old('type') == 'arret_maladie' ? 'selected' : '' }}>Arrêt maladie</option>
                                        <option value="attestation_travail" {{ old('type') == 'attestation_travail' ? 'selected' : '' }}>Attestation de travail</option>
                                        <option value="certificat_formation" {{ old('type') == 'certificat_formation' ? 'selected' : '' }}>Certificat de formation</option>
                                        <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre document</option>
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="titre" class="form-label">Titre du document *</label>
                                    <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}" required>
                                    @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_emission" class="form-label">Date d'émission *</label>
                                    <input type="date" name="date_emission" id="date_emission" class="form-control @error('date_emission') is-invalid @enderror" value="{{ old('date_emission') }}" required>
                                    @error('date_emission')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_expiration" class="form-label">Date d'expiration</label>
                                    <input type="date" name="date_expiration" id="date_expiration" class="form-control @error('date_expiration') is-invalid @enderror" value="{{ old('date_expiration') }}">
                                    @error('date_expiration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fichier" class="form-label">Fichier *</label>
                                    <input type="file" name="fichier" id="fichier" class="form-control @error('fichier') is-invalid @enderror" required>
                                    <small class="form-text text-muted">Formats acceptés : PDF, DOC, DOCX, JPG, PNG. Taille max : 10MB</small>
                                    @error('fichier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="commentaires" class="form-label">Commentaires</label>
                                    <textarea name="commentaires" id="commentaires" class="form-control @error('commentaires') is-invalid @enderror" rows="3">{{ old('commentaires') }}</textarea>
                                    @error('commentaires')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.hr.documents.index') }}" class="btn btn-secondary me-2">
                                        <i class="fas fa-times me-2"></i>Annuler
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Enregistrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0 35px 0 rgba(154,161,171,.15);
    margin-bottom: 24px;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-select, .form-control {
    border-radius: 0.375rem;
    border: 1px solid #d1d3e2;
}

.form-select:focus, .form-control:focus {
    border-color: #727cf5;
    box-shadow: 0 0 0 0.2rem rgba(114,124,245,.25);
}

.btn {
    border-radius: 0.375rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation de la date d'expiration
    const dateEmission = document.getElementById('date_emission');
    const dateExpiration = document.getElementById('date_expiration');
    
    dateEmission.addEventListener('change', function() {
        if (dateExpiration.value && dateExpiration.value <= dateEmission.value) {
            dateExpiration.setCustomValidity('La date d\'expiration doit être postérieure à la date d\'émission');
        } else {
            dateExpiration.setCustomValidity('');
        }
    });
    
    dateExpiration.addEventListener('change', function() {
        if (dateEmission.value && dateExpiration.value <= dateEmission.value) {
            dateExpiration.setCustomValidity('La date d\'expiration doit être postérieure à la date d\'émission');
        } else {
            dateExpiration.setCustomValidity('');
        }
    });
});
</script>
@endsection 
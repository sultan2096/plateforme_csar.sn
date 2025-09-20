@extends('layouts.admin')

@section('title', 'Nouveau Bulletin de Salaire - Interface Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-plus me-2"></i>
                    Nouveau Bulletin de Salaire
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.hr.salary-slips.store') }}" id="bulletinForm">
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

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="periode_debut" class="form-label">Début période *</label>
                                    <input type="date" name="periode_debut" id="periode_debut" class="form-control @error('periode_debut') is-invalid @enderror" value="{{ old('periode_debut') }}" required>
                                    @error('periode_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="periode_fin" class="form-label">Fin période *</label>
                                    <input type="date" name="periode_fin" id="periode_fin" class="form-control @error('periode_fin') is-invalid @enderror" value="{{ old('periode_fin') }}" required>
                                    @error('periode_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Salaire et indemnités -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">Salaire et Indemnités</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="salaire_brut" class="form-label">Salaire brut *</label>
                                            <input type="number" name="salaire_brut" id="salaire_brut" class="form-control @error('salaire_brut') is-invalid @enderror" value="{{ old('salaire_brut') }}" step="0.01" required>
                                            @error('salaire_brut')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="indemnite_logement" class="form-label">Indemnité logement</label>
                                            <input type="number" name="indemnite_logement" id="indemnite_logement" class="form-control @error('indemnite_logement') is-invalid @enderror" value="{{ old('indemnite_logement', 0) }}" step="0.01">
                                            @error('indemnite_logement')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="indemnite_transport" class="form-label">Indemnité transport</label>
                                            <input type="number" name="indemnite_transport" id="indemnite_transport" class="form-control @error('indemnite_transport') is-invalid @enderror" value="{{ old('indemnite_transport', 0) }}" step="0.01">
                                            @error('indemnite_transport')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="indemnite_fonction" class="form-label">Indemnité fonction</label>
                                            <input type="number" name="indemnite_fonction" id="indemnite_fonction" class="form-control @error('indemnite_fonction') is-invalid @enderror" value="{{ old('indemnite_fonction', 0) }}" step="0.01">
                                            @error('indemnite_fonction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="autres_indemnites" class="form-label">Autres indemnités</label>
                                            <input type="number" name="autres_indemnites" id="autres_indemnites" class="form-control @error('autres_indemnites') is-invalid @enderror" value="{{ old('autres_indemnites', 0) }}" step="0.01">
                                            @error('autres_indemnites')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">Déductions</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="cnss" class="form-label">CNSS</label>
                                            <input type="number" name="cnss" id="cnss" class="form-control @error('cnss') is-invalid @enderror" value="{{ old('cnss', 0) }}" step="0.01">
                                            @error('cnss')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="impot" class="form-label">Impôt</label>
                                            <input type="number" name="impot" id="impot" class="form-control @error('impot') is-invalid @enderror" value="{{ old('impot', 0) }}" step="0.01">
                                            @error('impot')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="autres_deductions" class="form-label">Autres déductions</label>
                                            <input type="number" name="autres_deductions" id="autres_deductions" class="form-control @error('autres_deductions') is-invalid @enderror" value="{{ old('autres_deductions', 0) }}" step="0.01">
                                            @error('autres_deductions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jours travaillés -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">Jours de travail</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="jours_travailles" class="form-label">Jours travaillés *</label>
                                                    <input type="number" name="jours_travailles" id="jours_travailles" class="form-control @error('jours_travailles') is-invalid @enderror" value="{{ old('jours_travailles') }}" min="0" required>
                                                    @error('jours_travailles')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="jours_conges" class="form-label">Jours de congé</label>
                                                    <input type="number" name="jours_conges" id="jours_conges" class="form-control @error('jours_conges') is-invalid @enderror" value="{{ old('jours_conges', 0) }}" min="0">
                                                    @error('jours_conges')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="jours_absences" class="form-label">Jours d'absence</label>
                                                    <input type="number" name="jours_absences" id="jours_absences" class="form-control @error('jours_absences') is-invalid @enderror" value="{{ old('jours_absences', 0) }}" min="0">
                                                    @error('jours_absences')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" id="calculerJours" class="btn btn-info">
                                                    <i class="fas fa-calculator me-2"></i>Calculer automatiquement les jours
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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

                        <!-- Résumé du calcul -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card bg-primary text-white">
                                    <div class="card-header">
                                        <h6 class="mb-0">Résumé du calcul</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h5>Salaire brut</h5>
                                                    <h4 id="totalBrut">0 FCFA</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h5>Total indemnités</h5>
                                                    <h4 id="totalIndemnites">0 FCFA</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h5>Total déductions</h5>
                                                    <h4 id="totalDeductions">0 FCFA</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h5>Salaire net</h5>
                                                    <h4 id="salaireNet">0 FCFA</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.hr.salary-slips.index') }}" class="btn btn-secondary me-2">
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

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 0.75rem 1rem;
}

.card-header h6 {
    margin: 0;
    color: #495057;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments pour le calcul
    const salaireBrut = document.getElementById('salaire_brut');
    const indemniteLogement = document.getElementById('indemnite_logement');
    const indemniteTransport = document.getElementById('indemnite_transport');
    const indemniteFonction = document.getElementById('indemnite_fonction');
    const autresIndemnites = document.getElementById('autres_indemnites');
    const cnss = document.getElementById('cnss');
    const impot = document.getElementById('impot');
    const autresDeductions = document.getElementById('autres_deductions');

    // Éléments d'affichage
    const totalBrut = document.getElementById('totalBrut');
    const totalIndemnites = document.getElementById('totalIndemnites');
    const totalDeductions = document.getElementById('totalDeductions');
    const salaireNet = document.getElementById('salaireNet');

    // Fonction de calcul
    function calculerSalaire() {
        const brut = parseFloat(salaireBrut.value) || 0;
        const logement = parseFloat(indemniteLogement.value) || 0;
        const transport = parseFloat(indemniteTransport.value) || 0;
        const fonction = parseFloat(indemniteFonction.value) || 0;
        const autres = parseFloat(autresIndemnites.value) || 0;
        const cnssVal = parseFloat(cnss.value) || 0;
        const impotVal = parseFloat(impot.value) || 0;
        const autresDed = parseFloat(autresDeductions.value) || 0;

        const totalIndemnitesVal = logement + transport + fonction + autres;
        const totalDeductionsVal = cnssVal + impotVal + autresDed;
        const net = brut + totalIndemnitesVal - totalDeductionsVal;

        totalBrut.textContent = formatCurrency(brut);
        totalIndemnites.textContent = formatCurrency(totalIndemnitesVal);
        totalDeductions.textContent = formatCurrency(totalDeductionsVal);
        salaireNet.textContent = formatCurrency(net);
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('fr-FR').format(amount) + ' FCFA';
    }

    // Écouteurs d'événements
    [salaireBrut, indemniteLogement, indemniteTransport, indemniteFonction, autresIndemnites, cnss, impot, autresDeductions].forEach(input => {
        input.addEventListener('input', calculerSalaire);
    });

    // Calcul automatique des jours
    document.getElementById('calculerJours').addEventListener('click', function() {
        const personnelId = document.getElementById('personnel_id').value;
        const periodeDebut = document.getElementById('periode_debut').value;
        const periodeFin = document.getElementById('periode_fin').value;

        if (!personnelId || !periodeDebut || !periodeFin) {
            alert('Veuillez sélectionner un personnel et définir la période');
            return;
        }

        fetch(`/admin/hr/salary-slips/calculer-jours?personnel_id=${personnelId}&periode_debut=${periodeDebut}&periode_fin=${periodeFin}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('jours_travailles').value = data.jours_travailles;
                document.getElementById('jours_conges').value = data.jours_conges;
                document.getElementById('jours_absences').value = data.jours_absences;
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors du calcul automatique des jours');
            });
    });

    // Calcul initial
    calculerSalaire();
});
</script>
@endsection 
@extends('layouts.admin')

@section('title', 'Bulletins de Salaire - Interface Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    Gestion des Bulletins de Salaire
                </h4>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.hr.salary-slips.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Personnel</label>
                            <select name="personnel" class="form-select">
                                <option value="">Tous les personnels</option>
                                @foreach($personnel as $p)
                                <option value="{{ $p->id }}" {{ request('personnel') == $p->id ? 'selected' : '' }}>
                                    {{ $p->prenoms_nom }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="brouillon" {{ request('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                <option value="valide" {{ request('statut') == 'valide' ? 'selected' : '' }}>Validé</option>
                                <option value="paye" {{ request('statut') == 'paye' ? 'selected' : '' }}>Payé</option>
                                <option value="annule" {{ request('statut') == 'annule' ? 'selected' : '' }}>Annulé</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Début période</label>
                            <input type="date" name="periode_debut" class="form-control" value="{{ request('periode_debut') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Fin période</label>
                            <input type="date" name="periode_fin" class="form-control" value="{{ request('periode_fin') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Recherche</label>
                            <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Filtrer
                            </button>
                            <a href="{{ route('admin.hr.salary-slips.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Bulletins de Salaire</h5>
                        <div>
                            <a href="{{ route('admin.hr.salary-slips.export-pdf') }}" class="btn btn-info me-2">
                                <i class="fas fa-file-pdf me-2"></i>Export PDF
                            </a>
                            <a href="{{ route('admin.hr.salary-slips.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nouveau Bulletin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des bulletins -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>N° Bulletin</th>
                                    <th>Personnel</th>
                                    <th>Période</th>
                                    <th>Salaire Brut</th>
                                    <th>Salaire Net</th>
                                    <th>Jours Travaillés</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bulletins as $bulletin)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-invoice-dollar text-warning me-2"></i>
                                            <div>
                                                <h6 class="mb-0">{{ $bulletin->numero_bulletin }}</h6>
                                                <small class="text-muted">Créé le {{ $bulletin->created_at->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $bulletin->personnel->prenoms_nom }}</h6>
                                            <small class="text-muted">{{ $bulletin->personnel->matricule }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $bulletin->periode_label }}</td>
                                    <td>
                                        <span class="fw-bold">{{ number_format($bulletin->salaire_brut, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">{{ number_format($bulletin->salaire_net, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $bulletin->jours_travailles }} jours</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $bulletin->statut === 'valide' ? 'success' : ($bulletin->statut === 'paye' ? 'info' : ($bulletin->statut === 'annule' ? 'danger' : 'warning')) }}">
                                            {{ $bulletin->statut_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.hr.salary-slips.show', $bulletin) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.hr.salary-slips.edit', $bulletin) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($bulletin->statut === 'brouillon')
                                            <form method="POST" action="{{ route('admin.hr.salary-slips.valider', $bulletin) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Valider">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @if($bulletin->statut === 'valide')
                                            <form method="POST" action="{{ route('admin.hr.salary-slips.marquer-paye', $bulletin) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-info" title="Marquer comme payé">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </button>
                                            </form>
                                            @endif
                                            <a href="{{ route('admin.hr.salary-slips.pdf', $bulletin) }}" class="btn btn-sm btn-outline-secondary" title="Générer PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.hr.salary-slips.destroy', $bulletin) }}" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bulletin ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucun bulletin trouvé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $bulletins->links() }}
                    </div>
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

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
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

.fw-bold {
    font-weight: 700 !important;
}
</style>
@endsection 
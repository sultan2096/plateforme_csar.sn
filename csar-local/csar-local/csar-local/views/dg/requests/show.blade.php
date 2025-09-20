@extends('layouts.dg')

@section('title', 'Détails de la Demande - CSAR DG')

@section('content')
<div class="dg-container">
    <!-- Header -->
    <div class="dg-header">
        <div class="header-content">
            <h1>Détails de la Demande</h1>
            <p>Demande #{{ $request->id }} - {{ $request->full_name }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('dg.requests.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <!-- Messages Flash -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Informations principales -->
    <div class="request-details">
        <div class="detail-card">
            <div class="card-header">
                <h3>Informations Générales</h3>
            </div>
            <div class="card-content">
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Nom complet</label>
                        <span>{{ $request->full_name }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Email</label>
                        <span>{{ $request->email }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Téléphone</label>
                        <span>{{ $request->phone }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Région</label>
                        <span>{{ $request->region }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Type de demande</label>
                        <span class="badge badge-{{ $request->type == 'aide' ? 'primary' : ($request->type == 'partenariat' ? 'success' : 'info') }}">
                            {{ ucfirst($request->type) }}
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Statut</label>
                        <span class="badge badge-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'approved' ? 'success' : ($request->status == 'rejected' ? 'danger' : 'info')) }}">
                            {{ ucfirst($request->status) }}
                        </span>
                    </div>
                    <div class="detail-item">
                        <label>Date de création</label>
                        <span>{{ $request->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    <div class="detail-item">
                        <label>Dernière modification</label>
                        <span>{{ $request->updated_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description de la demande -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Description de la Demande</h3>
            </div>
            <div class="card-content">
                <div class="description-content">
                    {{ $request->description }}
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Actions</h3>
            </div>
            <div class="card-content">
                <div class="actions-grid">
                    @if($request->status == 'pending')
                        <form method="POST" action="{{ route('dg.requests.approve', $request->id) }}" style="display: inline;" id="approveForm">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirmApprove()">
                                <i class="fas fa-check"></i> Approuver
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('dg.requests.reject', $request->id) }}" style="display: inline;" id="rejectForm">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirmReject()">
                                <i class="fas fa-times"></i> Rejeter
                            </button>
                        </form>
                    @elseif($request->status == 'approved')
                        <form method="POST" action="{{ route('dg.requests.complete', $request->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-check-double"></i> Marquer comme terminé
                            </button>
                        </form>
                    @endif
                    
                    <a href="mailto:{{ $request->email }}" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Contacter
                    </a>
                    
                    <a href="tel:{{ $request->phone }}" class="btn btn-secondary">
                        <i class="fas fa-phone"></i> Appeler
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dg-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.dg-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e5e7eb;
}

.header-content h1 {
    color: #1e40af;
    font-size: 2rem;
    margin: 0 0 0.5rem 0;
}

.header-content p {
    color: #6b7280;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.request-details {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.detail-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    background: #f8fafc;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h3 {
    color: #1e40af;
    margin: 0;
    font-size: 1.25rem;
}

.card-content {
    padding: 1.5rem;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-item label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.detail-item span {
    color: #1f2937;
    font-size: 1rem;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
    width: fit-content;
}

.badge-primary {
    background: #dbeafe;
    color: #1e40af;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-info {
    background: #cffafe;
    color: #0e7490;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

.description-content {
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
    line-height: 1.6;
    color: #374151;
    white-space: pre-wrap;
}

.actions-grid {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.9rem;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

.btn-info {
    background: #06b6d4;
    color: white;
}

.btn-info:hover {
    background: #0891b2;
}

.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-danger {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.alert i {
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .dg-container {
        padding: 1rem;
    }
    
    .dg-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        flex-direction: column;
    }
    
    .btn {
        justify-content: center;
    }
}
</style>
@endsection 

<script>
function confirmApprove() {
    console.log('Tentative d\'approbation...');
    if (confirm('Êtes-vous sûr de vouloir approuver cette demande ?')) {
        console.log('Approbation confirmée, soumission du formulaire...');
        document.getElementById('approveForm').submit();
        return true;
    }
    console.log('Approbation annulée');
    return false;
}

function confirmReject() {
    console.log('Tentative de rejet...');
    if (confirm('Êtes-vous sûr de vouloir rejeter cette demande ?')) {
        console.log('Rejet confirmé, soumission du formulaire...');
        document.getElementById('rejectForm').submit();
        return true;
    }
    console.log('Rejet annulé');
    return false;
}

// Debug: vérifier que les formulaires sont bien présents
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page chargée, vérification des formulaires...');
    const approveForm = document.getElementById('approveForm');
    const rejectForm = document.getElementById('rejectForm');
    
    if (approveForm) {
        console.log('Formulaire d\'approbation trouvé');
        approveForm.addEventListener('submit', function(e) {
            console.log('Formulaire d\'approbation soumis');
        });
    } else {
        console.log('Formulaire d\'approbation NON trouvé');
    }
    
    if (rejectForm) {
        console.log('Formulaire de rejet trouvé');
        rejectForm.addEventListener('submit', function(e) {
            console.log('Formulaire de rejet soumis');
        });
    } else {
        console.log('Formulaire de rejet NON trouvé');
    }
});
</script> 
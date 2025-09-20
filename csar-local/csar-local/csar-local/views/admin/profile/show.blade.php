@extends('layouts.admin')

@section('title', 'Mon Profil - Administration CSAR')
@section('page-title', 'Mon Profil')
@section('page-subtitle', 'Informations personnelles')

@section('content')
@if(session('success'))
<div class="admin-card" style="background-color: #d1fae5; border-left: 4px solid #059669;">
    <p style="color: #065f46; margin: 0;">{{ session('success') }}</p>
</div>
@endif

@if(session('info'))
<div class="admin-card" style="background-color: #dbeafe; border-left: 4px solid #3b82f6;">
    <p style="color: #1e40af; margin: 0;">{{ session('info') }}</p>
</div>
@endif

<div class="admin-grid admin-grid-2">
    <!-- Informations du profil -->
    <div class="admin-card">
        <h2 class="admin-section-title">Informations personnelles</h2>
        
        <div style="display: flex; align-items: center; margin-bottom: 2rem;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #e5e7eb; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                @else
                    <span style="font-size: 2rem; color: #6b7280;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                @endif
            </div>
            <div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 0.25rem;">{{ $user->name }}</h3>
                <p style="color: #6b7280; margin-bottom: 0.25rem;">{{ ucfirst($user->role) }}</p>
                <p style="color: #6b7280; font-size: 0.875rem;">Membre depuis {{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">Nom complet</label>
                <p style="color: #111827; padding: 0.5rem; background-color: #f9fafb; border-radius: 0.375rem;">{{ $user->name }}</p>
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">Adresse email</label>
                <p style="color: #111827; padding: 0.5rem; background-color: #f9fafb; border-radius: 0.375rem;">{{ $user->email }}</p>
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">Téléphone</label>
                <p style="color: #111827; padding: 0.5rem; background-color: #f9fafb; border-radius: 0.375rem;">{{ $user->phone ?? 'Non renseigné' }}</p>
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">Adresse</label>
                <p style="color: #111827; padding: 0.5rem; background-color: #f9fafb; border-radius: 0.375rem;">{{ $user->address ?? 'Non renseignée' }}</p>
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">Rôle</label>
                <p style="color: #111827; padding: 0.5rem; background-color: #f9fafb; border-radius: 0.375rem;">{{ ucfirst($user->role) }}</p>
            </div>

            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem;">Dernière connexion</label>
                <p style="color: #111827; padding: 0.5rem; background-color: #f9fafb; border-radius: 0.375rem;">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</p>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <a href="{{ route('admin.profile.edit') }}" class="admin-btn">Modifier le profil</a>
            <a href="{{ route('admin.profile.export-pdf') }}" class="admin-btn-secondary">Exporter en PDF</a>
        </div>
    </div>

    <!-- Statistiques de l'utilisateur -->
    <div class="admin-card">
        <h2 class="admin-section-title">Statistiques de l'utilisateur</h2>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background-color: #f9fafb; border-radius: 0.375rem;">
                <div>
                    <p style="font-weight: 600; color: #111827; margin-bottom: 0.25rem;">Demandes traitées</p>
                    <p style="color: #6b7280; font-size: 0.875rem;">Ce mois</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 1.5rem; font-weight: 700; color: #059669;">{{ rand(5, 25) }}</p>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background-color: #f9fafb; border-radius: 0.375rem;">
                <div>
                    <p style="font-weight: 600; color: #111827; margin-bottom: 0.25rem;">Actions effectuées</p>
                    <p style="color: #6b7280; font-size: 0.875rem;">Cette semaine</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 1.5rem; font-weight: 700; color: #3b82f6;">{{ rand(10, 50) }}</p>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background-color: #f9fafb; border-radius: 0.375rem;">
                <div>
                    <p style="font-weight: 600; color: #111827; margin-bottom: 0.25rem;">Messages reçus</p>
                    <p style="color: #6b7280; font-size: 0.875rem;">Non lus</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">{{ rand(0, 8) }}</p>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background-color: #f9fafb; border-radius: 0.375rem;">
                <div>
                    <p style="font-weight: 600; color: #111827; margin-bottom: 0.25rem;">Temps de connexion</p>
                    <p style="color: #6b7280; font-size: 0.875rem;">Aujourd'hui</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 1.5rem; font-weight: 700; color: #6b7280;">{{ rand(2, 8) }}h</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activité récente -->
<div class="admin-card">
    <h2 class="admin-section-title">Activité récente</h2>
    
    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
        <div style="display: flex; align-items: center; padding: 1rem; background-color: #f9fafb; border-radius: 0.375rem;">
            <div style="width: 2rem; height: 2rem; background-color: #d1fae5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <span style="font-size: 0.875rem;">✓</span>
            </div>
            <div style="flex: 1;">
                <p style="font-weight: 600; color: #111827; margin-bottom: 0.25rem;">Demande approuvée</p>
                <p style="color: #6b7280; font-size: 0.875rem;">Demande CSAR-ABC123 approuvée</p>
            </div>
            <span style="color: #6b7280; font-size: 0.75rem;">Il y a 2h</span>
        </div>

        <div style="display: flex; align-items: center; padding: 1rem; background-color: #f9fafb; border-radius: 0.375rem;">
            <div style="width: 2rem; height: 2rem; background-color: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <span style="font-size: 0.875rem;">📋</span>
            </div>
            <div style="flex: 1;">
                <p style="font-weight: 600; color: #111827; margin-bottom: 0.25rem;">Nouvelle demande</p>
                <p style="color: #6b7280; font-size: 0.875rem;">Nouvelle demande reçue de la région de Thiès</p>
            </div>
            <span style="color: #6b7280; font-size: 0.75rem;">Il y a 4h</span>
        </div>

        <div style="display: flex; align-items: center; padding: 1rem; background-color: #f9fafb; border-radius: 0.375rem;">
            <div style="width: 2rem; height: 2rem; background-color: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <span style="font-size: 0.875rem;">📦</span>
            </div>
            <div style="flex: 1;">
                <p style="font-weight: 600; color: #111827; margin-bottom: 0.25rem;">Stock mis à jour</p>
                <p style="color: #6b7280; font-size: 0.875rem;">Stock de l'entrepôt Dakar mis à jour</p>
            </div>
            <span style="color: #6b7280; font-size: 0.75rem;">Il y a 6h</span>
        </div>

        <div style="display: flex; align-items: center; padding: 1rem; background-color: #f9fafb; border-radius: 0.375rem;">
            <div style="width: 2rem; height: 2rem; background-color: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <span style="font-size: 0.875rem;">⚠️</span>
            </div>
            <div style="flex: 1;">
                <p style="font-weight: 600; color: #111827; margin-bottom: 0.25rem;">Alerte stock</p>
                <p style="color: #6b7280; font-size: 0.875rem;">Stock faible détecté dans l'entrepôt Kaolack</p>
            </div>
            <span style="color: #6b7280; font-size: 0.75rem;">Il y a 1j</span>
        </div>
    </div>
</div>
@endsection 
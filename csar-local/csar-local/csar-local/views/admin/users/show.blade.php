@extends('layouts.admin')

@section('title', 'Détails de l\'Agent - Administration CSAR')
@section('page-title', 'Détails de l\'Agent')
@section('page-subtitle', 'Informations détaillées du profil utilisateur')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="admin-section-title">Profil de {{ $user->name }}</h2>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="admin-btn-secondary">
                ✏️ Modifier
            </a>
            <a href="{{ route('admin.users.index') }}" class="admin-btn-secondary">
                ← Retour à la liste
            </a>
        </div>
    </div>

    <div class="admin-grid admin-grid-2">
        <!-- Informations personnelles -->
        <div class="admin-card" style="background: #f8fafc; border: 1px solid #e2e8f0;">
            <h3 style="color: #1e40af; margin-bottom: 1rem; font-size: 1.125rem;">📋 Informations personnelles</h3>
            
            <div style="margin-bottom: 1rem;">
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Nom complet</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    {{ $user->name }}
                </p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Adresse email</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    {{ $user->email }}
                </p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Téléphone</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    {{ $user->phone ?? 'Non renseigné' }}
                </p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Adresse</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    {{ $user->address ?? 'Non renseignée' }}
                </p>
            </div>
        </div>

        <!-- Informations professionnelles -->
        <div class="admin-card" style="background: #f8fafc; border: 1px solid #e2e8f0;">
            <h3 style="color: #1e40af; margin-bottom: 1rem; font-size: 1.125rem;">💼 Informations professionnelles</h3>
            
            <div style="margin-bottom: 1rem;">
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Rôle</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    @switch($user->role_id)
                        @case(1)
                            <span style="color: #dc2626; font-weight: 600;">👑 Administrateur</span>
                            @break
                        @case(2)
                            <span style="color: #1e40af; font-weight: 600;">🎯 Directeur Général</span>
                            @break
                        @case(3)
                            <span style="color: #059669; font-weight: 600;">📦 Responsable</span>
                            @break
                        @case(4)
                            <span style="color: #7c3aed; font-weight: 600;">👤 Agent</span>
                            @break
                        @default
                            <span style="color: #6b7280;">Rôle non défini</span>
                    @endswitch
                </p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Poste</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    {{ $user->position }}
                </p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Direction</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    {{ $user->department }}
                </p>
            </div>

            @if($user->warehouse_id)
            <div style="margin-bottom: 1rem;">
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Entrepôt assigné</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    Entrepôt #{{ $user->warehouse_id }}
                </p>
            </div>
            @endif
        </div>
    </div>

    <!-- Informations système -->
    <div class="admin-card" style="background: #f8fafc; border: 1px solid #e2e8f0; margin-top: 1.5rem;">
        <h3 style="color: #1e40af; margin-bottom: 1rem; font-size: 1.125rem;">⚙️ Informations système</h3>
        
        <div class="admin-grid admin-grid-3">
            <div>
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">ID Utilisateur</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    #{{ $user->id }}
                </p>
            </div>

            <div>
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Date de création</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    {{ $user->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>

            <div>
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Dernière modification</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    {{ $user->updated_at->format('d/m/Y à H:i') }}
                </p>
            </div>

            <div>
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Email vérifié</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    @if($user->email_verified_at)
                        <span style="color: #059669;">✅ Vérifié le {{ \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y') }}</span>
                    @else
                        <span style="color: #dc2626;">❌ Non vérifié</span>
                    @endif
                </p>
            </div>

            <div>
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Dernière connexion</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    @if($user->last_login_at)
                        <span style="color: #059669;">{{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y à H:i') }}</span>
                    @else
                        <span style="color: #6b7280;">Jamais connecté</span>
                    @endif
                </p>
            </div>

            <div>
                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.25rem;">Avatar</label>
                <p style="color: #1f2937; margin: 0; padding: 0.5rem; background: white; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                    @if($user->avatar)
                        <span style="color: #059669;">✅ Photo de profil</span>
                    @else
                        <span style="color: #6b7280;">Aucune photo</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="admin-card" style="background: #f8fafc; border: 1px solid #e2e8f0; margin-top: 1.5rem;">
        <h3 style="color: #1e40af; margin-bottom: 1rem; font-size: 1.125rem;">🔧 Actions</h3>
        
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="admin-btn">
                ✏️ Modifier le profil
            </a>
            
            @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                    🗑️ Supprimer l'utilisateur
                </button>
            </form>
            @else
            <button class="admin-btn-secondary" disabled title="Vous ne pouvez pas supprimer votre propre compte">
                🗑️ Supprimer l'utilisateur
            </button>
            @endif
            
            <a href="{{ route('admin.users.index') }}" class="admin-btn-secondary">
                ← Retour à la liste
            </a>
        </div>
    </div>
</div>

<style>
.admin-grid-3 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.admin-btn-danger {
    background: #dc2626;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.admin-btn-danger:hover {
    background: #b91c1c;
}

.admin-btn-danger:disabled {
    background: #9ca3af;
    cursor: not-allowed;
}
</style>
@endsection 
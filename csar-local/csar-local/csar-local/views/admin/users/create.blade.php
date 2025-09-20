@extends('layouts.admin')

@section('title', 'Ajouter un Agent - Administration CSAR')
@section('page-title', 'Ajouter un Agent')
@section('page-subtitle', 'Recensement du personnel CSAR')

@section('content')
@if($errors->any())
<div class="admin-card" style="background-color: #fee2e2; border-left: 4px solid #dc2626;">
    <ul style="color: #991b1b; margin: 0; padding-left: 1rem;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="admin-card">
    <h2 class="admin-section-title">Informations de l'agent</h2>
    
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        
        <div class="admin-grid admin-grid-2">
            <div>
                <label for="name" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Nom complet *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="form-input @error('name') error @enderror"
                       placeholder="Nom et prénom de l'agent">
                @error('name')
                    <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Adresse email *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="form-input @error('email') error @enderror"
                       placeholder="email@csar.sn">
                @error('email')
                    <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Téléphone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                       class="form-input @error('phone') error @enderror"
                       placeholder="+221 77 XXX XX XX">
                @error('phone')
                    <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role_id" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Rôle *</label>
                <select id="role_id" name="role_id" required class="form-input @error('role_id') error @enderror">
                    <option value="">Sélectionner un rôle</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->display_name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="position" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Poste *</label>
                <input type="text" id="position" name="position" value="{{ old('position') }}" required
                       class="form-input @error('position') error @enderror"
                       placeholder="Poste occupé">
                @error('position')
                    <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="department" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Direction *</label>
                <select id="department" name="department" required class="form-input @error('department') error @enderror">
                    <option value="">Sélectionner une direction</option>
                    <option value="Administration" {{ old('department') === 'Administration' ? 'selected' : '' }}>Administration</option>
                    <option value="Logistique" {{ old('department') === 'Logistique' ? 'selected' : '' }}>Logistique</option>
                                            <option value="Sécurité Alimentaire et Résilience" {{ old('department') === 'Sécurité Alimentaire et Résilience' ? 'selected' : '' }}>Sécurité Alimentaire et Résilience</option>
                    <option value="Résilience" {{ old('department') === 'Résilience' ? 'selected' : '' }}>Résilience</option>
                    <option value="Communication" {{ old('department') === 'Communication' ? 'selected' : '' }}>Communication</option>
                </select>
                @error('department')
                    <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div style="margin-top: 1.5rem;">
            <label for="address" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Adresse</label>
            <textarea id="address" name="address" rows="3"
                      class="form-input @error('address') error @enderror"
                      placeholder="Adresse complète de l'agent">{{ old('address') }}</textarea>
            @error('address')
                <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div class="admin-grid admin-grid-2" style="margin-top: 1.5rem;">
            <div>
                <label for="password" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Mot de passe *</label>
                <input type="password" id="password" name="password" required
                       class="form-input @error('password') error @enderror"
                       placeholder="Mot de passe (min. 8 caractères)">
                @error('password')
                    <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Confirmer le mot de passe *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="form-input"
                       placeholder="Confirmez le mot de passe">
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="admin-btn">➕ Ajouter l'agent</button>
            <a href="{{ route('admin.users.index') }}" class="admin-btn-secondary">❌ Annuler</a>
        </div>
    </form>
</div>

<style>
.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: border-color 0.2s;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
}

.form-input.error {
    border-color: #dc2626;
}

textarea.form-input {
    resize: vertical;
    min-height: 80px;
}
</style>
@endsection 
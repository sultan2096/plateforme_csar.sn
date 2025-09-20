@extends('layouts.admin')

@section('title', 'Créer une Demande - Administration CSAR')
@section('page-title', 'Créer une Demande')
@section('page-subtitle', 'Ajouter une nouvelle demande d\'aide, de partenariat ou d\'audience')

@section('content')
<style>
.admin-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.admin-header {
    text-align: center;
    margin-bottom: 3rem;
}

.admin-header h1 {
    color: #1e40af;
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.admin-header p {
    color: #6b7280;
    font-size: 1.1rem;
}

.admin-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
    transition: all 0.3s ease;
}

.admin-card:hover {
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.admin-section-title {
    color: #1e40af;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.admin-grid {
    display: grid;
    gap: 1.5rem;
}

.admin-grid-2 {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
}

.admin-grid-3 {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
}

.form-input, .form-select, .form-textarea {
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fafafa;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.admin-btn {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
}

.admin-btn:hover {
    background: linear-gradient(135deg, #2563eb, #1e3a8a);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
}

.admin-btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
}

.admin-btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
}

.error-message {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.success-message {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border: 1px solid #10b981;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);
}

.success-message p {
    color: #065f46;
    margin: 0;
    font-weight: 600;
}

@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }
    
    .admin-grid-2 {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1>Créer une Demande</h1>
        <p>Ajouter une nouvelle demande d'aide, de partenariat ou d'audience</p>
    </div>

    @if(session('success'))
    <div class="success-message">
        <p>✅ {{ session('success') }}</p>
    </div>
    @endif

    <!-- Formulaire de création -->
    <div class="admin-card">
        <h2 class="admin-section-title">
            <span>📝</span>
            Informations de la demande
        </h2>
        
        <form action="{{ route('admin.requests.store') }}" method="POST">
            @csrf
            
            <!-- Informations du demandeur -->
            <div class="admin-grid admin-grid-2">
                <div class="form-group">
                    <label for="full_name" class="form-label">👤 Nom complet *</label>
                    <input type="text" id="full_name" name="full_name" required
                           class="form-input" placeholder="Ex: Mamadou Diallo"
                           value="{{ old('full_name') }}">
                    @error('full_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">📧 Email *</label>
                    <input type="email" id="email" name="email" required
                           class="form-input" placeholder="Ex: mamadou.diallo@email.com"
                           value="{{ old('email') }}">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">📞 Téléphone *</label>
                    <input type="tel" id="phone" name="phone" required
                           class="form-input" placeholder="Ex: +221 77 123 45 67"
                           value="{{ old('phone') }}">
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="type" class="form-label">🎯 Type de demande *</label>
                    <select id="type" name="type" required class="form-select">
                        <option value="">Sélectionner un type</option>
                        <option value="help" {{ old('type') == 'help' ? 'selected' : '' }}>🆘 Demande d'aide</option>
                        <option value="partnership" {{ old('type') == 'partnership' ? 'selected' : '' }}>🤝 Demande de partenariat</option>
                        <option value="audience" {{ old('type') == 'audience' ? 'selected' : '' }}>👥 Demande d'audience</option>
                    </select>
                    @error('type')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="region" class="form-label">🗺️ Région *</label>
                    <select id="region" name="region" required class="form-select">
                        <option value="">Sélectionner une région</option>
                        @foreach($regions as $region)
                            <option value="{{ $region }}" {{ old('region') == $region ? 'selected' : '' }}>
                                {{ $region }}
                            </option>
                        @endforeach
                    </select>
                    @error('region')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="status" class="form-label">📊 Statut *</label>
                    <select id="status" name="status" required class="form-select">
                        <option value="">Sélectionner un statut</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                        <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>✅ Approuvée</option>
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>❌ Rejetée</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>✅ Terminée</option>
                    </select>
                    @error('status')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="assigned_to" class="form-label">👨‍💼 Agent assigné</label>
                    <select id="assigned_to" name="assigned_to" class="form-select">
                        <option value="">Aucun agent assigné</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ old('assigned_to') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name ?? $agent->email }} ({{ $agent->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Description -->
            <div class="form-group" style="margin-top: 1.5rem;">
                <label for="description" class="form-label">📋 Description de la demande *</label>
                <textarea id="description" name="description" required
                          class="form-textarea" placeholder="Décrivez en détail la demande, les besoins, les objectifs..."
                          rows="6">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Commentaire admin -->
            <div class="form-group" style="margin-top: 1.5rem;">
                <label for="admin_comment" class="form-label">💬 Commentaire administrateur</label>
                <textarea id="admin_comment" name="admin_comment"
                          class="form-textarea" placeholder="Commentaires internes, notes de traitement..."
                          rows="4">{{ old('admin_comment') }}</textarea>
                @error('admin_comment')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Actions -->
            <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                <button type="submit" class="admin-btn">
                    <span>💾</span>
                    Créer la demande
                </button>
                
                <a href="{{ route('admin.requests.index') }}" class="admin-btn admin-btn-secondary">
                    <span>↩️</span>
                    Retour à la liste
                </a>
            </div>
        </form>
    </div>
</div>
@endsection 
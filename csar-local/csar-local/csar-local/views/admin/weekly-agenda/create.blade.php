@extends('layouts.admin')

@section('title', 'Créer un Événement - Administration CSAR')

@section('content')
<style>
:root {
    --create-primary: #3b82f6;
    --create-secondary: #8b5cf6;
    --create-success: #10b981;
    --create-warning: #f59e0b;
    --create-danger: #ef4444;
    --create-bg: #f8fafc;
    --create-card-bg: #ffffff;
    --create-border: #e5e7eb;
    --create-text: #1f2937;
    --create-text-muted: #6b7280;
    --create-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.create-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 1.5rem;
    background: var(--create-bg);
    min-height: 100vh;
}

.create-header {
    background: linear-gradient(135deg, var(--create-primary), var(--create-secondary));
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    text-align: center;
}

.create-title {
    margin: 0;
    font-size: 2rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.create-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
}

.form-card {
    background: var(--create-card-bg);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--create-shadow);
    border: 1px solid var(--create-border);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--create-text);
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--create-border);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.2s;
    background: var(--create-card-bg);
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: var(--create-primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.priority-options {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
}

.priority-option {
    position: relative;
}

.priority-radio {
    position: absolute;
    opacity: 0;
}

.priority-label {
    display: block;
    padding: 0.75rem;
    border: 2px solid var(--create-border);
    border-radius: 8px;
    text-align: center;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.priority-radio:checked + .priority-label {
    color: white;
}

.priority-radio[value="low"]:checked + .priority-label {
    background: var(--create-success);
    border-color: var(--create-success);
}

.priority-radio[value="medium"]:checked + .priority-label {
    background: var(--create-primary);
    border-color: var(--create-primary);
}

.priority-radio[value="high"]:checked + .priority-label {
    background: var(--create-warning);
    border-color: var(--create-warning);
}

.priority-radio[value="urgent"]:checked + .priority-label {
    background: var(--create-danger);
    border-color: var(--create-danger);
}

.status-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.status-option {
    position: relative;
}

.status-radio {
    position: absolute;
    opacity: 0;
}

.status-label {
    display: block;
    padding: 0.75rem;
    border: 2px solid var(--create-border);
    border-radius: 8px;
    text-align: center;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.status-radio:checked + .status-label {
    background: var(--create-primary);
    border-color: var(--create-primary);
    color: white;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--create-border);
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: var(--create-primary);
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--create-border);
    color: var(--create-text);
}

.btn-secondary:hover {
    background: #d1d5db;
    text-decoration: none;
}

.datetime-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

@media (max-width: 768px) {
    .create-container { padding: 1rem; }
    .form-grid { grid-template-columns: 1fr; }
    .priority-options { grid-template-columns: repeat(2, 1fr); }
    .status-options { grid-template-columns: 1fr; }
    .datetime-grid { grid-template-columns: 1fr; }
    .form-actions { flex-direction: column; }
}
</style>

<div class="create-container">
    <!-- Header -->
    <div class="create-header">
        <h1 class="create-title">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            Créer un Événement
        </h1>
        <p class="create-subtitle">Ajouter un nouvel événement à l'agenda hebdomadaire</p>
    </div>

    <!-- Form -->
    <div class="form-card">
        <form method="POST" action="{{ route('admin.weekly-agenda.store') }}">
            @csrf

            <div class="form-grid">
                <!-- Titre -->
                <div class="form-group full-width">
                    <label class="form-label" for="title">Titre de l'événement *</label>
                    <input type="text" id="title" name="title" class="form-input" 
                           value="{{ old('title') }}" required placeholder="Ex: Réunion équipe, Livraison matériel...">
                    @error('title')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type d'événement -->
                <div class="form-group">
                    <label class="form-label" for="event_type">Type d'événement *</label>
                    <select id="event_type" name="event_type" class="form-select" required>
                        <option value="">Sélectionner un type</option>
                        <option value="meeting" {{ old('event_type') == 'meeting' ? 'selected' : '' }}>Réunion</option>
                        <option value="delivery" {{ old('event_type') == 'delivery' ? 'selected' : '' }}>Livraison</option>
                        <option value="visit" {{ old('event_type') == 'visit' ? 'selected' : '' }}>Visite</option>
                        <option value="task" {{ old('event_type') == 'task' ? 'selected' : '' }}>Tâche</option>
                        <option value="instruction" {{ old('event_type') == 'instruction' ? 'selected' : '' }}>Instruction</option>
                    </select>
                    @error('event_type')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Assigné à -->
                <div class="form-group">
                    <label class="form-label" for="assigned_to">Assigné à</label>
                    <select id="assigned_to" name="assigned_to" class="form-select">
                        <option value="">Non assigné</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date et heure de début -->
                <div class="form-group">
                    <label class="form-label" for="start_date">Date et heure de début *</label>
                    <input type="datetime-local" id="start_date" name="start_date" class="form-input" 
                           value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date et heure de fin -->
                <div class="form-group">
                    <label class="form-label" for="end_date">Date et heure de fin</label>
                    <input type="datetime-local" id="end_date" name="end_date" class="form-input" 
                           value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lieu -->
                <div class="form-group full-width">
                    <label class="form-label" for="location">Lieu</label>
                    <input type="text" id="location" name="location" class="form-input" 
                           value="{{ old('location') }}" placeholder="Ex: Salle de réunion, Entrepôt A...">
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-textarea" 
                              placeholder="Description détaillée de l'événement">{{ old('description') }}</textarea>
                </div>

                <!-- Priorité -->
                <div class="form-group full-width">
                    <label class="form-label">Priorité *</label>
                    <div class="priority-options">
                        <div class="priority-option">
                            <input type="radio" id="priority_low" name="priority" value="low" class="priority-radio" 
                                   {{ old('priority', 'medium') == 'low' ? 'checked' : '' }}>
                            <label for="priority_low" class="priority-label">Faible</label>
                        </div>
                        <div class="priority-option">
                            <input type="radio" id="priority_medium" name="priority" value="medium" class="priority-radio" 
                                   {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                            <label for="priority_medium" class="priority-label">Normale</label>
                        </div>
                        <div class="priority-option">
                            <input type="radio" id="priority_high" name="priority" value="high" class="priority-radio" 
                                   {{ old('priority') == 'high' ? 'checked' : '' }}>
                            <label for="priority_high" class="priority-label">Élevée</label>
                        </div>
                        <div class="priority-option">
                            <input type="radio" id="priority_urgent" name="priority" value="urgent" class="priority-radio" 
                                   {{ old('priority') == 'urgent' ? 'checked' : '' }}>
                            <label for="priority_urgent" class="priority-label">Urgente</label>
                        </div>
                    </div>
                </div>

                <!-- Statut -->
                <div class="form-group full-width">
                    <label class="form-label">Statut *</label>
                    <div class="status-options">
                        <div class="status-option">
                            <input type="radio" id="status_scheduled" name="status" value="scheduled" class="status-radio" 
                                   {{ old('status', 'scheduled') == 'scheduled' ? 'checked' : '' }}>
                            <label for="status_scheduled" class="status-label">Planifié</label>
                        </div>
                        <div class="status-option">
                            <input type="radio" id="status_in_progress" name="status" value="in_progress" class="status-radio" 
                                   {{ old('status') == 'in_progress' ? 'checked' : '' }}>
                            <label for="status_in_progress" class="status-label">En cours</label>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group full-width">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="form-textarea" 
                              placeholder="Notes supplémentaires">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.weekly-agenda.index') }}" class="btn btn-secondary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    Créer l'événement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textareas
    const textareas = document.querySelectorAll('.form-textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });

    // Validation de dates
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    startDate.addEventListener('change', function() {
        if (endDate.value && new Date(endDate.value) < new Date(this.value)) {
            endDate.value = this.value;
        }
        endDate.min = this.value;
    });
});
</script>
@endsection


@extends('layouts.admin')

@section('title', 'Modifier l\'Événement - Administration CSAR')

@section('content')
<style>
:root {
    --edit-primary: #3b82f6;
    --edit-secondary: #8b5cf6;
    --edit-success: #10b981;
    --edit-warning: #f59e0b;
    --edit-danger: #ef4444;
    --edit-bg: #f8fafc;
    --edit-card-bg: #ffffff;
    --edit-border: #e5e7eb;
    --edit-text: #1f2937;
    --edit-text-muted: #6b7280;
    --edit-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.edit-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 1.5rem;
    background: var(--edit-bg);
    min-height: 100vh;
}

.edit-header {
    background: linear-gradient(135deg, var(--edit-warning), var(--edit-secondary));
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    text-align: center;
}

.edit-title {
    margin: 0;
    font-size: 2rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.edit-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
}

.form-card {
    background: var(--edit-card-bg);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--edit-shadow);
    border: 1px solid var(--edit-border);
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
    color: var(--edit-text);
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--edit-border);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.2s;
    background: var(--edit-card-bg);
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: var(--edit-primary);
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
    border: 2px solid var(--edit-border);
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
    background: var(--edit-success);
    border-color: var(--edit-success);
}

.priority-radio[value="medium"]:checked + .priority-label {
    background: var(--edit-primary);
    border-color: var(--edit-primary);
}

.priority-radio[value="high"]:checked + .priority-label {
    background: var(--edit-warning);
    border-color: var(--edit-warning);
}

.priority-radio[value="urgent"]:checked + .priority-label {
    background: var(--edit-danger);
    border-color: var(--edit-danger);
}

.status-options {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
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
    border: 2px solid var(--edit-border);
    border-radius: 8px;
    text-align: center;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.status-radio:checked + .status-label {
    background: var(--edit-primary);
    border-color: var(--edit-primary);
    color: white;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--edit-border);
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
    background: var(--edit-primary);
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--edit-border);
    color: var(--edit-text);
}

.btn-secondary:hover {
    background: #d1d5db;
    text-decoration: none;
}

.btn-danger {
    background: var(--edit-danger);
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
    transform: translateY(-1px);
}

.delete-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--edit-border);
}

.delete-warning {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--edit-danger);
}

@media (max-width: 768px) {
    .edit-container { padding: 1rem; }
    .form-grid { grid-template-columns: 1fr; }
    .priority-options { grid-template-columns: repeat(2, 1fr); }
    .status-options { grid-template-columns: repeat(2, 1fr); }
    .form-actions { flex-direction: column; }
}
</style>

<div class="edit-container">
    <!-- Header -->
    <div class="edit-header">
        <h1 class="edit-title">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
            </svg>
            Modifier l'Événement
        </h1>
        <p class="edit-subtitle">{{ $weeklyAgenda->title }}</p>
    </div>

    <!-- Form -->
    <div class="form-card">
        <form method="POST" action="{{ route('admin.weekly-agenda.update', $weeklyAgenda) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Titre -->
                <div class="form-group full-width">
                    <label class="form-label" for="title">Titre de l'événement *</label>
                    <input type="text" id="title" name="title" class="form-input" 
                           value="{{ old('title', $weeklyAgenda->title) }}" required placeholder="Ex: Réunion équipe, Livraison matériel...">
                    @error('title')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type d'événement -->
                <div class="form-group">
                    <label class="form-label" for="event_type">Type d'événement *</label>
                    <select id="event_type" name="event_type" class="form-select" required>
                        <option value="">Sélectionner un type</option>
                        <option value="meeting" {{ old('event_type', $weeklyAgenda->event_type) == 'meeting' ? 'selected' : '' }}>Réunion</option>
                        <option value="delivery" {{ old('event_type', $weeklyAgenda->event_type) == 'delivery' ? 'selected' : '' }}>Livraison</option>
                        <option value="visit" {{ old('event_type', $weeklyAgenda->event_type) == 'visit' ? 'selected' : '' }}>Visite</option>
                        <option value="task" {{ old('event_type', $weeklyAgenda->event_type) == 'task' ? 'selected' : '' }}>Tâche</option>
                        <option value="instruction" {{ old('event_type', $weeklyAgenda->event_type) == 'instruction' ? 'selected' : '' }}>Instruction</option>
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
                            <option value="{{ $user->id }}" {{ old('assigned_to', $weeklyAgenda->assigned_to) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date et heure de début -->
                <div class="form-group">
                    <label class="form-label" for="start_date">Date et heure de début *</label>
                    <input type="datetime-local" id="start_date" name="start_date" class="form-input" 
                           value="{{ old('start_date', $weeklyAgenda->start_date->format('Y-m-d\TH:i')) }}" required>
                    @error('start_date')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date et heure de fin -->
                <div class="form-group">
                    <label class="form-label" for="end_date">Date et heure de fin</label>
                    <input type="datetime-local" id="end_date" name="end_date" class="form-input" 
                           value="{{ old('end_date', $weeklyAgenda->end_date ? $weeklyAgenda->end_date->format('Y-m-d\TH:i') : '') }}">
                    @error('end_date')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lieu -->
                <div class="form-group full-width">
                    <label class="form-label" for="location">Lieu</label>
                    <input type="text" id="location" name="location" class="form-input" 
                           value="{{ old('location', $weeklyAgenda->location) }}" placeholder="Ex: Salle de réunion, Entrepôt A...">
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-textarea" 
                              placeholder="Description détaillée de l'événement">{{ old('description', $weeklyAgenda->description) }}</textarea>
                </div>

                <!-- Priorité -->
                <div class="form-group full-width">
                    <label class="form-label">Priorité *</label>
                    <div class="priority-options">
                        <div class="priority-option">
                            <input type="radio" id="priority_low" name="priority" value="low" class="priority-radio" 
                                   {{ old('priority', $weeklyAgenda->priority) == 'low' ? 'checked' : '' }}>
                            <label for="priority_low" class="priority-label">Faible</label>
                        </div>
                        <div class="priority-option">
                            <input type="radio" id="priority_medium" name="priority" value="medium" class="priority-radio" 
                                   {{ old('priority', $weeklyAgenda->priority) == 'medium' ? 'checked' : '' }}>
                            <label for="priority_medium" class="priority-label">Normale</label>
                        </div>
                        <div class="priority-option">
                            <input type="radio" id="priority_high" name="priority" value="high" class="priority-radio" 
                                   {{ old('priority', $weeklyAgenda->priority) == 'high' ? 'checked' : '' }}>
                            <label for="priority_high" class="priority-label">Élevée</label>
                        </div>
                        <div class="priority-option">
                            <input type="radio" id="priority_urgent" name="priority" value="urgent" class="priority-radio" 
                                   {{ old('priority', $weeklyAgenda->priority) == 'urgent' ? 'checked' : '' }}>
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
                                   {{ old('status', $weeklyAgenda->status) == 'scheduled' ? 'checked' : '' }}>
                            <label for="status_scheduled" class="status-label">Planifié</label>
                        </div>
                        <div class="status-option">
                            <input type="radio" id="status_in_progress" name="status" value="in_progress" class="status-radio" 
                                   {{ old('status', $weeklyAgenda->status) == 'in_progress' ? 'checked' : '' }}>
                            <label for="status_in_progress" class="status-label">En cours</label>
                        </div>
                        <div class="status-option">
                            <input type="radio" id="status_completed" name="status" value="completed" class="status-radio" 
                                   {{ old('status', $weeklyAgenda->status) == 'completed' ? 'checked' : '' }}>
                            <label for="status_completed" class="status-label">Terminé</label>
                        </div>
                        <div class="status-option">
                            <input type="radio" id="status_cancelled" name="status" value="cancelled" class="status-radio" 
                                   {{ old('status', $weeklyAgenda->status) == 'cancelled' ? 'checked' : '' }}>
                            <label for="status_cancelled" class="status-label">Annulé</label>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group full-width">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="form-textarea" 
                              placeholder="Notes supplémentaires">{{ old('notes', $weeklyAgenda->notes) }}</textarea>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.weekly-agenda.show', $weeklyAgenda) }}" class="btn btn-secondary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    Sauvegarder les modifications
                </button>
            </div>
        </form>

        <!-- Section de suppression -->
        <div class="delete-section">
            <div class="delete-warning">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                </svg>
                <span>Attention : La suppression de cet événement est irréversible.</span>
            </div>
            <form method="POST" action="{{ route('admin.weekly-agenda.destroy', $weeklyAgenda) }}" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                    </svg>
                    Supprimer l'événement
                </button>
            </form>
        </div>
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
        // Initial resize
        textarea.dispatchEvent(new Event('input'));
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


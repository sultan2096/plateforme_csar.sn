@extends('layouts.admin')

@section('title', 'Modifier la Tâche - CSAR')

@section('content')
<style>
:root {
    --primary-blue: #2563eb;
    --primary-blue-dark: #1d4ed8;
    --success-green: #059669;
    --warning-orange: #d97706;
    --danger-red: #dc2626;
    --purple-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --blue-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --green-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-600: #4b5563;
    --gray-800: #1f2937;
    --gray-900: #111827;
}

.admin-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.admin-header {
    background: var(--purple-gradient);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.admin-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 100%;
    height: 200%;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
    opacity: 0.1;
}

.admin-header-content {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
}

.admin-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.admin-header-icon {
    background: rgba(255, 255, 255, 0.2);
    padding: 1rem;
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.admin-header p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.btn-header {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-header:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.form-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-100);
    overflow: hidden;
}

.form-header {
    background: var(--blue-gradient);
    color: white;
    padding: 2rem;
    text-align: center;
}

.form-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.form-header p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
}

.form-body {
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
}

.form-section:last-child {
    margin-bottom: 0;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--gray-200);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-icon {
    color: var(--primary-blue);
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-weight: 600;
    color: var(--gray-800);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.required-mark {
    color: var(--danger-red);
}

.form-input,
.form-select,
.form-textarea {
    padding: 0.875rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-input.is-invalid,
.form-select.is-invalid,
.form-textarea.is-invalid {
    border-color: var(--danger-red);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.invalid-feedback {
    color: var(--danger-red);
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    appearance: none;
}

.priority-preview {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.priority-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.priority-low {
    background: #e5e7eb;
    color: #6b7280;
}

.priority-medium {
    background: #fef3c7;
    color: #d97706;
}

.priority-high {
    background: #fee2e2;
    color: #dc2626;
}

.priority-urgent {
    background: #dc2626;
    color: white;
    animation: pulse 2s infinite;
}

.tags-container {
    position: relative;
}

.tags-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.5rem;
    min-height: 2rem;
    align-items: flex-start;
}

.tag-item {
    background: var(--primary-blue);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    animation: fadeInScale 0.3s ease;
}

.tag-remove {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 1rem;
    line-height: 1;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.tag-remove:hover {
    opacity: 1;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--gray-100);
}

.btn-primary {
    background: var(--blue-gradient);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
}

.btn-secondary {
    background: white;
    color: var(--gray-600);
    border: 2px solid var(--gray-200);
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-secondary:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
    color: var(--gray-800);
    text-decoration: none;
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }
    
    .admin-header {
        padding: 1.5rem;
    }
    
    .admin-header h1 {
        font-size: 1.75rem;
    }
    
    .form-body {
        padding: 1.5rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .admin-header-content {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <div class="admin-header-content">
            <div>
                <h1>
                    <div class="admin-header-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    Modifier la Tâche
                </h1>
                <p>Mettre à jour les informations de la tâche</p>
            </div>
            <a href="{{ route('admin.tasks.show', $task) }}" class="btn-header">
                <i class="fas fa-eye"></i>
                Voir Détails
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <h2>
                <i class="fas fa-tasks"></i>
                Modifier: {{ Str::limit($task->title, 50) }}
            </h2>
            <p>Modifiez les informations ci-dessous</p>
        </div>

        <div class="form-body">
            <form method="POST" action="{{ route('admin.tasks.update', $task) }}" id="taskEditForm" onsubmit="handleSubmit(event)">
                @csrf
                @method('PUT')

                <!-- Section Informations Générales -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle section-icon"></i>
                        Informations Générales
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Titre <span class="required-mark">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title" 
                                value="{{ old('title', $task->title) }}" 
                                class="form-input @error('title') is-invalid @enderror" 
                                required
                                placeholder="Ex: Finaliser le rapport mensuel">
                            @error('title')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Échéance <span class="required-mark">*</span>
                            </label>
                            <input 
                                type="date" 
                                name="due_date" 
                                value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" 
                                class="form-input @error('due_date') is-invalid @enderror" 
                                required>
                            @error('due_date')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea 
                            name="description" 
                            rows="4" 
                            class="form-textarea @error('description') is-invalid @enderror"
                            placeholder="Décrivez les détails de la tâche...">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Section Configuration -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-cogs section-icon"></i>
                        Configuration
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Priorité <span class="required-mark">*</span>
                            </label>
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror" required onchange="updatePriorityPreview(this.value)">
                                @php($prio = old('priority', $task->priority))
                                <option value="low" {{ $prio==='low' ? 'selected' : '' }}>Basse</option>
                                <option value="medium" {{ $prio==='medium' ? 'selected' : '' }}>Moyenne</option>
                                <option value="high" {{ $prio==='high' ? 'selected' : '' }}>Haute</option>
                                <option value="urgent" {{ $prio==='urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            <div class="priority-preview">
                                <span>Aperçu:</span>
                                <span class="priority-badge priority-{{ $prio }}" id="priorityBadge">{{ ucfirst($prio) }}</span>
                            </div>
                            @error('priority')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Statut <span class="required-mark">*</span>
                            </label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                @php($status = old('status', $task->status))
                                <option value="todo" {{ $status==='todo' ? 'selected' : '' }}>À faire</option>
                                <option value="in_progress" {{ $status==='in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="done" {{ $status==='done' ? 'selected' : '' }}>Terminée</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Assigner à <span class="required-mark">*</span>
                        </label>
                        <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror" required>
                            <option value="">— Sélectionner un agent —</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ old('assigned_to', $task->assigned_to) == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} 
                                    @if($u->department) — {{ $u->department }} @endif
                                    @if($u->position) ({{ $u->position }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Section Détails Supplémentaires -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-edit section-icon"></i>
                        Détails Supplémentaires
                    </h3>

                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <textarea 
                            name="notes" 
                            rows="3" 
                            class="form-textarea @error('notes') is-invalid @enderror"
                            placeholder="Notes additionnelles, instructions spécifiques...">{{ old('notes', $task->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tags</label>
                        <div class="tags-container">
                            <input 
                                type="text" 
                                id="tagsInput"
                                class="form-input @error('tags') is-invalid @enderror" 
                                placeholder="Tapez un tag et appuyez sur Entrée..."
                                onkeypress="handleTagInput(event)">
                            <div class="tags-preview" id="tagsPreview"></div>
                        </div>
                        @error('tags')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.tasks.show', $task) }}" class="btn-secondary">
                        <i class="fas fa-times"></i>
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i>
                        Enregistrer les Modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let tags = [];

// Initialize with existing tags
@if($task->tags)
    tags = @json($task->tags);
    updateTagsDisplay();
@endif

// Override with old input if validation failed
@if(old('tags'))
    @if(is_array(old('tags')))
        tags = @json(old('tags'));
    @else
        tags = '{{ old('tags') }}'.split(',').map(t => t.trim()).filter(t => t.length > 0);
    @endif
    updateTagsDisplay();
@endif

function updatePriorityPreview(priority) {
    const badge = document.getElementById('priorityBadge');
    const priorityLabels = {
        'low': 'Basse',
        'medium': 'Moyenne', 
        'high': 'Haute',
        'urgent': 'Urgent'
    };
    
    badge.textContent = priorityLabels[priority];
    badge.className = `priority-badge priority-${priority}`;
}

function handleTagInput(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const input = event.target;
        const tag = input.value.trim();
        
        if (tag && !tags.includes(tag)) {
            tags.push(tag);
            updateTagsDisplay();
            input.value = '';
        }
    }
}

function removeTag(index) {
    tags.splice(index, 1);
    updateTagsDisplay();
}

function updateTagsDisplay() {
    const preview = document.getElementById('tagsPreview');
    preview.innerHTML = tags.map((tag, index) => `
        <span class="tag-item">
            ${tag}
            <button type="button" class="tag-remove" onclick="removeTag(${index})">×</button>
        </span>
    `).join('');
}

function handleSubmit(event) {
    const form = event.target;
    
    // Remove old hidden inputs
    [...form.querySelectorAll('input[name="tags[]"]')].forEach(el => el.remove());
    
    // Add current tags
    tags.forEach(tag => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'tags[]';
        input.value = tag;
        form.appendChild(input);
    });
    
    // Add loading state
    form.classList.add('form-loading');
}

// Initialize priority preview
document.addEventListener('DOMContentLoaded', function() {
    const prioritySelect = document.querySelector('select[name="priority"]');
    updatePriorityPreview(prioritySelect.value);
});
</script>
@endpush

@endsection


@extends('layouts.admin')

@section('title', 'Détails de la Tâche - CSAR')

@section('content')
<style>
:root {
    --primary-blue: #2563eb;
    --success-green: #059669;
    --warning-orange: #d97706;
    --danger-red: #dc2626;
    --purple-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-600: #4b5563;
    --gray-800: #1f2937;
}

.admin-container {
    padding: 2rem;
    max-width: 1000px;
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
    color: white;
}

.admin-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 1rem;
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
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-header:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
}

.task-details {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.task-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.task-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.task-meta {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 1rem;
}

.meta-item {
    text-align: center;
}

.meta-label {
    font-size: 0.875rem;
    opacity: 0.8;
    margin-bottom: 0.25rem;
}

.meta-value {
    font-weight: 600;
}

.task-body {
    padding: 2rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.info-section {
    background: var(--gray-50);
    border-radius: 15px;
    padding: 1.5rem;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-item {
    margin-bottom: 1rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    font-weight: 600;
    color: var(--gray-600);
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.info-value {
    color: var(--gray-800);
}

.priority-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.priority-low { background: #e5e7eb; color: #6b7280; }
.priority-medium { background: #fef3c7; color: #d97706; }
.priority-high { background: #fee2e2; color: #dc2626; }
.priority-urgent { background: #dc2626; color: white; }

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-todo { background: #fef3c7; color: #d97706; }
.status-in_progress { background: #dbeafe; color: #2563eb; }
.status-done { background: #d1fae5; color: #059669; }

.tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag-item {
    background: var(--primary-blue);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.actions-section {
    padding: 2rem;
    border-top: 2px solid var(--gray-100);
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: var(--primary-blue);
    color: white;
}

.btn-warning {
    background: var(--warning-orange);
    color: white;
}

.btn-danger {
    background: var(--danger-red);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }
    
    .task-meta {
        flex-direction: column;
        gap: 1rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-section {
        flex-direction: column;
    }
}
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>
                    <i class="fas fa-eye"></i>
                    Détails de la Tâche
                </h1>
                <p class="mb-0 opacity-75">Informations complètes de la tâche</p>
            </div>
            <a href="{{ route('admin.tasks.index') }}" class="btn-header">
                <i class="fas fa-arrow-left"></i>
                Retour aux Tâches
            </a>
        </div>
    </div>

    <!-- Task Details -->
    <div class="task-details">
        <div class="task-header">
            <h2 class="task-title">{{ $task->title }}</h2>
            
            <div class="task-meta">
                <div class="meta-item">
                    <div class="meta-label">Priorité</div>
                    <div class="meta-value">
                        <span class="priority-badge priority-{{ $task->priority }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                </div>
                
                <div class="meta-item">
                    <div class="meta-label">Statut</div>
                    <div class="meta-value">
                        <span class="status-badge status-{{ $task->status }}">
                            {{ str_replace('_', ' ', ucfirst($task->status)) }}
                        </span>
                    </div>
                </div>
                
                <div class="meta-item">
                    <div class="meta-label">Échéance</div>
                    <div class="meta-value">
                        {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Non définie' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="task-body">
            <div class="info-grid">
                <!-- Informations Générales -->
                <div class="info-section">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle text-primary"></i>
                        Informations Générales
                    </h3>
                    
                    @if($task->description)
                        <div class="info-item">
                            <div class="info-label">Description</div>
                            <div class="info-value">{{ $task->description }}</div>
                        </div>
                    @endif
                    
                    <div class="info-item">
                        <div class="info-label">Créée le</div>
                        <div class="info-value">{{ $task->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    
                    @if($task->completed_at)
                        <div class="info-item">
                            <div class="info-label">Terminée le</div>
                            <div class="info-value">{{ $task->completed_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    @endif
                </div>

                <!-- Assignation -->
                <div class="info-section">
                    <h3 class="section-title">
                        <i class="fas fa-users text-success"></i>
                        Assignation
                    </h3>
                    
                    <div class="info-item">
                        <div class="info-label">Assignée à</div>
                        <div class="info-value">
                            {{ $task->assignedTo ? $task->assignedTo->name : 'Non assigné' }}
                            @if($task->assignedTo && $task->assignedTo->department)
                                <br><small class="text-muted">{{ $task->assignedTo->department }}</small>
                            @endif
                        </div>
                    </div>
                    
                    @if($task->assignedBy)
                        <div class="info-item">
                            <div class="info-label">Assignée par</div>
                            <div class="info-value">{{ $task->assignedBy->name }}</div>
                        </div>
                    @endif
                </div>
            </div>

            @if($task->notes)
                <div class="info-section">
                    <h3 class="section-title">
                        <i class="fas fa-sticky-note text-warning"></i>
                        Notes
                    </h3>
                    <div class="info-value">{{ $task->notes }}</div>
                </div>
            @endif

            @if($task->tags && count($task->tags) > 0)
                <div class="info-section">
                    <h3 class="section-title">
                        <i class="fas fa-tags text-info"></i>
                        Tags
                    </h3>
                    <div class="tags-container">
                        @foreach($task->tags as $tag)
                            <span class="tag-item">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="actions-section">
            @if($task->status !== 'done')
                <form method="POST" action="{{ route('admin.tasks.update-status', $task) }}" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="done">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i>
                        Marquer comme Terminée
                    </button>
                </form>
            @endif
            
            <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>
                Modifier
            </a>
            
            <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

@endsection


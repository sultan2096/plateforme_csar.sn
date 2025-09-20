@extends('layouts.admin')

@section('title', 'Gestion des Tâches - CSAR')

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
    --orange-gradient: linear-gradient(135deg, #fc7303 0%, #ffb347 100%);
    --red-gradient: linear-gradient(135deg, #ff512f 0%, #f09819 100%);
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-600: #4b5563;
    --gray-800: #1f2937;
}

.admin-container {
    padding: 2rem;
    max-width: 1600px;
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

/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-100);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
}

.stat-card.total {
    background: var(--blue-gradient);
    color: white;
}

.stat-card.todo {
    background: var(--orange-gradient);
    color: white;
}

.stat-card.progress {
    background: var(--purple-gradient);
    color: white;
}

.stat-card.done {
    background: var(--green-gradient);
    color: white;
}

.stat-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-info h3 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
    opacity: 0.9;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
    line-height: 1;
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.7;
}

/* Kanban Board */
.kanban-container {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-100);
}

.kanban-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 2rem;
}

.kanban-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0;
}

.kanban-board {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.kanban-column {
    background: var(--gray-50);
    border-radius: 15px;
    padding: 1.5rem;
    min-height: 500px;
    position: relative;
}

.column-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--gray-200);
}

.column-title {
    font-weight: 700;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.column-count {
    background: var(--gray-600);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.column-todo .column-title {
    color: var(--warning-orange);
}

.column-todo .column-count {
    background: var(--warning-orange);
}

.column-progress .column-title {
    color: var(--primary-blue);
}

.column-progress .column-count {
    background: var(--primary-blue);
}

.column-done .column-title {
    color: var(--success-green);
}

.column-done .column-count {
    background: var(--success-green);
}

/* Task Cards */
.task-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    cursor: grab;
    position: relative;
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.task-card:active {
    cursor: grabbing;
}

.task-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.task-title {
    font-weight: 700;
    font-size: 1rem;
    color: var(--gray-800);
    margin: 0;
    line-height: 1.4;
}

.task-priority {
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

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.task-description {
    color: var(--gray-600);
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.task-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.75rem;
    color: var(--gray-600);
    margin-bottom: 1rem;
}

.task-assignee {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.task-due-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.task-due-date.overdue {
    color: var(--danger-red);
    font-weight: 600;
}

.task-actions {
    display: flex;
    gap: 0.5rem;
}

.task-btn {
    padding: 0.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1;
}

.task-btn:hover {
    transform: translateY(-1px);
}

.task-btn.view {
    background: #e0f2fe;
    color: #0277bd;
}

.task-btn.view:hover {
    background: #b3e5fc;
}

.task-btn.edit {
    background: #fff3e0;
    color: #f57c00;
}

.task-btn.edit:hover {
    background: #ffe0b2;
}

.task-btn.delete {
    background: #ffebee;
    color: #d32f2f;
}

.task-btn.delete:hover {
    background: #ffcdd2;
}

/* Progress Bar for In Progress Tasks */
.task-progress {
    background: var(--gray-200);
    border-radius: 10px;
    height: 6px;
    margin-bottom: 1rem;
    overflow: hidden;
}

.task-progress-bar {
    background: var(--primary-blue);
    height: 100%;
    border-radius: 10px;
    transition: width 0.3s ease;
}

/* Drag and Drop Styling */
.drag-over {
    background: rgba(37, 99, 235, 0.1);
    border: 2px dashed var(--primary-blue);
}

.task-card.dragging {
    opacity: 0.5;
    transform: rotate(5deg);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--gray-600);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

/* Responsive */
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
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .kanban-board {
        grid-template-columns: 1fr;
    }
    
    .admin-header-content {
        flex-direction: column;
        gap: 1rem;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card {
    animation: fadeInUp 0.6s ease forwards;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

.task-card {
    animation: fadeInUp 0.6s ease forwards;
}
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <div class="admin-header-content">
        <div>
                <h1>
                    <div class="admin-header-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    Gestion des Tâches
                </h1>
                <p>Tableau Kanban pour le suivi et la gestion des tâches</p>
        </div>
            <a href="{{ route('admin.tasks.create') }}" class="btn-header">
                <i class="fas fa-plus"></i>
                Nouvelle Tâche
        </a>
    </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>Total des Tâches</h3>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                        </div>
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
        </div>

        <div class="stat-card todo">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>À Faire</h3>
                    <div class="stat-value">{{ $stats['todo'] ?? 0 }}</div>
                        </div>
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="stat-card progress">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>En Cours</h3>
                    <div class="stat-value">{{ $stats['in_progress'] ?? 0 }}</div>
                        </div>
                <div class="stat-icon">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
        </div>

        <div class="stat-card done">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>Terminées</h3>
                    <div class="stat-value">{{ $stats['done'] ?? 0 }}</div>
                        </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="kanban-container">
        <div class="kanban-header">
            <h2 class="kanban-title">Tableau Kanban</h2>
        </div>
        
        <div class="kanban-board">
            <!-- Column À Faire -->
            <div class="kanban-column column-todo" data-status="todo">
                <div class="column-header">
                    <div class="column-title">
                        <i class="fas fa-clock"></i>
                        À Faire
                    </div>
                    <span class="column-count">{{ ($allTasks ?? $tasks)->where('status', 'todo')->count() }}</span>
                </div>
                
                <div class="column-content" id="todo-column">
                    @forelse(($allTasks ?? $tasks)->where('status', 'todo') as $task)
                        <div class="task-card" data-task-id="{{ $task->id }}" draggable="true">
                            <div class="task-header">
                                <h4 class="task-title">{{ $task->title }}</h4>
                                <span class="task-priority priority-{{ $task->priority }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </div>
                            
                                    @if($task->description)
                                <div class="task-description">
                                    {{ Str::limit($task->description, 100) }}
                                </div>
                                    @endif
                            
                            <div class="task-meta">
                                <div class="task-assignee">
                                    <i class="fas fa-user"></i>
                                    {{ $task->assignedTo ? $task->assignedTo->name : 'Non assigné' }}
                                </div>
                                        @if($task->due_date)
                                    <div class="task-due-date {{ $task->due_date < now() ? 'overdue' : '' }}">
                                        <i class="fas fa-calendar"></i>
                                        {{ $task->due_date->format('d/m/Y') }}
                                    </div>
                                        @endif
                                    </div>
                            
                            <div class="task-actions">
                                <button type="button" class="task-btn view" onclick="viewTask({{ $task->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                <button type="button" class="task-btn edit" onclick="editTask({{ $task->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                <button type="button" class="task-btn delete" onclick="deleteTask({{ $task->id }})">
                                    <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Aucune tâche à faire</p>
                                </div>
                    @endforelse
            </div>
        </div>

            <!-- Column En Cours -->
            <div class="kanban-column column-progress" data-status="in_progress">
                <div class="column-header">
                    <div class="column-title">
                        <i class="fas fa-spinner"></i>
                        En Cours
                    </div>
                    <span class="column-count">{{ ($allTasks ?? $tasks)->where('status', 'in_progress')->count() }}</span>
                </div>
                
                <div class="column-content" id="in-progress-column">
                    @forelse(($allTasks ?? $tasks)->where('status', 'in_progress') as $task)
                        <div class="task-card" data-task-id="{{ $task->id }}" draggable="true">
                            <div class="task-header">
                                <h4 class="task-title">{{ $task->title }}</h4>
                                <span class="task-priority priority-{{ $task->priority }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </div>
                            
                                    @if($task->description)
                                <div class="task-description">
                                    {{ Str::limit($task->description, 100) }}
                                </div>
                            @endif
                            
                            @if(isset($task->progress_percentage))
                                <div class="task-progress">
                                    <div class="task-progress-bar" style="width: {{ $task->progress_percentage ?? 50 }}%"></div>
                                </div>
                                    @endif
                            
                            <div class="task-meta">
                                <div class="task-assignee">
                                    <i class="fas fa-user"></i>
                                    {{ $task->assignedTo ? $task->assignedTo->name : 'Non assigné' }}
                                </div>
                                @if($task->due_date)
                                    <div class="task-due-date {{ $task->due_date < now() ? 'overdue' : '' }}">
                                        <i class="fas fa-calendar"></i>
                                        {{ $task->due_date->format('d/m/Y') }}
                                    </div>
                                            @endif
                                    </div>
                            
                            <div class="task-actions">
                                <button type="button" class="task-btn view" onclick="viewTask({{ $task->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                <button type="button" class="task-btn edit" onclick="editTask({{ $task->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                <button type="button" class="task-btn delete" onclick="deleteTask({{ $task->id }})">
                                    <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-spinner"></i>
                            <p>Aucune tâche en cours</p>
                                </div>
                    @endforelse
            </div>
        </div>

            <!-- Column Terminées -->
            <div class="kanban-column column-done" data-status="done">
                <div class="column-header">
                    <div class="column-title">
                        <i class="fas fa-check-circle"></i>
                        Terminées
                    </div>
                    <span class="column-count">{{ ($allTasks ?? $tasks)->where('status', 'done')->count() }}</span>
                </div>
                
                <div class="column-content" id="done-column">
                    @forelse(($allTasks ?? $tasks)->where('status', 'done') as $task)
                        <div class="task-card" data-task-id="{{ $task->id }}" draggable="true">
                            <div class="task-header">
                                <h4 class="task-title">{{ $task->title }}</h4>
                                <span class="task-priority priority-{{ $task->priority }}">
                                    Terminée
                                </span>
                                    </div>
                            
                                    @if($task->description)
                                <div class="task-description">
                                    {{ Str::limit($task->description, 100) }}
                                </div>
                                    @endif
                            
                            <div class="task-meta">
                                <div class="task-assignee">
                                    <i class="fas fa-user"></i>
                                    {{ $task->assignedTo ? $task->assignedTo->name : 'Non assigné' }}
                                </div>
                                        @if($task->completed_at)
                                    <div class="task-due-date">
                                        <i class="fas fa-check"></i>
                                        {{ $task->completed_at->format('d/m/Y') }}
                                    </div>
                                        @endif
                                    </div>
                            
                            <div class="task-actions">
                                <button type="button" class="task-btn view" onclick="viewTask({{ $task->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                <button type="button" class="task-btn edit" onclick="editTask({{ $task->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                <button type="button" class="task-btn delete" onclick="deleteTask({{ $task->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                        </div>
                                    </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <p>Aucune tâche terminée</p>
                                </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Drag and Drop functionality
    $('.task-card').on('dragstart', function(e) {
        $(this).addClass('dragging');
        e.originalEvent.dataTransfer.setData('text/plain', $(this).data('task-id'));
    });

    $('.task-card').on('dragend', function(e) {
        $(this).removeClass('dragging');
    });

    $('.column-content').on('dragover', function(e) {
        e.preventDefault();
        $(this).closest('.kanban-column').addClass('drag-over');
    });

    $('.column-content').on('dragleave', function(e) {
        if (!$(this).closest('.kanban-column')[0].contains(e.relatedTarget)) {
            $(this).closest('.kanban-column').removeClass('drag-over');
        }
    });

    $('.column-content').on('drop', function(e) {
        e.preventDefault();
        $(this).closest('.kanban-column').removeClass('drag-over');
        
        const taskId = e.originalEvent.dataTransfer.getData('text/plain');
        const newStatus = $(this).closest('.kanban-column').data('status');
        
        updateTaskStatus(taskId, newStatus);
    });
});

function viewTask(taskId) {
    window.location.href = `/admin/tasks/${taskId}`;
}

function editTask(taskId) {
    window.location.href = `/admin/tasks/${taskId}/edit`;
}

function deleteTask(taskId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/tasks/${taskId}`;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';
        
        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function updateTaskStatus(taskId, status) {
    $.ajax({
        url: `/admin/tasks/${taskId}/update-status`,
        method: 'PATCH',
        data: {
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function() {
            alert('Erreur lors de la mise à jour du statut');
        }
    });
}

// Animation au scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
        }
    });
}, observerOptions);

document.querySelectorAll('.task-card').forEach(card => {
    observer.observe(card);
});
</script>
@endpush 
 
@endsection
 
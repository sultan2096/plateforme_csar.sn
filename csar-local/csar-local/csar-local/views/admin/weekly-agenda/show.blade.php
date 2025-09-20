@extends('layouts.admin')

@section('title', 'Détail de l\'Événement - Administration CSAR')

@section('content')
<style>
:root {
    --show-primary: #3b82f6;
    --show-secondary: #8b5cf6;
    --show-success: #10b981;
    --show-warning: #f59e0b;
    --show-danger: #ef4444;
    --show-info: #06b6d4;
    --show-bg: #f8fafc;
    --show-card-bg: #ffffff;
    --show-border: #e5e7eb;
    --show-text: #1f2937;
    --show-text-muted: #6b7280;
    --show-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.show-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 1.5rem;
    background: var(--show-bg);
    min-height: 100vh;
}

.show-header {
    background: linear-gradient(135deg, var(--show-primary), var(--show-secondary));
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.show-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.show-header-content {
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
}

.show-title {
    margin: 0;
    font-size: 2rem;
    font-weight: 800;
    line-height: 1.2;
}

.show-meta {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
    flex-wrap: wrap;
}

.show-badge {
    padding: 0.5rem 1rem;
    border-radius: 999px;
    font-size: 0.875rem;
    font-weight: 600;
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.show-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.2s;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

.details-grid {
    display: grid;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.detail-card {
    background: var(--show-card-bg);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: var(--show-shadow);
    border: 1px solid var(--show-border);
}

.detail-section {
    margin-bottom: 1.5rem;
}

.detail-section:last-child {
    margin-bottom: 0;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--show-text);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--show-bg);
    border-radius: 12px;
    border: 1px solid var(--show-border);
}

.info-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-icon.primary { background: rgba(59, 130, 246, 0.1); color: var(--show-primary); }
.info-icon.success { background: rgba(16, 185, 129, 0.1); color: var(--show-success); }
.info-icon.warning { background: rgba(245, 158, 11, 0.1); color: var(--show-warning); }
.info-icon.danger { background: rgba(239, 68, 68, 0.1); color: var(--show-danger); }
.info-icon.info { background: rgba(6, 182, 212, 0.1); color: var(--show-info); }

.info-content h4 {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--show-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-content p {
    margin: 0.25rem 0 0 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--show-text);
}

.priority-badge, .status-badge, .type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 999px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.priority-badge.low { background: rgba(16, 185, 129, 0.1); color: var(--show-success); }
.priority-badge.medium { background: rgba(6, 182, 212, 0.1); color: var(--show-info); }
.priority-badge.high { background: rgba(245, 158, 11, 0.1); color: var(--show-warning); }
.priority-badge.urgent { background: rgba(239, 68, 68, 0.1); color: var(--show-danger); }

.status-badge.scheduled { background: rgba(107, 114, 128, 0.1); color: var(--show-text-muted); }
.status-badge.in_progress { background: rgba(6, 182, 212, 0.1); color: var(--show-info); }
.status-badge.completed { background: rgba(16, 185, 129, 0.1); color: var(--show-success); }
.status-badge.cancelled { background: rgba(239, 68, 68, 0.1); color: var(--show-danger); }

.type-badge.meeting { background: rgba(6, 182, 212, 0.1); color: var(--show-info); }
.type-badge.delivery { background: rgba(16, 185, 129, 0.1); color: var(--show-success); }
.type-badge.visit { background: rgba(245, 158, 11, 0.1); color: var(--show-warning); }
.type-badge.task { background: rgba(139, 92, 246, 0.1); color: var(--show-secondary); }
.type-badge.instruction { background: rgba(239, 68, 68, 0.1); color: var(--show-danger); }

.description-content {
    color: var(--show-text);
    line-height: 1.6;
    margin: 0;
}

.notes-content {
    color: var(--show-text-muted);
    line-height: 1.6;
    margin: 0;
    font-style: italic;
}

.status-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--show-border);
}

.status-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.status-btn.start {
    background: var(--show-info);
    color: white;
}

.status-btn.complete {
    background: var(--show-success);
    color: white;
}

.status-btn.cancel {
    background: var(--show-danger);
    color: white;
}

.status-btn:hover {
    transform: translateY(-1px);
    box-shadow: var(--show-shadow);
}

.empty-state {
    text-align: center;
    color: var(--show-text-muted);
    font-style: italic;
}

@media (max-width: 768px) {
    .show-container { padding: 1rem; }
    .show-header-content { flex-direction: column; align-items: flex-start; }
    .info-grid { grid-template-columns: 1fr; }
    .show-actions { justify-content: center; }
}
</style>

<div class="show-container">
    <!-- Header -->
    <div class="show-header">
        <div class="show-header-content">
            <div style="flex: 1;">
                <h1 class="show-title">{{ $weeklyAgenda->title }}</h1>
                <div class="show-meta">
                    <span class="type-badge {{ $weeklyAgenda->event_type }}">
                        {{ ucfirst($weeklyAgenda->event_type) }}
                    </span>
                    <span class="priority-badge {{ $weeklyAgenda->priority }}">
                        {{ ucfirst($weeklyAgenda->priority) }}
                    </span>
                    <span class="status-badge {{ $weeklyAgenda->status }}">
                        {{ ucfirst(str_replace('_', ' ', $weeklyAgenda->status)) }}
                    </span>
                </div>
            </div>
            <div class="show-actions">
                <a href="{{ route('admin.weekly-agenda.index') }}" class="action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                    Retour
                </a>
                <a href="{{ route('admin.weekly-agenda.edit', $weeklyAgenda) }}" class="action-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    Modifier
                </a>
            </div>
        </div>
    </div>

    <!-- Details -->
    <div class="details-grid">
        <!-- Informations principales -->
        <div class="detail-card">
            <div class="detail-section">
                <h2 class="section-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Informations principales
                </h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-icon primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h4>Date et heure de début</h4>
                            <p>{{ $weeklyAgenda->start_date->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if($weeklyAgenda->end_date)
                    <div class="info-item">
                        <div class="info-icon primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h4>Date et heure de fin</h4>
                            <p>{{ $weeklyAgenda->end_date->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($weeklyAgenda->location)
                    <div class="info-item">
                        <div class="info-icon warning">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h4>Lieu</h4>
                            <p>{{ $weeklyAgenda->location }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="info-item">
                        <div class="info-icon info">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h4>Assigné à</h4>
                            <p>
                                @if($weeklyAgenda->assignedTo)
                                    {{ $weeklyAgenda->assignedTo->name }}
                                @else
                                    Non assigné
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($weeklyAgenda->description)
        <div class="detail-card">
            <div class="detail-section">
                <h2 class="section-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                    Description
                </h2>
                <p class="description-content">{{ $weeklyAgenda->description }}</p>
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($weeklyAgenda->notes)
        <div class="detail-card">
            <div class="detail-section">
                <h2 class="section-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    Notes
                </h2>
                <p class="notes-content">{{ $weeklyAgenda->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Actions de statut -->
        <div class="detail-card">
            <div class="detail-section">
                <h2 class="section-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Actions
                </h2>
                <div class="status-actions">
                    @if($weeklyAgenda->status == 'scheduled')
                        <button class="status-btn start" onclick="updateStatus('{{ $weeklyAgenda->id }}', 'in_progress')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            Démarrer
                        </button>
                    @elseif($weeklyAgenda->status == 'in_progress')
                        <button class="status-btn complete" onclick="updateStatus('{{ $weeklyAgenda->id }}', 'completed')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                            Terminer
                        </button>
                    @endif
                    
                    @if($weeklyAgenda->status != 'cancelled')
                        <button class="status-btn cancel" onclick="updateStatus('{{ $weeklyAgenda->id }}', 'cancelled')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                            Annuler
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatus(eventId, status) {
    if (!confirm('Êtes-vous sûr de vouloir changer le statut de cet événement ?')) {
        return;
    }

    fetch(`/admin/weekly-agenda/${eventId}/update-status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur lors de la mise à jour du statut');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la mise à jour du statut');
    });
}
</script>
@endsection


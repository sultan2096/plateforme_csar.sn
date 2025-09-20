@extends('layouts.admin')

@section('title', 'Agenda Hebdomadaire - Administration CSAR')

@section('content')
<style>
:root {
    --agenda-primary: #3b82f6;
    --agenda-secondary: #8b5cf6;
    --agenda-success: #10b981;
    --agenda-warning: #f59e0b;
    --agenda-danger: #ef4444;
    --agenda-info: #06b6d4;
    --agenda-bg: #f8fafc;
    --agenda-card-bg: #ffffff;
    --agenda-border: #e5e7eb;
    --agenda-text: #1f2937;
    --agenda-text-muted: #6b7280;
    --agenda-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --agenda-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.agenda-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1.5rem;
    background: var(--agenda-bg);
    min-height: 100vh;
}

.agenda-header {
    background: linear-gradient(135deg, var(--agenda-primary), var(--agenda-secondary));
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.agenda-header::before {
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

.agenda-header-content {
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.agenda-title {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.agenda-title svg {
    width: 2.5rem;
    height: 2.5rem;
    fill: currentColor;
}

.agenda-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.agenda-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.agenda-btn {
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

.agenda-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

.week-nav {
    background: var(--agenda-card-bg);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--agenda-shadow);
    border: 1px solid var(--agenda-border);
}

.week-nav-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.week-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--agenda-text);
}

.week-buttons {
    display: flex;
    gap: 0.5rem;
    background: var(--agenda-bg);
    padding: 0.25rem;
    border-radius: 12px;
}

.week-btn {
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
    border: none;
}

.week-btn.active {
    background: var(--agenda-primary);
    color: white;
    box-shadow: var(--agenda-shadow);
}

.week-btn:not(.active) {
    background: transparent;
    color: var(--agenda-text-muted);
}

.week-btn:hover {
    transform: translateY(-1px);
    text-decoration: none;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--agenda-card-bg);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: var(--agenda-shadow);
    border: 1px solid var(--agenda-border);
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
}

.stat-card.total::before { background: var(--agenda-primary); }
.stat-card.meetings::before { background: var(--agenda-info); }
.stat-card.deliveries::before { background: var(--agenda-success); }
.stat-card.visits::before { background: var(--agenda-warning); }
.stat-card.tasks::before { background: var(--agenda-secondary); }
.stat-card.instructions::before { background: var(--agenda-danger); }

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--agenda-hover-shadow);
}

.stat-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-info h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: 800;
    color: var(--agenda-text);
}

.stat-info p {
    margin: 0.25rem 0 0 0;
    color: var(--agenda-text-muted);
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-icon {
    width: 3rem;
    height: 3rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.8;
}

.stat-icon.total { background: rgba(59, 130, 246, 0.1); color: var(--agenda-primary); }
.stat-icon.meetings { background: rgba(6, 182, 212, 0.1); color: var(--agenda-info); }
.stat-icon.deliveries { background: rgba(16, 185, 129, 0.1); color: var(--agenda-success); }
.stat-icon.visits { background: rgba(245, 158, 11, 0.1); color: var(--agenda-warning); }
.stat-icon.tasks { background: rgba(139, 92, 246, 0.1); color: var(--agenda-secondary); }
.stat-icon.instructions { background: rgba(239, 68, 68, 0.1); color: var(--agenda-danger); }

.schedule-section {
    display: grid;
    gap: 1.5rem;
}

.day-card {
    background: var(--agenda-card-bg);
    border-radius: 16px;
    box-shadow: var(--agenda-shadow);
    border: 1px solid var(--agenda-border);
    overflow: hidden;
    transition: all 0.3s;
}

.day-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--agenda-hover-shadow);
}

.day-header {
    padding: 1.25rem 1.5rem;
    font-weight: 700;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.1rem;
}

.day-header.lundi { background: linear-gradient(135deg, var(--agenda-primary), #4f46e5); }
.day-header.mardi { background: linear-gradient(135deg, var(--agenda-info), #0ea5e9); }
.day-header.mercredi { background: linear-gradient(135deg, var(--agenda-warning), #f97316); }
.day-header.jeudi { background: linear-gradient(135deg, var(--agenda-success), #059669); }
.day-header.vendredi { background: linear-gradient(135deg, var(--agenda-danger), #dc2626); }
.day-header.samedi { background: linear-gradient(135deg, var(--agenda-secondary), #7c3aed); }
.day-header.dimanche { background: linear-gradient(135deg, #374151, #1f2937); }

.day-content {
    padding: 1.5rem;
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}

.event-card {
    background: var(--agenda-bg);
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid var(--agenda-border);
    transition: all 0.2s;
    position: relative;
    overflow: hidden;
}

.event-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
}

.event-card.priority-urgent::before { background: var(--agenda-danger); }
.event-card.priority-high::before { background: var(--agenda-warning); }
.event-card.priority-medium::before { background: var(--agenda-info); }
.event-card.priority-low::before { background: var(--agenda-success); }

.event-card:hover {
    transform: translateX(4px);
    box-shadow: var(--agenda-shadow);
}

.event-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.75rem;
    gap: 0.75rem;
}

.event-title {
    margin: 0;
    font-size: 1rem;
    font-weight: 700;
    color: var(--agenda-text);
    line-height: 1.3;
}

.priority-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.priority-badge.urgent { background: rgba(239, 68, 68, 0.1); color: var(--agenda-danger); }
.priority-badge.high { background: rgba(245, 158, 11, 0.1); color: var(--agenda-warning); }
.priority-badge.medium { background: rgba(6, 182, 212, 0.1); color: var(--agenda-info); }
.priority-badge.low { background: rgba(16, 185, 129, 0.1); color: var(--agenda-success); }

.event-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.event-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--agenda-text-muted);
    font-size: 0.875rem;
}

.event-description {
    color: var(--agenda-text-muted);
    font-size: 0.875rem;
    line-height: 1.4;
    margin-bottom: 0.75rem;
}

.event-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
}

.event-assignee {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--agenda-text-muted);
    font-size: 0.875rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-badge.completed { background: rgba(16, 185, 129, 0.1); color: var(--agenda-success); }
.status-badge.in_progress { background: rgba(6, 182, 212, 0.1); color: var(--agenda-info); }
.status-badge.scheduled { background: rgba(107, 114, 128, 0.1); color: var(--agenda-text-muted); }
.status-badge.cancelled { background: rgba(239, 68, 68, 0.1); color: var(--agenda-danger); }

.event-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.75rem;
}

.action-btn {
    padding: 0.5rem;
    border-radius: 8px;
    border: 1px solid var(--agenda-border);
    background: var(--agenda-card-bg);
    color: var(--agenda-text-muted);
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1;
}

.action-btn:hover {
    border-color: var(--agenda-primary);
    color: var(--agenda-primary);
    transform: translateY(-1px);
}

.empty-day {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--agenda-text-muted);
}

.empty-day svg {
    width: 4rem;
    height: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.fade-in {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .agenda-container { padding: 1rem; }
    .agenda-header { padding: 1.5rem; }
    .agenda-title { font-size: 2rem; }
    .agenda-header-content { flex-direction: column; align-items: flex-start; }
    .week-nav-content { flex-direction: column; align-items: flex-start; }
    .stats-grid { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); }
    .events-grid { grid-template-columns: 1fr; }
}
</style>

<div class="agenda-container fade-in">
    <!-- Header -->
    <div class="agenda-header">
        <div class="agenda-header-content">
            <div>
                <h1 class="agenda-title">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 2V5M16 2V5M7 10H17M5 4H19C20.1046 4 21 4.89543 21 6V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V6C3 4.89543 3.89543 4 5 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Agenda Hebdomadaire
                </h1>
                <p class="agenda-subtitle">Gestion des événements et instructions de la semaine</p>
            </div>
            <div class="agenda-actions">
                <a href="{{ route('admin.weekly-agenda.calendar') }}" class="agenda-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                    Vue Calendrier
                </a>
                <a href="{{ route('admin.weekly-agenda.create') }}" class="agenda-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Nouvel Événement
                </a>
            </div>
        </div>
    </div>

    <!-- Week Navigation -->
    <div class="week-nav">
        <div class="week-nav-content">
            <h2 class="week-title">{{ $weekTitle }}</h2>
            <div class="week-buttons">
                <a href="{{ route('admin.weekly-agenda.index', ['week' => 'current']) }}" 
                   class="week-btn {{ $week == 'current' ? 'active' : '' }}">
                    Cette semaine
                </a>
                <a href="{{ route('admin.weekly-agenda.index', ['week' => 'next']) }}" 
                   class="week-btn {{ $week == 'next' ? 'active' : '' }}">
                    Semaine prochaine
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total</p>
                </div>
                <div class="stat-icon total">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card meetings">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $stats['meetings'] }}</h3>
                    <p>Réunions</p>
                </div>
                <div class="stat-icon meetings">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-1c0-1.33 2.67-2 4-2s4 .67 4 2v1H4zM8 10c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2zm8 4c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2zm0 2c-1.33 0-4 .67-4 2v1h8v-1c0-1.33-2.67-2-4-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card deliveries">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $stats['deliveries'] }}</h3>
                    <p>Livraisons</p>
                </div>
                <div class="stat-icon deliveries">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card visits">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $stats['visits'] }}</h3>
                    <p>Visites</p>
                </div>
                <div class="stat-icon visits">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card tasks">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $stats['tasks'] }}</h3>
                    <p>Tâches</p>
                </div>
                <div class="stat-icon tasks">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card instructions">
            <div class="stat-content">
                <div class="stat-info">
                    <h3>{{ $stats['instructions'] }}</h3>
                    <p>Instructions</p>
                </div>
                <div class="stat-icon instructions">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Schedule -->
    <div class="schedule-section">
        @php
            $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            $dayClasses = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        @endphp
        
        @foreach($days as $index => $day)
            <div class="day-card">
                <div class="day-header {{ $dayClasses[$index] }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v10z"/>
                    </svg>
                    {{ $day }}
                </div>
                <div class="day-content">
                    @php
                        $dayEvents = $agendas->filter(function($event) use ($index) {
                            return $event->start_date->dayOfWeek == ($index + 1);
                        });
                    @endphp
                    
                    @if($dayEvents->count() > 0)
                        <div class="events-grid">
                            @foreach($dayEvents as $event)
                                <div class="event-card priority-{{ $event->priority }}">
                                    <div class="event-header">
                                        <h4 class="event-title">{{ $event->title }}</h4>
                                        <span class="priority-badge {{ $event->priority }}">
                                            {{ $event->priority }}
                                        </span>
                                    </div>
                                    
                                    <div class="event-meta">
                                        <div class="event-meta-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                                <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                            </svg>
                                            {{ $event->start_date->format('H:i') }}
                                            @if($event->end_date)
                                                - {{ $event->end_date->format('H:i') }}
                                            @endif
                                        </div>
                                        
                                        @if($event->location)
                                            <div class="event-meta-item">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                                </svg>
                                                {{ $event->location }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if($event->description)
                                        <p class="event-description">{{ Str::limit($event->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="event-footer">
                                        <div class="event-assignee">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                            @if($event->assignedTo)
                                                {{ $event->assignedTo->name }}
                                            @else
                                                Non assigné
                                            @endif
                                        </div>
                                        <span class="status-badge {{ $event->status }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="event-actions">
                                        <button class="action-btn" onclick="viewEvent({{ $event->id }})" title="Voir">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                            </svg>
                                        </button>
                                        <button class="action-btn" onclick="editEvent({{ $event->id }})" title="Modifier">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                            </svg>
                                        </button>
                                        @if($event->status == 'scheduled')
                                            <button class="action-btn" onclick="startEvent({{ $event->id }})" title="Démarrer">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </button>
                                        @elseif($event->status == 'in_progress')
                                            <button class="action-btn" onclick="completeEvent({{ $event->id }})" title="Terminer">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-day">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22 5.72l-4.6-3.86-1.29 1.53 4.6 3.86L22 5.72zM7.88 3.39L6.6 1.86 2 5.71l1.29 1.53 4.59-3.85zM12.5 8H11v6l4.75 2.85.75-1.23-4-2.37V8zM12 4c-4.97 0-9 4.03-9 9s4.02 9 9 9c4.97 0 9-4.03 9-9s-4.03-9-9-9zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
                            </svg>
                            <p>Aucun événement prévu pour {{ $day }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" style="z-index: 1050;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
            <div class="modal-header" style="border-bottom: 1px solid var(--agenda-border); padding: 1.5rem;">
                <h5 class="modal-title" style="font-weight: 700; color: var(--agenda-text);">Détails de l'Événement</h5>
                <button type="button" class="close" data-dismiss="modal" style="border: none; background: none; font-size: 1.5rem; color: var(--agenda-text-muted);">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="eventModalBody" style="padding: 1.5rem;">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewEvent(eventId) {
    fetch(`/admin/weekly-agenda/${eventId}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('eventModalBody').innerHTML = data;
            $('#eventModal').modal('show');
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement des détails');
        });
}

function editEvent(eventId) {
    window.location.href = `/admin/weekly-agenda/${eventId}/edit`;
}

function startEvent(eventId) {
    updateEventStatus(eventId, 'in_progress');
}

function completeEvent(eventId) {
    updateEventStatus(eventId, 'completed');
}

function updateEventStatus(eventId, status) {
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

// Animation au scroll
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.day-card, .stat-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
</script>
@endpush


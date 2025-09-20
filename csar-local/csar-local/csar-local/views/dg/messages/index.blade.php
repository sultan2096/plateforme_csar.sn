@extends('layouts.dg')

@section('title', 'Gestion des Messages - CSAR DG')

@section('content')
<div class="dg-container">
    <!-- Header -->
    <div class="dg-header">
        <h1>Gestion des Messages</h1>
        <p>Consultez et gérez tous les messages reçus par le CSAR</p>
    </div>

    <!-- Statistiques -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 26px;
        margin: 32px 0 24px 0;
    }
    .stat-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 28px rgba(30,41,59,0.11), 0 1.5px 6px rgba(30,41,59,0.07);
        padding: 22px 18px 18px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: box-shadow 0.2s;
        position: relative;
        min-height: 95px;
    }
    .stat-card:hover {
        box-shadow: 0 8px 32px rgba(30,41,59,0.17), 0 2px 10px rgba(30,41,59,0.12);
    }
    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        background: linear-gradient(135deg, #3b82f6 60%, #2563eb 100%);
        box-shadow: 0 2px 8px rgba(59,130,246,0.11);
        flex-shrink: 0;
    }
    .stat-card:nth-child(2) .stat-icon {
        background: linear-gradient(135deg, #22c55e 60%, #16a34a 100%);
    }
    .stat-card:nth-child(3) .stat-icon {
        background: linear-gradient(135deg, #f59e0b 60%, #d97706 100%);
    }
    .stat-card:nth-child(4) .stat-icon {
        background: linear-gradient(135deg, #f43f5e 60%, #be123c 100%);
    }
    .stat-content h3 {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 2px;
        color: #0f172a;
        letter-spacing: -1px;
    }
    .stat-content p {
        font-size: 1.02rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0;
    }
    @media (max-width: 700px) {
        .stats-grid { grid-template-columns: 1fr; }
        .stat-card { flex-direction: column; align-items: flex-start; gap: 10px; }
        .stat-icon { margin-bottom: 4px; }
    }
    
    .dg-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .dg-header h1 {
        color: #1e40af;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .dg-header p {
        color: #6b7280;
        font-size: 1.1rem;
    }

    .messages-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .messages-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .messages-header h2 {
        color: #1e40af;
        margin: 0;
    }

    .messages-count {
        color: #6b7280;
        font-weight: 600;
    }

    .filters-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .filters-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-weight: 600;
        color: #374151;
    }

    .filter-select, .filter-input {
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: border-color 0.3s;
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .filter-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    .messages-table {
        overflow-x: auto;
    }

    .messages-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .messages-table th,
    .messages-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .messages-table th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
    }

    .message-sender {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .message-sender strong {
        color: #1f2937;
    }

    .message-sender small {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .message-content {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-read {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-unread {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-urgent {
        background: #fee2e2;
        color: #991b1b;
    }

    .actions {
        display: flex;
        gap: 0.5rem;
    }

    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        margin-bottom: 0.5rem;
        color: #374151;
    }

    .message-preview {
        background: #f9fafb;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280;
        border-left: 3px solid #3b82f6;
    }

    @media (max-width: 768px) {
        .filter-row {
            grid-template-columns: 1fr;
        }
        
        .filter-actions {
            flex-direction: column;
        }
        
        .messages-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
        
        .message-content {
            max-width: 200px;
        }
    }
    </style>

    <div class="stats-grid animate__animated animate__fadeInUp animate__delay-1s">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-envelope"></i></div>
            <div class="stat-content">
                <h3>{{ $stats['total'] }}</h3>
                <p>Total Messages</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-envelope-open"></i></div>
            <div class="stat-content">
                <h3>{{ $stats['read'] }}</h3>
                <p>Messages Lus</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-envelope"></i></div>
            <div class="stat-content">
                <h3>{{ $stats['unread'] }}</h3>
                <p>Messages Non Lus</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-content">
                <h3>{{ $stats['this_week'] ?? 0 }}</h3>
                <p>Cette Semaine</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <form method="GET" action="{{ route('dg.messages.index') }}" class="filters-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="status">Statut</label>
                    <select name="status" id="status" class="filter-select">
                        <option value="">Tous les statuts</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Non lu</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Lu</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="search">Rechercher</label>
                    <input type="text" name="search" id="search" class="filter-input" 
                           placeholder="Nom, email ou contenu..." 
                           value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label for="date">Date</label>
                    <select name="date" id="date" class="filter-select">
                        <option value="">Toutes les dates</option>
                        <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                        <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                        <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>Ce mois</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filtrer
                </button>
                <a href="{{ route('dg.messages.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Réinitialiser
                </a>
                @if($stats['unread'] > 0)
                    <a href="{{ route('dg.messages.mark-all-read') }}" class="btn btn-success">
                        <i class="fas fa-check-double"></i>
                        Tout marquer comme lu
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Liste des messages -->
    <div class="messages-section">
        <div class="messages-header">
            <h2>Liste des messages</h2>
            <span class="messages-count">{{ $messages->total() }} message(s)</span>
        </div>

        @if($messages->count() > 0)
            <div class="messages-table">
                <table>
                    <thead>
                        <tr>
                            <th>Expéditeur</th>
                            <th>Objet</th>
                            <th>Message</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr class="{{ !$message->is_read ? 'bg-blue-50' : '' }}">
                                <td>
                                    <div class="message-sender">
                                        <strong>{{ $message->name }}</strong>
                                        <small>{{ $message->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $message->subject ?? 'Sans objet' }}</strong>
                                </td>
                                <td>
                                    <div class="message-content">
                                        {{ Str::limit($message->message, 100) }}
                                    </div>
                                </td>
                                <td>
                                    @if(!$message->is_read)
                                        <span class="badge badge-unread">Non lu</span>
                                    @else
                                        <span class="badge badge-read">Lu</span>
                                    @endif
                                </td>
                                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('dg.messages.show', $message->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(!$message->is_read)
                                            <a href="{{ route('dg.messages.mark-read', $message->id) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('dg.messages.reply', $message->id) }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                        <form method="POST" action="{{ route('dg.messages.destroy', $message->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $messages->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Aucun message trouvé</h3>
                <p>Aucun message ne correspond aux critères de recherche.</p>
            </div>
        @endif
    </div>
</div>
@endsection 
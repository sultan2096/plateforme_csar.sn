@extends('layouts.admin')

@section('title', 'Messages de Contact - Administration CSAR')
@section('page-title', 'Messages de Contact')
@section('page-subtitle', 'Gestion des messages reçus via le formulaire de contact public')

@section('content')
<style>
.admin-container {
    padding: 2rem;
    max-width: 1400px;
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

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
}

.filters-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
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
    font-size: 0.875rem;
}

.filter-input, .filter-select {
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: border-color 0.3s;
}

.filter-input:focus, .filter-select:focus {
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

.btn-info {
    background: #06b6d4;
    color: white;
}

.btn-info:hover {
    background: #0891b2;
}

.btn-warning {
    background: #f59e0b;
    color: white;
}

.btn-warning:hover {
    background: #d97706;
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

.messages-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
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

.messages-table {
    overflow-x: auto;
}

.messages-table table {
    width: 100%;
    border-collapse: collapse;
}

.messages-table th, .messages-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.messages-table th {
    background: #f9fafb;
    font-weight: 600;
    color: #374151;
}

.message-name {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.message-name small {
    color: #6b7280;
    font-size: 0.875rem;
}

.message-preview {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #6b7280;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-unread {
    background: #dbeafe;
    color: #1e40af;
}

.badge-read {
    background: #d1fae5;
    color: #065f46;
}

.badge-replied {
    background: #fef3c7;
    color: #92400e;
}

.badge-archived {
    background: #f3f4f6;
    color: #374151;
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

@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }
    
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
}
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1>Messages de Contact</h1>
        <p>Gestion des messages reçus via le formulaire de contact public</p>
    </div>

    @if(session('success'))
    <div class="success-message">
        <p>✅ {{ session('success') }}</p>
    </div>
    @endif

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📧</div>
            <div class="stat-value">{{ $stats['total_messages'] }}</div>
            <div class="stat-label">Total messages</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📬</div>
            <div class="stat-value">{{ $stats['unread_messages'] }}</div>
            <div class="stat-label">Non lus</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📖</div>
            <div class="stat-value">{{ $stats['read_messages'] }}</div>
            <div class="stat-label">Lus</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💬</div>
            <div class="stat-value">{{ $stats['replied_messages'] }}</div>
            <div class="stat-label">Répondu</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📁</div>
            <div class="stat-value">{{ $stats['archived_messages'] }}</div>
            <div class="stat-label">Archivé</div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <form action="{{ route('admin.contact.index') }}" method="GET" class="filters-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="search">🔍 Recherche</label>
                    <input type="text" id="search" name="search" 
                           class="filter-input" placeholder="Nom, email, sujet..."
                           value="{{ request('search') }}">
                </div>
                
                <div class="filter-group">
                    <label for="status">📊 Statut</label>
                    <select id="status" name="status" class="filter-select">
                        <option value="">Tous les statuts</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Non lu</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Lu</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Répondu</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archivé</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filtrer
                </button>
                <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Réinitialiser
                </a>
                <a href="{{ route('admin.contact.export-csv') }}" class="btn btn-success">
                    <i class="fas fa-download"></i>
                    Exporter CSV
                </a>
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
                            <th>#</th>
                            <th>👤 Nom</th>
                            <th>📧 Email</th>
                            <th>📝 Sujet</th>
                            <th>💬 Message</th>
                            <th>📅 Date</th>
                            <th>📊 Statut</th>
                            <th>⚡ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>
                                    <div class="message-name">
                                        <strong>{{ $message->name }}</strong>
                                        <small>{{ $message->email }}</small>
                                    </div>
                                </td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->subject ?? 'Sans sujet' }}</td>
                                <td>
                                    <div class="message-preview" title="{{ strip_tags($message->message) }}">
                                        {{ Str::limit(strip_tags($message->message), 50) }}
                                    </div>
                                </td>
                                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($message->status === 'unread')
                                        <span class="badge badge-unread">Non lu</span>
                                    @elseif($message->status === 'read')
                                        <span class="badge badge-read">Lu</span>
                                    @elseif($message->status === 'replied')
                                        <span class="badge badge-replied">Répondu</span>
                                    @elseif($message->status === 'archived')
                                        <span class="badge badge-archived">Archivé</span>
                                    @else
                                        <span class="badge">{{ ucfirst($message->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.contact.show', $message->id) }}" 
                                           class="btn btn-info btn-sm" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($message->status === 'unread')
                                            <form method="POST" action="{{ route('admin.contact.mark-as-read', $message->id) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="Marquer comme lu">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($message->status !== 'replied')
                                            <form method="POST" action="{{ route('admin.contact.mark-as-replied', $message->id) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm" title="Marquer comme répondu">
                                                    <i class="fas fa-reply"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($message->status !== 'archived')
                                            <form method="POST" action="{{ route('admin.contact.archive', $message->id) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary btn-sm" title="Archiver">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('admin.contact.destroy', $message->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')"
                                                    title="Supprimer">
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

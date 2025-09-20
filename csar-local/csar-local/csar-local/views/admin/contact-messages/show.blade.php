@extends('layouts.admin')

@section('title', 'Détails du Message - Administration CSAR')
@section('page-title', 'Détails du Message')
@section('page-subtitle', 'Consulter et gérer le message de contact')

@section('content')
<style>
.admin-container {
    padding: 2rem;
    max-width: 1000px;
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

.message-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f3f4f6;
}

.message-info {
    flex: 1;
}

.message-title {
    color: #1e40af;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.message-meta {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.meta-label {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
}

.meta-value {
    font-size: 0.875rem;
    color: #374151;
    font-weight: 500;
}

.message-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-unread {
    background: #dbeafe;
    color: #1e40af;
}

.status-read {
    background: #d1fae5;
    color: #065f46;
}

.status-replied {
    background: #fef3c7;
    color: #92400e;
}

.status-archived {
    background: #f3f4f6;
    color: #374151;
}

.message-content {
    margin-bottom: 2rem;
}

.content-section {
    margin-bottom: 1.5rem;
}

.content-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
}

.content-value {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
    color: #374151;
    line-height: 1.6;
    white-space: pre-wrap;
}

.message-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    padding-top: 1.5rem;
    border-top: 2px solid #f3f4f6;
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

.btn-info {
    background: #06b6d4;
    color: white;
}

.btn-info:hover {
    background: #0891b2;
}

@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }
    
    .message-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .message-meta {
        gap: 1rem;
    }
    
    .message-actions {
        flex-direction: column;
    }
}
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1>Détails du Message</h1>
        <p>Consulter et gérer le message de contact #{{ $message->id }}</p>
    </div>

    @if(session('success'))
    <div class="success-message">
        <p>✅ {{ session('success') }}</p>
    </div>
    @endif

    <!-- Carte du message -->
    <div class="message-card">
        <div class="message-header">
            <div class="message-info">
                <h2 class="message-title">{{ $message->subject ?? 'Message sans sujet' }}</h2>
                <div class="message-meta">
                    <div class="meta-item">
                        <div class="meta-label">👤 Expéditeur</div>
                        <div class="meta-value">{{ $message->name }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">📧 Email</div>
                        <div class="meta-value">{{ $message->email }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">📅 Date d'envoi</div>
                        <div class="meta-value">{{ $message->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">🆔 ID Message</div>
                        <div class="meta-value">#{{ $message->id }}</div>
                    </div>
                </div>
            </div>
            <div class="message-status status-{{ $message->status }}">
                @if($message->status === 'unread')
                    Non lu
                @elseif($message->status === 'read')
                    Lu
                @elseif($message->status === 'replied')
                    Répondu
                @elseif($message->status === 'archived')
                    Archivé
                @else
                    {{ ucfirst($message->status) }}
                @endif
            </div>
        </div>

        <div class="message-content">
            <div class="content-section">
                <div class="content-label">📝 Message</div>
                <div class="content-value">{{ $message->message }}</div>
            </div>

            @if($message->admin_comment)
            <div class="content-section">
                <div class="content-label">💬 Commentaire administrateur</div>
                <div class="content-value">{{ $message->admin_comment }}</div>
            </div>
            @endif
        </div>

        <div class="message-actions">
                            <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>

            @if($message->status === 'unread')
                <form method="POST" action="{{ route('admin.contact.mark-as-read', $message->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        Marquer comme lu
                    </button>
                </form>
            @endif

            @if($message->status !== 'replied')
                <form method="POST" action="{{ route('admin.contact.mark-as-replied', $message->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-reply"></i>
                        Marquer comme répondu
                    </button>
                </form>
            @endif

            @if($message->status !== 'archived')
                <form method="POST" action="{{ route('admin.contact.archive', $message->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-archive"></i>
                        Archiver
                    </button>
                </form>
            @endif

                            <form method="POST" action="{{ route('admin.contact.destroy', $message->id) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                    <i class="fas fa-trash"></i>
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 
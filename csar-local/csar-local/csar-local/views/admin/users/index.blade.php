@extends('layouts.admin')

@section('title', 'Gestion du Personnel - Administration CSAR')
@section('page-title', 'Gestion du Personnel')
@section('page-subtitle', 'Recensement et gestion des agents CSAR')

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

.info-message {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border: 1px solid #3b82f6;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.1);
}

.info-message p {
    color: #1e40af;
    margin: 0;
    font-weight: 600;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #1e40af);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.75rem;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e40af;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-label {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.actions-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
}

.actions-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.actions-header h2 {
    color: #1e40af;
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.actions-buttons {
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
    font-size: 0.875rem;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1e3a8a);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-1px);
}

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-success:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-1px);
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
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-input, .filter-select {
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s;
    background: #fafafa;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.filter-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.users-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f4f6;
}

.users-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.users-header h2 {
    color: #1e40af;
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.users-count {
    color: #6b7280;
    font-weight: 600;
    background: #f3f4f6;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
}

.users-table {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.users-table table {
    width: 100%;
    border-collapse: collapse;
}

.users-table th {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 1rem;
    text-align: left;
    font-weight: 700;
    color: #374151;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #e5e7eb;
}

.users-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.users-table tr:hover {
    background: #f9fafb;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.875rem;
    margin-right: 0.75rem;
}

.user-info {
    display: flex;
    align-items: center;
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.user-name {
    font-weight: 600;
    color: #111827;
    font-size: 0.9rem;
}

.user-date {
    font-size: 0.75rem;
    color: #6b7280;
}

.user-email {
    color: #374151;
    font-size: 0.875rem;
}

.badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.badge-admin {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.badge-dg {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    border: 1px solid #6ee7b7;
}

.badge-responsable {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    border: 1px solid #fbbf24;
}

.badge-agent {
    background: linear-gradient(135deg, #e5e7eb, #d1d5db);
    color: #374151;
    border: 1px solid #9ca3af;
}

.user-position {
    color: #374151;
    font-size: 0.875rem;
    font-weight: 500;
}

.user-department {
    color: #6b7280;
    font-size: 0.875rem;
}

.user-phone {
    color: #374151;
    font-size: 0.875rem;
    font-family: monospace;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    min-width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    color: white;
}

.btn-info:hover {
    background: linear-gradient(135deg, #0891b2, #0e7490);
}

.btn-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #d97706, #b45309);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
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
    
    .actions-header, .users-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .actions-buttons {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1>Gestion du Personnel</h1>
        <p>Recensement et gestion des agents CSAR</p>
    </div>

    @if(session('success'))
    <div class="success-message">
        <p>✅ {{ session('success') }}</p>
    </div>
    @endif

    @if(session('info'))
    <div class="info-message">
        <p>ℹ️ {{ session('info') }}</p>
    </div>
    @endif

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Total personnel</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👑</div>
            <div class="stat-value">{{ $stats['admin_users'] }}</div>
            <div class="stat-label">Administrateurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🏢</div>
            <div class="stat-value">{{ $stats['dg_users'] }}</div>
            <div class="stat-label">Directeurs Généraux</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div class="stat-value">{{ $stats['responsable_users'] }}</div>
            <div class="stat-label">Responsables</div>
        </div>
    </div>

    <!-- Actions -->
    <div class="actions-section">
        <div class="actions-header">
            <h2>Actions rapides</h2>
            <div class="actions-buttons">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Ajouter un agent
                </a>
                <button type="button" class="btn btn-secondary" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-download"></i>
                    Export PDF
                </button>
                <button type="button" class="btn btn-success" disabled title="Fonctionnalité en développement">
                    <i class="fas fa-file-excel"></i>
                    Export Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.users.index') }}" class="filters-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="search">🔍 Recherche</label>
                    <input type="text" id="search" name="search" 
                           class="filter-input" placeholder="Nom, email, téléphone..."
                           value="{{ request('search') }}">
                </div>
                
                <div class="filter-group">
                    <label for="role">🎯 Rôle</label>
                    <select id="role" name="role" class="filter-select">
                        <option value="">Tous les rôles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="dg" {{ request('role') === 'dg' ? 'selected' : '' }}>Directeur Général</option>
                        <option value="responsable" {{ request('role') === 'responsable' ? 'selected' : '' }}>Responsable</option>
                        <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agent</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="department">🏢 Direction</label>
                    <select id="department" name="department" class="filter-select">
                        <option value="">Toutes les directions</option>
                        <option value="Administration" {{ request('department') === 'Administration' ? 'selected' : '' }}>Administration</option>
                        <option value="Logistique" {{ request('department') === 'Logistique' ? 'selected' : '' }}>Logistique</option>
                        <option value="Sécurité Alimentaire et Résilience" {{ request('department') === 'Sécurité Alimentaire et Résilience' ? 'selected' : '' }}>Sécurité Alimentaire et Résilience</option>
                        <option value="Résilience" {{ request('department') === 'Résilience' ? 'selected' : '' }}>Résilience</option>
                        <option value="Communication" {{ request('department') === 'Communication' ? 'selected' : '' }}>Communication</option>
                        <option value="Direction Générale" {{ request('department') === 'Direction Générale' ? 'selected' : '' }}>Direction Générale</option>
                        <option value="Opérations" {{ request('department') === 'Opérations' ? 'selected' : '' }}>Opérations</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filtrer
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Liste des utilisateurs -->
    <div class="users-section">
        <div class="users-header">
            <h2>Liste du personnel</h2>
            <span class="users-count">{{ $users->total() }} agent(s)</span>
        </div>

        @if($users->count() > 0)
            <div class="users-table">
                <table>
                    <thead>
                        <tr>
                            <th>👤 Agent</th>
                            <th>📧 Email</th>
                            <th>🎯 Rôle</th>
                            <th>💼 Poste</th>
                            <th>🏢 Direction</th>
                            <th>📞 Téléphone</th>
                            <th>⚡ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">{{ $user->name }}</div>
                                            <div class="user-date">Créé le {{ $user->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-email">{{ $user->email }}</div>
                                </td>
                                <td>
                                    @if($user->role && $user->role->name === 'admin')
                                        <span class="badge badge-admin">{{ $user->role->display_name }}</span>
                                    @elseif($user->role && $user->role->name === 'dg')
                                        <span class="badge badge-dg">{{ $user->role->display_name }}</span>
                                    @elseif($user->role && $user->role->name === 'responsable')
                                        <span class="badge badge-responsable">{{ $user->role->display_name }}</span>
                                    @elseif($user->role && $user->role->name === 'agent')
                                        <span class="badge badge-agent">{{ $user->role->display_name }}</span>
                                    @else
                                        <span class="badge badge-gray">Aucun rôle</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="user-position">{{ $user->position ?? 'Non renseigné' }}</div>
                                </td>
                                <td>
                                    <div class="user-department">{{ $user->department ?? 'Non renseignée' }}</div>
                                </td>
                                <td>
                                    <div class="user-phone">{{ $user->phone ?? 'Non renseigné' }}</div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="btn btn-info btn-sm" title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $users->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>Aucun agent trouvé</h3>
                <p>Aucun agent ne correspond aux critères de recherche.</p>
            </div>
        @endif
    </div>
</div>
@endsection 
@extends('layouts.dg')

@section('title', 'Gestion des Magasins de stockage - CSAR DG')

@section('content')
<div class="dg-container">
    <!-- Header -->
    <div class="dg-header">
            <h1>Gestion des Magasins de stockage</h1>
    <p>Consultez et gérez tous les magasins de stockage du CSAR</p>
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

    .warehouses-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .warehouses-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .warehouses-header h2 {
        color: #1e40af;
        margin: 0;
    }

    .warehouses-count {
        color: #6b7280;
        font-weight: 600;
    }

    .warehouses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .warehouse-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .warehouse-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .warehouse-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .warehouse-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .warehouse-location {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .warehouse-status {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .warehouse-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 0.75rem;
        background: #f9fafb;
        border-radius: 8px;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
    }

    .warehouse-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
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
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-info {
        background: #06b6d4;
        color: white;
    }

    .btn-info:hover {
        background: #0891b2;
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
        .warehouses-grid {
            grid-template-columns: 1fr;
        }
        
        .warehouse-stats {
            grid-template-columns: 1fr;
        }
        
        .warehouses-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }
    </style>
    
    <div class="stats-grid animate__animated animate__fadeInUp animate__delay-1s">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-warehouse"></i></div>
            <div class="stat-content">
                <h3>{{ $warehouses->count() }}</h3>
                <p>Total Magasins de stockage</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-content">
                <h3>{{ $warehouses->where('is_active', true)->count() }}</h3>
                <p>Magasins de stockage Actifs</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-box"></i></div>
            <div class="stat-content">
                <h3>{{ number_format($stats['total_food'] ?? 0) }}</h3>
                <p>Stock Nourriture</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-gas-pump"></i></div>
            <div class="stat-content">
                <h3>{{ number_format($stats['total_fuel'] ?? 0) }}</h3>
                <p>Stock Carburant</p>
            </div>
        </div>
    </div>

    <!-- Liste des entrepôts -->
    <div class="warehouses-section">
        <div class="warehouses-header">
            <h2>Liste des magasins de stockage</h2>
                          <span class="warehouses-count">{{ $warehouses->count() }} magasin(s) de stockage</span>
        </div>

        @if($warehouses->count() > 0)
            <div class="warehouses-grid">
                @foreach($warehouses as $warehouse)
                    <div class="warehouse-card">
                        <div class="warehouse-header">
                            <div>
                                <div class="warehouse-name">{{ $warehouse->name }}</div>
                                <div class="warehouse-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $warehouse->location ?? 'Localisation non définie' }}
                                </div>
                            </div>
                            <span class="warehouse-status {{ $warehouse->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $warehouse->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>

                        <div class="warehouse-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ $warehouse->stocks->where('type', 'food')->sum('quantity') }}</div>
                                <div class="stat-label">Nourriture</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $warehouse->stocks->where('type', 'equipment')->sum('quantity') }}</div>
                                <div class="stat-label">Équipement</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $warehouse->stocks->where('type', 'fuel')->sum('quantity') }}</div>
                                <div class="stat-label">Carburant</div>
                            </div>
                        </div>

                        <div class="warehouse-actions">
                            <a href="{{ route('dg.warehouses.show', $warehouse->id) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i>
                                Voir détails
                            </a>
                            @if($warehouse->is_active)
                                <a href="{{ route('dg.warehouses.edit', $warehouse->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                    Modifier
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-warehouse"></i>
                <h3>Aucun entrepôt trouvé</h3>
                <p>Aucun entrepôt n'est actuellement enregistré dans le système.</p>
            </div>
        @endif
    </div>
</div>
@endsection 
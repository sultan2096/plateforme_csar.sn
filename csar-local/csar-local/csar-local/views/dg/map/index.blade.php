@extends('layouts.dg')

@section('title', 'Carte Interactive - CSAR DG')

@section('content')
<div class="dg-container">
    <!-- Header -->
    <div class="dg-header">
        <h1>Carte Interactive</h1>
        <p>Visualisez l'activité du CSAR sur la carte</p>
    </div>

    <!-- Carte Interactive -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
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

    .map-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .map-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .map-header h2 {
        color: #1e40af;
        margin: 0;
    }

    .map-controls {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .map-control-btn {
        padding: 0.5rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: white;
        color: #374151;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.875rem;
    }

    .map-control-btn:hover {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .map-control-btn.active {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }

    .map-container {
        position: relative;
        height: 600px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #dgMap {
        width: 100%;
        height: 100%;
    }

    .map-legend {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 8px;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #374151;
    }

    .legend-marker {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .legend-requests {
        background: #3b82f6;
    }

    .legend-warehouses {
        background: #22c55e;
    }

    .legend-personnel {
        background: #f59e0b;
    }

    .stats-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        border: 1px solid #e5e7eb;
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
        font-weight: 500;
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
        .map-container {
            height: 400px;
        }
        
        .map-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
        
        .map-controls {
            width: 100%;
            justify-content: center;
        }
        
        .stats-overview {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <!-- Statistiques rapides -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-value">{{ $requests->count() }}</div>
            <div class="stat-label">Demandes sur la carte</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $warehouses->count() }}</div>
            <div class="stat-label">Entrepôts actifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $personnel->count() ?? 0 }}</div>
            <div class="stat-label">Personnel localisé</div>
        </div>
    </div>

    <!-- Carte -->
    <div class="map-section">
        <div class="map-header">
            <h2>Carte Interactive CSAR</h2>
            <div class="map-controls">
                <button class="map-control-btn active" data-layer="all">
                    <i class="fas fa-globe"></i>
                    Tout afficher
                </button>
                <button class="map-control-btn" data-layer="requests">
                    <i class="fas fa-file-alt"></i>
                    Demandes
                </button>
                <button class="map-control-btn" data-layer="warehouses">
                    <i class="fas fa-warehouse"></i>
                    Entrepôts
                </button>
                <button class="map-control-btn" data-layer="personnel">
                    <i class="fas fa-users"></i>
                    Personnel
                </button>
            </div>
        </div>

        <div class="map-container">
            <div id="dgMap"></div>
        </div>

        <div class="map-legend">
            <div class="legend-item">
                <div class="legend-marker legend-requests"></div>
                <span>Demandes d'aide</span>
            </div>
            <div class="legend-item">
                <div class="legend-marker legend-warehouses"></div>
                <span>Entrepôts CSAR</span>
            </div>
            <div class="legend-item">
                <div class="legend-marker legend-personnel"></div>
                <span>Personnel</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser la carte centrée sur le Sénégal
    const map = L.map('dgMap').setView([14.7167, -17.4677], 7);
    
    // Ajouter la couche de tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Ajouter une couche satellite optionnelle
    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© Esri'
    });
    
    // Contrôle des couches de base
    const baseMaps = {
        "Carte": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }),
        "Satellite": satelliteLayer
    };
    
    L.control.layers(baseMaps).addTo(map);
    
    // Groupes de marqueurs
    const requestMarkers = L.layerGroup();
    const warehouseMarkers = L.layerGroup();
    const personnelMarkers = L.layerGroup();
    
    // Ajouter les groupes à la carte
    requestMarkers.addTo(map);
    warehouseMarkers.addTo(map);
    personnelMarkers.addTo(map);
    
    // Marqueurs pour les demandes
    @foreach($requests as $request)
        const requestMarker = L.marker([{{ $request['lat'] }}, {{ $request['lng'] }}], {
            icon: L.divIcon({
                className: 'custom-div-icon',
                html: '<div style="background-color: #3b82f6; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;"><i class="fas fa-file-alt" style="color: white; font-size: 10px;"></i></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            })
        });
        
        requestMarker.bindPopup(`
            <div style="min-width: 250px;">
                <h4 style="margin: 0 0 8px 0; color: #1e40af; font-size: 1.1rem;">{{ $request['title'] ?? 'Demande d\'aide' }}</h4>
                <p style="margin: 0 0 8px 0; color: #6b7280; font-size: 0.875rem;">{{ Str::limit($request['description'] ?? '', 120) }}</p>
                <div style="margin: 8px 0;">
                    <strong style="color: #374151;">Région:</strong> {{ $request['region'] ?? 'Non spécifiée' }}
                </div>
                <div style="margin: 8px 0;">
                    <strong style="color: #374151;">Code de suivi:</strong> {{ $request['tracking_code'] ?? 'Non spécifié' }}
                </div>
                <div style="display: flex; gap: 8px; margin-top: 12px;">
                    <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Demande d'aide</span>
                    <span style="background: {{ $request['status'] == 'approved' ? '#d1fae5' : ($request['status'] == 'pending' ? '#fef3c7' : '#fee2e2') }}; color: {{ $request['status'] == 'approved' ? '#065f46' : ($request['status'] == 'pending' ? '#92400e' : '#991b1b') }}; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">{{ ucfirst($request['status'] ?? 'En attente') }}</span>
                </div>
                <div style="margin-top: 8px; font-size: 0.75rem; color: #6b7280;">
                    Créée le {{ $request['created_at'] ?? 'Date inconnue' }}
                </div>
            </div>
        `);
        
        requestMarkers.addLayer(requestMarker);
    @endforeach
    
    // Marqueurs pour les entrepôts
    @foreach($warehouses as $warehouse)
        const warehouseMarker = L.marker([{{ $warehouse['lat'] }}, {{ $warehouse['lng'] }}], {
            icon: L.divIcon({
                className: 'custom-div-icon',
                html: '<div style="background-color: #22c55e; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;"><i class="fas fa-warehouse" style="color: white; font-size: 10px;"></i></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            })
        });
        
        warehouseMarker.bindPopup(`
            <div style="min-width: 250px;">
                <h4 style="margin: 0 0 8px 0; color: #1e40af; font-size: 1.1rem;">{{ $warehouse['title'] }}</h4>
                <p style="margin: 0 0 8px 0; color: #6b7280; font-size: 0.875rem;">{{ $warehouse['description'] ?? 'Adresse non définie' }}</p>
                <div style="margin: 8px 0;">
                    <strong style="color: #374151;">Capacité:</strong> {{ $warehouse['capacity'] ?? 'Non spécifiée' }}
                </div>
                <div style="display: flex; gap: 8px; margin-top: 12px;">
                    <span style="background: {{ $warehouse['status'] == 'active' ? '#d1fae5' : '#fee2e2' }}; color: {{ $warehouse['status'] == 'active' ? '#065f46' : '#991b1b' }}; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">{{ $warehouse['status'] == 'active' ? 'Actif' : 'Inactif' }}</span>
                    <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Entrepôt CSAR</span>
                </div>
            </div>
        `);
        
        warehouseMarkers.addLayer(warehouseMarker);
    @endforeach
    
    // Marqueurs pour le personnel (si disponible)
    @if(isset($personnel) && $personnel->count() > 0)
        @foreach($personnel as $person)
            const personnelMarker = L.marker([{{ $person['lat'] }}, {{ $person['lng'] }}], {
                icon: L.divIcon({
                    className: 'custom-div-icon',
                    html: '<div style="background-color: #f59e0b; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;"><i class="fas fa-user" style="color: white; font-size: 10px;"></i></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            });
            
            personnelMarker.bindPopup(`
                <div style="min-width: 250px;">
                    <h4 style="margin: 0 0 8px 0; color: #1e40af; font-size: 1.1rem;">{{ $person['title'] ?? 'Personnel CSAR' }}</h4>
                    <p style="margin: 0 0 8px 0; color: #6b7280; font-size: 0.875rem;">{{ $person['description'] ?? 'Poste non spécifié' }}</p>
                    <div style="margin: 8px 0;">
                        <strong style="color: #374151;">Direction:</strong> {{ $person['direction'] ?? 'Non spécifiée' }}
                    </div>
                    <div style="display: flex; gap: 8px; margin-top: 12px;">
                        <span style="background: {{ $person['status'] == 'validated' ? '#d1fae5' : '#fee2e2' }}; color: {{ $person['status'] == 'validated' ? '#065f46' : '#991b1b' }}; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">{{ $person['status'] == 'validated' ? 'Validé' : 'En attente' }}</span>
                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Personnel CSAR</span>
                    </div>
                </div>
            `);
            
            personnelMarkers.addLayer(personnelMarker);
        @endforeach
    @endif
    
    // Contrôles de couches
    const layerControls = document.querySelectorAll('.map-control-btn');
    layerControls.forEach(btn => {
        btn.addEventListener('click', function() {
            const layer = this.dataset.layer;
            
            // Mettre à jour les boutons actifs
            layerControls.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Gérer l'affichage des couches
            if (layer === 'all') {
                requestMarkers.addTo(map);
                warehouseMarkers.addTo(map);
                personnelMarkers.addTo(map);
            } else if (layer === 'requests') {
                map.removeLayer(warehouseMarkers);
                map.removeLayer(personnelMarkers);
                requestMarkers.addTo(map);
            } else if (layer === 'warehouses') {
                map.removeLayer(requestMarkers);
                map.removeLayer(personnelMarkers);
                warehouseMarkers.addTo(map);
            } else if (layer === 'personnel') {
                map.removeLayer(requestMarkers);
                map.removeLayer(warehouseMarkers);
                personnelMarkers.addTo(map);
            }
        });
    });
    
    // Ajuster la vue si des marqueurs existent
    const allMarkers = [...requestMarkers.getLayers(), ...warehouseMarkers.getLayers(), ...personnelMarkers.getLayers()];
    if (allMarkers.length > 0) {
        const group = new L.featureGroup(allMarkers);
        map.fitBounds(group.getBounds().pad(0.1));
    } else {
        // Si aucun marqueur, centrer sur le Sénégal
        map.setView([14.7167, -17.4677], 7);
    }
    
    // Ajouter un contrôle de recherche
    const searchControl = L.Control.extend({
        options: {
            position: 'topleft'
        },
        
        onAdd: function(map) {
            const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
            container.innerHTML = `
                <div style="background: white; padding: 8px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                    <input type="text" id="mapSearch" placeholder="Rechercher..." 
                           style="width: 200px; padding: 4px 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px;">
                </div>
            `;
            
            const searchInput = container.querySelector('#mapSearch');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                // Filtrer les marqueurs
                allMarkers.forEach(marker => {
                    const popup = marker.getPopup();
                    const content = popup.getContent();
                    const isVisible = content.toLowerCase().includes(searchTerm);
                    
                    if (searchTerm === '' || isVisible) {
                        marker.addTo(map);
                    } else {
                        map.removeLayer(marker);
                    }
                });
            });
            
            return container;
        }
    });
    
    map.addControl(new searchControl());
    
    // Ajouter des informations sur la carte
    const infoControl = L.Control.extend({
        options: {
            position: 'topright'
        },
        
        onAdd: function(map) {
            const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
            container.innerHTML = `
                <div style="background: white; padding: 12px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); min-width: 200px;">
                    <h4 style="margin: 0 0 8px 0; color: #1e40af; font-size: 14px;">📊 Statistiques</h4>
                    <div style="font-size: 12px; color: #374151;">
                        <div>📋 Demandes: <strong>{{ $requests->count() }}</strong></div>
                        <div>🏢 Entrepôts: <strong>{{ $warehouses->count() }}</strong></div>
                        <div>👥 Personnel: <strong>{{ $personnel->count() ?? 0 }}</strong></div>
                    </div>
                </div>
            `;
            
            return container;
        }
    });
    
    map.addControl(new infoControl());
});
</script>
@endpush
@endsection 
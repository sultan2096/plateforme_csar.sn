@extends('layouts.admin')

@section('title', 'Carte Interactive - Administration CSAR')
@section('page-title', 'Carte Interactive')
@section('page-subtitle', 'Localisation des demandes et entrepôts')

@section('content')
<!-- Filtres -->
<div class="admin-card">
    <h2 class="admin-section-title">Filtres</h2>
    <div class="admin-grid admin-grid-4">
        <div>
            <label for="type-filter" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Type</label>
            <select id="type-filter" class="form-input" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="all">Tous</option>
                <option value="requests">Demandes d'aide</option>
                <option value="warehouses">Entrepôts</option>
            </select>
        </div>
        
        <div>
            <label for="status-filter" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Statut</label>
            <select id="status-filter" class="form-input" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="all">Tous</option>
                <option value="pending">En attente</option>
                <option value="approved">Approuvé</option>
                <option value="rejected">Rejeté</option>
                <option value="active">Actif</option>
                <option value="inactive">Inactif</option>
            </select>
        </div>
        
        <div>
            <label for="region-filter" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Région</label>
            <select id="region-filter" class="form-input" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                <option value="all">Toutes les régions</option>
                <option value="Dakar">Dakar</option>
                <option value="Thiès">Thiès</option>
                <option value="Diourbel">Diourbel</option>
                <option value="Fatick">Fatick</option>
                <option value="Kaolack">Kaolack</option>
                <option value="Kolda">Kolda</option>
                <option value="Louga">Louga</option>
                <option value="Matam">Matam</option>
                <option value="Saint-Louis">Saint-Louis</option>
                <option value="Tambacounda">Tambacounda</option>
                <option value="Ziguinchor">Ziguinchor</option>
                <option value="Kaffrine">Kaffrine</option>
                <option value="Kédougou">Kédougou</option>
                <option value="Sédhiou">Sédhiou</option>
            </select>
        </div>
        
        <div style="display: flex; align-items: end;">
            <button id="apply-filters" class="admin-btn" style="width: 100%;">Appliquer les filtres</button>
        </div>
    </div>
</div>

<!-- Statistiques -->
<div class="admin-grid admin-grid-4">
    <div class="admin-stats-card">
        <div class="admin-stats-info">
            <h3>Demandes totales</h3>
            <div class="admin-stats-number">{{ $stats['total_requests'] }}</div>
        </div>
        <div class="admin-stats-icon" style="background-color: #dbeafe;">
            📋
        </div>
    </div>
    
    <div class="admin-stats-card">
        <div class="admin-stats-info">
            <h3>Demandes en attente</h3>
            <div class="admin-stats-number" style="color: #f59e0b;">{{ $stats['pending_requests'] }}</div>
        </div>
        <div class="admin-stats-icon" style="background-color: #fef3c7;">
            ⏳
        </div>
    </div>
    
    <div class="admin-stats-card">
        <div class="admin-stats-info">
            <h3>Entrepôts actifs</h3>
            <div class="admin-stats-number" style="color: #059669;">{{ $stats['active_warehouses'] }}</div>
        </div>
        <div class="admin-stats-icon" style="background-color: #d1fae5;">
            🏢
        </div>
    </div>
    
    <div class="admin-stats-card">
        <div class="admin-stats-info">
            <h3>Entrepôts inactifs</h3>
            <div class="admin-stats-number" style="color: #6b7280;">{{ $stats['inactive_warehouses'] }}</div>
        </div>
        <div class="admin-stats-icon" style="background-color: #f3f4f6;">
            🏚️
        </div>
    </div>
</div>

<!-- Carte Interactive -->
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2 class="admin-section-title">Carte Interactive</h2>
        <div style="display: flex; gap: 0.5rem;">
            <button id="center-map" class="admin-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Centrer la carte</button>
            <button id="fullscreen-map" class="admin-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Plein écran</button>
        </div>
    </div>
    
    <div id="map" style="height: 600px; width: 100%; border-radius: 0.5rem; overflow: hidden;"></div>
</div>

<!-- Légende -->
<div class="admin-card">
    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">Légende</h3>
    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <div style="width: 1rem; height: 1rem; background-color: #dc2626; border-radius: 50%;"></div>
            <span style="font-size: 0.875rem;">Demandes en attente</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <div style="width: 1rem; height: 1rem; background-color: #059669; border-radius: 50%;"></div>
            <span style="font-size: 0.875rem;">Demandes approuvées</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <div style="width: 1rem; height: 1rem; background-color: #6b7280; border-radius: 50%;"></div>
            <span style="font-size: 0.875rem;">Demandes rejetées</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <div style="width: 1.5rem; height: 1.5rem; background-color: #3b82f6; border-radius: 0.25rem;"></div>
            <span style="font-size: 0.875rem;">Entrepôts actifs</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <div style="width: 1.5rem; height: 1.5rem; background-color: #9ca3af; border-radius: 0.25rem;"></div>
            <span style="font-size: 0.875rem;">Entrepôts inactifs</span>
        </div>
    </div>
</div>

<!-- Styles pour la carte -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .form-input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: border-color 0.2s;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }
    
    .leaflet-popup-content {
        margin: 0.5rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .popup-title {
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }
    
    .popup-info {
        color: #6b7280;
        font-size: 0.75rem;
        margin-bottom: 0.25rem;
    }
    
    .popup-status {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-approved {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-rejected {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .status-active {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-inactive {
        background-color: #f3f4f6;
        color: #6b7280;
    }
</style>

<!-- Scripts pour la carte -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser la carte (centrée sur le Sénégal)
    const map = L.map('map').setView([14.7167, -17.4677], 7);
    
    // Ajouter la couche de tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    let markers = [];
    let currentData = @json($requests->merge($warehouses));
    
    // Fonction pour créer un marqueur
    function createMarker(item) {
        let icon, color;
        
        if (item.type === 'request') {
            // Marqueur pour les demandes (cercles colorés)
            switch(item.status) {
                case 'pending':
                    color = '#dc2626';
                    break;
                case 'approved':
                    color = '#059669';
                    break;
                case 'rejected':
                    color = '#6b7280';
                    break;
                default:
                    color = '#6b7280';
            }
            icon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="background-color: ${color}; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
                iconSize: [12, 12],
                iconAnchor: [6, 6]
            });
        } else {
            // Marqueur pour les entrepôts (carrés colorés)
            color = item.status === 'active' ? '#3b82f6' : '#9ca3af';
            icon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="background-color: ${color}; width: 16px; height: 16px; border-radius: 4px; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
                iconSize: [16, 16],
                iconAnchor: [8, 8]
            });
        }
        
        const marker = L.marker([item.latitude, item.longitude], { icon: icon }).addTo(map);
        
        // Créer le contenu de la popup
        let popupContent = `
            <div class="popup-title">${item.title}</div>
            <div class="popup-info">${item.description}</div>
        `;
        
        if (item.type === 'request') {
            popupContent += `
                <div class="popup-info">Date: ${item.created_at}</div>
                <div class="popup-info">Assigné à: ${item.assigned_to}</div>
                <div class="popup-status status-${item.status}">${getStatusText(item.status)}</div>
            `;
        } else {
            popupContent += `
                <div class="popup-info">Capacité: ${item.capacity} tonnes</div>
                <div class="popup-info">Stock actuel: ${item.current_stock} tonnes</div>
                <div class="popup-info">Responsable: ${item.responsible}</div>
                <div class="popup-status status-${item.status}">${getStatusText(item.status)}</div>
            `;
        }
        
        marker.bindPopup(popupContent);
        return marker;
    }
    
    // Fonction pour obtenir le texte du statut
    function getStatusText(status) {
        const statusMap = {
            'pending': 'En attente',
            'approved': 'Approuvé',
            'rejected': 'Rejeté',
            'active': 'Actif',
            'inactive': 'Inactif'
        };
        return statusMap[status] || status;
    }
    
    // Fonction pour ajouter tous les marqueurs
    function addMarkers(data) {
        // Supprimer les marqueurs existants
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];
        
        // Ajouter les nouveaux marqueurs
        data.forEach(item => {
            if (item.latitude && item.longitude) {
                const marker = createMarker(item);
                markers.push(marker);
            }
        });
    }
    
    // Ajouter les marqueurs initiaux
    addMarkers(currentData);
    
    // Gestionnaire pour les filtres
    document.getElementById('apply-filters').addEventListener('click', function() {
        const type = document.getElementById('type-filter').value;
        const status = document.getElementById('status-filter').value;
        const region = document.getElementById('region-filter').value;
        
        // Filtrer les données
        let filteredData = currentData.filter(item => {
            let typeMatch = type === 'all' || item.type === type;
            let statusMatch = status === 'all' || item.status === status;
            let regionMatch = region === 'all' || (item.description && item.description.includes(region));
            
            return typeMatch && statusMatch && regionMatch;
        });
        
        addMarkers(filteredData);
    });
    
    // Centrer la carte sur le Sénégal
    document.getElementById('center-map').addEventListener('click', function() {
        map.setView([14.7167, -17.4677], 7);
    });
    
    // Mode plein écran
    document.getElementById('fullscreen-map').addEventListener('click', function() {
        const mapContainer = document.getElementById('map');
        if (mapContainer.requestFullscreen) {
            mapContainer.requestFullscreen();
        } else if (mapContainer.webkitRequestFullscreen) {
            mapContainer.webkitRequestFullscreen();
        } else if (mapContainer.msRequestFullscreen) {
            mapContainer.msRequestFullscreen();
        }
    });
});
</script>
@endsection 
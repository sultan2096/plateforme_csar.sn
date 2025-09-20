@extends('layouts.admin')

@section('title', 'Tableau de bord - CSAR Admin')

@section('content')
<div class="dashboard-container">
    <!-- Top Statistics Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $totalRequests }}</h3>
                <p class="stat-label">Demandes d'aide</p>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $requestsGrowth }}% cette semaine
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-warehouse"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $totalWarehouses }}</h3>
                <p class="stat-label">Magasins de stockage</p>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $warehousesGrowth }}% cette semaine
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-gas-pump"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $totalFuel }}L</h3>
                <p class="stat-label">Carburant disponible</p>
                <span class="stat-change {{ $fuelChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ $fuelChange >= 0 ? 'up' : 'down' }}"></i> {{ abs($fuelChange) }}% cette semaine
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $newMessages }}</h3>
                <p class="stat-label">Nouveaux messages</p>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $messagesGrowth }}% cette semaine
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Evolution Graph -->
        <div class="dashboard-card large">
            <div class="card-header">
                <h3>Évolution des activités</h3>
                <div class="date-selector">
                    <i class="fas fa-calendar"></i>
                    <span>{{ now()->format('d/m/Y') }} - {{ now()->subDays(6)->format('d/m/Y') }}</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <canvas id="evolutionChart" height="300"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-color" style="background: #059669;"></span>
                        <span>Demandes d'aide</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #3b82f6;"></span>
                        <span>Magasins de stockage</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #f59e0b;"></span>
                        <span>Carburant disponible</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Activité récente</h3>
                <a href="#" class="view-all">Voir tout</a>
            </div>
            <div class="card-content">
                <div class="activity-timeline">
                    @forelse($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-{{ $activity->icon }}"></i>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">{{ $activity->description }}</p>
                            <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="no-data">Aucune activité récente</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Stock Status -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>État des stocks</h3>
                <a href="{{ route('admin.stocks.index') }}" class="view-all">Gérer</a>
            </div>
            <div class="card-content">
                <div class="stock-tabs">
                    <button class="stock-tab active" data-category="all">Tous</button>
                    <button class="stock-tab" data-category="alimentaire">Alimentaire</button>
                    <button class="stock-tab" data-category="carburant">Carburant</button>
                    <div class="stock-totals">
                        <span>Alimentaire: <strong id="totalFood">—</strong></span>
                        <span>Carburant: <strong id="totalFuel">—</strong></span>
                    </div>
                </div>
                <div class="stock-items" id="stockItems">
                    @foreach($stockStatus as $stock)
                    <div class="stock-item" data-category="{{ $stock->category }}">
                        <div class="stock-info">
                            <span class="stock-name">{{ $stock->name }}</span>
                            <span class="stock-quantity">{{ $stock->quantity }} {{ $stock->unit }}</span>
                        </div>
                        <div class="stock-progress">
                            <div class="progress-bar">
                                <div class="progress-fill {{ $stock->status }}" style="width: {{ $stock->percentage }}%"></div>
                            </div>
                            <span class="stock-percentage">{{ $stock->percentage }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.stocks.index') }}" class="view-all" style="display:block;margin-top:8px;">Voir tout</a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Actions rapides</h3>
            </div>
            <div class="card-content">
                <div class="quick-actions">
                    <a href="{{ route('admin.requests.create') }}" class="action-item">
                        <i class="fas fa-plus"></i>
                        <span>Nouvelle demande</span>
                    </a>
                    <a href="{{ route('admin.personnel.create') }}" class="action-item">
                        <i class="fas fa-user-plus"></i>
                        <span>Ajouter personnel</span>
                    </a>
                    <a href="{{ route('admin.warehouses.create') }}" class="action-item">
                        <i class="fas fa-warehouse"></i>
                        <span>Nouvel entrepôt</span>
                    </a>
                    <a href="{{ route('admin.stocks.create') }}" class="action-item">
                        <i class="fas fa-boxes"></i>
                        <span>Gérer stocks</span>
                    </a>
                    <a href="{{ route('admin.contact.index') }}" class="action-item">
                        <i class="fas fa-envelope"></i>
                        <span>Messages</span>
                    </a>
                    <a href="{{ route('admin.newsletter.index') }}" class="action-item">
                        <i class="fas fa-newspaper"></i>
                        <span>Newsletter</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Notifications</h3>
                <a href="#" class="view-all">Marquer comme lu</a>
            </div>
            <div class="card-content">
                <div class="notifications-list">
                    @forelse($notifications as $notification)
                    <div class="notification-item {{ $notification->read ? 'read' : 'unread' }}">
                        <div class="notification-icon">
                            <i class="fas fa-{{ $notification->icon }}"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">{{ $notification->message }}</p>
                            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="no-data">Aucune notification</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Profile Completion -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Complétion du profil</h3>
            </div>
            <div class="card-content">
                <div class="profile-completion">
                    <div class="completion-gauge">
                        <div class="gauge-circle">
                            <div class="gauge-fill" style="transform: rotate({{ $profileCompletion['completion'] * 3.6 }}deg)"></div>
                            <div class="gauge-center">
                                <span class="completion-percentage">{{ $profileCompletion['completion'] }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="completion-stats">
                        <div class="completion-item">
                            <span class="completion-label">Informations de base</span>
                            <span class="completion-value">{{ $profileCompletion['basicInfo'] }}%</span>
                        </div>
                        <div class="completion-item">
                            <span class="completion-label">Photo de profil</span>
                            <span class="completion-value">{{ $profileCompletion['profilePhoto'] ? '100%' : '0%' }}</span>
                        </div>
                        <div class="completion-item">
                            <span class="completion-label">Permissions</span>
                            <span class="completion-value">{{ $profileCompletion['permissions'] }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interactive Map -->
        <div class="dashboard-card large">
            <div class="card-header">
                <h3>Carte Interactive CSAR</h3>
                <div class="map-controls">
                    <button class="map-btn active" data-layer="warehouses">
                        <i class="fas fa-warehouse"></i> Entrepôts
                    </button>
                    <button class="map-btn" data-layer="requests">
                        <i class="fas fa-map-marker-alt"></i> Demandes
                    </button>
                    <button class="map-btn" data-layer="all">
                        <i class="fas fa-layer-group"></i> Tout
                    </button>
                </div>
            </div>
            <div class="card-content">
                <div class="map-container">
                    <div id="adminMap" style="height: 400px; width: 100%; border-radius: 8px;"></div>
                    <div class="map-legend">
                        <div class="legend-item">
                            <span class="legend-color warehouse"></span>
                            <span>Entrepôts actifs</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color request-pending"></span>
                            <span>Demandes en attente</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color request-approved"></span>
                            <span>Demandes approuvées</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color request-completed"></span>
                            <span>Demandes terminées</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js for graphs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Leaflet for interactive map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Evolution Chart
    const ctx = document.getElementById('evolutionChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [{
                    label: 'Demandes d\'aide',
                    data: {!! json_encode($chartData['requestsData']) !!},
                    borderColor: '#059669',
                    backgroundColor: 'rgba(5, 150, 105, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#059669',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }, {
                    label: 'Magasins de stockage',
                    data: {!! json_encode($chartData['warehousesData'] ?? []) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }, {
                    label: 'Carburant disponible',
                    data: {!! json_encode($chartData['fuelData'] ?? []) !!},
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#1f2937',
                        bodyColor: '#4b5563',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        padding: 12,
                        boxPadding: 6
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            padding: 8
                        }
                    }
                },
                elements: {
                    point: {
                        hoverBackgroundColor: '#ffffff',
                        hoverBorderColor: '#059669',
                        hoverBorderWidth: 3
                    }
                }
            }
        });
    }

    // Interactive Map
    const mapElement = document.getElementById('adminMap');
    if (mapElement) {
        const map = L.map('adminMap').setView([14.7167, -17.4677], 8); // Centered on Senegal
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Data from controller
        const warehouses = @json($mapData['warehouses'] ?? []);
        const requests = @json($mapData['requests'] ?? []);

        let warehouseMarkers = [];
        let requestMarkers = [];

        // Create warehouse markers
        if (warehouses && warehouses.length > 0) {
            warehouses.forEach(warehouse => {
                if (warehouse.lat && warehouse.lng) {
                    const marker = L.marker([warehouse.lat, warehouse.lng], {
                        icon: L.divIcon({
                            className: 'warehouse-marker',
                            html: '<i class="fas fa-warehouse" style="color: #4299e1; font-size: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"></i>',
                            iconSize: [20, 20],
                            iconAnchor: [10, 10]
                        })
                    }).addTo(map);

                    marker.bindPopup(`
                        <div style="text-align: center;">
                            <h4 style="margin: 0 0 8px 0; color: #2d3748;">${warehouse.name}</h4>
                            <p style="margin: 0 0 4px 0; color: #718096;">${warehouse.address}</p>
                            <p style="margin: 0 0 8px 0; color: #718096;">Capacité: ${warehouse.capacity}</p>
                            <span style="background: #48bb78; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">Actif</span>
                        </div>
                    `);

                    warehouseMarkers.push(marker);
                }
            });
        }

        // Create request markers
        if (requests && requests.length > 0) {
            requests.forEach(request => {
                if (request.lat && request.lng) {
                    let color, icon;
                    switch(request.status) {
                        case 'pending':
                            color = '#f59e0b';
                            icon = 'clock';
                            break;
                        case 'approved':
                            color = '#48bb78';
                            icon = 'check';
                            break;
                        case 'completed':
                            color = '#805ad5';
                            icon = 'flag-checkered';
                            break;
                        default:
                            color = '#718096';
                            icon = 'question';
                    }

                    const marker = L.marker([request.lat, request.lng], {
                        icon: L.divIcon({
                            className: 'request-marker',
                            html: `<i class="fas fa-${icon}" style="color: ${color}; font-size: 16px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"></i>`,
                            iconSize: [16, 16],
                            iconAnchor: [8, 8]
                        })
                    }).addTo(map);

                    marker.bindPopup(`
                        <div style="text-align: center;">
                            <h4 style="margin: 0 0 8px 0; color: #2d3748;">${request.type}</h4>
                            <p style="margin: 0 0 4px 0; color: #718096;">${request.name}</p>
                            <p style="margin: 0 0 4px 0; color: #718096;">${request.region}</p>
                            <p style="margin: 0 0 8px 0; color: #718096;">${request.date}</p>
                            <span style="background: ${color}; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">
                                ${request.status === 'pending' ? 'En attente' : 
                                  request.status === 'approved' ? 'Approuvée' : 'Terminée'}
                            </span>
                        </div>
                    `);

                    requestMarkers.push(marker);
                }
            });
        }

        // Map layer controls
        const mapBtns = document.querySelectorAll('.map-btn');
        mapBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                mapBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const layer = this.dataset.layer;
                
                // Show/hide markers based on layer
                warehouseMarkers.forEach(marker => {
                    if (layer === 'warehouses' || layer === 'all') {
                        marker.addTo(map);
                    } else {
                        marker.remove();
                    }
                });

                requestMarkers.forEach(marker => {
                    if (layer === 'requests' || layer === 'all') {
                        marker.addTo(map);
                    } else {
                        marker.remove();
                    }
                });
            });
        });

        // Si aucun marqueur n'est affiché, afficher un message
        if (warehouseMarkers.length === 0 && requestMarkers.length === 0) {
            const noDataDiv = document.createElement('div');
            noDataDiv.style.cssText = `
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(255, 255, 255, 0.9);
                padding: 20px;
                border-radius: 8px;
                text-align: center;
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            `;
            noDataDiv.innerHTML = `
                <i class="fas fa-map-marker-alt" style="font-size: 24px; color: #6b7280; margin-bottom: 10px;"></i>
                <p style="margin: 0; color: #6b7280;">Aucune donnée à afficher sur la carte</p>
            `;
            mapElement.appendChild(noDataDiv);
        }
    }
});
</script>
@endsection

@section('styles')
<style>
.dashboard-container {
    padding: 20px;
    background: #f8f9fa;
    min-height: 100vh;
}

/* Stats Row */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(5, 150, 105, 0.1);
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
    background: linear-gradient(90deg, #059669, #10b981);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    border-color: rgba(5, 150, 105, 0.2);
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 28px;
    color: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.stat-card:nth-child(1) .stat-icon { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
.stat-card:nth-child(2) .stat-icon { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
.stat-card:nth-child(3) .stat-icon { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.stat-card:nth-child(4) .stat-icon { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 6px 0;
    line-height: 1;
}

.stat-label {
    color: #6b7280;
    font-size: 15px;
    margin: 0 0 10px 0;
    font-weight: 500;
}

.stat-change {
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
}

.stat-change.positive {
    color: #059669;
}

.stat-change.negative {
    color: #dc2626;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

.dashboard-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.dashboard-card.large {
    grid-column: 1 / -1;
}

.card-header {
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #2d3748;
}

.view-all {
    color: #4299e1;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.card-content {
    padding: 24px;
}

/* Activity Timeline */
.activity-timeline {
    max-height: 300px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f7fafc;
}

.activity-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-text {
    margin: 0 0 4px 0;
    font-size: 14px;
    color: #4a5568;
}

.activity-time {
    font-size: 12px;
    color: #a0aec0;
}

/* Stock Status */
.stock-items {
    space-y: 16px;
}

.stock-item {
    margin-bottom: 16px;
}

.stock-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.stock-name {
    font-size: 14px;
    color: #4a5568;
}

.stock-quantity {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
}

.stock-progress {
    display: flex;
    align-items: center;
    gap: 12px;
}

.progress-bar {
    flex: 1;
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-fill.critical { background: #f56565; }
.progress-fill.warning { background: #ed8936; }
.progress-fill.good { background: #48bb78; }

.stock-percentage {
    font-size: 12px;
    color: #718096;
    min-width: 40px;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.action-item {
    display: flex;
    align-items: center;
    padding: 16px;
    border-radius: 8px;
    background: #f7fafc;
    text-decoration: none;
    color: #4a5568;
    transition: all 0.2s;
}

.action-item:hover {
    background: #edf2f7;
    transform: translateY(-1px);
}

.action-item i {
    margin-right: 12px;
    font-size: 16px;
    color: #4299e1;
}

/* Notifications */
.notifications-list {
    max-height: 300px;
    overflow-y: auto;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid #f7fafc;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item.unread {
    background: #f0fff4;
    margin: 0 -24px;
    padding: 12px 24px;
}

.notification-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #4299e1;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
    color: white;
    font-size: 12px;
}

.notification-content {
    flex: 1;
}

.notification-text {
    margin: 0 0 4px 0;
    font-size: 14px;
    color: #4a5568;
}

.notification-time {
    font-size: 12px;
    color: #a0aec0;
}

/* Profile Completion */
.profile-completion {
    text-align: center;
}

.completion-gauge {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 24px;
}

.gauge-circle {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#e2e8f0 0deg, #e2e8f0 360deg);
    position: relative;
}

.gauge-fill {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#4299e1 0deg, #4299e1 var(--rotation), #e2e8f0 var(--rotation), #e2e8f0 360deg);
    transition: all 0.3s ease;
}

.gauge-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.completion-percentage {
    font-size: 18px;
    font-weight: 700;
    color: #2d3748;
}

.completion-stats {
    text-align: left;
}

.completion-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f7fafc;
}

.completion-item:last-child {
    border-bottom: none;
}

.completion-label {
    font-size: 14px;
    color: #4a5568;
}

.completion-value {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
}

/* Evolution Stats */
.evolution-stats {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.evolution-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.evolution-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.evolution-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
}

.evolution-content {
    flex: 1;
}

.evolution-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.evolution-numbers {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.evolution-percentage {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

.evolution-count {
    font-size: 1.125rem;
    font-weight: 700;
    color: #059669;
}

/* Interactive Map */
.map-container {
    position: relative;
    height: 400px;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
}

#adminMap {
    width: 100%;
    height: 100%;
    border-radius: 8px;
}

.map-legend {
    position: absolute;
    bottom: 20px;
    left: 20px;
    background: white;
    padding: 16px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 1000;
    min-width: 200px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-size: 12px;
}

.legend-item:last-child {
    margin-bottom: 0;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    flex-shrink: 0;
}

.legend-color.warehouse {
    background: #4299e1;
}

.legend-color.request-pending {
    background: #f59e0b;
}

.legend-color.request-approved {
    background: #48bb78;
}

.legend-color.request-completed {
    background: #805ad5;
}

.map-controls {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}

.map-btn {
    padding: 8px 16px;
    border: 1px solid #e2e8f0;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
}

.map-btn:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
    transform: translateY(-1px);
}

.map-btn.active {
    background: #4299e1;
    color: white;
    border-color: #4299e1;
    box-shadow: 0 2px 8px rgba(66, 153, 225, 0.3);
}

/* Map marker styles */
.warehouse-marker {
    background: transparent;
    border: none;
}

.request-marker {
    background: transparent;
    border: none;
}

/* Responsive map */
@media (max-width: 768px) {
    .map-container {
        height: 300px;
    }
    
    .map-legend {
        bottom: 10px;
        left: 10px;
        padding: 12px;
        min-width: 150px;
    }
    
    .map-controls {
        flex-direction: column;
        gap: 4px;
    }
    
    .map-btn {
        font-size: 12px;
        padding: 6px 12px;
    }
}

@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-row {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .map-controls {
        flex-direction: column;
        gap: 4px;
    }
    
    .map-btn {
        font-size: 12px;
        padding: 6px 12px;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 10px;
    }
    
    .stats-row {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
}

.no-data {
    text-align: center;
    color: #a0aec0;
    font-style: italic;
    padding: 20px;
}

/* Tabs stocks */
.stock-tabs { display:flex; gap:8px; align-items:center; flex-wrap:wrap; margin-bottom:10px; }
.stock-tab { padding:6px 12px; border:1px solid #e2e8f0; background:#fff; border-radius:6px; cursor:pointer; font-size:13px; }
.stock-tab.active { background:#059669; color:#fff; border-color:#059669; }
.stock-totals { margin-left:auto; display:flex; gap:12px; font-size:13px; color:#4b5563; }

/* Limit height and scroll */
#stockItems { max-height: 260px; overflow: auto; }
</style>
@endsection 
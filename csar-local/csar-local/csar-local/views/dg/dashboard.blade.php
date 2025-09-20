@extends('layouts.dg')

@section('title', 'Tableau de Bord - DG')

@section('content')
<div class="dg-dashboard">
    <!-- Header -->
    <div class="dashboard-header">
        <h1>Tableau de Bord DG</h1>
        <p>Vue stratégique de l'activité du CSAR</p>
    </div>

    <!-- Stats Cards Grid -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 28px;
    margin: 32px 0 36px 0;
}
.stat-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 28px rgba(30,41,59,0.10), 0 1.5px 6px rgba(30,41,59,0.07);
    padding: 28px 24px 22px 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    transition: box-shadow 0.2s;
    position: relative;
    min-height: 120px;
}
.stat-card:hover {
    box-shadow: 0 8px 32px rgba(30,41,59,0.17), 0 2px 10px rgba(30,41,59,0.11);
}
.stat-icon {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #fff;
    background: linear-gradient(135deg, #3b82f6 60%, #2563eb 100%);
    box-shadow: 0 2px 8px rgba(59,130,246,0.12);
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
.stat-value {
    font-size: 2.2rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 4px;
    letter-spacing: -1px;
}
.stat-label {
    font-size: 1.08rem;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 7px;
}
.stat-details {
    margin-top: 2px;
}
.badge {
    display: inline-block;
    font-size: 0.92rem;
    font-weight: 600;
    border-radius: 12px;
    padding: 3px 12px;
    margin-right: 6px;
    margin-top: 4px;
    background: #f1f5f9;
    color: #334155;
}
.badge-pending {
    background: #fef3c7;
    color: #b45309;
}
.badge-approved, .badge-success {
    background: #bbf7d0;
    color: #166534;
}
.badge-stock {
    background: #e0e7ff;
    color: #3730a3;
}
.badge-active {
    background: #bae6fd;
    color: #0369a1;
}
@media (max-width: 700px) {
    .stats-grid { grid-template-columns: 1fr; }
    .stat-card { flex-direction: column; align-items: flex-start; gap: 14px; }
    .stat-icon { margin-bottom: 6px; }
}
</style>
<div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['total_requests']) }}</div>
                <div class="stat-label">Demandes d'aide traitées</div>
                <div class="stat-details">
                    <span class="badge badge-pending animate__animated animate__pulse animate__infinite">{{ $stats['pending_requests'] }} en attente</span>
                    <span class="badge badge-approved animate__animated animate__fadeIn animate__delay-1s">{{ $stats['approved_requests'] }} approuvées</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['total_personnel']) }}</div>
                <div class="stat-label">Agents recensés et validés</div>
                <div class="stat-details">
                    <span class="badge badge-success animate__animated animate__fadeIn animate__delay-1s">Tous validés</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-gas-pump"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['total_fuel']) }} L</div>
                <div class="stat-label">Carburant disponible</div>
                <div class="stat-details">
                    <span class="badge badge-stock animate__animated animate__pulse animate__infinite">Stock suffisant</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-warehouse"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['total_warehouses']) }}</div>
                <div class="stat-label">Entrepôts actifs</div>
                <div class="stat-details">
                    <span class="badge badge-active animate__animated animate__fadeIn animate__delay-1s">Tous opérationnels</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->

<!-- Notifications/Activité récente -->
@if(!empty($notifications))
<div class="notifications-section animate__animated animate__fadeInRight" style="margin-bottom: 32px;">
    <h3 style="font-size: 1.1rem; margin-bottom: 12px; color: #0f172a;">Notifications récentes</h3>
    <ul style="list-style: none; padding: 0;">
        @foreach($notifications as $notif)
            <li style="background: #f1f5f9; border-left: 4px solid #3b82f6; margin-bottom: 8px; padding: 10px 16px; border-radius: 6px; font-size: 0.97rem; color: #334155;">
                <i class="fas fa-bell" style="margin-right: 8px; color: #3b82f6;"></i>
                {{ $notif['message'] }}
                <span style="float: right; font-size: 0.85em; color: #64748b;">{{ $notif['time'] ?? '' }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endif

    <style>
.charts-section {
    display: flex;
    flex-wrap: wrap;
    gap: 32px;
    margin: 32px 0 0 0;
}
.chart-container {
    flex: 1 1 480px;
    min-width: 340px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(30,41,59,0.09);
    padding: 28px 28px 20px 28px;
    display: flex;
    flex-direction: column;
    align-items: stretch;
}
.chart-container h3 {
    font-size: 1.16rem;
    color: #0f172a;
    font-weight: 700;
    margin-bottom: 18px;
}
.chart-container canvas {
    width: 100% !important;
    height: 340px !important;
    max-width: 100%;
}
@media (max-width: 900px) {
    .charts-section { flex-direction: column; gap: 20px; }
    .chart-container { min-width: unset; }
}
</style>
<div class="charts-section">
    <div class="chart-container">
        <h3>Évolution du carburant</h3>
        <canvas id="fuelChart" width="400" height="200"></canvas>
    </div>
    <div class="chart-container">
        <h3>Répartition des entrepôts</h3>
        <canvas id="warehouseChart" width="400" height="200"></canvas>
    </div>
        <div class="chart-container">
            <h3>Évolution des demandes</h3>
            <canvas id="requestsChart" width="400" height="200"></canvas>
        </div>

        <div class="chart-container">
            <h3>Répartition du personnel</h3>
            <canvas id="personnelPieChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Requests Chart
const requestsCtx = document.getElementById('requestsChart').getContext('2d');
new Chart(requestsCtx, {
    type: 'line',
    data: {
        labels: @json(array_column($chartData['requests'], 'month')),
        datasets: [{
            label: 'Total demandes',
            data: @json(array_column($chartData['requests'], 'total')),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.14)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#3b82f6',
            pointHoverBackgroundColor: '#3b82f6',
            pointHoverBorderColor: '#fff',
        }, {
            label: 'En attente',
            data: @json(array_column($chartData['requests'], 'pending')),
            borderColor: '#f59e0b',
            backgroundColor: 'rgba(245, 158, 11, 0.13)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#f59e0b',
            pointHoverBackgroundColor: '#f59e0b',
            pointHoverBorderColor: '#fff',
        }, {
            label: 'Approuvées',
            data: @json(array_column($chartData['requests'], 'approved')),
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34, 197, 94, 0.13)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#22c55e',
            pointHoverBackgroundColor: '#22c55e',
            pointHoverBorderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: { size: 13 },
                    color: '#0f172a',
                }
            },
            tooltip: {
                backgroundColor: '#1e293b',
                titleColor: '#fff',
                bodyColor: '#f1f5f9',
                borderColor: '#3b82f6',
                borderWidth: 1,
                padding: 12,
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.parsed.y;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: { color: '#64748b', font: { size: 13 } }
            },
            x: {
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: { color: '#64748b', font: { size: 13 } }
            }
        },
        elements: {
            point: { radius: 4, hoverRadius: 7 }
        }
    }
});

// Fuel Chart
const fuelCtx = document.getElementById('fuelChart').getContext('2d');
new Chart(fuelCtx, {
    type: 'bar',
    data: {
        labels: @json(array_column($chartData['fuel'], 'month')),
        datasets: [{
            label: 'Litres de carburant',
            data: @json(array_column($chartData['fuel'], 'total')),
            backgroundColor: 'rgba(245, 158, 11, 0.76)',
            borderColor: '#f59e0b',
            borderWidth: 2,
            borderRadius: 8,
            maxBarThickness: 42,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    color: '#0f172a',
                    font: { size: 13 }
                }
            },
            tooltip: {
                backgroundColor: '#f59e0b',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#d97706',
                borderWidth: 1,
                padding: 12,
                callbacks: {
                    label: function(context) {
                        return 'Carburant: ' + context.parsed.y + ' L';
                    }
                }
            }
        },
        scales: {
            y: { beginAtZero: true, ticks: { color: '#b45309', font: { size: 13 } } },
            x: { ticks: { color: '#b45309', font: { size: 13 } } }
        }
    }
});

// Warehouse Chart
const warehouseCtx = document.getElementById('warehouseChart').getContext('2d');
new Chart(warehouseCtx, {
    type: 'pie',
    data: {
        labels: @json(array_column($chartData['warehouses'], 'status')),
        datasets: [{
            data: @json(array_column($chartData['warehouses'], 'count')),
            backgroundColor: [
                '#3b82f6', '#22c55e', '#f59e0b', '#ef4444', '#a21caf'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    color: '#0f172a',
                    font: { size: 13 }
                }
            },
            tooltip: {
                backgroundColor: '#3b82f6',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#2563eb',
                borderWidth: 1,
                padding: 12,
                callbacks: {
                    label: function(context) {
                        return context.label + ': ' + context.parsed + ' entrepôts';
                    }
                }
            }
        }
    }
});

// Personnel Doughnut Chart
const personnelPieCtx = document.getElementById('personnelPieChart').getContext('2d');
new Chart(personnelPieCtx, {
    type: 'doughnut',
    data: {
        labels: @json(array_column($chartData['personnel'], 'role')),
        datasets: [{
            data: @json(array_column($chartData['personnel'], 'count')),
            backgroundColor: [
                '#3b82f6',
                '#22c55e',
                '#f59e0b',
                '#ef4444'
            ],
            borderWidth: 0,
            cutout: '60%'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: { size: 12 }
                }
            }
        }
    }
});
</script>
@endpush

@push('styles')
<style>
.dg-dashboard {
    background: white;
    border-radius: 18px;
    box-shadow: 0 6px 24px -4px rgba(0,0,0,0.11);
    padding: 32px 24px;
    max-width: 1400px;
    margin: 30px auto;
    min-height: 90vh;
}

.dashboard-header {
    text-align: center;
    margin-bottom: 40px;
}

.dashboard-header h1 {
    color: #1e40af;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 8px;
    letter-spacing: -0.025em;
}

.dashboard-header p {
    color: #6b7280;
    font-size: 1.125rem;
    font-weight: 400;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
    border: 1px solid #f3f4f6;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    flex-shrink: 0;
}

.stat-icon i.fa-file-alt { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
.stat-icon i.fa-users { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
.stat-icon i.fa-gas-pump { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
.stat-icon i.fa-warehouse { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 4px;
    line-height: 1;
}

.stat-label {
    color: #6b7280;
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 8px;
    line-height: 1.4;
}

.stat-details {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.badge {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.badge-pending { 
    background: #fef3c7; 
    color: #92400e; 
}

.badge-approved { 
    background: #d1fae5; 
    color: #065f46; 
}

.badge-success { 
    background: #d1fae5; 
    color: #065f46; 
}

.badge-active { 
    background: #dbeafe; 
    color: #1e40af; 
}

.badge-stock { 
    background: #fef3c7; 
    color: #92400e; 
}

.charts-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 24px;
}

.chart-container {
    background: white;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid #f3f4f6;
    min-height: 400px;
    display: flex;
    flex-direction: column;
}

.chart-container h3 {
    color: #1f2937;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 24px;
    text-align: center;
    padding-bottom: 16px;
    border-bottom: 2px solid #f3f4f6;
}

.chart-container canvas {
    flex: 1;
    max-height: 300px;
}

@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .charts-section {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 24px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    .stat-value {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .dg-dashboard {
        padding: 20px 16px;
        margin: 20px auto;
    }
    
    .dashboard-header h1 {
        font-size: 2rem;
    }
    
    .stats-grid {
        gap: 16px;
    }
    
    .stat-card {
        padding: 20px;
        gap: 16px;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        font-size: 18px;
    }
    
    .stat-value {
        font-size: 1.75rem;
    }
    
    .charts-section {
        grid-template-columns: 1fr;
        gap: 16px;
    }
}
</style>
@endpush
@endsection 
@extends('layouts.admin')

@section('title', "Détails de l'entrepôt")

@section('content')
<div class="wh-page">
    <div class="wh-container">
        <nav class="wh-breadcrumbs">
            <a href="{{ route('admin.dashboard') }}">Administration</a>
            <span>/</span>
            <a href="{{ route('admin.warehouses.index') }}">Magasins de stockage</a>
            <span>/</span>
            <span>{{ $warehouse->name }}</span>
        </nav>

        <header class="wh-hero">
            <div class="wh-hero-left">
                <div class="wh-hero-icon"><i class="fas fa-warehouse"></i></div>
                <div>
                    <h1 class="wh-title">{{ $warehouse->name }}</h1>
                    <div class="wh-hero-meta">
                        <span class="wh-tag {{ $warehouse->is_active ? 'is-green' : 'is-red' }}">
                            <i class="fas fa-circle"></i> {{ $warehouse->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                        <span class="sep">•</span>
                        <span class="region"><i class="fas fa-map-pin"></i> {{ $warehouse->region }}</span>
                    </div>
                    <div class="wh-address"><i class="fas fa-map-marker-alt"></i> {{ $warehouse->address }}</div>
                </div>
            </div>
            <div class="wh-hero-actions">
                <a href="{{ route('admin.warehouses.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Retour</a>
                <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</a>
            </div>
        </header>

        <div class="wh-grid">
            <main class="wh-main">
                <section class="wh-card">
                    <div class="wh-card-header">
                        <div class="wh-card-icon blue"><i class="fas fa-info-circle"></i></div>
                        <h2>Fiche entrepôt</h2>
                    </div>
                    <div class="wh-two-cols">
                        <div class="col">
                            <div class="wh-field"><div class="label">Nom</div><div class="value">{{ $warehouse->name }}</div></div>
                            <div class="wh-field"><div class="label">Région</div><div class="value">{{ $warehouse->region }}</div></div>
                            <div class="wh-field"><div class="label">Ville</div><div class="value">{{ $warehouse->city }}</div></div>
                            <div class="wh-field"><div class="label">Adresse</div><div class="value">{{ $warehouse->address }}</div></div>
                        </div>
                        <div class="col">
                            <div class="wh-field">
                                <div class="label">Capacité totale</div>
                                @if(($warehouse->capacity ?? 0) > 0)
                                    <div class="value big">{{ number_format($warehouse->capacity) }}<span class="unit">&nbsp;unités</span></div>
                                @else
                                    <div class="value">
                                        <span class="wh-tag warn"><i class="fas fa-exclamation-triangle"></i> Capacité non définie</span>
                                        <div style="margin-top:10px">
                                            <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-warn"><i class="fas fa-sliders-h"></i> Définir la capacité</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if($warehouse->phone)
                            <div class="wh-field"><div class="label">Téléphone</div><div class="value">{{ $warehouse->phone }}</div></div>
                            @endif
                            @if($warehouse->email)
                            <div class="wh-field"><div class="label">Email</div><div class="value">{{ $warehouse->email }}</div></div>
                            @endif
                            <div class="wh-field">
                                <div class="label">Statut</div>
                                <div class="value">
                                    <span class="wh-tag {{ $warehouse->is_active ? 'is-green' : 'is-red' }}"><i class="fas fa-circle"></i> {{ $warehouse->is_active ? 'Actif' : 'Inactif' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($warehouse->description)
                        <div class="wh-description"><div class="label">Description</div><p>{{ $warehouse->description }}</p></div>
                    @endif
                </section>

                <section class="wh-card">
                    <div class="wh-card-header">
                        <div class="wh-card-icon green"><i class="fas fa-map-marker-alt"></i></div>
                        <h2>Localisation</h2>
                    </div>
                    <div class="wh-two-cols">
                        <div class="col">
                            <div class="wh-field">
                                <div class="label">Latitude</div>
                                <div class="value mono">{{ $warehouse->latitude }}</div>
                                <button class="btn btn-mini" onclick="copyToClipboard('{{ $warehouse->latitude }}')"><i class="fas fa-copy"></i> Copier</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="wh-field">
                                <div class="label">Longitude</div>
                                <div class="value mono">{{ $warehouse->longitude }}</div>
                                <button class="btn btn-mini" onclick="copyToClipboard('{{ $warehouse->longitude }}')"><i class="fas fa-copy"></i> Copier</button>
                            </div>
                        </div>
                    </div>
                    <div id="map" class="wh-map"></div>
                </section>
            </main>

            <aside class="wh-side">
                @php
                    $occupation = ($warehouse->capacity ?? 0) > 0 ? round((($warehouse->current_stock ?? 0) / max(1, $warehouse->capacity)) * 100, 1) : 0;
                    if ($occupation > 100) { $occupation = 100; }
                @endphp

                <section class="wh-card">
                    <div class="wh-card-header">
                        <div class="wh-card-icon purple"><i class="fas fa-chart-bar"></i></div>
                        <h2>Statistiques</h2>
                    </div>
                    <div class="wh-stats">
                        <div class="wh-stat-card blue">
                            <div>
                                <div class="stat-label">Stock actuel (toutes unités)</div>
                                <div class="stat-value">{{ number_format($warehouse->current_stock ?? 0) }}</div>
                            </div>
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="wh-stat-card green">
                            <div>
                                <div class="stat-label">Capacité totale</div>
                                <div class="stat-value">{{ ($warehouse->capacity ?? 0) > 0 ? number_format($warehouse->capacity) : '—' }}</div>
                            </div>
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="wh-progress">
                            <div class="progress-head"><span>Taux d'occupation</span><strong>{{ $occupation }}%</strong></div>
                            <div class="bar"><div class="fill" style="width: {{ $occupation }}%"></div></div>
                            @if(($warehouse->capacity ?? 0) <= 0)
                                <div class="hint">Définissez la capacité du magasin pour un taux d'occupation précis.</div>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="wh-card">
                    <div class="wh-card-header">
                        <div class="wh-card-icon amber"><i class="fas fa-bolt"></i></div>
                        <h2>Actions rapides</h2>
                    </div>
                    <div class="wh-actions-vert">
                        <a href="{{ route('admin.stocks.create', ['warehouse' => $warehouse->id]) }}" class="btn btn-success"><i class="fas fa-plus"></i> Ajouter du stock</a>
                        <a href="{{ route('admin.stocks.index', ['warehouse' => $warehouse->id]) }}" class="btn btn-info"><i class="fas fa-boxes"></i> Gérer les stocks</a>
                        <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-dark"><i class="fas fa-cog"></i> Paramètres</a>
                    </div>
                </section>

                <section class="wh-card">
                    <div class="wh-card-header">
                        <div class="wh-card-icon indigo"><i class="fas fa-database"></i></div>
                        <h2>Informations système</h2>
                    </div>
                    <div class="sys-info">
                        <div><span>Créé le</span><strong>{{ $warehouse->created_at->format('d/m/Y H:i') }}</strong></div>
                        <div><span>Modifié le</span><strong>{{ $warehouse->updated_at->format('d/m/Y H:i') }} ({{ $warehouse->updated_at->diffForHumans() }})</strong></div>
                        <div><span>Identifiant</span><strong>#{{ $warehouse->id }}</strong></div>
                    </div>
                </section>
            </aside>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<script>
function copyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text);
    } else {
        const ta = document.createElement('textarea');
        ta.value = text; document.body.appendChild(ta); ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('map', { zoomControl: true, scrollWheelZoom: true, doubleClickZoom: false })
        .setView([{{ $warehouse->latitude }}, {{ $warehouse->longitude }}], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors', maxZoom: 18 }).addTo(map);

    const customIcon = L.divIcon({
        className: 'wh-marker',
        html: '<div class="mk"><i class="fas fa-warehouse"></i></div>',
        iconSize: [50, 50], iconAnchor: [25, 50]
    });

    const marker = L.marker([{{ $warehouse->latitude }}, {{ $warehouse->longitude }}], {icon: customIcon}).addTo(map);
    marker.bindPopup(`<div style="text-align:center;min-width:200px"><div style="font-weight:800;color:#059669">{{ $warehouse->name }}</div><div style="color:#666">{{ $warehouse->address }}</div></div>`).openPopup();
});
</script>

@endsection

@section('styles')
<style>
/* Layout */
.wh-page { background: linear-gradient(135deg, #f8fafc, #f0fdf4); min-height: 100vh; }
.wh-container { max-width: 1200px; margin: 0 auto; padding: 24px 24px 40px; }
.wh-breadcrumbs { margin-bottom: 12px; font-size: 13px; color: #6b7280; }
.wh-breadcrumbs a { color: #374151; text-decoration: none; }
.wh-breadcrumbs a:hover { text-decoration: underline; }

/* Hero */
.wh-hero { background: linear-gradient(135deg, #ffffff, #f0fdf4); border: 1px solid #d1fae5; box-shadow: 0 10px 30px rgba(5,150,105,.08); border-radius: 20px; padding: 22px; display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 22px; }
.wh-hero-left { display: flex; align-items: center; gap: 16px; }
.wh-hero-icon { width: 64px; height: 64px; border-radius: 18px; background: linear-gradient(135deg, #059669, #10b981); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 10px 20px rgba(5,150,105,.25); }
.wh-title { margin: 0 0 4px; font-size: 28px; font-weight: 800; color: #111827; }
.wh-hero-meta { display: flex; align-items: center; gap: 10px; font-size: 13px; }
.wh-hero-meta .region { color: #374151; }
.wh-hero-meta .sep { color: #9ca3af; }
.wh-address { margin-top: 6px; color: #4b5563; font-size: 14px; }
.wh-hero-actions { display: flex; gap: 10px; }

/* Grid */
.wh-grid { display: grid; grid-template-columns: 1.6fr .9fr; gap: 18px; }
.wh-main { display: grid; gap: 18px; }
.wh-side { display: grid; gap: 18px; }

/* Cards */
.wh-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 18px; box-shadow: 0 8px 24px rgba(0,0,0,.06); padding: 18px; }
.wh-card-header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
.wh-card-header h2 { margin: 0; font-size: 18px; font-weight: 800; color: #111827; }
.wh-card-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
.wh-card-icon.blue { background: #e0f2fe; color: #2563eb; }
.wh-card-icon.green { background: #dcfce7; color: #059669; }
.wh-card-icon.purple { background: #ede9fe; color: #7c3aed; }
.wh-card-icon.indigo { background: #e0e7ff; color: #4f46e5; }
.wh-card-icon.amber { background: #fef3c7; color: #b45309; }

.wh-two-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.wh-field { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px; position: relative; }
.wh-field .label { font-size: 11px; text-transform: uppercase; color: #6b7280; font-weight: 700; }
.wh-field .value { margin-top: 6px; color: #111827; font-weight: 600; }
.wh-field .value.big { font-size: 22px; font-weight: 800; }
.wh-field .value.mono { font-family: ui-monospace, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
.wh-description { margin-top: 10px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px; }
.wh-description .label { font-size: 11px; text-transform: uppercase; color: #6b7280; font-weight: 700; margin-bottom: 6px; }
.wh-description p { margin: 0; color: #374151; }

/* Stats */
.wh-stats { display: grid; gap: 12px; }
.wh-stat-card { display: flex; align-items: center; justify-content: space-between; border-radius: 14px; padding: 12px 14px; color: #fff; }
.wh-stat-card .stat-label { font-size: 12px; opacity: .9; }
.wh-stat-card .stat-value { font-size: 22px; font-weight: 800; }
.wh-stat-card.blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.wh-stat-card.green { background: linear-gradient(135deg, #059669, #10b981); }
.wh-progress .progress-head { display:flex; align-items:center; justify-content:space-between; font-weight:700; color:#374151; margin-bottom:6px; }
.wh-progress .bar { width:100%; height: 8px; background:#e5e7eb; border-radius: 6px; overflow:hidden; }
.wh-progress .fill { height:100%; background: linear-gradient(135deg, #10b981, #059669); }
.wh-progress .hint { margin-top:6px; font-size:12px; color:#6b7280; }

/* Buttons & tags */
.btn { display:inline-flex; align-items:center; gap:8px; border:none; cursor:pointer; text-decoration:none; font-weight:700; border-radius:10px; padding:10px 14px; }
.btn-primary { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color:#fff; }
.btn-light { background:#f3f4f6; color:#374151; }
.btn-success { background: linear-gradient(135deg, #059669, #10b981); color:#fff; }
.btn-info { background: linear-gradient(135deg, #0ea5e9, #0284c7); color:#fff; }
.btn-dark { background: linear-gradient(135deg, #6b7280, #374151); color:#fff; }
.btn-warn { background: linear-gradient(135deg, #f59e0b, #d97706); color:#fff; }
.btn-mini { background:#059669; color:#fff; border-radius:8px; padding:6px 10px; font-size:12px; }
.wh-tag { display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:700; }
.wh-tag.is-green { background:#d1fae5; color:#065f46; }
.wh-tag.is-red { background:#fee2e2; color:#991b1b; }
.wh-tag.warn { background:#fef3c7; color:#92400e; }
.unit { color:#6b7280; font-size:14px; font-weight:700; }

/* Map */
.wh-map { width: 100%; height: 360px; border: 2px solid #e5e7eb; border-radius: 14px; box-shadow: inset 0 1px 6px rgba(0,0,0,.05); overflow:hidden; }
.wh-marker .mk { background: linear-gradient(135deg, #059669, #10b981); width:50px; height:50px; border-radius:50%; color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; box-shadow: 0 8px 24px rgba(5,150,105,.35); border:3px solid #fff; }

/* Responsive */
@media (max-width: 992px) {
  .wh-grid { grid-template-columns: 1fr; }
  .wh-hero { flex-direction: column; align-items: flex-start; }
  .wh-hero-actions { width: 100%; }
  .wh-hero-actions .btn { flex: 1; justify-content: center; }
  .wh-two-cols { grid-template-columns: 1fr; }
}
</style>
@endsection

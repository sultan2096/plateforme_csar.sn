@extends('layouts.admin')

@section('content')
<style>
    .warehouse-form-card { max-width: 720px; margin: 24px auto; background:#fff; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); overflow:hidden; }
    .wf-header { padding:18px 22px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; display:flex; align-items:center; gap:10px; }
    .wf-body { padding:22px; }
    .wf-row { display:grid; grid-template-columns: 1fr 1fr; gap:14px; }
    label { font-weight:700; font-size:.92rem; color:#374151; display:block; margin-bottom:6px; }
    input, select { width:100%; border:1px solid #e5e7eb; border-radius:10px; padding:10px 12px; font-size:.98rem; }
    input:focus, select:focus { outline:none; border-color:#059669; box-shadow:0 0 0 3px rgba(5,150,105,.12); }
    .wf-actions { display:flex; gap:10px; margin-top:10px; }
    .btn { border:none; border-radius:10px; padding:10px 14px; font-weight:700; cursor:pointer; }
    .btn-primary{ background:linear-gradient(135deg,#059669,#10b981); color:#fff; }
    .btn-secondary{ background:#f3f4f6; color:#374151; }
    .error-box{background:#fee2e2;color:#7f1d1d;padding:10px;border-radius:8px;margin-bottom:12px}
    @media(max-width:768px){ .wf-row{ grid-template-columns:1fr } }
</style>
<div class="warehouse-form-card">
    <div class="wf-header"><i class="fas fa-warehouse"></i><strong>Modifier l'entrepôt</strong></div>
    <div class="wf-body">
        @if ($errors->any())
            <div class="error-box"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        @php($regions = ['Dakar','Diourbel','Fatick','Kaffrine','Kaolack','Kédougou','Kolda','Louga','Matam','Saint-Louis','Sédhiou','Tambacounda','Thiès','Ziguinchor'])
        <form action="{{ route('admin.warehouses.update', $warehouse) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="name">Nom de l'entrepôt</label>
            <input type="text" name="name" id="name" value="{{ $warehouse->name }}" required>

            <label for="address">Adresse</label>
            <input type="text" name="address" id="address" value="{{ $warehouse->address }}" required>

            <div class="wf-row">
                <div>
                    <label for="region">Région</label>
                    <select name="region" id="region" required>
                        @foreach($regions as $r)
                            <option value="{{ $r }}" {{ $warehouse->region === $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="city">Ville</label>
                    <input type="text" name="city" id="city" value="{{ $warehouse->city }}" required>
                </div>
            </div>

            <div class="wf-row">
                <div>
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" id="latitude" value="{{ $warehouse->latitude }}" required>
                </div>
                <div>
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" id="longitude" value="{{ $warehouse->longitude }}" required>
                </div>
            </div>

            <div class="wf-row">
                <div>
                    <label for="capacity">Capacité (tonnes)</label>
                    <input type="number" min="0" step="0.01" name="capacity" id="capacity" value="{{ $warehouse->capacity }}">
                </div>
                <div>
                    <label for="status">Statut</label>
                    <select name="status" id="status">
                        <option value="active" {{ ($warehouse->status ?? ($warehouse->is_active ? 'active' : 'inactive')) === 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ ($warehouse->status ?? ($warehouse->is_active ? 'active' : 'inactive')) === 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
            </div>

            <div class="wf-actions">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.warehouses.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection




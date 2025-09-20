@extends('layouts.admin')

@section('content')
<style>
    .warehouse-form-card { max-width: 720px; margin: 24px auto; background:#fff; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); overflow:hidden; }
    .wf-header { padding:18px 22px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; display:flex; align-items:center; gap:10px; }
    .wf-header i{font-size:18px}
    .wf-body { padding:22px; }
    .wf-row { display:grid; grid-template-columns: 1fr 1fr; gap:14px; }
    .wf-row-3 { display:grid; grid-template-columns: 1fr 1fr 1fr; gap:14px; }
    label { font-weight:700; font-size:.92rem; color:#374151; display:block; margin-bottom:6px; }
    input, select { width:100%; border:1px solid #e5e7eb; border-radius:10px; padding:10px 12px; font-size:.98rem; }
    input:focus, select:focus { outline:none; border-color:#059669; box-shadow:0 0 0 3px rgba(5,150,105,.12); }
    .wf-actions { display:flex; gap:10px; margin-top:10px; }
    .btn { border:none; border-radius:10px; padding:10px 14px; font-weight:700; cursor:pointer; }
    .btn-primary{ background:linear-gradient(135deg,#059669,#10b981); color:#fff; }
    .btn-secondary{ background:#f3f4f6; color:#374151; }
    .help { color:#6b7280; font-size:.82rem; margin-top:4px; }
    .error-box{background:#fee2e2;color:#7f1d1d;padding:10px;border-radius:8px;margin-bottom:12px}
    @media(max-width:768px){ .wf-row,.wf-row-3{ grid-template-columns:1fr } }
</style>
<div class="warehouse-form-card">
    <div class="wf-header"><i class="fas fa-warehouse"></i><strong>Ajouter un nouvel entrepôt</strong></div>
    <div class="wf-body">
        @if ($errors->any())
            <div class="error-box">
                <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        @php($regions = ['Dakar','Diourbel','Fatick','Kaffrine','Kaolack','Kédougou','Kolda','Louga','Matam','Saint-Louis','Sédhiou','Tambacounda','Thiès','Ziguinchor'])
        <form action="{{ route('admin.warehouses.store') }}" method="POST" id="warehouseForm">
            @csrf
            <label for="name">Nom de l'entrepôt</label>
            <input type="text" name="name" id="name" placeholder="Magasin CSAR Dakar" required>

            <label for="address">Adresse</label>
            <input type="text" name="address" id="address" placeholder="Zone industrielle" required>

            <div class="wf-row">
                <div>
                    <label for="region">Région</label>
                    <select name="region" id="region" required>
                        <option value="">Sélectionner…</option>
                        @foreach($regions as $r)
                            <option value="{{ $r }}">{{ $r }}</option>
                        @endforeach
                    </select>
                    <div class="help">Sélectionnez une région pour préremplir les coordonnées (modifiables).</div>
                </div>
                <div>
                    <label for="city">Ville</label>
                    <input type="text" name="city" id="city" placeholder="Dakar" required>
                </div>
            </div>

            <div class="wf-row">
                <div>
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" id="latitude" placeholder="14.7167" required>
                </div>
                <div>
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" id="longitude" placeholder="-17.4677" required>
                </div>
            </div>

            <div class="wf-row">
                <div>
                    <label for="capacity">Capacité (tonnes)</label>
                    <input type="number" min="0" step="0.01" name="capacity" id="capacity" placeholder="5000">
                </div>
                <div>
                    <label for="status">Statut</label>
                    <select name="status" id="status"><option value="active" selected>Actif</option><option value="inactive">Inactif</option></select>
                </div>
            </div>

            <div class="wf-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.warehouses.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="button" class="btn btn-secondary" id="btnAutoCoords"><i class="fas fa-map-marker-alt"></i> Coords auto</button>
            </div>
        </form>
    </div>
</div>
<script>
const presets = {
    'Dakar':[14.7167,-17.4677], 'Diourbel':[14.6550,-16.2400], 'Fatick':[14.3370,-16.4111],
    'Kaffrine':[14.1050,-15.5500], 'Kaolack':[14.1825,-16.2533], 'Kédougou':[12.5530,-12.1788],
    'Kolda':[12.8833,-14.9500], 'Louga':[15.6100,-16.2250], 'Matam':[15.6559,-13.2554],
    'Saint-Louis':[16.0179,-16.4896], 'Sédhiou':[12.7081,-15.5569], 'Tambacounda':[13.7700,-13.6700],
    'Thiès':[14.7900,-16.9300], 'Ziguinchor':[12.5590,-16.2734]
};
const regionSel = document.getElementById('region');
const latInp = document.getElementById('latitude');
const lngInp = document.getElementById('longitude');
const cityInp = document.getElementById('city');
function applyPreset(){
  const r = regionSel.value; if(!presets[r]) return; const [la,lo]=presets[r];
  if(!latInp.value) latInp.value = la; if(!lngInp.value) lngInp.value = lo; if(!cityInp.value) cityInp.value = r;
}
regionSel && regionSel.addEventListener('change', applyPreset);
document.getElementById('btnAutoCoords').addEventListener('click', applyPreset);
</script>
@endsection

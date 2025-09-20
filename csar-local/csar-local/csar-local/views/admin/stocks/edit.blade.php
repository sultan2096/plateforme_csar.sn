@extends('layouts.admin')

@section('content')
<style>
    .stock-form-card { max-width: 720px; margin: 24px auto; background:#fff; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08); overflow:hidden; }
    .sf-header { padding:18px 22px; background:linear-gradient(135deg,#059669,#10b981); color:#fff; display:flex; align-items:center; gap:10px; }
    .sf-body { padding:22px; }
    .row2 { display:grid; grid-template-columns: 1fr 1fr; gap:14px; }
    label { font-weight:700; font-size:.92rem; color:#374151; display:block; margin-bottom:6px; }
    input, select { width:100%; border:1px solid #e5e7eb; border-radius:10px; padding:10px 12px; font-size:.98rem; }
    input:focus, select:focus { outline:none; border-color:#059669; box-shadow:0 0 0 3px rgba(5,150,105,.12); }
    .actions { display:flex; gap:10px; margin-top:10px; }
    .btn { border:none; border-radius:10px; padding:10px 14px; font-weight:700; cursor:pointer; }
    .btn-primary{ background:linear-gradient(135deg,#059669,#10b981); color:#fff; }
    .btn-secondary{ background:#f3f4f6; color:#374151; }
    .help { color:#6b7280; font-size:.82rem; margin-top:4px; }
    .error-box{background:#fee2e2;color:#7f1d1d;padding:10px;border-radius:8px;margin-bottom:12px}
    @media(max-width:768px){ .row2{ grid-template-columns:1fr } }
</style>

<div class="stock-form-card">
    <div class="sf-header"><i class="fas fa-edit"></i><strong>Modifier le stock</strong></div>
    <div class="sf-body">
        @if ($errors->any())
            <div class="error-box"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ route('admin.stocks.update', $stock) }}" method="POST" id="stockForm">
            @csrf
            @method('PUT')
            <label for="warehouse_id">Magasin</label>
            <select name="warehouse_id" id="warehouse_id" required>
                @foreach($warehouses as $w)
                    <option value="{{ $w->id }}" {{ $stock->warehouse_id == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                @endforeach
            </select>

            <label for="stock_type_id">Type / Unité</label>
            <select name="stock_type_id" id="stock_type_id" required>
                @foreach($stockTypes as $t)
                    <option value="{{ $t->id }}" {{ $stock->stock_type_id == $t->id ? 'selected' : '' }}>{{ $t->display_name }} ({{ $t->unit }})</option>
                @endforeach
                <option value="custom">— Type personnalisé…</option>
            </select>
            <div id="customTypeFields" style="display:none; margin-top:10px;">
                <div class="row2">
                    <div>
                        <label for="custom_display_name">Nom du type</label>
                        <input type="text" name="custom_display_name" id="custom_display_name" placeholder="Ex: Aide alimentaire (sac), Matériel logistique (pcs)">
                    </div>
                    <div>
                        <label for="custom_unit">Unité</label>
                        <input type="text" name="custom_unit" id="custom_unit" placeholder="Ex: kg, L, pcs">
                    </div>
                </div>
                <div class="help">Crée un type réutilisable. Utilisez une unité claire (kg, L, pcs…).</div>
            </div>

            <label for="item_name">Nom du produit</label>
            <input type="text" name="item_name" id="item_name" value="{{ $stock->item_name }}" required>

            <div class="row2">
                <div>
                    <label for="quantity">Quantité</label>
                    <input type="number" name="quantity" id="quantity" min="0" step="0.01" value="{{ $stock->quantity }}" required>
                </div>
                <div>
                    <label for="min_quantity">Seuil minimum</label>
                    <input type="number" name="min_quantity" id="min_quantity" min="0" step="0.01" value="{{ $stock->min_quantity }}">
                </div>
            </div>
            <div class="row2">
                <div>
                    <label for="max_quantity">Capacité max</label>
                    <input type="number" name="max_quantity" id="max_quantity" min="0" step="0.01" value="{{ $stock->max_quantity }}">
                </div>
                <div>
                    <label for="is_active">Statut</label>
                    <select name="is_active" id="is_active">
                        <option value="1" {{ $stock->is_active ? 'selected' : '' }}>Actif</option>
                        <option value="0" {{ !$stock->is_active ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
<script>
const sel = document.getElementById('stock_type_id');
const box = document.getElementById('customTypeFields');
sel.addEventListener('change', ()=>{ box.style.display = sel.value==='custom' ? 'block':'none'; });
</script>
@endsection




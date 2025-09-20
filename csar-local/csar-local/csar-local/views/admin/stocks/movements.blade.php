@extends('layouts.admin')

@section('title', 'Historique des reçus - Administration CSAR')

@section('content')
<div style="max-width:1200px;margin:0 auto;padding:0 2rem 2rem;">
  <div class="page-header" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); padding: 1.5rem 1rem; border-radius: 12px; color:#fff; margin: 18px 0; display:flex; align-items:center; justify-content:space-between;">
    <div style="display:flex; align-items:center; gap:12px;">
      <div style="width:48px;height:48px;border-radius:12px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;"><i class="fas fa-history"></i></div>
      <div>
        <h1 style="margin:0; font-size:1.4rem;">Historique des reçus</h1>
        <div style="opacity:.9; font-size:.95rem;">Tous les mouvements de stock avec téléchargement de reçu PDF</div>
      </div>
    </div>
    <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color:#fff; padding:.65rem 1rem; border-radius:8px; text-decoration:none;">
      <i class="fas fa-arrow-left"></i> Retour aux stocks
    </a>
  </div>

  <form method="GET" style="display:flex; gap:10px; flex-wrap:wrap; background:#fff; border:1px solid #e5e7eb; padding:12px; border-radius:12px; margin-bottom:12px;">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Référence ou produit..." style="flex:1; min-width:220px; padding:.6rem .8rem; border:2px solid #e5e7eb; border-radius:8px;">
    <select name="type" style="padding:.6rem .8rem; border:2px solid #e5e7eb; border-radius:8px;">
      <option value="">Tous les types</option>
      <option value="in" {{ request('type')==='in' ? 'selected' : '' }}>Entrée</option>
      <option value="out" {{ request('type')==='out' ? 'selected' : '' }}>Sortie</option>
    </select>
    <button class="btn btn-primary" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color:#fff; padding:.6rem 1rem; border-radius:8px; border:none;">Filtrer</button>
    <a href="{{ route('admin.stocks.movements') }}" class="btn btn-outline" style="padding:.6rem 1rem; border-radius:8px; text-decoration:none; border:2px solid #059669; color:#059669;">Réinitialiser</a>
  </form>

  @isset($stats)
  <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:12px;">
    <div style="flex:1; min-width:220px; background:linear-gradient(135deg,#ffffff 0%,#f8fafc 100%); border:1px solid #e5e7eb; border-radius:12px; padding:12px; display:flex; align-items:center; gap:10px;">
      <div style="width:36px;height:36px;border-radius:10px;background:#e0f2fe;color:#0369a1;display:flex;align-items:center;justify-content:center;"><i class="fas fa-list"></i></div>
      <div>
        <div style="font-size:12px; color:#64748b;">Mouvements</div>
        <div style="font-size:22px; font-weight:800; color:#0f172a;">{{ $stats['total'] }}</div>
      </div>
    </div>
    <div style="flex:1; min-width:220px; background:linear-gradient(135deg,#f0fdf4 0%,#ecfdf5 100%); border:1px solid #bbf7d0; border-radius:12px; padding:12px; display:flex; align-items:center; gap:10px;">
      <div style="width:36px;height:36px;border-radius:10px;background:#dcfce7;color:#065f46;display:flex;align-items:center;justify-content:center;"><i class="fas fa-arrow-down"></i></div>
      <div>
        <div style="font-size:12px; color:#065f46;">Entrées</div>
        <div style="font-size:22px; font-weight:800; color:#065f46;">{{ $stats['in'] }}</div>
      </div>
    </div>
    <div style="flex:1; min-width:220px; background:linear-gradient(135deg,#fef2f2 0%,#fef2f2 100%); border:1px solid #fecaca; border-radius:12px; padding:12px; display:flex; align-items:center; gap:10px;">
      <div style="width:36px;height:36px;border-radius:10px;background:#fee2e2;color:#991b1b;display:flex;align-items:center;justify-content:center;"><i class="fas fa-arrow-up"></i></div>
      <div>
        <div style="font-size:12px; color:#991b1b;">Sorties</div>
        <div style="font-size:22px; font-weight:800; color:#991b1b;">{{ $stats['out'] }}</div>
      </div>
    </div>
  </div>
  @endisset

  <div class="table-wrap" style="overflow:auto; background:#fff; border:1px solid #e5e7eb; border-radius:12px;">
    <table style="width:100%; border-collapse: collapse; min-width:980px;">
      <thead>
        <tr style="background:#f8fafc; position: sticky; top:0; z-index:1;">
          <th style="text-align:left; padding:12px; border-bottom:1px solid #e5e7eb;">Date</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #e5e7eb;">Référence</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #e5e7eb;">Type</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #e5e7eb;">Produit</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #e5e7eb;">Quantité</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #e5e7eb;">Entrepôt</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #e5e7eb;">Reçu</th>
        </tr>
      </thead>
      <tbody>
      @forelse($movements as $m)
        <tr style="transition:background .2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
          <td style="padding:12px; border-bottom:1px solid #f3f4f6;">{{ $m->created_at->format('d/m/Y H:i') }}</td>
          <td style="padding:12px; border-bottom:1px solid #f3f4f6; font-weight:600;">{{ $m->reference }}</td>
          <td style="padding:12px; border-bottom:1px solid #f3f4f6;">
            @if($m->type === 'in')
              <span style="background:#dcfce7; color:#065f46; border:1px solid #86efac; padding:2px 8px; border-radius:999px; font-size:12px; font-weight:700;">Entrée</span>
            @else
              <span style="background:#fee2e2; color:#991b1b; border:1px solid #fecaca; padding:2px 8px; border-radius:999px; font-size:12px; font-weight:700;">Sortie</span>
            @endif
          </td>
          <td style="padding:12px; border-bottom:1px solid #f3f4f6;">{{ optional($m->stock)->item_name }}</td>
          <td style="padding:12px; border-bottom:1px solid #f3f4f6; font-weight:600;">{{ number_format($m->quantity, 2) }} {{ optional(optional($m->stock)->stockType)->unit }}</td>
          <td style="padding:12px; border-bottom:1px solid #f3f4f6;">{{ optional($m->warehouse)->name }}</td>
          <td style="padding:12px; border-bottom:1px solid #f3f4f6;">
            <a href="{{ route('admin.stocks.movement-receipt', $m->id) }}" class="btn btn-outline" target="_blank" title="Télécharger le reçu PDF" style="display:inline-flex;align-items:center;gap:8px;padding:.45rem .9rem; border:2px solid #059669; color:#059669; border-radius:999px; text-decoration:none; font-weight:600;">
              <i class="fas fa-file-pdf"></i> <span>Télécharger</span>
            </a>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" style="padding:18px; text-align:center; color:#6b7280;">Aucun mouvement trouvé</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:12px;">{{ $movements->withQueryString()->links() }}</div>
</div>
@endsection


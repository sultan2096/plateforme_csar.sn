<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu CSAR - {{ $movement->reference }}</title>
    <style>
        @page { margin: 16px 16px 56px 16px; }
        html, body { margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; color:#111827; }
        .brandbar { height: 6px; background: linear-gradient(90deg,#059669,#10b981,#34d399); margin: 0 0 8px; }
        .wrap { padding: 16px; position: relative; }
        .watermark { position: fixed; top: 52%; left: 50%; transform: translate(-50%, -45%) rotate(-15deg); z-index: 0; }
        .watermark .wm-img { width: 820px; height: auto; opacity: .12; }
        .header { text-align:center; margin-bottom: 8px; }
        .logo-top { height: 64px; margin-bottom: 10px; display:inline-block; }
        .mast-title { font-size: 26px; font-weight: 900; color: #0f172a; letter-spacing: .3px; }
        .mast-sub { font-size: 16px; font-weight: 800; color:#059669; margin-top:6px; }
        .mast-mini { font-size: 11px; color:#64748b; margin-top:6px; }
        .doc-meta { display:flex; justify-content:space-between; font-size:12px; color:#4b5563; margin: 10px 0 6px; }
        .badge { display:inline-block; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:800; color:#065f46; background:#d1fae5; border:1px solid #a7f3d0; }
        .card { border:1px solid #e5e7eb; border-radius:12px; padding:12px; margin-bottom:10px; background:#fff; }
        .row { display:flex; gap:12px; }
        .col { flex:1; }
        .label { font-size:10px; color:#6b7280; text-transform:uppercase; font-weight:800; letter-spacing:.3px }
        .value { margin-top:4px; font-weight:800; color:#111827; }
        .table { width:100%; border-collapse: collapse; margin-top: 6px; }
        .table th { background:#f1f5f9; color:#0f172a; font-weight:800; border-bottom:1px solid #e2e8f0; }
        .table th, .table td { border:1px solid #e5e7eb; padding:6px; font-size:12px; }
        .table tbody tr:nth-child(even) td { background:#fbfbfb; }
        .footer { margin-top: 14px; font-size:11px; color:#6b7280; }
        .sign { margin-top: 18px; display:flex; gap:18px; }
        .sign .box { flex:1; height: 60px; border:1px dashed #cbd5e1; border-radius:8px; padding:6px; font-size:10px; color:#64748b; }
        .page-footer { position: fixed; left: 16px; right: 16px; bottom: 8px; border-top:1px solid #e5e7eb; padding-top:6px; text-align:center; font-size:10px; color:#334155; }
    </style>
    </head>
<body>
    <div class="brandbar"></div>
    <div class="wrap">
        @php
            // Force le logo officiel si présent, sinon tente quelques variantes
            // Préférer JPEG (pas de dépendance GD), puis PNG
            $candidates = [
                public_path('images/csar-logo.jpg'),
                public_path('images/csar-logo.jpeg'),
                public_path('images/csar-logo.png'),
                public_path('images/csar-logo-white.png'),
                public_path('images/logos/LOGO CSAR vectoriel-01.png'),
            ];
            $logoPath = null;
            foreach ($candidates as $p) { if (is_file($p)) { $logoPath = $p; break; } }
            $logoExt = $logoPath ? strtolower(pathinfo($logoPath, PATHINFO_EXTENSION)) : null;
            $logoMime = $logoExt === 'jpg' || $logoExt === 'jpeg' ? 'image/jpeg' : 'image/png';
            $isJpeg = in_array($logoExt, ['jpg','jpeg']);
            $isPng = $logoExt === 'png';

            $logoBase64 = null;
            if ($logoPath && is_readable($logoPath)) {
                $content = @file_get_contents($logoPath);
                if ($content !== false) {
                    $logoBase64 = 'data:'.$logoMime.';base64,'.base64_encode($content);
                }
            }
            // URL fichier locale de secours (Windows friendly)
            $logoFileUrl = $logoPath ? ('file:///' . str_replace('\\', '/', $logoPath)) : null;
            // Toujours autoriser JPEG; pour PNG on exige GD pour éviter les 500
            $useImages = (bool) $logoPath && ($isJpeg || ($isPng && extension_loaded('gd')));
        @endphp
        <div class="watermark">
            @if($useImages)
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" class="wm-img" alt="CSAR">
                @elseif(!empty($logoFileUrl))
                    <img src="{{ $logoFileUrl }}" class="wm-img" alt="CSAR">
                @endif
            @endif
        </div>
        <div class="header">
            @if($useImages)
                @php
                    $topLogoSrc = !empty($logoBase64) ? $logoBase64 : $logoFileUrl;
                @endphp
                @if($topLogoSrc)
                    <img src="{{ $topLogoSrc }}" class="logo-top" alt="CSAR">
                @endif
            @endif
            <div class="mast-title">COMMISSARIAT À LA SÉCURITÉ ALIMENTAIRE ET À LA RÉSILIENCE</div>
            <div class="mast-sub">C.S.A.R</div>
            <div class="mast-mini">Suivi et gestion des mouvements de stock</div>
        </div>
        <div class="doc-meta">
            <div><strong>Reçu N°</strong> {{ $movement->reference }}</div>
            <div><strong>Date</strong> {{ $generatedAt->format('d/m/Y') }}</div>
        </div>

        <div class="card">
            <div class="row">
                <div class="col">
                    <div class="label">Entrepôt</div>
                    <div class="value">{{ $movement->warehouse->name }}</div>
                </div>
                <div class="col">
                    <div class="label">Adresse</div>
                    <div class="value">{{ $movement->warehouse->address }}</div>
                </div>
                <div class="col">
                    <div class="label">Opérateur</div>
                    <div class="value">{{ $movement->user->name ?? 'Administrateur' }}</div>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th style="width:90px;">Quantité</th>
                <th>Désignation</th>
                <th style="width:110px;">Unité</th>
                <th style="width:110px;">Avant</th>
                <th style="width:110px;">Après</th>
                <th style="width:150px;">Motif</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="text-align:center; font-weight:700;">{{ number_format($movement->quantity, 2) }}</td>
                <td>
                    <div style="font-weight:700; color:#0f172a;">{{ $movement->stock->item_name }}</div>
                    <div style="font-size:12px; color:#64748b;">Mouvement: {{ $movement->type === 'in' ? 'Entrée' : 'Sortie' }} — Entrepôt: {{ $movement->warehouse->name }}</div>
                </td>
                <td>{{ optional($movement->stock->stockType)->unit }}</td>
                <td>{{ number_format($movement->quantity_before, 2) }}</td>
                <td>{{ number_format($movement->quantity_after, 2) }}</td>
                <td>{{ $movement->reason ?: '—' }}</td>
            </tr>
            </tbody>
        </table>

        <div class="card" style="margin-top:10px;">
            <div style="font-size:12px; color:#334155;">
                Arrêtée la présente pièce à la quantité de <strong>{{ number_format($movement->quantity,2) }} {{ optional($movement->stock->stockType)->unit }}</strong> 
                au titre de <strong>{{ $movement->type === 'in' ? 'l\'entrée' : 'la sortie' }}</strong> de stock.
            </div>
        </div>

        <div class="sign">
            <div class="box">Cachet de l'entrepôt</div>
            <div class="box">Nom & signature</div>
            <div class="box">Date</div>
        </div>
        <div class="footer">
            Document généré automatiquement par la plateforme CSAR.
        </div>

        <div class="page-footer">
            COMMISSARIAT À LA SÉCURITÉ ALIMENTAIRE ET À LA RÉSILIENCE (C.S.A.R) · 22 Rue Amadou Assane NDOYE X Béranger Féraud — BP 170 Dakar, Sénégal · Tél: +221 77 645 92 42 · Email: contact@csar.sn · Site: www.csar.sn
        </div>
    </div>
</body>
</html>



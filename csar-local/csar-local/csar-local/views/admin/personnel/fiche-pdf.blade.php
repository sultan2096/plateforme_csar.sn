<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Fiche Personnel - {{ $personnel->prenoms_nom }}</title>
  <style>
    @page { margin: 24px 24px 80px 24px; }
    body { font-family: DejaVu Sans, Arial, sans-serif; color:#111827; font-size:12px; }
    .header { display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #22c55e; padding-bottom:10px; margin-bottom:16px; }
    .title { font-size:18px; font-weight:700; color:#22c55e; }
    .grid { display:grid; grid-template-columns: 1fr 1fr; gap:10px; }
    .section { margin-bottom:14px; }
    .section h3 { font-size:14px; margin:0 0 6px 0; color:#16a34a; border-bottom:1px solid #e5e7eb; padding-bottom:4px; }
    .item { margin:3px 0; }
    .label { color:#6b7280; width:48%; display:inline-block; }
    .value { color:#111827; font-weight:600; }
    .avatar { width:90px; height:90px; border-radius:8px; object-fit:cover; border:1px solid #e5e7eb; }
    .footer { position: fixed; left:24px; right:24px; bottom:16px; font-size:10px; color:#6b7280; border-top:1px solid #e5e7eb; padding-top:6px; text-align:center; }
  </style>
  @php
    $photo = $personnel->photo_personnelle ? public_path('storage/personnel/' . $personnel->photo_personnelle) : null;
    $logoJpg = public_path('images/csar-logo.jpg');
    $logoPng = public_path('images/csar-logo.png');
    $logo = file_exists($logoJpg) ? $logoJpg : (file_exists($logoPng) ? $logoPng : null);
  @endphp
</head>
<body>
  <div class="header">
    <div class="title">FICHE PERSONNEL</div>
    <div>
      @if($logo)
        <img src="{{ $logo }}" alt="CSAR" style="height:32px;">
      @endif
    </div>
  </div>

  <div style="display:flex; gap:14px; align-items:flex-start; margin-bottom:10px;">
    <div>
      @if($photo && file_exists($photo))
        <img class="avatar" src="{{ $photo }}" alt="{{ $personnel->prenoms_nom }}">
      @else
        <img class="avatar" src="https://ui-avatars.com/api/?name={{ urlencode($personnel->prenoms_nom) }}&background=059669&color=ffffff" alt="{{ $personnel->prenoms_nom }}">
      @endif
    </div>
    <div>
      <div class="item"><span class="label">Nom et Prénoms</span> <span class="value">{{ $personnel->prenoms_nom }}</span></div>
      <div class="item"><span class="label">Matricule</span> <span class="value">{{ $personnel->matricule }}</span></div>
      <div class="item"><span class="label">Poste</span> <span class="value">{{ $personnel->poste_actuel }}</span></div>
      <div class="item"><span class="label">Direction / Service</span> <span class="value">{{ $personnel->direction_service }}</span></div>
    </div>
  </div>

  <div class="section">
    <h3>I. Informations personnelles</h3>
    <div class="grid">
      <div class="item"><span class="label">Date de naissance</span> <span class="value">{{ optional($personnel->date_naissance)->format('d/m/Y') }}</span></div>
      <div class="item"><span class="label">Lieu de naissance</span> <span class="value">{{ $personnel->lieu_naissance }}</span></div>
      <div class="item"><span class="label">Nationalité</span> <span class="value">{{ $personnel->nationalite }}</span></div>
      <div class="item"><span class="label">Téléphone</span> <span class="value">{{ $personnel->contact_telephonique }}</span></div>
      <div class="item"><span class="label">Email</span> <span class="value">{{ $personnel->email }}</span></div>
      <div class="item"><span class="label">Adresse</span> <span class="value">{{ $personnel->adresse_complete }}</span></div>
    </div>
  </div>

  <div class="section">
    <h3>II. Situation administrative</h3>
    <div class="grid">
      <div class="item"><span class="label">Date recrutement</span> <span class="value">{{ optional($personnel->date_recrutement_csar)->format('d/m/Y') }}</span></div>
      <div class="item"><span class="label">Date prise de service</span> <span class="value">{{ optional($personnel->date_prise_service_csar)->format('d/m/Y') }}</span></div>
      <div class="item"><span class="label">Statut</span> <span class="value">{{ $personnel->statut }}</span></div>
      @if($personnel->localisation_region)
      <div class="item"><span class="label">Localisation</span> <span class="value">{{ $personnel->localisation_region }}</span></div>
      @endif
    </div>
  </div>

  <div class="section">
    <h3>III. Compétences et divers</h3>
    @if($personnel->logiciels_maitrises)
      <div class="item"><span class="label">Logiciels</span> <span class="value">{{ implode(', ', $personnel->logiciels_maitrises) }}</span></div>
    @endif
    @if($personnel->langues_parlees)
      <div class="item"><span class="label">Langues</span> <span class="value">{{ implode(', ', $personnel->langues_parlees) }}</span></div>
    @endif
  </div>

  <div class="footer">
    Généré le {{ now()->format('d/m/Y H:i') }} — CSAR
  </div>
</body>
</html>


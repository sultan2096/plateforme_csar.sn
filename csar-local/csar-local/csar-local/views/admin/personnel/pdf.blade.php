@php
    $title = 'Liste du Personnel - CSAR';
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111827; }
        .header { text-align: center; margin-bottom: 16px; }
        .header h1 { font-size: 18px; margin: 0 0 4px; }
        .meta { font-size: 10px; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; font-weight: bold; }
        .small { font-size: 10px; color: #374151; }
        .right { text-align: right; }
        .center { text-align: center; }
    </style>
    </head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <div class="meta">Généré le {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Matricule</th>
                <th>Nom et Prénoms</th>
                <th>Poste</th>
                <th>Direction / Service</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Date recrutement</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personnel as $idx => $p)
            <tr>
                <td class="center">{{ $idx + 1 }}</td>
                <td>{{ $p->matricule }}</td>
                <td>{{ $p->prenoms_nom }}</td>
                <td>{{ $p->poste_actuel }}</td>
                <td>{{ $p->direction_service }}</td>
                <td class="small">{{ $p->email }}</td>
                <td class="small">{{ $p->contact_telephonique }}</td>
                <td class="small">{{ optional($p->date_recrutement_csar)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Annuaire du personnel - CSAR</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; margin: 24px; }
        .header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
        .title { font-size:20px; font-weight:700; }
        .grid { display:flex; flex-wrap:wrap; gap:10px; }
        .card { width: 31%; border:1px solid #e5e7eb; border-radius:8px; padding:10px; display:flex; gap:10px; }
        .avatar { width:64px; height:64px; border-radius:6px; object-fit:cover; border:1px solid #ddd; }
        .name { font-weight:700; font-size:12px; margin:0 0 2px 0; }
        .muted { color:#374151; font-size:11px; margin:1px 0; }
        .small { color:#6b7280; font-size:10px; }
        .footer { position:fixed; left:24px; right:24px; bottom:16px; font-size:10px; color:#6b7280; }
    </style>
    @php
        $logoJpg = public_path('images/csar-logo.jpg');
        $logoPng = public_path('images/csar-logo.png');
        $logo = file_exists($logoJpg) ? $logoJpg : (file_exists($logoPng) ? $logoPng : null);
    @endphp
</head>
<body>
    <div class="header">
        <div class="title">Annuaire du personnel - CSAR</div>
        @if($logo)
            <img src="{{ $logo }}" alt="CSAR" style="height:40px;">
        @endif
    </div>

    <div class="grid">
        @foreach($personnel as $p)
        <div class="card">
            @php
                $photo = $p->photo_personnelle
                    ? public_path('storage/personnel/' . $p->photo_personnelle)
                    : null;
            @endphp
            @if($photo && file_exists($photo))
                <img class="avatar" src="{{ $photo }}" alt="{{ $p->prenoms_nom }}">
            @else
                <img class="avatar" src="https://ui-avatars.com/api/?name={{ urlencode($p->prenoms_nom) }}&background=059669&color=ffffff" alt="{{ $p->prenoms_nom }}">
            @endif
            <div>
                <p class="name">{{ $p->prenoms_nom }}</p>
                <p class="muted">Matricule: {{ $p->matricule }}</p>
                <p class="muted">Poste: {{ $p->poste_actuel }}</p>
                <p class="small">{{ $p->direction_service }} • {{ $p->contact_telephonique }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="footer">
        Généré le {{ now()->format('d/m/Y H:i') }} — Total: {{ count($personnel) }}
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste du Personnel - CSAR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #22c55e;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #22c55e;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h2 {
            color: #22c55e;
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-valide {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-en-attente {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-rejete {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CSAR - Commissariat à la Sécurité Alimentaire et à la Résilience</h1>
        <p>Liste du Personnel</p>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="info-section">
        <h2>Résumé</h2>
        <p><strong>Total du personnel :</strong> {{ $personnel->count() }} personnes</p>
        <p><strong>Validés :</strong> {{ $personnel->where('statut_validation', 'Valide')->count() }}</p>
        <p><strong>En attente :</strong> {{ $personnel->where('statut_validation', 'En attente')->count() }}</p>
        <p><strong>Rejetés :</strong> {{ $personnel->where('statut_validation', 'Rejete')->count() }}</p>
    </div>

    <div class="info-section">
        <h2>Liste détaillée</h2>
        <table>
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Nom et Prénoms</th>
                    <th>Poste</th>
                    <th>Direction</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personnel as $p)
                <tr>
                    <td>{{ $p->matricule }}</td>
                    <td>{{ $p->prenoms_nom }}</td>
                    <td>{{ $p->poste_actuel }}</td>
                    <td>{{ $p->direction_service }}</td>
                    <td>{{ $p->contact_telephonique }}</td>
                    <td>{{ $p->email }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $p->statut_validation)) }}">
                            {{ $p->statut_validation }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Document généré automatiquement par le système CSAR</p>
        <p>© {{ date('Y') }} CSAR - Tous droits réservés</p>
    </div>
</body>
</html> 
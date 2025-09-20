<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation du Personnel - CSAR DG</title>
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
        <p>Consultation du Personnel - Interface DG</p>
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
        <p>Document généré automatiquement par le système CSAR - Interface DG</p>
        <p>© {{ date('Y') }} CSAR - Tous droits réservés</p>
    </div>
</body>
</html> 
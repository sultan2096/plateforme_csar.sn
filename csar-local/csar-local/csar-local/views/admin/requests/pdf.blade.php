<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande {{ $request->tracking_code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #059669;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #059669;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            color: #059669;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            font-size: 16px;
        }
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .info-value {
            display: table-cell;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-approved { background-color: #dcfce7; color: #166534; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }
        .status-completed { background-color: #dbeafe; color: #1e40af; }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CSAR - Commissariat à la Sécurité Alimentaire et à la Résilience</h1>
        <p>Demande d'assistance</p>
        <p>Code de suivi: <strong>{{ $request->tracking_code }}</strong></p>
    </div>

    <div class="section">
        <h2>Informations de la demande</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Type de demande:</div>
                <div class="info-value">{{ ucfirst($request->type) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Statut:</div>
                <div class="info-value">
                    <span class="status status-{{ $request->status }}">
                        {{ ucfirst($request->status) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Date de demande:</div>
                <div class="info-value">{{ $request->created_at->format('d/m/Y H:i') }}</div>
            </div>
            @if($request->processed_date)
            <div class="info-row">
                <div class="info-label">Date de traitement:</div>
                <div class="info-value">{{ $request->processed_date->format('d/m/Y H:i') }}</div>
            </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h2>Informations du demandeur</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nom complet:</div>
                <div class="info-value">{{ $request->full_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Téléphone:</div>
                <div class="info-value">{{ $request->phone }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $request->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Adresse:</div>
                <div class="info-value">{{ $request->address }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Région:</div>
                <div class="info-value">{{ $request->region }}</div>
            </div>
            @if($request->latitude && $request->longitude)
            <div class="info-row">
                <div class="info-label">Coordonnées GPS:</div>
                <div class="info-value">{{ $request->latitude }}, {{ $request->longitude }}</div>
            </div>
            @endif
        </div>
    </div>

    <div class="section">
        <h2>Description de la demande</h2>
        <div style="background-color: #f9fafb; padding: 15px; border-radius: 4px; border-left: 4px solid #059669;">
            {{ $request->description }}
        </div>
    </div>

    @if($request->admin_comment)
    <div class="section">
        <h2>Commentaire administratif</h2>
        <div style="background-color: #f0f9ff; padding: 15px; border-radius: 4px; border-left: 4px solid #0ea5e9;">
            {{ $request->admin_comment }}
        </div>
    </div>
    @endif

    @if($request->assignedTo)
    <div class="section">
        <h2>Agent assigné</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nom:</div>
                <div class="info-value">{{ $request->assignedTo->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $request->assignedTo->email }}</div>
            </div>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        <p>CSAR - Commissariat à la Sécurité Alimentaire et à la Résilience</p>
        <p>Ce document est confidentiel et destiné à un usage interne uniquement.</p>
    </div>
</body>
</html> 
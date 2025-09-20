<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande {{ $request->tracking_code }} - CSAR</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #22c55e;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .logo-section {
            margin-bottom: 15px;
        }
        
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin: 10px 0;
        }
        
        .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        
        .tracking-code {
            font-size: 18px;
            font-weight: bold;
            color: #22c55e;
            background: #f0f9ff;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        
        .info-section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            background: #f8fafc;
            padding: 10px;
            border-left: 4px solid #22c55e;
            margin-bottom: 15px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #374151;
            padding: 8px 15px 8px 0;
            width: 30%;
            vertical-align: top;
        }
        
        .info-value {
            display: table-cell;
            color: #1f2937;
            padding: 8px 0;
            vertical-align: top;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-completed {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .description-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            padding: 15px;
            margin: 10px 0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-section">
            <div style="font-size: 20px; font-weight: bold; color: #22c55e;">CSAR</div>
            <div style="font-size: 12px; color: #6b7280;">Commissariat à la Sécurité Alimentaire et à la Résilience</div>
        </div>
        <div class="title">Fiche de Demande</div>
        <div class="subtitle">République du Sénégal - Un Peuple, Un But, Une Foi</div>
    </div>

    <div class="tracking-code">
        Code de suivi : {{ $request->tracking_code }}
    </div>

    <div class="info-section">
        <div class="section-title">Informations générales</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Type de demande :</div>
                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $request->type ?? 'Non spécifié')) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Statut :</div>
                <div class="info-value">
                    <span class="status-badge 
                        @if($request->status === 'pending') status-pending
                        @elseif($request->status === 'approved') status-approved
                        @elseif($request->status === 'completed') status-completed
                        @elseif($request->status === 'rejected') status-rejected
                        @endif">
                        @if($request->status === 'pending') En attente
                        @elseif($request->status === 'approved') Approuvée
                        @elseif($request->status === 'completed') Terminée
                        @elseif($request->status === 'rejected') Rejetée
                        @else {{ ucfirst($request->status ?? 'Non défini') }}
                        @endif
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Date de soumission :</div>
                <div class="info-value">{{ $request->request_date ? \Carbon\Carbon::parse($request->request_date)->format('d/m/Y') : 'Non spécifiée' }}</div>
            </div>
            @if($request->processed_date)
            <div class="info-row">
                <div class="info-label">Date de traitement :</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($request->processed_date)->format('d/m/Y') }}</div>
            </div>
            @endif
        </div>
    </div>

    <div class="info-section">
        <div class="section-title">Informations du demandeur</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nom complet :</div>
                <div class="info-value">{{ $request->full_name ?? 'Non renseigné' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email :</div>
                <div class="info-value">{{ $request->email ?? 'Non renseigné' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Téléphone :</div>
                <div class="info-value">{{ $request->phone ?? 'Non renseigné' }}</div>
            </div>
            @if($request->address)
            <div class="info-row">
                <div class="info-label">Adresse :</div>
                <div class="info-value">{{ $request->address }}</div>
            </div>
            @endif
            @if($request->region)
            <div class="info-row">
                <div class="info-label">Région :</div>
                <div class="info-value">{{ $request->region }}</div>
            </div>
            @endif
        </div>
    </div>

    @if($request->description)
    <div class="info-section">
        <div class="section-title">Description de la demande</div>
        <div class="description-box">
            {{ $request->description }}
        </div>
    </div>
    @endif

    @if($request->admin_comment)
    <div class="info-section">
        <div class="section-title">Commentaire administratif</div>
        <div class="description-box">
            {{ $request->admin_comment }}
        </div>
    </div>
    @endif

    @if($request->assignedTo)
    <div class="info-section">
        <div class="section-title">Agent assigné</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nom :</div>
                <div class="info-value">{{ $request->assignedTo->name ?? 'Non assigné' }}</div>
            </div>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Ce document a été généré automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
        <p>CSAR - Commissariat à la Sécurité Alimentaire et à la Résilience</p>
        <p>Pour plus d'informations, visitez notre site web ou contactez-nous</p>
    </div>
</body>
</html>

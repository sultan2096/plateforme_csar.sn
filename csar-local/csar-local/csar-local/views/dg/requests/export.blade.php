<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport des Demandes - CSAR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e40af;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #1e40af;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
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
            font-size: 12px;
        }
        
        th {
            background-color: #1e40af;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .badge-completed {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport des Demandes - CSAR</h1>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ $requests->count() }}</div>
            <div class="stat-label">Total Demandes</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $requests->where('type', 'aide')->count() }}</div>
            <div class="stat-label">Demandes d'Aide</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $requests->where('type', 'partenariat')->count() }}</div>
            <div class="stat-label">Partenariats</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $requests->where('status', 'pending')->count() }}</div>
            <div class="stat-label">En Attente</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Type</th>
                <th>Région</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->created_at->format('d/m/Y') }}</td>
                <td>{{ $request->full_name }}</td>
                <td>{{ $request->email }}</td>
                <td>{{ $request->phone }}</td>
                <td>{{ ucfirst($request->type) }}</td>
                <td>{{ $request->region }}</td>
                <td>
                    <span class="badge badge-{{ $request->status }}">
                        {{ ucfirst($request->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Rapport généré automatiquement par le système CSAR</p>
        <p>Centre de Secours et d'Assistance aux Réfugiés</p>
    </div>
</body>
</html> 
<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use App\Models\PublicRequest;
use App\Models\Warehouse;
use App\Models\Personnel;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        // Demandes d'aide avec géolocalisation (tous statuts)
        $requests = PublicRequest::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', 0)
            ->where('longitude', '!=', 0)
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'type' => 'request',
                    'title' => "Demande d'aide - {$request->full_name}",
                    'description' => $request->description,
                    'lat' => $request->latitude,
                    'lng' => $request->longitude,
                    'status' => $request->status,
                    'region' => $request->region,
                    'created_at' => $request->created_at->format('d/m/Y'),
                    'icon' => 'request',
                    'tracking_code' => $request->tracking_code
                ];
            });
        
        // Debug temporaire
        \Log::info('Demandes récupérées pour la carte: ' . $requests->count());
        \Log::info('Demandes brutes: ' . PublicRequest::whereNotNull('latitude')->whereNotNull('longitude')->count());
        
        // Entrepôts
        $warehouses = Warehouse::where('is_active', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($warehouse) {
                return [
                    'id' => $warehouse->id,
                    'type' => 'warehouse',
                    'title' => $warehouse->name,
                    'description' => $warehouse->address,
                    'lat' => $warehouse->latitude,
                    'lng' => $warehouse->longitude,
                    'capacity' => $warehouse->capacity,
                    'status' => $warehouse->is_active ? 'active' : 'inactive',
                    'icon' => 'warehouse'
                ];
            });
        
        // Personnel avec géolocalisation
        $personnel = Personnel::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($person) {
                return [
                    'id' => $person->id,
                    'type' => 'personnel',
                    'title' => $person->prenoms_nom,
                    'description' => $person->poste_actuel,
                    'lat' => $person->latitude,
                    'lng' => $person->longitude,
                    'direction' => $person->direction_service,
                    'status' => $person->statut_validation,
                    'icon' => 'personnel'
                ];
            });
        
        // Statistiques pour les filtres
        $stats = [
            'total_requests' => $requests->count(),
            'total_warehouses' => $warehouses->count(),
            'total_personnel' => $personnel->count(),
            'regions' => $requests->pluck('region')->unique()->values(),
        ];
        
        return view('dg.map.index', compact('requests', 'warehouses', 'personnel', 'stats'));
    }
} 
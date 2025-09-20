<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicRequest;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        // Récupérer toutes les demandes avec géolocalisation
        $requests = PublicRequest::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with(['assignedTo'])
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'type' => 'request',
                    'title' => $request->full_name,
                    'description' => $request->type . ' - ' . $request->region,
                    'status' => $request->status,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'created_at' => $request->created_at->format('d/m/Y'),
                    'assigned_to' => $request->assignedTo ? $request->assignedTo->name : 'Non assigné'
                ];
            });

        // Récupérer tous les entrepôts avec géolocalisation
        $warehouses = Warehouse::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with(['responsible'])
            ->get()
            ->map(function ($warehouse) {
                return [
                    'id' => $warehouse->id,
                    'type' => 'warehouse',
                    'title' => $warehouse->name,
                    'description' => $warehouse->address . ', ' . $warehouse->city,
                    'capacity' => $warehouse->capacity,
                    'current_stock' => $warehouse->current_stock,
                    'latitude' => $warehouse->latitude,
                    'longitude' => $warehouse->longitude,
                    'responsible' => $warehouse->responsible ? $warehouse->responsible->name : 'Non assigné',
                    'status' => $warehouse->status
                ];
            });

        // Statistiques pour les filtres
        $stats = [
            'total_requests' => PublicRequest::count(),
            'pending_requests' => PublicRequest::where('status', 'pending')->count(),
            'approved_requests' => PublicRequest::where('status', 'approved')->count(),
            'rejected_requests' => PublicRequest::where('status', 'rejected')->count(),
            'total_warehouses' => Warehouse::count(),
            'active_warehouses' => Warehouse::where('status', 'active')->count(),
            'inactive_warehouses' => Warehouse::where('status', 'inactive')->count(),
        ];

        return view('admin.map.index', compact('requests', 'warehouses', 'stats'));
    }

    public function getMapData(Request $request)
    {
        $type = $request->get('type', 'all');
        $status = $request->get('status', 'all');
        $region = $request->get('region', 'all');

        $data = [];

        // Filtrer les demandes
        if ($type === 'all' || $type === 'requests') {
            $requestsQuery = PublicRequest::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->with(['assignedTo']);

            if ($status !== 'all') {
                $requestsQuery->where('status', $status);
            }

            if ($region !== 'all') {
                $requestsQuery->where('region', $region);
            }

            $requests = $requestsQuery->get()->map(function ($request) {
                return [
                    'id' => $request->id,
                    'type' => 'request',
                    'title' => $request->full_name,
                    'description' => $request->type . ' - ' . $request->region,
                    'status' => $request->status,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'created_at' => $request->created_at->format('d/m/Y'),
                    'assigned_to' => $request->assignedTo ? $request->assignedTo->name : 'Non assigné'
                ];
            });

            $data = array_merge($data, $requests->toArray());
        }

        // Filtrer les entrepôts
        if ($type === 'all' || $type === 'warehouses') {
            $warehousesQuery = Warehouse::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->with(['responsible']);

            if ($status !== 'all') {
                $warehousesQuery->where('status', $status);
            }

            $warehouses = $warehousesQuery->get()->map(function ($warehouse) {
                return [
                    'id' => $warehouse->id,
                    'type' => 'warehouse',
                    'title' => $warehouse->name,
                    'description' => $warehouse->address . ', ' . $warehouse->city,
                    'capacity' => $warehouse->capacity,
                    'current_stock' => $warehouse->current_stock,
                    'latitude' => $warehouse->latitude,
                    'longitude' => $warehouse->longitude,
                    'responsible' => $warehouse->responsible ? $warehouse->responsible->name : 'Non assigné',
                    'status' => $warehouse->status
                ];
            });

            $data = array_merge($data, $warehouses->toArray());
        }

        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        // Liste officielle des 14 régions du Sénégal
        $regions = [
            'Dakar','Diourbel','Fatick','Kaffrine','Kaolack','Kédougou','Kolda','Louga','Matam','Saint-Louis','Sédhiou','Tambacounda','Thiès','Ziguinchor'
        ];

        $warehousesQuery = Warehouse::with('responsible');

        // Filtres
        if ($request->filled('status')) {
            if ($request->get('status') === 'active') {
                $warehousesQuery->where('is_active', true);
            } elseif ($request->get('status') === 'inactive') {
                $warehousesQuery->where('is_active', false);
            }
        }

        if ($request->filled('region') && in_array($request->get('region'), $regions, true)) {
            $warehousesQuery->where('region', $request->get('region'));
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $warehousesQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_capacity')) {
            $min = (float) $request->get('min_capacity');
            $warehousesQuery->whereRaw('COALESCE(capacity, 0) >= ?', [$min]);
        }

        $warehouses = $warehousesQuery->orderBy('name')->paginate(12);

        // Calculer les statistiques pour affichage
        foreach ($warehouses as $warehouse) {
            $warehouse->current_stock = $warehouse->stocks()->sum('quantity') ?? 0;
            $warehouse->capacity = $warehouse->capacity ?? 5000; // défaut
        }

        $activeCount = Warehouse::where('is_active', true)->count();
        $inactiveCount = Warehouse::where('is_active', false)->count();
        $totalCapacity = (float) Warehouse::sum('capacity');
        $totalStock = (float) Stock::sum('quantity');

        return view('admin.warehouses.index', compact(
            'warehouses',
            'regions',
            'activeCount',
            'inactiveCount',
            'totalCapacity',
            'totalStock'
        ));
    }

    public function create()
    {
        $responsibles = User::where('role_id', 3)->get(); // Responsables
        return view('admin.warehouses.create', compact('responsibles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'region' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'responsible_id' => 'nullable|exists:users,id'
        ]);

        Warehouse::create($validated);

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Entrepôt créé avec succès');
    }

    public function show(Warehouse $warehouse)
    {
        $warehouse->load(['stocks.stockType', 'responsible']);
        return view('admin.warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        $responsibles = User::where('role_id', 3)->get();
        return view('admin.warehouses.edit', compact('warehouse', 'responsibles'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'region' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'responsible_id' => 'nullable|exists:users,id'
        ]);

        $warehouse->update($validated);

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Entrepôt mis à jour avec succès');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Entrepôt supprimé avec succès');
    }
} 
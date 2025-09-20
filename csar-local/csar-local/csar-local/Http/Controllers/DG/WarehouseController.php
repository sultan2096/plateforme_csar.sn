<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\Stock;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('stocks')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        // Statistiques globales
        $stats = [
            'total_warehouses' => $warehouses->count(),
            'total_food' => Stock::where('type', 'food')->sum('quantity'),
            'total_equipment' => Stock::where('type', 'equipment')->sum('quantity'),
            'total_fuel' => Stock::where('type', 'fuel')->sum('quantity'),
            'low_stock_warehouses' => $warehouses->filter(function ($warehouse) {
                return $warehouse->stocks->where('quantity', '<', 100)->count() > 0;
            })->count(),
        ];
        
        return view('dg.warehouses.index', compact('warehouses', 'stats'));
    }
    
    public function show($id)
    {
        $warehouse = Warehouse::with('stocks')->findOrFail($id);
        
        // Mouvements de stock récents
        $recentMovements = Stock::where('warehouse_id', $id)
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();
            
        return view('dg.warehouses.show', compact('warehouse', 'recentMovements'));
    }
}

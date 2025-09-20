<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\StockType;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::orderBy('name')->get(['id','name']);
        $stockTypes = StockType::orderBy('display_name')->get(['id','name','display_name','unit']);

        $stocksQuery = Stock::with(['warehouse','stockType']);

        if ($request->filled('warehouse')) {
            $stocksQuery->where('warehouse_id', $request->integer('warehouse'));
        }
        if ($request->filled('search')) {
            $search = $request->get('search');
            $stocksQuery->where('item_name', 'like', "%{$search}%");
        }
        if ($request->filled('status')) {
            if ($request->get('status') === 'low') {
                $stocksQuery->whereColumn('quantity', '<=', 'min_quantity');
            } elseif ($request->get('status') === 'critical') {
                // SQLite compatible critical condition
                $stocksQuery->where(function($q){
                    $q->whereColumn('quantity', '<=', 'min_quantity')
                      ->orWhereRaw('quantity <= (min_quantity * 0.2)');
                });
            }
        }
        if ($request->filled('category')) {
            $category = $request->get('category');
            if (in_array($category, ['carburant','alimentaire','autres'])) {
                $stocksQuery->whereHas('stockType', function($q) use ($category) {
                    if ($category === 'carburant') {
                        $q->where('unit', 'L');
                    } elseif ($category === 'alimentaire') {
                        $q->where('unit', '!=', 'L');
                    }
                });
            }
        }

        $stocks = $stocksQuery->orderBy('updated_at', 'desc')->paginate(12);

        // Stats
        $baseForStats = clone $stocksQuery;
        $stats = [
            'total_stock' => (float) (clone $baseForStats)->sum('quantity'),
            'low_stock_items' => (clone $baseForStats)->whereColumn('quantity','<=','min_quantity')->count(),
            'critical_stock_items' => (clone $baseForStats)->where(function($q){
                $q->whereColumn('quantity','<=','min_quantity')
                  ->orWhereRaw('quantity <= (min_quantity * 0.2)');
            })->count(),
            'active_warehouses' => Warehouse::where('is_active', true)->count(),
            'fuel_used_month' => $this->getFuelUsed(Carbon::now()->startOfMonth(), Carbon::now())
        ];

        return view('admin.stocks.index', compact('stocks','warehouses','stockTypes','stats'));
    }

    public function create(Request $request)
    {
        $warehouses = Warehouse::orderBy('name')->get(['id','name']);
        $stockTypes = StockType::orderBy('display_name')->get(['id','display_name','unit']);
        $preselectedWarehouse = $request->get('warehouse');
        return view('admin.stocks.create', compact('warehouses','stockTypes','preselectedWarehouse'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => ['required','exists:warehouses,id'],
            'stock_type_id' => ['required'], // peut être 'custom'
            'item_name' => ['required','string','max:255'],
            'quantity' => ['required','numeric','min:0'],
            'min_quantity' => ['nullable','numeric','min:0'],
            'max_quantity' => ['nullable','numeric','min:0'],
            'is_active' => ['nullable','boolean'],
            'custom_display_name' => ['nullable','string','max:255'],
            'custom_unit' => ['nullable','string','max:10'],
        ]);

        // Gérer le type personnalisé
        $stockTypeId = $validated['stock_type_id'];
        if ($stockTypeId === 'custom') {
            $request->validate([
                'custom_display_name' => ['required','string','max:255'],
                'custom_unit' => ['required','string','max:10']
            ]);
            $newType = StockType::create([
                'name' => Str::slug($request->input('custom_display_name')),
                'display_name' => $request->input('custom_display_name'),
                'unit' => $request->input('custom_unit'),
            ]);
            $stockTypeId = $newType->id;
        } else {
            // Vérifier existence si ce n'est pas custom
            $request->validate([
                'stock_type_id' => ['exists:stock_types,id']
            ]);
        }

        $stock = Stock::create([
            'warehouse_id' => $validated['warehouse_id'],
            'stock_type_id' => $stockTypeId,
            'item_name' => $validated['item_name'],
            'quantity' => $validated['quantity'],
            'min_quantity' => $validated['min_quantity'] ?? 0,
            'max_quantity' => $validated['max_quantity'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        // Mouvement initial (entrée)
        StockMovement::create([
            'stock_id' => $stock->id,
            'warehouse_id' => $stock->warehouse_id,
            'type' => 'in',
            'quantity' => $stock->quantity,
            'quantity_before' => 0,
            'quantity_after' => $stock->quantity,
            'reason' => 'initial',
            'reference' => 'INIT-'.strtoupper(str()->random(6)),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.stocks.index', ['warehouse' => $stock->warehouse_id])
            ->with('success', 'Stock créé avec succès');
    }

    public function edit(Stock $stock)
    {
        $warehouses = Warehouse::orderBy('name')->get(['id','name']);
        $stockTypes = StockType::orderBy('display_name')->get(['id','display_name','unit']);

        return view('admin.stocks.edit', compact('stock', 'warehouses', 'stockTypes'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'warehouse_id' => ['required','exists:warehouses,id'],
            'stock_type_id' => ['required'], // peut être 'custom'
            'item_name' => ['required','string','max:255'],
            'quantity' => ['required','numeric','min:0'],
            'min_quantity' => ['nullable','numeric','min:0'],
            'max_quantity' => ['nullable','numeric','min:0'],
            'is_active' => ['nullable','boolean'],
            'custom_display_name' => ['nullable','string','max:255'],
            'custom_unit' => ['nullable','string','max:10'],
        ]);

        $stockTypeId = $validated['stock_type_id'];

        if ($stockTypeId === 'custom') {
            $request->validate([
                'custom_display_name' => ['required','string','max:255'],
                'custom_unit' => ['required','string','max:10']
            ]);
            $newType = StockType::create([
                'name' => Str::slug($request->input('custom_display_name')),
                'display_name' => $request->input('custom_display_name'),
                'unit' => $request->input('custom_unit'),
            ]);
            $stockTypeId = $newType->id;
        } else {
            // Vérifier existence si ce n'est pas custom
            $request->validate([
                'stock_type_id' => ['exists:stock_types,id']
            ]);
        }

        $stock->update([
            'warehouse_id' => $validated['warehouse_id'],
            'stock_type_id' => $stockTypeId,
            'item_name' => $validated['item_name'],
            'quantity' => $validated['quantity'],
            'min_quantity' => $validated['min_quantity'] ?? 0,
            'max_quantity' => $validated['max_quantity'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.stocks.index', ['warehouse' => $stock->warehouse_id])
            ->with('success', 'Stock mis à jour avec succès');
    }

    public function add(Request $request, Stock $stock)
    {
        $data = $request->validate(['quantity' => ['required','numeric','min:0.01'], 'reason' => ['nullable','string','max:255']]);
        $before = (float) $stock->quantity;
        $stock->quantity = $before + (float) $data['quantity'];
        $stock->save();

        $movement = StockMovement::create([
            'stock_id' => $stock->id,
            'warehouse_id' => $stock->warehouse_id,
            'type' => 'in',
            'quantity' => $data['quantity'],
            'quantity_before' => $before,
            'quantity_after' => $stock->quantity,
            'reason' => $data['reason'] ?? 'ajout',
            'reference' => 'IN-'.strtoupper(str()->random(6)),
            'created_by' => Auth::id(),
        ]);

        return back()->with([
            'success' => 'Quantité ajoutée',
            'receipt_url' => route('admin.stocks.movement-receipt', $movement->id),
            'receipt_ref' => $movement->reference,
        ]);
    }

    public function remove(Request $request, Stock $stock)
    {
        $data = $request->validate([
            'quantity' => ['required','numeric','min:0.01'],
            'reason' => ['nullable','string','max:255']
        ]);
        $before = (float) $stock->quantity;
        $requested = (float) $data['quantity'];
        if ($requested > $before) {
            return back()->withErrors([
                'quantity' => 'Quantité demandée ('.number_format($requested, 2).') supérieure au stock disponible ('.number_format($before, 2).').'
            ])->withInput();
        }
        $remove = $requested;
        $stock->quantity = max(0, $before - $remove);
        $stock->save();

        $movement = StockMovement::create([
            'stock_id' => $stock->id,
            'warehouse_id' => $stock->warehouse_id,
            'type' => 'out',
            'quantity' => $remove,
            'quantity_before' => $before,
            'quantity_after' => $stock->quantity,
            'reason' => $data['reason'] ?? 'retrait',
            'reference' => 'OUT-'.strtoupper(str()->random(6)),
            'created_by' => Auth::id(),
        ]);

        return back()->with([
            'success' => 'Quantité retirée',
            'receipt_url' => route('admin.stocks.movement-receipt', $movement->id),
            'receipt_ref' => $movement->reference,
        ]);
    }

    public function movements(Request $request)
    {
        $query = StockMovement::with(['stock.stockType','warehouse'])
            ->orderByDesc('created_at');

        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }
        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function($sub) use ($q) {
                $sub->where('reference','like',"%{$q}%")
                    ->orWhereHas('stock', function($sq) use ($q){
                        $sq->where('item_name','like',"%{$q}%");
                    });
            });
        }

        // Stats (sur le jeu filtré)
        $baseForStats = clone $query;
        $stats = [
            'total' => (clone $baseForStats)->count(),
            'in' => (clone $baseForStats)->where('type','in')->count(),
            'out' => (clone $baseForStats)->where('type','out')->count(),
        ];

        $movements = $query->paginate(15);
        return view('admin.stocks.movements', compact('movements','stats'));
    }

    public function movementReceipt(StockMovement $movement)
    {
        $movement->load(['stock.stockType', 'warehouse', 'user']);

        $pdf = Pdf::loadView('admin.stocks.movement_receipt', [
            'movement' => $movement,
            'generatedAt' => now(),
        ])->setPaper('a4');

        $filename = 'CSAR-Recu-'.$movement->reference.'.pdf';
        return $pdf->download($filename);
    }

    private function getFuelUsed(Carbon $start, Carbon $end): float
    {
        $fuelStockIds = Stock::whereHas('stockType', function($q) {
            $q->where('unit', 'L');
        })->pluck('id');

        return (float) StockMovement::whereIn('stock_id', $fuelStockIds)
            ->where('type', 'out')
            ->whereBetween('created_at', [$start, $end])
            ->sum('quantity');
    }
}

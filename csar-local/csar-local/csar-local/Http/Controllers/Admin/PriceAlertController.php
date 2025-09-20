<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceAlertController extends Controller
{
    public function index()
    {
        $alerts = PriceAlert::orderBy('created_at', 'desc')->paginate(15);
        // Statistiques simples pour la vue (optionnelles)
        $stats = [
            'total' => PriceAlert::count(),
            'active' => PriceAlert::where(function($q){
                $q->where('status', 'active')->orWhere('is_active', true);
            })->count(),
            'critical' => PriceAlert::where('alert_level', 'critical')->count(),
            'high' => PriceAlert::where('alert_level', 'high')->count(),
        ];
        return view('admin.price-alerts.index', compact('alerts', 'stats'));
    }

    public function create()
    {
        return view('admin.price-alerts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'current_price' => 'required|numeric|min:0',
            'previous_price' => 'required|numeric|min:0',
            'increase_percentage' => 'required|numeric',
            'region' => 'required|string|max:255',
            'market_name' => 'required|string|max:255',
            'alert_level' => 'required|in:low,medium,high,critical',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        PriceAlert::create([
            'product_name' => $request->product_name,
            'current_price' => $request->current_price,
            'previous_price' => $request->previous_price,
            'increase_percentage' => $request->increase_percentage,
            'region' => $request->region,
            'market_name' => $request->market_name,
            'alert_level' => $request->alert_level,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'created_by' => Auth::id()
        ]);

        return redirect()->route('admin.price-alerts.index')
            ->with('success', 'Alerte de prix créée avec succès.');
    }

    public function show(PriceAlert $priceAlert)
    {
        return view('admin.price-alerts.show', compact('priceAlert'));
    }

    public function edit(PriceAlert $priceAlert)
    {
        return view('admin.price-alerts.edit', compact('priceAlert'));
    }

    public function update(Request $request, PriceAlert $priceAlert)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'current_price' => 'required|numeric|min:0',
            'previous_price' => 'required|numeric|min:0',
            'increase_percentage' => 'required|numeric',
            'region' => 'required|string|max:255',
            'market_name' => 'required|string|max:255',
            'alert_level' => 'required|in:low,medium,high,critical',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $priceAlert->update([
            'product_name' => $request->product_name,
            'current_price' => $request->current_price,
            'previous_price' => $request->previous_price,
            'increase_percentage' => $request->increase_percentage,
            'region' => $request->region,
            'market_name' => $request->market_name,
            'alert_level' => $request->alert_level,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.price-alerts.index')
            ->with('success', 'Alerte de prix mise à jour avec succès.');
    }

    public function destroy(PriceAlert $priceAlert)
    {
        $priceAlert->delete();
        return redirect()->route('admin.price-alerts.index')
            ->with('success', 'Alerte de prix supprimée avec succès.');
    }

    public function toggleStatus(PriceAlert $priceAlert)
    {
        $priceAlert->update(['is_active' => !$priceAlert->is_active]);
        return redirect()->route('admin.price-alerts.index')
            ->with('success', 'Statut de l\'alerte mis à jour.');
    }
}




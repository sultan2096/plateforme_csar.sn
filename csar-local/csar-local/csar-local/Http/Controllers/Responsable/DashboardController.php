<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter d\'abord.');
        }
        
        // Récupérer l'entrepôt du responsable
        $warehouse = $user->warehouse;
        
        if (!$warehouse) {
            // Assigner automatiquement le premier entrepôt disponible pour les tests
            $availableWarehouse = Warehouse::where('is_active', true)->first();
            
            if ($availableWarehouse) {
                $user->update(['warehouse_id' => $availableWarehouse->id]);
                $warehouse = $availableWarehouse;
            } else {
                // Créer un entrepôt de test si aucun n'existe
                $warehouse = Warehouse::create([
                    'name' => 'Entrepôt Principal - ' . $user->name,
                    'description' => 'Entrepôt assigné automatiquement',
                    'address' => 'Dakar, Sénégal',
                    'region' => 'Dakar',
                    'city' => 'Dakar',
                    'phone' => '+221 33 123 45 67',
                    'email' => 'entrepot@csar.sn',
                    'is_active' => true,
                    'capacity' => 1000,
                    'current_stock' => 0,
                    'status' => 'active',
                    'latitude' => 14.7167,
                    'longitude' => -17.4677
                ]);
                
                $user->update(['warehouse_id' => $warehouse->id]);
            }
        }
        
        // Calculer les statistiques de l'entrepôt
        $warehouseData = [
            'name' => $warehouse->name ?? 'Entrepôt CSAR',
            'type' => $warehouse->type ?? 'Mixte',
            'status' => ($warehouse->is_active ?? true) ? 'Actif' : 'Inactif',
            'capacity' => $warehouse->capacity ?? 1000,
            'location' => $warehouse->address ?? 'Dakar, Sénégal',
            'region' => $warehouse->region ?? 'Dakar',
        ];
        
        // Calculer les statistiques de stock
        $stockStats = $this->calculateStockStats($warehouse->id);
        
        // Récupérer les alertes de stock
        $alerts = $this->getStockAlerts($warehouse->id);
        
        // Récupérer les mouvements récents
        $recentMovements = $this->getRecentMovements($warehouse->id);
        
        return view('responsable.dashboard', compact('warehouseData', 'stockStats', 'alerts', 'recentMovements'));
    }
    
    /**
     * Calculer les statistiques de stock
     */
    private function calculateStockStats($warehouseId)
    {
        // Données de test pour éviter les erreurs
        $testStocks = collect([
            ['name' => 'Riz', 'category' => 'Denrées', 'quantity' => 500, 'unit' => 'kg'],
            ['name' => 'Lait en poudre', 'category' => 'Denrées', 'quantity' => 150, 'unit' => 'kg'],
            ['name' => 'Huile', 'category' => 'Denrées', 'quantity' => 80, 'unit' => 'L'],
            ['name' => 'Essence', 'category' => 'Carburant', 'quantity' => 200, 'unit' => 'L'],
            ['name' => 'Gasoil', 'category' => 'Carburant', 'quantity' => 300, 'unit' => 'L'],
        ]);
        
        $totalStock = $testStocks->sum('quantity');
        $categories = $testStocks->groupBy('category');
        
        return [
            'total_stock' => $totalStock,
            'categories' => $categories,
            'total_items' => $testStocks->count(),
            'low_stock_items' => $testStocks->where('quantity', '<', 100)->count(),
            'out_of_stock_items' => $testStocks->where('quantity', 0)->count(),
        ];
    }
    
    /**
     * Récupérer les alertes de stock
     */
    private function getStockAlerts($warehouseId)
    {
        // Alertes de test
        return [
            [
                'type' => 'warning',
                'title' => 'Stock critique',
                'message' => "Le stock d'huile est en dessous du seuil critique (80 restants)",
                'time' => 'Maintenant',
                'product' => 'Huile',
                'current_stock' => 80,
                'threshold' => 100
            ]
        ];
    }
    
    /**
     * Récupérer les mouvements récents
     */
    private function getRecentMovements($warehouseId)
    {
        // Mouvements de test
        return collect([
            [
                'type' => 'in',
                'product' => 'Riz',
                'quantity' => '+200 kg',
                'time' => 'Il y a 2 heures',
                'color' => '#059669',
                'user' => 'Responsable Entrepôt',
                'supplier_or_destination' => 'Fournisseur ABC'
            ],
            [
                'type' => 'out',
                'product' => 'Lait en poudre',
                'quantity' => '-50 kg',
                'time' => 'Il y a 1 jour',
                'color' => '#dc2626',
                'user' => 'Responsable Entrepôt',
                'supplier_or_destination' => 'Distribution Dakar'
            ],
            [
                'type' => 'in',
                'product' => 'Gasoil',
                'quantity' => '+500 L',
                'time' => 'Il y a 3 jours',
                'color' => '#059669',
                'user' => 'Responsable Entrepôt',
                'supplier_or_destination' => 'Total Sénégal'
            ]
        ]);
    }
}

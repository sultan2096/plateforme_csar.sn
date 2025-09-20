<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockMovement;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\StockType;
use Carbon\Carbon;

class StockMovementSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer un entrepôt et un utilisateur responsable
        $warehouse = Warehouse::first();
        $user = User::whereHas('role', function($query) {
            $query->where('name', 'responsable');
        })->first();
        
        if (!$warehouse || !$user) {
            return;
        }
        
        // Associer l'utilisateur à l'entrepôt
        $user->update(['warehouse_id' => $warehouse->id]);
        
        // Données de test pour les mouvements
        $movements = [
            // Entrées de stock
            [
                'type' => 'in',
                'product_name' => 'Riz',
                'product_category' => 'denrees',
                'quantity' => 2000,
                'unit' => 'kg',
                'supplier_or_destination' => 'Fournisseur Riz Dakar',
                'movement_date' => Carbon::now()->subDays(5),
                'notes' => 'Livraison de riz de qualité supérieure'
            ],
            [
                'type' => 'in',
                'product_name' => 'Lait en poudre',
                'product_category' => 'denrees',
                'quantity' => 500,
                'unit' => 'kg',
                'supplier_or_destination' => 'Laitier Central',
                'movement_date' => Carbon::now()->subDays(3),
                'notes' => 'Lait en poudre pour enfants'
            ],
            [
                'type' => 'in',
                'product_name' => 'Huile',
                'product_category' => 'denrees',
                'quantity' => 1000,
                'unit' => 'L',
                'supplier_or_destination' => 'Huilerie Nationale',
                'movement_date' => Carbon::now()->subDays(2),
                'notes' => 'Huile de cuisson'
            ],
            [
                'type' => 'in',
                'product_name' => 'Couvertures',
                'product_category' => 'materiel',
                'quantity' => 200,
                'unit' => 'unités',
                'supplier_or_destination' => 'Textile Plus',
                'movement_date' => Carbon::now()->subDays(4),
                'notes' => 'Couvertures pour l\'hiver'
            ],
            [
                'type' => 'in',
                'product_name' => 'Essence',
                'product_category' => 'carburant',
                'quantity' => 1000,
                'unit' => 'L',
                'supplier_or_destination' => 'Station Total',
                'movement_date' => Carbon::now()->subDays(1),
                'notes' => 'Essence pour véhicules'
            ],
            
            // Sorties de stock
            [
                'type' => 'out',
                'product_name' => 'Riz',
                'product_category' => 'denrees',
                'quantity' => 500,
                'unit' => 'kg',
                'supplier_or_destination' => 'Village de Thiès',
                'movement_date' => Carbon::now()->subDays(2),
                'notes' => 'Distribution d\'urgence'
            ],
            [
                'type' => 'out',
                'product_name' => 'Lait en poudre',
                'product_category' => 'denrees',
                'quantity' => 100,
                'unit' => 'kg',
                'supplier_or_destination' => 'Centre de santé Dakar',
                'movement_date' => Carbon::now()->subDays(1),
                'notes' => 'Pour les enfants malnutris'
            ],
            [
                'type' => 'out',
                'product_name' => 'Couvertures',
                'product_category' => 'materiel',
                'quantity' => 50,
                'unit' => 'unités',
                'supplier_or_destination' => 'Camp de réfugiés',
                'movement_date' => Carbon::now()->subHours(6),
                'notes' => 'Aide humanitaire'
            ],
            [
                'type' => 'out',
                'product_name' => 'Essence',
                'product_category' => 'carburant',
                'quantity' => 200,
                'unit' => 'L',
                'supplier_or_destination' => 'Véhicule de transport',
                'movement_date' => Carbon::now()->subHours(12),
                'notes' => 'Carburant pour mission'
            ]
        ];
        
        // Créer les mouvements avec calcul automatique des stocks
        foreach ($movements as $movementData) {
            // Find or create stock type
            $stockType = StockType::firstOrCreate([
                'name' => $movementData['product_category'],
                'display_name' => ucfirst($movementData['product_category']),
                'unit' => $movementData['unit'],
            ]);

            // Find or create stock
            $stock = Stock::firstOrCreate([
                'warehouse_id' => $warehouse->id,
                'stock_type_id' => $stockType->id,
                'item_name' => $movementData['product_name'],
            ], [
                'quantity' => 0,
                'description' => $movementData['notes'],
                'min_quantity' => 0,
            ]);

            $stockBefore = StockMovement::getCurrentStock($warehouse->id, $movementData['product_name']);
            $stockAfter = StockMovement::calculateStockAfter($warehouse->id, $movementData['product_name'], $movementData['quantity'], $movementData['type']);
            
            StockMovement::create([
                'stock_id' => $stock->id,
                'warehouse_id' => $warehouse->id,
                'created_by' => $user->id,
                'type' => $movementData['type'],
                'quantity' => $movementData['quantity'],
                'quantity_before' => $stockBefore,
                'quantity_after' => $stockAfter,
                'reason' => $movementData['notes'],
                'reference' => $movementData['supplier_or_destination'],
                'created_at' => $movementData['movement_date'],
                'updated_at' => $movementData['movement_date']
            ]);

            // Update the stock quantity
            $stock->update(['quantity' => $stockAfter]);
        }
    }
}

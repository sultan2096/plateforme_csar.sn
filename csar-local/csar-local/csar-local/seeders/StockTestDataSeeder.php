<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un entrepôt de test
        $warehouseId = DB::table('warehouses')->insertGetId([
            'name' => 'Entrepôt Principal Dakar',
            'description' => 'Entrepôt principal du CSAR à Dakar',
            'address' => 'Zone Industrielle, Dakar',
            'latitude' => 14.7167,
            'longitude' => -17.4677,
            'region' => 'Dakar',
            'city' => 'Dakar',
            'phone' => '+221 33 123 45 67',
            'email' => 'entrepot.dakar@csar.sn',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Récupérer les IDs des types de stock
        $foodTypeId = DB::table('stock_types')->where('name', 'food')->value('id');
        $fuelTypeId = DB::table('stock_types')->where('name', 'fuel')->value('id');
        $equipmentTypeId = DB::table('stock_types')->where('name', 'equipment')->value('id');

        // Données de test pour les stocks
        $stocks = [
            // Denrées alimentaires
            [
                'warehouse_id' => $warehouseId,
                'stock_type_id' => $foodTypeId,
                'item_name' => 'Riz',
                'description' => 'Riz blanc de qualité',
                'quantity' => 5000,
                'min_quantity' => 500,
                'max_quantity' => 10000,
                'expiry_date' => '2025-12-31',
                'batch_number' => 'RIZ-2025-001',
                'supplier' => 'Fournisseur Riz Sénégal',
                'unit_price' => 500,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse_id' => $warehouseId,
                'stock_type_id' => $foodTypeId,
                'item_name' => 'Huile de cuisine',
                'description' => 'Huile végétale pour cuisine',
                'quantity' => 2000,
                'min_quantity' => 200,
                'max_quantity' => 5000,
                'expiry_date' => '2025-10-31',
                'batch_number' => 'HUILE-2025-002',
                'supplier' => 'Huilerie Moderne',
                'unit_price' => 1200,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Carburant
            [
                'warehouse_id' => $warehouseId,
                'stock_type_id' => $fuelTypeId,
                'item_name' => 'Essence',
                'description' => 'Essence sans plomb 95',
                'quantity' => 15000,
                'min_quantity' => 1000,
                'max_quantity' => 20000,
                'expiry_date' => null,
                'batch_number' => 'ESS-2025-003',
                'supplier' => 'Total Sénégal',
                'unit_price' => 800,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse_id' => $warehouseId,
                'stock_type_id' => $fuelTypeId,
                'item_name' => 'Gasoil',
                'description' => 'Gasoil pour véhicules',
                'quantity' => 12000,
                'min_quantity' => 800,
                'max_quantity' => 15000,
                'expiry_date' => null,
                'batch_number' => 'GAS-2025-004',
                'supplier' => 'Shell Sénégal',
                'unit_price' => 750,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Matériel
            [
                'warehouse_id' => $warehouseId,
                'stock_type_id' => $equipmentTypeId,
                'item_name' => 'Générateurs',
                'description' => 'Générateurs électriques 10kW',
                'quantity' => 25,
                'min_quantity' => 5,
                'max_quantity' => 50,
                'expiry_date' => null,
                'batch_number' => 'GEN-2025-005',
                'supplier' => 'Équipements Électriques SA',
                'unit_price' => 250000,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'warehouse_id' => $warehouseId,
                'stock_type_id' => $equipmentTypeId,
                'item_name' => 'Pompes à eau',
                'description' => 'Pompes submersibles',
                'quantity' => 40,
                'min_quantity' => 10,
                'max_quantity' => 100,
                'expiry_date' => null,
                'batch_number' => 'POMPE-2025-006',
                'supplier' => 'Hydraulique Plus',
                'unit_price' => 150000,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($stocks as $stock) {
            DB::table('stocks')->insert($stock);
        }

        $this->command->info('Données de test des stocks créées avec succès !');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateDefaultUsersSeeder extends Seeder
{
	public function run(): void
	{
		// Create roles if not exists with fixed IDs (1: admin, 2: dg, 3: responsable, 4: agent)
		$roles = [
			1 => ['name' => 'admin', 'display_name' => 'Administrateur'],
			2 => ['name' => 'dg', 'display_name' => 'Directeur Général'],
			3 => ['name' => 'responsable', 'display_name' => 'Responsable Entrepôt'],
			4 => ['name' => 'agent', 'display_name' => 'Agent'],
		];

		foreach ($roles as $id => $data) {
			$exists = DB::table('roles')->where('id', $id)->exists();
			if (!$exists) {
				DB::table('roles')->insert([
					'id' => $id,
					'name' => $data['name'],
					'display_name' => $data['display_name'],
					'created_at' => now(),
					'updated_at' => now(),
				]);
			}
		}

		// Ensure a default warehouse exists
		$warehouseId = DB::table('warehouses')->value('id');
		if (!$warehouseId) {
			$warehouseId = DB::table('warehouses')->insertGetId([
				'name' => 'Entrepôt Principal',
				'description' => 'Entrepôt principal du siège',
				'address' => '123 Rue Principale',
				'latitude' => 0,
				'longitude' => 0,
				'region' => 'N/A',
				'city' => 'N/A',
				'phone' => null,
				'email' => null,
				'is_active' => true,
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}

		// Create admin user if not exists
		$admin = DB::table('users')->where('email', 'admin@csar.com')->first();
		if (!$admin) {
			DB::table('users')->insert([
				'name' => 'Admin',
				'email' => 'admin@csar.com',
				'password' => Hash::make('password'),
				'role_id' => 1,
				'warehouse_id' => $warehouseId,
				'remember_token' => Str::random(10),
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}
		
		// Create responsable user if not exists
		$responsable = DB::table('users')->where('email', 'responsable@csar.com')->first();
		if (!$responsable) {
			DB::table('users')->insert([
				'name' => 'Responsable',
				'email' => 'responsable@csar.com',
				'password' => Hash::make('password'),
				'role_id' => 3,
				'warehouse_id' => $warehouseId,
				'remember_token' => Str::random(10),
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}
	}
}




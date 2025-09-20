<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WarehouseSeeder::class,
            CreateDefaultUsersSeeder::class,
            PersonnelSeeder::class,
            HRDocumentSeeder::class,
            WorkAttendanceSeeder::class,
            SalarySlipSeeder::class,
            StockMovementSeeder::class,
            SpeechSeeder::class,
            CreateDefaultNewsSeeder::class,
            CreateDefaultHomeBackgroundSeeder::class,
        ]);
    }
}

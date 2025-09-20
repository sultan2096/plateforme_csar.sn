<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsletterSubscriber;
use Carbon\Carbon;

class DashboardTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des abonnés newsletter
        for ($i = 1; $i <= 25; $i++) {
            NewsletterSubscriber::create([
                'email' => "abonne{$i}@example.com",
                'is_active' => true,
                'subscribed_at' => Carbon::now()->subDays(rand(0, 180)),
                'created_at' => Carbon::now()->subDays(rand(0, 180)),
                'updated_at' => Carbon::now()->subDays(rand(0, 180)),
            ]);
        }

        $this->command->info('Données de test pour le dashboard créées avec succès !');
    }
}

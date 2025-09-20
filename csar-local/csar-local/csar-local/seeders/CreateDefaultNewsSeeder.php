<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateDefaultNewsSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifier si des actualités existent déjà
        $existingNews = DB::table('news')->count();
        if ($existingNews > 0) {
            echo "Des actualités existent déjà, skip...\n";
            return;
        }

        // Créer des actualités par défaut
        $news = [
            [
                'title' => 'Lancement Officiel de la Plateforme CSAR pour une Gestion Alimentaire Numérique et Transparente',
                'content' => 'Le Commissariat à la Sécurité Alimentaire et à la Résilience (CSAR) a procédé au lancement officiel de sa nouvelle plateforme numérique. Cette innovation technologique permettra une gestion transparente et efficace des stocks alimentaires à travers le pays.',
                'image' => 'news/images/csar-logo.jpg',
                'type' => 'communique',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Evènement Magal Touba 2025',
                'content' => 'Grand Magal de Touba - Édition 2025. À l\'occasion du Grand Magal de Touba, le Commissariat à la Sécurité Alimentaire et à la Résilience (CSAR) renforce ses dispositifs de sécurité alimentaire pour assurer un approvisionnement optimal pendant cette période de forte affluence.',
                'image' => 'news/images/dg.jpg',
                'type' => 'evenement',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Formation des Agents sur la Nouvelle Plateforme CSAR',
                'content' => 'Le CSAR organise une session de formation intensive pour tous ses agents sur l\'utilisation de la nouvelle plateforme numérique. Cette formation permettra une transition en douceur vers les nouveaux outils de gestion.',
                'image' => 'news/images/ministere.JPG',
                'type' => 'formation',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($news as $item) {
            DB::table('news')->insert($item);
        }

        echo "✅ Actualités par défaut créées avec succès !\n";
        echo "📰 3 actualités ajoutées avec des images\n";
    }
}


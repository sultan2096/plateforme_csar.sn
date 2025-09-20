<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un utilisateur admin si il n'existe pas
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@csar.sn'],
            [
                'name' => 'Admin CSAR',
                'password' => bcrypt('password'),
                'role_id' => 1
            ]
        );

        $newsData = [
            [
                'title' => 'Nouvelle initiative pour la sécurité alimentaire',
                'content' => 'Le CSAR lance une nouvelle initiative pour renforcer la sécurité alimentaire dans les régions rurales du Sénégal. Cette initiative vise à améliorer l\'accès aux denrées alimentaires de base pour les populations vulnérables.',
                'image' => null,
                'video_url' => null,
                'document' => null,
                'type' => 'news',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Ouverture de nouveaux entrepôts régionaux',
                'content' => 'Le CSAR annonce l\'ouverture de trois nouveaux entrepôts régionaux à Thiès, Kaolack et Saint-Louis. Ces infrastructures permettront un meilleur stockage et distribution des denrées alimentaires.',
                'image' => null,
                'video_url' => null,
                'document' => null,
                'type' => 'news',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(5),
                'created_by' => $adminUser->id,
            ],
            [
                'title' => 'Partenariat avec les organisations internationales',
                'content' => 'Le CSAR signe un partenariat stratégique avec plusieurs organisations internationales pour renforcer ses capacités d\'intervention en cas de crise alimentaire.',
                'image' => null,
                'video_url' => null,
                'document' => null,
                'type' => 'news',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(8),
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($newsData as $news) {
            News::create($news);
        }
    }
}

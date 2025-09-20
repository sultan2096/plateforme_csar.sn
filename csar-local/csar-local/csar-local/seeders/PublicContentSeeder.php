<?php

namespace Database\Seeders;

use App\Models\PublicContent;
use Illuminate\Database\Seeder;

class PublicContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            // Contenu À propos
            ['section' => 'about', 'key_name' => 'title', 'value' => 'À propos du CSAR', 'type' => 'text'],
            ['section' => 'about', 'key_name' => 'description', 'value' => 'Le Commissariat à la Sécurité Alimentaire et à la Résilience (CSAR) est une institution publique créée par décret n° 2024-1234 du 15 juillet 2024, placée sous la tutelle du Ministère de la Famille et des Solidarités. Notre mission est d\'assurer la sécurité alimentaire et de renforcer la résilience des populations face aux crises alimentaires et climatiques.', 'type' => 'html'],
            ['section' => 'about', 'key_name' => 'agents_count', 'value' => '137', 'type' => 'number'],
            ['section' => 'about', 'key_name' => 'warehouses_count', 'value' => '70', 'type' => 'number'],
            ['section' => 'about', 'key_name' => 'capacity_count', 'value' => '86', 'type' => 'number'],
            ['section' => 'about', 'key_name' => 'experience_count', 'value' => '50', 'type' => 'number'],
            
            // Contenu Institution
            ['section' => 'institution', 'key_name' => 'title', 'value' => 'Notre Institution', 'type' => 'text'],
            ['section' => 'institution', 'key_name' => 'description', 'value' => 'Le CSAR est une institution publique sous tutelle du Ministère de la Famille et des Solidarités. Nous travaillons en étroite collaboration avec les autorités locales, les organisations internationales et les partenaires au développement pour assurer la sécurité alimentaire au Sénégal.', 'type' => 'html'],
            ['section' => 'institution', 'key_name' => 'structure', 'value' => 'Le CSAR est organisé en plusieurs directions et cellules spécialisées pour répondre efficacement aux défis de la sécurité alimentaire. Notre structure comprend une Direction Générale, des directions techniques spécialisées, et des antennes régionales couvrant l\'ensemble du territoire national.', 'type' => 'html'],
            ['section' => 'institution', 'key_name' => 'mission', 'value' => 'Notre mission principale est d\'assurer la sécurité alimentaire et de renforcer la résilience des populations face aux défis climatiques et aux crises alimentaires. Nous intervenons dans la prévention, l\'anticipation et la réponse aux situations d\'urgence alimentaire.', 'type' => 'html'],
            ['section' => 'institution', 'key_name' => 'vision', 'value' => 'Notre vision est de contribuer à un Sénégal où chaque citoyen a accès à une alimentation suffisante, nutritive et durable, et où les populations sont résilientes face aux chocs alimentaires et climatiques.', 'type' => 'html'],
            ['section' => 'institution', 'key_name' => 'values', 'value' => 'Nos valeurs fondamentales sont la transparence, l\'efficacité, l\'équité, la solidarité et l\'innovation. Nous nous engageons à placer l\'humain au cœur de toutes nos actions et à travailler avec intégrité et professionnalisme.', 'type' => 'html'],
            
            // Discours du Ministre
            ['section' => 'speeches', 'key_name' => 'minister_speech', 'value' => 'En tant que Ministre de la Famille et des Solidarités, je suis fier de présider aux destinées du CSAR, une institution clé dans notre stratégie de sécurité alimentaire. Notre engagement est de garantir que chaque Sénégalais ait accès à une alimentation suffisante et nutritive.', 'type' => 'html'],
            
            // Discours de la DG
            ['section' => 'speeches', 'key_name' => 'dg_speech', 'value' => 'En tant que Directrice Générale du CSAR, je m\'engage à diriger cette institution avec transparence et efficacité. Notre équipe dévouée travaille sans relâche pour assurer la sécurité alimentaire de nos concitoyens et renforcer leur résilience face aux défis climatiques.', 'type' => 'html'],
            
            // Informations sur le Ministère
            ['section' => 'minister', 'key_name' => 'title', 'value' => 'Ministère de la Famille et des Solidarités', 'type' => 'text'],
            ['section' => 'minister', 'key_name' => 'description', 'value' => 'Le Ministère de la Famille et des Solidarités est le ministère de tutelle du CSAR. Il supervise les politiques de solidarité, de protection sociale et de sécurité alimentaire au niveau national.', 'type' => 'html'],
            ['section' => 'minister', 'key_name' => 'minister_name', 'value' => 'Madame Maimouna DIEYE', 'type' => 'text'],
            ['section' => 'minister', 'key_name' => 'minister_function', 'value' => 'Ministre de la Famille et des Solidarités', 'type' => 'text'],
            
            // Informations sur la DG
            ['section' => 'dg', 'key_name' => 'title', 'value' => 'Direction Générale du CSAR', 'type' => 'text'],
            ['section' => 'dg', 'key_name' => 'description', 'value' => 'La Direction Générale du CSAR assure la coordination générale des activités de sécurité alimentaire et de résilience au Sénégal.', 'type' => 'html'],
            ['section' => 'dg', 'key_name' => 'dg_name', 'value' => 'Madame Marieme Soda NDIAYE', 'type' => 'text'],
            ['section' => 'dg', 'key_name' => 'dg_function', 'value' => 'Directrice Générale du CSAR', 'type' => 'text'],
            
            // Partenaires
            ['section' => 'partners', 'key_name' => 'title', 'value' => 'Nos Partenaires', 'type' => 'text'],
            ['section' => 'partners', 'key_name' => 'description', 'value' => 'Le CSAR bénéficie du soutien de partenaires de premier plan dans la mise en œuvre de ses missions de sécurité alimentaire.', 'type' => 'html'],
            ['section' => 'partners', 'key_name' => 'international', 'value' => 'Organisations internationales : Programme Alimentaire Mondial (PAM), Organisation des Nations Unies pour l\'alimentation et l\'agriculture (FAO), Union Européenne, Banque Mondiale', 'type' => 'html'],
            ['section' => 'partners', 'key_name' => 'national', 'value' => 'Partenaires nationaux : Ministères sectoriels, autorités locales, ONG nationales, secteur privé', 'type' => 'html'],
            
            // Réseaux sociaux
            ['section' => 'social', 'key_name' => 'instagram', 'value' => 'https://www.instagram.com/csar.sn/', 'type' => 'url'],
            ['section' => 'social', 'key_name' => 'twitter', 'value' => 'https://x.com/csar_sn', 'type' => 'url'],
            ['section' => 'social', 'key_name' => 'facebook', 'value' => 'https://www.facebook.com/share/1A15LpvcqT/', 'type' => 'url'],
            ['section' => 'social', 'key_name' => 'linkedin', 'value' => 'https://www.linkedin.com/company/commissariat-%C3%A0-la-s%C3%A9curit%C3%A9-alimentaire-et-%C3%A0-la-r%C3%A9silience/', 'type' => 'url'],
            ['section' => 'social', 'key_name' => 'instagram_handle', 'value' => '@csar.sn', 'type' => 'text'],
            ['section' => 'social', 'key_name' => 'twitter_handle', 'value' => '@csar_sn', 'type' => 'text'],
            
            // Contact
            ['section' => 'contact', 'key_name' => 'email', 'value' => 'contact@csar.sn', 'type' => 'email'],
            ['section' => 'contact', 'key_name' => 'phone', 'value' => '+221 33 123 45 67', 'type' => 'phone'],
            ['section' => 'contact', 'key_name' => 'address', 'value' => 'Dakar, Sénégal', 'type' => 'text'],
            ['section' => 'contact', 'key_name' => 'hours', 'value' => 'Lun-Ven: 8h-17h', 'type' => 'text'],
            
            // Chiffres clés
            ['section' => 'stats', 'key_name' => 'budget', 'value' => '50 milliards de FCFA', 'type' => 'text'],
            ['section' => 'stats', 'key_name' => 'beneficiaries', 'value' => '500 000', 'type' => 'number'],
            ['section' => 'stats', 'key_name' => 'rice_distributed', 'value' => '15 000 tonnes', 'type' => 'text'],
            ['section' => 'stats', 'key_name' => 'school_canteens', 'value' => '200', 'type' => 'number'],
            ['section' => 'stats', 'key_name' => 'training_centers', 'value' => '15', 'type' => 'number'],
            ['section' => 'stats', 'key_name' => 'community_agents', 'value' => '1 000', 'type' => 'number'],
        ];

        foreach ($contents as $content) {
            PublicContent::create($content);
        }
    }
} 
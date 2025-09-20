<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Personnel;

class PersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personnelData = [
            [
                'prenoms_nom' => 'Mamadou Diallo',
                'date_naissance' => '1985-03-15',
                'lieu_naissance' => 'Dakar',
                'tranche_age' => '36-45',
                'nationalite' => 'Sénégalaise',
                'numero_cni' => '123456789012',
                'sexe' => 'Masculin',
                'situation_matrimoniale' => 'Marie',
                'nombre_enfants' => 3,
                'contact_telephonique' => '778123456',
                'email' => 'mamadou.diallo@csar.sn',
                'groupe_sanguin' => 'A+',
                'adresse_complete' => '123 Rue de la Paix, Dakar',
                'matricule' => 'CSAR-2024-0001',
                'date_recrutement_csar' => '2020-01-15',
                'date_prise_service_csar' => '2020-02-01',
                'statut' => 'Fonctionnaire',
                'poste_actuel' => 'Directeur',
                'direction_service' => 'Direction Generale',
                'localisation_region' => 'Dakar',
                'dernier_poste_avant_csar' => 'Chef de service à la DGPRE',
                'formations_professionnelles' => 'Formation en gestion administrative',
                'diplome_academique' => 'Master',
                'autres_diplomes_certifications' => 'Certification en management',
                'logiciels_maitrises' => ['Word', 'Excel', 'PowerPoint'],
                'langues_parlees' => ['Français', 'Anglais'],
                'autres_aptitudes' => 'Gestion d\'équipe, planification stratégique',
                'aspirations_professionnelles' => 'Évolution vers un poste de direction générale',
                'interet_nouvelles_responsabilites' => 'Oui',
                'taille_vetements' => 'L',
                'contact_urgence_nom' => 'Fatou Diallo',
                'contact_urgence_telephone' => '778123457',
                'contact_urgence_lien_parente' => 'Épouse',
                'observations_personnelles' => 'Excellent manager, très impliqué dans son travail',
                'statut_validation' => 'Valide'
            ],
            [
                'prenoms_nom' => 'Aissatou Ndiaye',
                'date_naissance' => '1990-07-22',
                'lieu_naissance' => 'Thies',
                'tranche_age' => '26-35',
                'nationalite' => 'Sénégalaise',
                'numero_cni' => '123456789013',
                'sexe' => 'Feminin',
                'situation_matrimoniale' => 'Celibataire',
                'nombre_enfants' => 0,
                'contact_telephonique' => '778123458',
                'email' => 'aissatou.ndiaye@csar.sn',
                'groupe_sanguin' => 'O+',
                'adresse_complete' => '456 Avenue Léopold Sédar Senghor, Dakar',
                'matricule' => 'CSAR-2024-0002',
                'date_recrutement_csar' => '2021-06-01',
                'date_prise_service_csar' => '2021-06-15',
                'statut' => 'Contractuel',
                'poste_actuel' => 'Agent Comptable',
                'direction_service' => 'DFC',
                'localisation_region' => 'Dakar',
                'dernier_poste_avant_csar' => 'Comptable junior dans une PME',
                'formations_professionnelles' => 'Formation en comptabilité publique',
                'diplome_academique' => 'Licence',
                'autres_diplomes_certifications' => 'Certification en comptabilité',
                'logiciels_maitrises' => ['Excel', 'SAARI'],
                'langues_parlees' => ['Français'],
                'autres_aptitudes' => 'Comptabilité analytique, gestion budgétaire',
                'aspirations_professionnelles' => 'Spécialisation en audit comptable',
                'interet_nouvelles_responsabilites' => 'Oui',
                'taille_vetements' => 'M',
                'contact_urgence_nom' => 'Mariama Ndiaye',
                'contact_urgence_telephone' => '778123459',
                'contact_urgence_lien_parente' => 'Sœur',
                'observations_personnelles' => 'Très compétente en comptabilité, ponctuelle',
                'statut_validation' => 'Valide'
            ],
            [
                'prenoms_nom' => 'Ousmane Sall',
                'date_naissance' => '1978-11-08',
                'lieu_naissance' => 'Kaolack',
                'tranche_age' => '46-55',
                'nationalite' => 'Sénégalaise',
                'numero_cni' => '123456789014',
                'sexe' => 'Masculin',
                'situation_matrimoniale' => 'Marie',
                'nombre_enfants' => 4,
                'contact_telephonique' => '778123460',
                'email' => 'ousmane.sall@csar.sn',
                'groupe_sanguin' => 'B+',
                'adresse_complete' => '789 Boulevard de la République, Kaolack',
                'matricule' => 'CSAR-2024-0003',
                'date_recrutement_csar' => '2018-03-10',
                'date_prise_service_csar' => '2018-04-01',
                'statut' => 'Fonctionnaire',
                'poste_actuel' => 'Inspecteur regional',
                'direction_service' => 'IR',
                'localisation_region' => 'Kaolack',
                'dernier_poste_avant_csar' => 'Agent technique dans une ONG',
                'formations_professionnelles' => 'Formation en inspection et contrôle',
                'diplome_academique' => 'Maitrise',
                'autres_diplomes_certifications' => 'Certification en sécurité alimentaire',
                'logiciels_maitrises' => ['Word', 'Excel', 'PowerPoint'],
                'langues_parlees' => ['Français', 'Wolof'],
                'autres_aptitudes' => 'Inspection, contrôle qualité, relations publiques',
                'aspirations_professionnelles' => 'Formation continue en nouvelles technologies',
                'interet_nouvelles_responsabilites' => 'Neutre',
                'taille_vetements' => 'XL',
                'contact_urgence_nom' => 'Awa Sall',
                'contact_urgence_telephone' => '778123461',
                'contact_urgence_lien_parente' => 'Épouse',
                'observations_personnelles' => 'Expérimenté, bon relationnel avec les populations',
                'statut_validation' => 'Valide'
            ]
        ];

        foreach ($personnelData as $data) {
            Personnel::create($data);
        }
    }
}

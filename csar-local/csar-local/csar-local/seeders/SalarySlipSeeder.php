<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalarySlip;
use App\Models\Personnel;
use App\Models\User;
use Carbon\Carbon;

class SalarySlipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer le premier personnel et admin
        $personnel = Personnel::first();
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $admin = $adminRole ? User::where('role_id', $adminRole->id)->first() : User::first();

        if (!$personnel || !$admin) {
            return;
        }

        // Créer des bulletins de salaire pour les 6 derniers mois
        for ($i = 5; $i >= 0; $i--) {
            $periodeDebut = Carbon::now()->subMonths($i)->startOfMonth();
            $periodeFin = Carbon::now()->subMonths($i)->endOfMonth();
            
            // Salaire de base
            $salaireBrut = 250000 + rand(0, 100000);
            
            // Indemnités
            $indemniteLogement = 50000 + rand(0, 20000);
            $indemniteTransport = 15000 + rand(0, 10000);
            $indemniteFonction = 25000 + rand(0, 15000);
            $autresIndemnites = rand(0, 10000);
            
            // Déductions
            $cnss = $salaireBrut * 0.05; // 5% CNSS
            $impot = $salaireBrut * 0.03; // 3% Impôt
            $autresDeductions = rand(0, 5000);
            
            // Calcul du salaire net
            $totalIndemnites = $indemniteLogement + $indemniteTransport + $indemniteFonction + $autresIndemnites;
            $totalDeductions = $cnss + $impot + $autresDeductions;
            $salaireNet = $salaireBrut + $totalIndemnites - $totalDeductions;
            
            // Jours travaillés
            $joursTravailles = 22 - rand(0, 3);
            $joursConges = rand(0, 2);
            $joursAbsences = rand(0, 1);
            
            // Statut
            $statuts = ['brouillon', 'valide', 'paye'];
            $statut = $statuts[array_rand($statuts)];
            
            SalarySlip::create([
                'personnel_id' => $personnel->id,
                'numero_bulletin' => SalarySlip::genererNumeroBulletin($personnel->id, $periodeDebut),
                'periode_debut' => $periodeDebut,
                'periode_fin' => $periodeFin,
                'salaire_brut' => $salaireBrut,
                'salaire_net' => $salaireNet,
                'cnss' => $cnss,
                'impot' => $impot,
                'autres_deductions' => $autresDeductions,
                'indemnite_logement' => $indemniteLogement,
                'indemnite_transport' => $indemniteTransport,
                'indemnite_fonction' => $indemniteFonction,
                'autres_indemnites' => $autresIndemnites,
                'jours_travailles' => $joursTravailles,
                'jours_conges' => $joursConges,
                'jours_absences' => $joursAbsences,
                'statut' => $statut,
                'commentaires' => $this->getCommentaire($statut),
                'cree_par' => $admin->id,
                'valide_par' => $statut !== 'brouillon' ? $admin->id : null,
                'date_validation' => $statut !== 'brouillon' ? Carbon::now() : null,
                'date_paiement' => $statut === 'paye' ? Carbon::now() : null
            ]);
        }

        $this->command->info('Bulletins de salaire créés avec succès !');
    }

    private function getCommentaire($statut)
    {
        $commentaires = [
            'brouillon' => 'Bulletin en cours de préparation',
            'valide' => 'Bulletin validé par la direction',
            'paye' => 'Salaire versé le ' . Carbon::now()->format('d/m/Y')
        ];

        return $commentaires[$statut] ?? null;
    }
}


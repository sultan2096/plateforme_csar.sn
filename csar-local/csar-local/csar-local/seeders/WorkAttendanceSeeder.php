<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkAttendance;
use App\Models\Personnel;
use App\Models\User;
use Carbon\Carbon;

class WorkAttendanceSeeder extends Seeder
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

        // Créer des données de présence pour le mois en cours
        $debutMois = Carbon::now()->startOfMonth();
        $finMois = Carbon::now()->endOfMonth();

        for ($date = $debutMois; $date <= $finMois; $date->addDay()) {
            // Ignorer les weekends
            if ($date->isWeekend()) {
                continue;
            }

            // Générer des données aléatoires
            $statut = $this->getRandomStatus();
            $heureArrivee = null;
            $heureDepart = null;
            $heuresTravaillees = 0;

            if ($statut === 'present') {
                $heureArrivee = $date->copy()->setTime(8, rand(0, 30), 0);
                $heureDepart = $date->copy()->setTime(17, rand(0, 30), 0);
                $heuresTravaillees = $heureArrivee->diffInMinutes($heureDepart);
            } elseif ($statut === 'retard') {
                $heureArrivee = $date->copy()->setTime(9, rand(0, 45), 0);
                $heureDepart = $date->copy()->setTime(17, rand(0, 30), 0);
                $heuresTravaillees = $heureArrivee->diffInMinutes($heureDepart);
            }

            WorkAttendance::updateOrCreate(
                [
                    'personnel_id' => $personnel->id,
                    'date' => $date->format('Y-m-d')
                ],
                [
                    'heure_arrivee' => $heureArrivee ? $heureArrivee->format('H:i:s') : null,
                    'heure_depart' => $heureDepart ? $heureDepart->format('H:i:s') : null,
                    'statut' => $statut,
                    'justification' => $this->getJustification($statut),
                    'heures_travaillees' => $heuresTravaillees,
                    'valide' => true,
                    'valide_par' => $admin->id,
                    'date_validation' => Carbon::now()
                ]
            );
        }

        $this->command->info('Données de présence au travail créées avec succès !');
    }

    private function getRandomStatus()
    {
        $statuses = ['present', 'present', 'present', 'present', 'present', 'retard', 'congé', 'maladie'];
        return $statuses[array_rand($statuses)];
    }

    private function getJustification($statut)
    {
        $justifications = [
            'present' => null,
            'retard' => 'Trafic dense ce matin',
            'congé' => 'Congé annuel',
            'maladie' => 'Certificat médical fourni',
            'formation' => 'Formation professionnelle',
            'mission' => 'Mission sur le terrain',
            'absent' => 'Absence non justifiée'
        ];

        return $justifications[$statut] ?? null;
    }
}


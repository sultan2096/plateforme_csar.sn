<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\HRDocument;
use App\Models\SalarySlip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('agent.login')->with('error', "Session expirée. Veuillez vous reconnecter.");
        }
        
        // Vérifier que l'utilisateur a un email
        if (!$user->email) {
            return redirect()->route('agent.login')->with('error', "Profil utilisateur incomplet. Veuillez contacter l'administrateur.");
        }
        
        // Récupérer le profil personnel de l'agent
        $personnel = Personnel::where('email', $user->email)->first();
        
        if (!$personnel) {
            return redirect()->route('agent.profile')->with('error', 'Profil personnel non trouvé. Veuillez contacter l\'administrateur.');
        }
        
        // Message de bienvenue personnalisé
        $welcomeMessage = $this->getWelcomeMessage($personnel);
        
        // Résumé du profil
        $profileSummary = [
            'poste_actuel' => $personnel->poste_actuel,
            'direction_service' => $personnel->direction_service,
            'date_recrutement' => $personnel->date_recrutement_csar ? Carbon::parse($personnel->date_recrutement_csar)->format('d/m/Y') : 'Non spécifiée',
            'contrat_type' => $personnel->statut,
            'contrat_statut' => $personnel->statut_validation === 'valide' ? 'Actif' : 'En attente de validation'
        ];
        
        // Statistiques personnelles
        $stats = [
            'documents_total' => HRDocument::where('personnel_id', $personnel->id)->count(),
            'bulletins_total' => SalarySlip::where('personnel_id', $personnel->id)->count(),
            'bulletins_ce_mois' => SalarySlip::where('personnel_id', $personnel->id)
                ->whereYear('annee', now()->year)
                ->where('mois', now()->format('F'))
                ->count(),
            'documents_recents' => HRDocument::where('personnel_id', $personnel->id)
                ->where('created_at', '>=', now()->subDays(30))
                ->count()
        ];
        
        // Documents récents
        $recentDocuments = HRDocument::where('personnel_id', $personnel->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Bulletins récents
        $recentSalarySlips = SalarySlip::where('personnel_id', $personnel->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Notifications
        $notifications = $this->getNotifications($personnel);
        
        return view('agent.dashboard', compact(
            'personnel',
            'welcomeMessage',
            'profileSummary',
            'stats',
            'recentDocuments',
            'recentSalarySlips',
            'notifications'
        ));
    }
    
    /**
     * Générer un message de bienvenue personnalisé
     */
    private function getWelcomeMessage($personnel)
    {
        $hour = now()->hour;
        $greeting = '';
        
        if ($hour < 12) {
            $greeting = 'Bonjour';
        } elseif ($hour < 18) {
            $greeting = 'Bon après-midi';
        } else {
            $greeting = 'Bonsoir';
        }
        
        $firstName = explode(' ', $personnel->prenoms_nom)[0] ?? $personnel->prenoms_nom;
        
        return [
            'greeting' => $greeting,
            'name' => $firstName,
            'full_name' => $personnel->prenoms_nom,
            'poste' => $personnel->poste_actuel,
            'direction' => $personnel->direction_service
        ];
    }
    
    /**
     * Récupérer les notifications pour l'agent
     */
    private function getNotifications($personnel)
    {
        $notifications = [];
        
        // Vérifier les documents expirés ou expirant bientôt
        $expiringDocuments = HRDocument::where('personnel_id', $personnel->id)
            ->where('date_emission', '<=', now()->subMonths(11))
            ->get();
        
        foreach ($expiringDocuments as $document) {
            $notifications[] = [
                'type' => 'warning',
                'title' => 'Document expirant',
                'message' => "Le document '{$document->file_name}' expire bientôt",
                'time' => 'Maintenant',
                'icon' => 'fas fa-exclamation-triangle'
            ];
        }
        
        // Vérifier les nouveaux documents
        $newDocuments = HRDocument::where('personnel_id', $personnel->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->get();
        
        foreach ($newDocuments as $document) {
            $notifications[] = [
                'type' => 'info',
                'title' => 'Nouveau document',
                'message' => "Un nouveau document '{$document->file_name}' a été ajouté",
                'time' => $document->created_at->diffForHumans(),
                'icon' => 'fas fa-file-alt'
            ];
        }
        
        // Vérifier les bulletins de salaire du mois
        $currentMonthSlip = SalarySlip::where('personnel_id', $personnel->id)
            ->whereYear('annee', now()->year)
            ->where('mois', now()->format('F'))
            ->first();
        
        if ($currentMonthSlip) {
            $notifications[] = [
                'type' => 'success',
                'title' => 'Bulletin disponible',
                'message' => "Votre bulletin de salaire de " . now()->format('F Y') . " est disponible",
                'time' => $currentMonthSlip->created_at->diffForHumans(),
                'icon' => 'fas fa-file-invoice-dollar'
            ];
        }
        
        return $notifications;
    }
}

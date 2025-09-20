<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\HRDocument;
use App\Models\SalarySlip;
use App\Models\WorkAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HRController extends Controller
{
    public function index()
    {
        // Récupérer le personnel connecté
        $personnel = Personnel::where('email', Auth::user()->email)->first();
        
        if (!$personnel) {
            return redirect()->route('agent.dashboard')->with('error', 'Profil personnel non trouvé');
        }

        // Statistiques personnelles
        $stats = [
            'documents_actifs' => HRDocument::where('personnel_id', $personnel->id)
                                          ->where('statut', 'actif')
                                          ->count(),
            'documents_expires' => HRDocument::where('personnel_id', $personnel->id)
                                           ->where('statut', 'expire')
                                           ->count(),
            'bulletins_ce_mois' => SalarySlip::where('personnel_id', $personnel->id)
                                           ->whereYear('periode_debut', now()->year)
                                           ->whereMonth('periode_debut', now()->month)
                                           ->count(),
            'presences_ce_mois' => WorkAttendance::where('personnel_id', $personnel->id)
                                               ->whereYear('date', now()->year)
                                               ->whereMonth('date', now()->month)
                                               ->count()
        ];

        // Documents récents
        $documentsRecents = HRDocument::where('personnel_id', $personnel->id)
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // Bulletins récents
        $bulletinsRecents = SalarySlip::where('personnel_id', $personnel->id)
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('agent.hr.index', compact('personnel', 'stats', 'documentsRecents', 'bulletinsRecents'));
    }

    public function documents(Request $request)
    {
        // Récupérer le personnel connecté
        $personnel = Personnel::where('email', Auth::user()->email)->first();
        
        if (!$personnel) {
            return redirect()->route('agent.dashboard')->with('error', 'Profil personnel non trouvé');
        }

        $query = HRDocument::where('personnel_id', $personnel->id);

        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        $documents = $query->latest()->paginate(20);

        return view('agent.hr.documents.index', compact('documents', 'personnel'));
    }

    public function showDocument(HRDocument $document)
    {
        // Vérifier que l'agent peut accéder à ce document
        $personnel = Personnel::where('email', Auth::user()->email)->first();
        
        if (!$personnel || $document->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        return view('agent.hr.documents.show', compact('document', 'personnel'));
    }

    public function downloadDocument(HRDocument $document)
    {
        // Vérifier que l'agent peut télécharger ce document
        $personnel = Personnel::where('email', Auth::user()->email)->first();
        
        if (!$personnel || $document->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        $path = storage_path('app/public/hr-documents/' . $document->fichier);
        
        if (file_exists($path)) {
            return response()->download($path, $document->titre . '.' . $document->extension);
        }
        
        return back()->with('error', 'Fichier non trouvé');
    }

    public function salarySlips(Request $request)
    {
        // Récupérer le personnel connecté
        $personnel = Personnel::where('email', Auth::user()->email)->first();
        
        if (!$personnel) {
            return redirect()->route('agent.dashboard')->with('error', 'Profil personnel non trouvé');
        }

        $query = SalarySlip::where('personnel_id', $personnel->id);

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('periode_debut')) {
            $query->where('periode_debut', '>=', $request->periode_debut);
        }

        if ($request->filled('periode_fin')) {
            $query->where('periode_fin', '<=', $request->periode_fin);
        }

        $bulletins = $query->latest()->paginate(20);

        return view('agent.hr.salary-slips.index', compact('bulletins', 'personnel'));
    }

    public function showSalarySlip(SalarySlip $salarySlip)
    {
        // Vérifier que l'agent peut accéder à ce bulletin
        $personnel = Personnel::where('email', Auth::user()->email)->first();
        
        if (!$personnel || $salarySlip->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        return view('agent.hr.salary-slips.show', compact('salarySlip', 'personnel'));
    }

    public function downloadSalarySlip(SalarySlip $salarySlip)
    {
        // Vérifier que l'agent peut télécharger ce bulletin
        $personnel = Personnel::where('email', Auth::user()->email)->first();
        
        if (!$personnel || $salarySlip->personnel_id !== $personnel->id) {
            abort(403, 'Accès non autorisé');
        }

        if ($salarySlip->fichier_pdf) {
            $path = storage_path('app/public/salary-slips/' . $salarySlip->fichier_pdf);
            
            if (file_exists($path)) {
                return response()->download($path, 'bulletin_' . $salarySlip->numero_bulletin . '.pdf');
            }
        }
        
        return back()->with('error', 'Fichier PDF non disponible');
    }

    public function attendance(Request $request)
    {
        // Récupérer le personnel connecté
        $personnel = Personnel::where('email', Auth::user()->email)->first();
        
        if (!$personnel) {
            return redirect()->route('agent.dashboard')->with('error', 'Profil personnel non trouvé');
        }

        $query = WorkAttendance::where('personnel_id', $personnel->id);

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('date_debut')) {
            $query->where('date', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->where('date', '<=', $request->date_fin);
        }

        $attendance = $query->latest()->paginate(20);

        return view('agent.hr.attendance.index', compact('attendance', 'personnel'));
    }

    public function statistics(Request $request)
    {
        // Récupérer le personnel connecté
        $personnel = Personnel::where('email', Auth::user()->email)->first();
        
        if (!$personnel) {
            return redirect()->route('agent.dashboard')->with('error', 'Profil personnel non trouvé');
        }

        $annee = $request->get('annee', now()->year);
        $mois = $request->get('mois', now()->month);

        // Statistiques personnelles
        $stats = WorkAttendance::calculerStatistiques($personnel->id, 
            Carbon::create($annee, $mois, 1)->startOfMonth(),
            Carbon::create($annee, $mois, 1)->endOfMonth()
        );

        // Statistiques salariales
        $statsSalariales = SalarySlip::calculerStatistiques($personnel->id, $annee);

        // Données pour graphiques
        $presencesParJour = WorkAttendance::where('personnel_id', $personnel->id)
                                        ->whereYear('date', $annee)
                                        ->whereMonth('date', $mois)
                                        ->selectRaw('date, statut, COUNT(*) as total')
                                        ->groupBy('date', 'statut')
                                        ->orderBy('date')
                                        ->get();

        return view('agent.hr.statistics', compact('personnel', 'stats', 'statsSalariales', 'presencesParJour', 'annee', 'mois'));
    }
}

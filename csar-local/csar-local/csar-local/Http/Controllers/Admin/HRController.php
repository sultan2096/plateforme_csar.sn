<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\HRDocument;
use App\Models\WorkAttendance;
use App\Models\SalarySlip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HRController extends Controller
{
    public function index()
    {
        // Statistiques RH
        $stats = [
            'total_personnel' => Personnel::count(),
            'personnel_valide' => Personnel::where('statut_validation', 'Valide')->count(),
            'documents_actifs' => HRDocument::where('statut', 'actif')->count(),
            'documents_expires' => HRDocument::where('statut', 'expire')->count(),
            'bulletins_ce_mois' => SalarySlip::whereMonth('periode_debut', now()->month)->count(),
            'presences_aujourd_hui' => WorkAttendance::whereDate('date', today())->count()
        ];

        // Documents récents
        $documentsRecents = HRDocument::with('personnel')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // Bulletins récents
        $bulletinsRecents = SalarySlip::with('personnel')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('admin.hr.index', compact('stats', 'documentsRecents', 'bulletinsRecents'));
    }

    // Gestion des documents RH
    public function documents(Request $request)
    {
        $query = HRDocument::with(['personnel', 'createur']);

        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('personnel')) {
            $query->where('personnel_id', $request->personnel);
        }

        if ($request->filled('search')) {
            $query->whereHas('personnel', function($q) use ($request) {
                $q->where('prenoms_nom', 'like', '%' . $request->search . '%');
            });
        }

        $documents = $query->latest()->paginate(20);
        $personnel = Personnel::orderBy('prenoms_nom')->get();

        return view('admin.hr.documents.index', compact('documents', 'personnel'));
    }

    public function createDocument()
    {
        $personnel = Personnel::orderBy('prenoms_nom')->get();
        return view('admin.hr.documents.create', compact('personnel'));
    }

    public function storeDocument(Request $request)
    {
        $validated = $request->validate([
            'personnel_id' => 'required|exists:personnel,id',
            'type' => 'required|in:contrat_travail,bulletin_salaire,certificat_medical,arret_maladie,attestation_travail,certificat_formation,autre',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fichier' => 'required|file|max:10240', // 10MB max
            'date_emission' => 'required|date',
            'date_expiration' => 'nullable|date|after:date_emission',
            'commentaires' => 'nullable|string'
        ]);

        // Upload du fichier
        $fichier = $request->file('fichier');
        $nomFichier = time() . '_' . $fichier->getClientOriginalName();
        $fichier->storeAs('public/hr-documents', $nomFichier);

        $validated['fichier'] = $nomFichier;
        $validated['extension'] = $fichier->getClientOriginalExtension();
        $validated['taille_fichier'] = $fichier->getSize();
        $validated['cree_par'] = Auth::id();

        HRDocument::create($validated);

        return redirect()->route('admin.hr.documents.index')->with('success', 'Document RH créé avec succès');
    }

    public function showDocument(HRDocument $document)
    {
        return view('admin.hr.documents.show', compact('document'));
    }

    public function editDocument(HRDocument $document)
    {
        $personnel = Personnel::orderBy('prenoms_nom')->get();
        return view('admin.hr.documents.edit', compact('document', 'personnel'));
    }

    public function updateDocument(Request $request, HRDocument $document)
    {
        $validated = $request->validate([
            'personnel_id' => 'required|exists:personnel,id',
            'type' => 'required|in:contrat_travail,bulletin_salaire,certificat_medical,arret_maladie,attestation_travail,certificat_formation,autre',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fichier' => 'nullable|file|max:10240',
            'date_emission' => 'required|date',
            'date_expiration' => 'nullable|date|after:date_emission',
            'commentaires' => 'nullable|string'
        ]);

        // Upload du nouveau fichier si fourni
        if ($request->hasFile('fichier')) {
            // Supprimer l'ancien fichier
            if ($document->fichier) {
                Storage::delete('public/hr-documents/' . $document->fichier);
            }
            
            $fichier = $request->file('fichier');
            $nomFichier = time() . '_' . $fichier->getClientOriginalName();
            $fichier->storeAs('public/hr-documents', $nomFichier);
            
            $validated['fichier'] = $nomFichier;
            $validated['extension'] = $fichier->getClientOriginalExtension();
            $validated['taille_fichier'] = $fichier->getSize();
        }

        $document->update($validated);

        return redirect()->route('admin.hr.documents.index')->with('success', 'Document RH mis à jour avec succès');
    }

    public function destroyDocument(HRDocument $document)
    {
        // Supprimer le fichier
        if ($document->fichier) {
            Storage::delete('public/hr-documents/' . $document->fichier);
        }

        $document->delete();

        return redirect()->route('admin.hr.documents.index')->with('success', 'Document RH supprimé avec succès');
    }

    public function downloadDocument(HRDocument $document)
    {
        $path = storage_path('app/public/hr-documents/' . $document->fichier);
        
        if (file_exists($path)) {
            return response()->download($path, $document->titre . '.' . $document->extension);
        }
        
        return back()->with('error', 'Fichier non trouvé');
    }

    // Gestion de la présence au travail
    public function attendance(Request $request)
    {
        $query = WorkAttendance::with(['personnel', 'validateur']);

        // Filtres
        if ($request->filled('personnel')) {
            $query->where('personnel_id', $request->personnel);
        }

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
        $personnel = Personnel::orderBy('prenoms_nom')->get();

        return view('admin.hr.attendance.index', compact('attendance', 'personnel'));
    }

    public function createAttendance()
    {
        $personnel = Personnel::orderBy('prenoms_nom')->get();
        return view('admin.hr.attendance.create', compact('personnel'));
    }

    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'personnel_id' => 'required|exists:personnel,id',
            'date' => 'required|date',
            'heure_arrivee' => 'nullable|date_format:H:i',
            'heure_depart' => 'nullable|date_format:H:i',
            'statut' => 'required|in:present,absent,retard,congé,maladie,formation,mission',
            'justification' => 'nullable|string',
            'heures_travaillees' => 'nullable|integer|min:0'
        ]);

        // Vérifier qu'il n'y a pas déjà une entrée pour cette date et ce personnel
        $existing = WorkAttendance::where('personnel_id', $validated['personnel_id'])
                                 ->where('date', $validated['date'])
                                 ->first();

        if ($existing) {
            return back()->with('error', 'Une entrée existe déjà pour cette date et ce personnel');
        }

        WorkAttendance::create($validated);

        return redirect()->route('admin.hr.attendance.index')->with('success', 'Présence enregistrée avec succès');
    }

    public function editAttendance(WorkAttendance $attendance)
    {
        $personnel = Personnel::orderBy('prenoms_nom')->get();
        return view('admin.hr.attendance.edit', compact('attendance', 'personnel'));
    }

    public function updateAttendance(Request $request, WorkAttendance $attendance)
    {
        $validated = $request->validate([
            'personnel_id' => 'required|exists:personnel,id',
            'date' => 'required|date',
            'heure_arrivee' => 'nullable|date_format:H:i',
            'heure_depart' => 'nullable|date_format:H:i',
            'statut' => 'required|in:present,absent,retard,congé,maladie,formation,mission',
            'justification' => 'nullable|string',
            'heures_travaillees' => 'nullable|integer|min:0'
        ]);

        $attendance->update($validated);

        return redirect()->route('admin.hr.attendance.index')->with('success', 'Présence mise à jour avec succès');
    }

    public function destroyAttendance(WorkAttendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('admin.hr.attendance.index')->with('success', 'Présence supprimée avec succès');
    }

    // Statistiques RH
    public function statistics(Request $request)
    {
        $annee = $request->get('annee', now()->year);
        $mois = $request->get('mois', now()->month);

        // Statistiques générales
        $stats = [
            'total_personnel' => Personnel::count(),
            'personnel_valide' => Personnel::where('statut_validation', 'Valide')->count(),
            'personnel_en_attente' => Personnel::where('statut_validation', 'En attente')->count(),
            'documents_actifs' => HRDocument::where('statut', 'actif')->count(),
            'documents_expires' => HRDocument::where('statut', 'expire')->count(),
            'bulletins_ce_mois' => SalarySlip::whereYear('periode_debut', $annee)
                                           ->whereMonth('periode_debut', $mois)
                                           ->count(),
            'presences_ce_mois' => WorkAttendance::whereYear('date', $annee)
                                               ->whereMonth('date', $mois)
                                               ->count()
        ];

        // Données pour graphiques
        $presencesParJour = WorkAttendance::whereYear('date', $annee)
                                        ->whereMonth('date', $mois)
                                        ->selectRaw('date, COUNT(*) as total')
                                        ->groupBy('date')
                                        ->orderBy('date')
                                        ->get();

        $documentsParType = HRDocument::selectRaw('type, COUNT(*) as total')
                                    ->groupBy('type')
                                    ->get();

        return view('admin.hr.statistics', compact('stats', 'presencesParJour', 'documentsParType', 'annee', 'mois'));
    }
}

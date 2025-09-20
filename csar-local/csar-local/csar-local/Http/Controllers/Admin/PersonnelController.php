<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PersonnelController extends Controller
{
    /**
     * Supprime la photo de profil d'un personnel (admin only)
     */
    public function deletePhoto(Personnel $personnel)
    {
        // Vérifier que l'utilisateur est admin
        if (!\Illuminate\Support\Facades\Auth::check() || !\Illuminate\Support\Facades\Auth::user()->is_admin) {
            abort(403, 'Accès refusé');
        }
        if ($personnel->photo_personnelle) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete('personnel/' . $personnel->photo_personnelle);
            $personnel->photo_personnelle = null;
            $personnel->save();
            return redirect()->back()->with('success', 'Photo supprimée avec succès.');
        }
        return redirect()->back()->with('info', 'Aucune photo à supprimer.');
    }
    public function index(Request $request)
    {
        $query = Personnel::query();

        // Filtres
        if ($request->filled('direction')) {
            $query->where('direction_service', $request->direction);
        }

        if ($request->filled('poste')) {
            $query->where('poste_actuel', $request->poste);
        }

        // Filtre de statut supprimé (plus de workflow approbation)

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('prenoms_nom', 'like', '%' . $request->search . '%')
                  ->orWhere('matricule', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Tri
        $sort = $request->input('sort', 'name');
        if ($sort === 'date') {
            $query->orderByDesc('date_recrutement_csar');
        } elseif ($sort === 'poste') {
            $query->orderBy('poste_actuel');
        } else {
            $query->orderBy('prenoms_nom');
        }

        $personnel = $query->with('validateur')->paginate(20);

        // Données pour les filtres et la barre latérale
        $directions = Personnel::distinct()->pluck('direction_service');
        $postes = Personnel::distinct()->pluck('poste_actuel');
        $directionCounts = Personnel::select('direction_service', DB::raw('COUNT(*) as total'))
            ->groupBy('direction_service')
            ->pluck('total', 'direction_service');

        // Postes hiérarchiques pour la direction sélectionnée (chips)
        $postesForDirection = collect();
        if ($request->filled('direction')) {
            $postesForDirection = Personnel::select('poste_actuel', DB::raw('COUNT(*) as total'))
                ->where('direction_service', $request->direction)
                ->groupBy('poste_actuel')
                ->pluck('total', 'poste_actuel');
        }

        // Compteurs de tuiles
        $totalPersonnel = Personnel::count();
        // Si plus de workflow, on affiche 0 pour validés/en attente/rejetés
        $validatedCount = 0;
        $pendingCount = 0;
        $rejectedCount = 0;

        return view('admin.personnel.index', compact(
            'personnel', 'directions', 'postes', 'directionCounts', 'sort',
            'totalPersonnel', 'validatedCount', 'pendingCount', 'rejectedCount',
            'postesForDirection'
        ));
    }

    public function show(Personnel $personnel)
    {
        return view('admin.personnel.show', compact('personnel'));
    }

    public function create()
    {
        return view('admin.personnel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenoms_nom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'tranche_age' => 'required|in:18-25,26-35,36-45,46-55,56-60',
            'nationalite' => 'required|string|max:100',
            'numero_cni' => 'required|string|max:50|unique:personnel',
            'sexe' => 'required|in:Masculin,Féminin',
            'situation_matrimoniale' => 'required|in:Celibataire,Marie,Divorce,Veuf,Veuve',
            'nombre_enfants' => 'required|integer|min:0|max:10',
            'contact_telephonique' => 'required|string|max:20',
            'email' => 'required|email|unique:personnel',
            'groupe_sanguin' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'adresse_complete' => 'required|string',
            'date_recrutement_csar' => 'required|date',
            'date_prise_service_csar' => 'required|date',
            'statut' => 'required|in:Fonctionnaire,Contractuel,Stagiaire,Journalier,Autre',
            'poste_actuel' => 'required|string|max:255',
            'direction_service' => 'required|string',
            'localisation_region' => 'nullable|string',
            'dernier_poste_avant_csar' => 'nullable|string',
            'formations_professionnelles' => 'nullable|string',
            'diplome_academique' => 'required|string',
            'autres_diplomes_certifications' => 'nullable|string',
            'logiciels_maitrises' => 'nullable|array',
            'langues_parlees' => 'nullable|array',
            'autres_aptitudes' => 'nullable|string',
            'aspirations_professionnelles' => 'nullable|string',
            'interet_nouvelles_responsabilites' => 'required|in:Oui,Non,Neutre',
            'photo_personnelle' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'taille_vetements' => 'required|in:S,M,L,XL,XXL,XXXL,Autre',
            'contact_urgence_nom' => 'required|string|max:255',
            'contact_urgence_telephone' => 'required|string|max:20',
            'contact_urgence_lien_parente' => 'required|string|max:100',
            'observations_personnelles' => 'nullable|string'
        ]);

        // Générer matricule unique
        $validated['matricule'] = Personnel::genererMatricule();

        // Gérer l'upload de photo
        if ($request->hasFile('photo_personnelle')) {
            $photo = $request->file('photo_personnelle');
            $original = $photo->getClientOriginalName();
            $nameOnly = pathinfo($original, PATHINFO_FILENAME);
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            $safeBase = Str::slug($nameOnly, '-');
            $photoName = time() . '_' . ($safeBase ?: 'photo') . '.' . ($ext ?: 'jpg');
            Storage::disk('public')->putFileAs('personnel', $photo, $photoName);
            $validated['photo_personnelle'] = $photoName;
        }

        Personnel::create($validated);

        return redirect()->route('admin.personnel.index')->with('success', 'Fiche personnel créée avec succès');
    }

    public function edit(Personnel $personnel)
    {
        return view('admin.personnel.edit', compact('personnel'));
    }

    public function update(Request $request, Personnel $personnel)
    {
        $validated = $request->validate([
            'prenoms_nom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'tranche_age' => 'required|in:18-25,26-35,36-45,46-55,56-60',
            'nationalite' => 'required|string|max:100',
            'numero_cni' => 'required|string|max:50|unique:personnel,numero_cni,' . $personnel->id,
            'sexe' => 'required|in:Masculin,Féminin',
            'situation_matrimoniale' => 'required|in:Celibataire,Marie,Divorce,Veuf,Veuve',
            'nombre_enfants' => 'required|integer|min:0|max:10',
            'contact_telephonique' => 'required|string|max:20',
            'email' => 'required|email|unique:personnel,email,' . $personnel->id,
            'groupe_sanguin' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'adresse_complete' => 'required|string',
            'date_recrutement_csar' => 'required|date',
            'date_prise_service_csar' => 'required|date',
            'statut' => 'required|in:Fonctionnaire,Contractuel,Stagiaire,Journalier,Autre',
            'poste_actuel' => 'required|string|max:255',
            'direction_service' => 'required|string',
            'localisation_region' => 'nullable|string',
            'dernier_poste_avant_csar' => 'nullable|string',
            'formations_professionnelles' => 'nullable|string',
            'diplome_academique' => 'required|string',
            'autres_diplomes_certifications' => 'nullable|string',
            'logiciels_maitrises' => 'nullable|array',
            'langues_parlees' => 'nullable|array',
            'autres_aptitudes' => 'nullable|string',
            'aspirations_professionnelles' => 'nullable|string',
            'interet_nouvelles_responsabilites' => 'required|in:Oui,Non,Neutre',
            'photo_personnelle' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'taille_vetements' => 'required|in:S,M,L,XL,XXL,XXXL,Autre',
            'contact_urgence_nom' => 'required|string|max:255',
            'contact_urgence_telephone' => 'required|string|max:20',
            'contact_urgence_lien_parente' => 'required|string|max:100',
            'observations_personnelles' => 'nullable|string'
        ]);

        // Gérer l'upload de photo
        if ($request->hasFile('photo_personnelle')) {
            // Supprimer l'ancienne photo
            if ($personnel->photo_personnelle) {
                Storage::disk('public')->delete('personnel/' . $personnel->photo_personnelle);
            }
            
            $photo = $request->file('photo_personnelle');
            $original = $photo->getClientOriginalName();
            $nameOnly = pathinfo($original, PATHINFO_FILENAME);
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            $safeBase = Str::slug($nameOnly, '-');
            $photoName = time() . '_' . ($safeBase ?: 'photo') . '.' . ($ext ?: 'jpg');
            Storage::disk('public')->putFileAs('personnel', $photo, $photoName);
            $validated['photo_personnelle'] = $photoName;
        }

        $personnel->update($validated);

        return redirect()->route('admin.personnel.index')->with('success', 'Fiche personnel mise à jour avec succès');
    }

    public function destroy(Personnel $personnel)
    {
        // Supprimer la photo
        if ($personnel->photo_personnelle) {
            Storage::disk('public')->delete('personnel/' . $personnel->photo_personnelle);
        }

        $personnel->delete();

        return redirect()->route('admin.personnel.index')->with('success', 'Fiche personnel supprimée avec succès');
    }

    // Méthodes valider/rejeter supprimées

    public function exportPdf(Request $request)
    {
        $query = Personnel::query();

        // Appliquer les mêmes filtres que dans index
        if ($request->filled('direction')) {
            $query->where('direction_service', $request->direction);
        }

        if ($request->filled('poste')) {
            $query->where('poste_actuel', $request->poste);
        }

        // Filtre de statut supprimé

        $personnel = $query->with('validateur')->get();

        // Génère un PDF à partir de la vue dédiée
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.personnel.pdf', compact('personnel'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('personnel-csar-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Télécharger la fiche individuelle d'un personnel en PDF
     */
    public function exportFichePdf(Personnel $personnel)
    {
        // Vue PDF dédiée; si non présente on peut réutiliser une structure minimale
        $pdf = Pdf::loadView('admin.personnel.fiche-pdf', compact('personnel'))
            ->setPaper('a4', 'portrait');
        $filename = 'fiche-personnel-' . ($personnel->matricule ?: 'csar') . '.pdf';
        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $query = Personnel::query();

        // Appliquer les mêmes filtres que dans index
        if ($request->filled('direction')) {
            $query->where('direction_service', $request->direction);
        }

        if ($request->filled('poste')) {
            $query->where('poste_actuel', $request->poste);
        }

        // Filtre de statut supprimé

        $personnel = $query->with('validateur')->get();
        
        // Retourner un CSV compatible Excel pour simplicité
        $filename = 'personnel-csar-' . date('Y-m-d-H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($personnel) {
            $output = fopen('php://output', 'w');
            // BOM UTF-8 pour Excel Windows
            fwrite($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, ['Matricule', 'Nom et Prénoms', 'Poste', 'Direction/Service', 'Email', 'Téléphone', 'Date recrutement'], ';');
            foreach ($personnel as $p) {
                fputcsv($output, [
                    $p->matricule,
                    $p->prenoms_nom,
                    $p->poste_actuel,
                    $p->direction_service,
                    $p->email,
                    $p->contact_telephonique,
                    optional($p->date_recrutement_csar)->format('d/m/Y'),
                ], ';');
            }
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }
}

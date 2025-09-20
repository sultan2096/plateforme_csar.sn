<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\SalarySlip;
use App\Models\WorkAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalarySlipController extends Controller
{
    public function index(Request $request)
    {
        $query = SalarySlip::with(['personnel', 'createur', 'validateur']);

        // Filtres
        if ($request->filled('personnel')) {
            $query->where('personnel_id', $request->personnel);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('periode_debut')) {
            $query->where('periode_debut', '>=', $request->periode_debut);
        }

        if ($request->filled('periode_fin')) {
            $query->where('periode_fin', '<=', $request->periode_fin);
        }

        if ($request->filled('search')) {
            $query->whereHas('personnel', function($q) use ($request) {
                $q->where('prenoms_nom', 'like', '%' . $request->search . '%');
            });
        }

        $bulletins = $query->latest()->paginate(20);
        $personnel = Personnel::orderBy('prenoms_nom')->get();

        return view('admin.hr.salary-slips.index', compact('bulletins', 'personnel'));
    }

    public function create()
    {
        $personnel = Personnel::where('statut_validation', 'Valide')->orderBy('prenoms_nom')->get();
        return view('admin.hr.salary-slips.create', compact('personnel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'personnel_id' => 'required|exists:personnel,id',
            'periode_debut' => 'required|date',
            'periode_fin' => 'required|date|after:periode_debut',
            'salaire_brut' => 'required|numeric|min:0',
            'cnss' => 'nullable|numeric|min:0',
            'impot' => 'nullable|numeric|min:0',
            'autres_deductions' => 'nullable|numeric|min:0',
            'indemnite_logement' => 'nullable|numeric|min:0',
            'indemnite_transport' => 'nullable|numeric|min:0',
            'indemnite_fonction' => 'nullable|numeric|min:0',
            'autres_indemnites' => 'nullable|numeric|min:0',
            'jours_travailles' => 'required|integer|min:0',
            'jours_conges' => 'nullable|integer|min:0',
            'jours_absences' => 'nullable|integer|min:0',
            'commentaires' => 'nullable|string'
        ]);

        // Vérifier qu'il n'y a pas déjà un bulletin pour cette période
        $existing = SalarySlip::where('personnel_id', $validated['personnel_id'])
                             ->where('periode_debut', $validated['periode_debut'])
                             ->where('periode_fin', $validated['periode_fin'])
                             ->first();

        if ($existing) {
            return back()->with('error', 'Un bulletin existe déjà pour cette période');
        }

        // Générer le numéro de bulletin
        $validated['numero_bulletin'] = SalarySlip::genererNumeroBulletin(
            $validated['personnel_id'], 
            Carbon::parse($validated['periode_debut'])
        );

        // Calculer le salaire net
        $totalIndemnites = ($validated['indemnite_logement'] ?? 0) + 
                          ($validated['indemnite_transport'] ?? 0) + 
                          ($validated['indemnite_fonction'] ?? 0) + 
                          ($validated['autres_indemnites'] ?? 0);

        $totalDeductions = ($validated['cnss'] ?? 0) + 
                          ($validated['impot'] ?? 0) + 
                          ($validated['autres_deductions'] ?? 0);

        $validated['salaire_net'] = $validated['salaire_brut'] + $totalIndemnites - $totalDeductions;
        $validated['cree_par'] = Auth::id();

        SalarySlip::create($validated);

        return redirect()->route('admin.hr.salary-slips.index')->with('success', 'Bulletin de salaire créé avec succès');
    }

    public function show(SalarySlip $salarySlip)
    {
        return view('admin.hr.salary-slips.show', compact('salarySlip'));
    }

    public function edit(SalarySlip $salarySlip)
    {
        $personnel = Personnel::where('statut_validation', 'Valide')->orderBy('prenoms_nom')->get();
        return view('admin.hr.salary-slips.edit', compact('salarySlip', 'personnel'));
    }

    public function update(Request $request, SalarySlip $salarySlip)
    {
        $validated = $request->validate([
            'personnel_id' => 'required|exists:personnel,id',
            'periode_debut' => 'required|date',
            'periode_fin' => 'required|date|after:periode_debut',
            'salaire_brut' => 'required|numeric|min:0',
            'cnss' => 'nullable|numeric|min:0',
            'impot' => 'nullable|numeric|min:0',
            'autres_deductions' => 'nullable|numeric|min:0',
            'indemnite_logement' => 'nullable|numeric|min:0',
            'indemnite_transport' => 'nullable|numeric|min:0',
            'indemnite_fonction' => 'nullable|numeric|min:0',
            'autres_indemnites' => 'nullable|numeric|min:0',
            'jours_travailles' => 'required|integer|min:0',
            'jours_conges' => 'nullable|integer|min:0',
            'jours_absences' => 'nullable|integer|min:0',
            'commentaires' => 'nullable|string'
        ]);

        // Vérifier qu'il n'y a pas déjà un autre bulletin pour cette période
        $existing = SalarySlip::where('personnel_id', $validated['personnel_id'])
                             ->where('periode_debut', $validated['periode_debut'])
                             ->where('periode_fin', $validated['periode_fin'])
                             ->where('id', '!=', $salarySlip->id)
                             ->first();

        if ($existing) {
            return back()->with('error', 'Un autre bulletin existe déjà pour cette période');
        }

        // Calculer le salaire net
        $totalIndemnites = ($validated['indemnite_logement'] ?? 0) + 
                          ($validated['indemnite_transport'] ?? 0) + 
                          ($validated['indemnite_fonction'] ?? 0) + 
                          ($validated['autres_indemnites'] ?? 0);

        $totalDeductions = ($validated['cnss'] ?? 0) + 
                          ($validated['impot'] ?? 0) + 
                          ($validated['autres_deductions'] ?? 0);

        $validated['salaire_net'] = $validated['salaire_brut'] + $totalIndemnites - $totalDeductions;

        $salarySlip->update($validated);

        return redirect()->route('admin.hr.salary-slips.index')->with('success', 'Bulletin de salaire mis à jour avec succès');
    }

    public function destroy(SalarySlip $salarySlip)
    {
        // Supprimer le fichier PDF s'il existe
        if ($salarySlip->fichier_pdf) {
            Storage::delete('public/salary-slips/' . $salarySlip->fichier_pdf);
        }

        $salarySlip->delete();

        return redirect()->route('admin.hr.salary-slips.index')->with('success', 'Bulletin de salaire supprimé avec succès');
    }

    public function valider(SalarySlip $salarySlip)
    {
        $salarySlip->valider(Auth::id());

        return redirect()->back()->with('success', 'Bulletin de salaire validé avec succès');
    }

    public function marquerCommePaye(SalarySlip $salarySlip)
    {
        $salarySlip->marquerCommePaye();

        return redirect()->back()->with('success', 'Bulletin marqué comme payé');
    }

    public function genererPDF(SalarySlip $salarySlip)
    {
        // Générer le PDF du bulletin de salaire
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.hr.salary-slips.pdf', compact('salarySlip'));
        
        // Sauvegarder le PDF
        $nomFichier = 'bulletin_' . $salarySlip->numero_bulletin . '.pdf';
        $pdf->save(storage_path('app/public/salary-slips/' . $nomFichier));
        
        // Mettre à jour le bulletin
        $salarySlip->update(['fichier_pdf' => $nomFichier]);

        return $pdf->download($nomFichier);
    }

    public function calculerJoursTravail(Request $request)
    {
        $request->validate([
            'personnel_id' => 'required|exists:personnel,id',
            'periode_debut' => 'required|date',
            'periode_fin' => 'required|date'
        ]);

        $personnelId = $request->personnel_id;
        $debut = Carbon::parse($request->periode_debut);
        $fin = Carbon::parse($request->periode_fin);

        // Calculer les jours travaillés
        $presences = WorkAttendance::where('personnel_id', $personnelId)
                                 ->whereBetween('date', [$debut, $fin])
                                 ->where('statut', 'present')
                                 ->count();

        $conges = WorkAttendance::where('personnel_id', $personnelId)
                              ->whereBetween('date', [$debut, $fin])
                              ->where('statut', 'congé')
                              ->count();

        $absences = WorkAttendance::where('personnel_id', $personnelId)
                                ->whereBetween('date', [$debut, $fin])
                                ->where('statut', 'absent')
                                ->count();

        return response()->json([
            'jours_travailles' => $presences,
            'jours_conges' => $conges,
            'jours_absences' => $absences
        ]);
    }

    public function exportPDF(Request $request)
    {
        $query = SalarySlip::with(['personnel', 'createur']);

        // Appliquer les mêmes filtres que l'index
        if ($request->filled('personnel')) {
            $query->where('personnel_id', $request->personnel);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('periode_debut')) {
            $query->where('periode_debut', '>=', $request->periode_debut);
        }

        if ($request->filled('periode_fin')) {
            $query->where('periode_fin', '<=', $request->periode_fin);
        }

        $bulletins = $query->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.hr.salary-slips.export-pdf', compact('bulletins'));
        return $pdf->download('bulletins-salaire-' . date('Y-m-d') . '.pdf');
    }
}

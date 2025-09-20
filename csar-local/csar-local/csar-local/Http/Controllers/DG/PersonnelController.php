<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
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

        if ($request->filled('statut_validation')) {
            $query->where('statut_validation', $request->statut_validation);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('prenoms_nom', 'like', '%' . $request->search . '%')
                  ->orWhere('matricule', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $personnel = $query->with('validateur')->latest()->paginate(20);

        // Données pour les filtres
        $directions = Personnel::distinct()->pluck('direction_service');
        $postes = Personnel::distinct()->pluck('poste_actuel');

        return view('dg.personnel.index', compact('personnel', 'directions', 'postes'));
    }

    public function show(Personnel $personnel)
    {
        return view('dg.personnel.show', compact('personnel'));
    }

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

        if ($request->filled('statut_validation')) {
            $query->where('statut_validation', $request->statut_validation);
        }

        $personnel = $query->with('validateur')->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dg.personnel.pdf', compact('personnel'));
        return $pdf->download('personnel-csar-dg-' . date('Y-m-d') . '.pdf');
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

        if ($request->filled('statut_validation')) {
            $query->where('statut_validation', $request->statut_validation);
        }

        $personnel = $query->with('validateur')->get();
        
        $filename = 'personnel-csar-dg-' . date('Y-m-d-H-i-s') . '.xlsx';
        
        return response()->json([
            'message' => 'Export Excel en cours...',
            'filename' => $filename,
            'data' => $personnel
        ]);
    }
} 
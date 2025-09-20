<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user');

        // Filtres
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('ip_address', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->paginate(20);

        // Récupérer tous les utilisateurs pour les filtres
        $users = User::orderBy('name')->get();

        // Actions disponibles
        $actions = AuditLog::distinct()->pluck('action')->filter()->sort();

        // Types de modèles disponibles
        $modelTypes = AuditLog::distinct()->pluck('model_type')->filter()->sort();

        // Statistiques
        $stats = [
            'total_logs' => AuditLog::count(),
            'today_logs' => AuditLog::whereDate('created_at', today())->count(),
            'this_week_logs' => AuditLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month_logs' => AuditLog::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'login_logs' => AuditLog::where('action', 'login')->count(),
            'create_logs' => AuditLog::where('action', 'create')->count(),
            'update_logs' => AuditLog::where('action', 'update')->count(),
            'delete_logs' => AuditLog::where('action', 'delete')->count(),
        ];

        return view('admin.audit-logs.index', compact('auditLogs', 'users', 'actions', 'modelTypes', 'stats'));
    }

    public function show(AuditLog $auditLog)
    {
        return view('admin.audit-logs.show', compact('auditLog'));
    }

    public function exportCsv(Request $request)
    {
        $query = AuditLog::with('user');

        // Appliquer les mêmes filtres que l'index
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->get();

        $filename = 'audit_logs_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return Response::stream(function() use ($auditLogs) {
            $handle = fopen('php://output', 'w');
            
            // Ajouter BOM UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // En-têtes CSV
            fputcsv($handle, [
                'ID',
                'Utilisateur',
                'Email',
                'Action',
                'Type de modèle',
                'ID du modèle',
                'Description',
                'Adresse IP',
                'User Agent',
                'Date de création'
            ], ';');

            // Données
            foreach ($auditLogs as $log) {
                fputcsv($handle, [
                    $log->id,
                    $log->user ? $log->user->name : 'Utilisateur supprimé',
                    $log->user ? $log->user->email : 'N/A',
                    $log->action,
                    $log->model_type ?? 'N/A',
                    $log->model_id ?? 'N/A',
                    $log->description ?? 'N/A',
                    $log->ip_address ?? 'N/A',
                    $log->user_agent ?? 'N/A',
                    $log->created_at->format('d/m/Y H:i:s')
                ], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function clearOld(Request $request)
    {
        $days = $request->input('days', 30);
        
        $deleted = AuditLog::where('created_at', '<', now()->subDays($days))->delete();

        return redirect()->route('admin.audit.index')
            ->with('success', "$deleted logs de plus de $days jours ont été supprimés.");
    }
}

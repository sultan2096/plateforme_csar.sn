<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeeklyAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeeklyAgendaController extends Controller
{
    public function index(Request $request)
    {
        $week = $request->get('week', 'current');
        
        // Calculer les dates de début et fin de semaine
        if ($week === 'next') {
            $week_start = now()->addWeek()->startOfWeek();
            $week_end = now()->addWeek()->endOfWeek();
            $weekTitle = 'Semaine prochaine (' . $week_start->format('d/m') . ' - ' . $week_end->format('d/m') . ')';
        } else {
            $week_start = now()->startOfWeek();
            $week_end = now()->endOfWeek();
            $weekTitle = 'Semaine en cours (' . $week_start->format('d/m') . ' - ' . $week_end->format('d/m') . ')';
        }

        // Récupérer les agendas pour la semaine sélectionnée
        $agendas = WeeklyAgenda::with(['assignedTo', 'createdBy'])
            ->whereBetween('start_date', [$week_start, $week_end])
            ->orderBy('start_date', 'asc')
            ->get();

        // Calculer les statistiques
        $stats = [
            'total' => $agendas->count(),
            'meetings' => $agendas->where('event_type', 'meeting')->count(),
            'deliveries' => $agendas->where('event_type', 'delivery')->count(),
            'visits' => $agendas->where('event_type', 'visit')->count(),
            'tasks' => $agendas->where('event_type', 'task')->count(),
            'instructions' => $agendas->where('event_type', 'instruction')->count(),
        ];

        return view('admin.weekly-agenda.index', [
            'agendas' => $agendas,
            'stats' => $stats,
            'week' => $week,
            'weekTitle' => $weekTitle,
        ]);
    }

    // Méthode create déplacée à la fin

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:meeting,delivery,visit,task,instruction',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'participants' => 'nullable|array',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
        ]);

        WeeklyAgenda::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_type' => $request->event_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'participants' => $request->participants,
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
            'priority' => $request->priority,
            'status' => $request->status,
            'notes' => $request->notes,
            'tags' => $request->tags,
        ]);

        return redirect()->route('admin.weekly-agenda.index')
            ->with('success', 'Événement créé avec succès.');
    }

    public function show(WeeklyAgenda $weeklyAgenda)
    {
        return view('admin.weekly-agenda.show', compact('weeklyAgenda'));
    }

    public function edit(WeeklyAgenda $weeklyAgenda)
    {
        $users = \App\Models\User::all();
        return view('admin.weekly-agenda.edit', compact('weeklyAgenda', 'users'));
    }

    public function update(Request $request, WeeklyAgenda $weeklyAgenda)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:meeting,delivery,visit,task,instruction',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'participants' => 'nullable|array',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
        ]);

        $weeklyAgenda->update([
            'title' => $request->title,
            'description' => $request->description,
            'event_type' => $request->event_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'participants' => $request->participants,
            'assigned_to' => $request->assigned_to,
            'priority' => $request->priority,
            'status' => $request->status,
            'notes' => $request->notes,
            'tags' => $request->tags,
        ]);

        return redirect()->route('admin.weekly-agenda.index')
            ->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy(WeeklyAgenda $weeklyAgenda)
    {
        $weeklyAgenda->delete();
        return redirect()->route('admin.weekly-agenda.index')
            ->with('success', 'Événement supprimé avec succès.');
    }

    public function updateStatus(Request $request, WeeklyAgenda $weeklyAgenda)
    {
        $request->validate(['status' => 'required|in:scheduled,in_progress,completed,cancelled']);
        $weeklyAgenda->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function calendar(Request $request)
    {
        $week_start = now()->startOfWeek();
        $week_end = now()->endOfWeek();
        
        $events = WeeklyAgenda::select(['id', 'title', 'start_date as start', 'end_date as end'])
            ->whereBetween('start_date', [$week_start, $week_end])
            ->get();

        return response()->json($events);
    }
    
    public function create()
    {
        $users = \App\Models\User::all();
        return view('admin.weekly-agenda.create', compact('users'));
    }
}




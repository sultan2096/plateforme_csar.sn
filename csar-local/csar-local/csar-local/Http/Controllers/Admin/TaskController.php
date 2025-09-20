<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        // Pagination pour la vue liste
        $tasks = Task::with(['assignedTo', 'assignedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Collection complète pour le Kanban et les stats
        $allTasks = Task::with(['assignedTo', 'assignedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $allTasks->count(),
            'todo' => $allTasks->where('status', 'todo')->count(),
            'in_progress' => $allTasks->where('status', 'in_progress')->count(),
            'done' => $allTasks->where('status', 'done')->count(),
        ];
        
        return view('admin.tasks.index', compact('tasks', 'allTasks', 'stats'));
    }

    public function create()
    {
        $users = User::where('role_id', '!=', 1)->get();
        return view('admin.tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date|after:today',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array'
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'assigned_by' => Auth::id(),
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'tags' => $request->tags ?? []
        ]);

        // Envoyer notification d'assignation de tâche
        $notificationService = new NotificationService();
        $notificationService->sendTaskAssignedNotification($task);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tâche créée avec succès. L\'assigné a été notifié.');
    }

    public function show(Task $task)
    {
        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $users = User::where('role_id', '!=', 1)->get();
        return view('admin.tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array'
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'tags' => $request->tags ?? []
        ]);

        if ($request->status === 'done' && !$task->completed_at) {
            $task->update(['completed_at' => now()]);
        }

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tâche mise à jour avec succès.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tâche supprimée avec succès.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:todo,in_progress,done'
        ]);

        $task->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'done' ? now() : null
        ]);

        return response()->json(['success' => true]);
    }
}




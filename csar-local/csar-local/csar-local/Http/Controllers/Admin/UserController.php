<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        // Filtres
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('position')) {
            $query->where('position', 'like', '%' . $request->position . '%');
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Récupérer tous les rôles pour les filtres
        $roles = Role::all();

        // Statistiques
        $adminRole = Role::where('name', 'admin')->first();
        $dgRole = Role::where('name', 'dg')->first();
        $responsableRole = Role::where('name', 'responsable')->first();
        $agentRole = Role::where('name', 'agent')->first();
        
        $stats = [
            'total_users' => User::count(),
            'admin_users' => $adminRole ? User::where('role_id', $adminRole->id)->count() : 0,
            'dg_users' => $dgRole ? User::where('role_id', $dgRole->id)->count() : 0,
            'responsable_users' => $responsableRole ? User::where('role_id', $responsableRole->id)->count() : 0,
            'agent_users' => $agentRole ? User::where('role_id', $agentRole->id)->count() : 0,
        ];

        return view('admin.users.index', compact('users', 'stats', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'position' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'role_id.required' => 'Le rôle est requis.',
            'role_id.exists' => 'Le rôle sélectionné n\'existe pas.',
            'position.required' => 'Le poste est requis.',
            'department.required' => 'La direction est requise.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'position' => $request->position,
            'department' => $request->department,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        // Envoyer la notification de bienvenue
        $notificationService = new NotificationService();
        $notificationService->sendWelcomeNotification($user, $request->password);

        return redirect()->route('admin.users.index')->with('success', 'Agent ajouté avec succès ! Un email de bienvenue a été envoyé.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'position' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'role_id.required' => 'Le rôle est requis.',
            'role_id.exists' => 'Le rôle sélectionné n\'existe pas.',
            'position.required' => 'Le poste est requis.',
            'department.required' => 'La direction est requise.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'position' => $request->position,
            'department' => $request->department,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Agent mis à jour avec succès !');
    }

    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Agent supprimé avec succès !');
    }

    public function exportPdf()
    {
        $users = User::orderBy('department')->orderBy('name')->get();
        
        // Ici vous pouvez implémenter l'export PDF
        // Pour l'instant, on redirige vers la liste
        return redirect()->route('admin.users.index')->with('info', 'Export PDF à implémenter.');
    }

    public function exportExcel()
    {
        $users = User::orderBy('department')->orderBy('name')->get();
        
        // Ici vous pouvez implémenter l'export Excel
        // Pour l'instant, on redirige vers la liste
        return redirect()->route('admin.users.index')->with('info', 'Export Excel à implémenter.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'csar' . rand(1000, 9999);
        $user->update(['password' => Hash::make($newPassword)]);

        return redirect()->route('admin.users.index')->with('success', 'Mot de passe réinitialisé. Nouveau mot de passe : ' . $newPassword);
    }
}

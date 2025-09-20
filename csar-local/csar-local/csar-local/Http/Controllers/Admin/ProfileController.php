<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User as AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var AppUser $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            // Le changement de mot de passe est géré dans updatePassword()
        ], [
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
        ]);

        // Mettre à jour les informations de base
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profil mis à jour avec succès !');
    }

    /**
     * Met à jour le mot de passe de l'utilisateur connecté
     */
    public function updatePassword(Request $request)
    {
        /** @var AppUser $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Le mot de passe actuel est requis.',
            'new_password.required' => 'Le nouveau mot de passe est requis.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'new_password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Mot de passe mis à jour avec succès !');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ], [
            'avatar.required' => 'Veuillez sélectionner une image.',
            'avatar.image' => 'Le fichier doit être une image.',
            'avatar.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'avatar.max' => 'L\'image ne doit pas dépasser 2MB.',
        ]);

        /** @var AppUser $user */
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->avatar && file_exists(public_path('storage/' . $user->avatar))) {
                unlink(public_path('storage/' . $user->avatar));
            }

            // Sauvegarder la nouvelle image
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();

            return redirect()->route('admin.profile.edit')->with('success', 'Photo de profil mise à jour avec succès !');
        }

        return back()->withErrors(['avatar' => 'Erreur lors du téléchargement de l\'image.']);
    }

    public function exportPdf()
    {
        $user = Auth::user();
        
        // Ici vous pouvez implémenter l'export PDF du profil
        // Pour l'instant, on redirige vers la page de profil
        return redirect()->route('admin.profile.edit')->with('info', 'Export PDF à implémenter.');
    }
}

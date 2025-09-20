<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('dg.profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        
        // Gestion de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            
            // Sauvegarder la nouvelle photo
            $photoPath = $request->file('photo')->store('profile-photos', 'public');
            $data['photo'] = $photoPath;
        }
        
        $user->update($data);
        
        return redirect()->route('dg.profile.edit')
            ->with('success', 'Profil mis à jour avec succès');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->route('dg.profile.edit')
            ->with('success', 'Mot de passe mis à jour avec succès');
    }
} 
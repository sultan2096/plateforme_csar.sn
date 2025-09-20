<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer le profil personnel de l'agent
        $personnel = Personnel::where('email', $user->email)->first();
        
        if (!$personnel) {
            return redirect()->route('agent.dashboard')->with('error', 'Profil personnel non trouvé. Veuillez contacter l\'administrateur.');
        }
        
        return view('agent.profile', compact('personnel', 'user'));
    }
    
    /**
     * Afficher le formulaire de modification du profil
     */
    public function edit()
    {
        $user = Auth::user();
        $personnel = Personnel::where('email', $user->email)->first();
        
        if (!$personnel) {
            return redirect()->route('agent.dashboard')->with('error', 'Profil personnel non trouvé.');
        }
        
        return view('agent.profile.edit', compact('personnel', 'user'));
    }
    
    /**
     * Mettre à jour le profil de l'agent
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $user = Auth::user();
        
        // Mettre à jour les informations de base
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        
        // Gérer l'upload de photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('agent-photos', 'public');
            $user->update(['photo' => $photoPath]);
        }
        
        // Mettre à jour le personnel si l'email a changé
        $personnel = Personnel::where('email', $user->getOriginal('email'))->first();
        if ($personnel && $request->email !== $user->getOriginal('email')) {
            $personnel->update(['email' => $request->email]);
        }
        
        return redirect()->route('agent.profile')->with('success', 'Profil mis à jour avec succès');
    }
    
    /**
     * Afficher le formulaire de changement de mot de passe
     */
    public function changePassword()
    {
        return view('agent.profile.change-password');
    }
    
    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Vérifier le mot de passe actuel
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
        }
        
        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->route('agent.profile')->with('success', 'Mot de passe mis à jour avec succès');
    }
    
    /**
     * Télécharger la fiche agent en PDF
     */
    public function downloadPdf()
    {
        $user = Auth::user();
        $personnel = Personnel::where('email', $user->email)->first();
        
        if (!$personnel) {
            return back()->with('error', 'Profil personnel non trouvé');
        }
        
        $pdf = PDF::loadView('agent.profile.pdf', compact('personnel'));
        
        return $pdf->download('fiche-agent-' . $personnel->matricule . '.pdf');
    }
    
    /**
     * Afficher les informations détaillées du profil
     */
    public function show()
    {
        $user = Auth::user();
        $personnel = Personnel::where('email', $user->email)->first();
        
        if (!$personnel) {
            return redirect()->route('agent.dashboard')->with('error', 'Profil personnel non trouvé');
        }
        
        return view('agent.profile.show', compact('personnel', 'user'));
    }
}

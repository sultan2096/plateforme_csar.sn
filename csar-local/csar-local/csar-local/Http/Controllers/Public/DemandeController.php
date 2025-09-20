<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemandeController extends Controller
{
    public function create()
    {
        return view('public.demande');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:30',
            'objet' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'pj' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,zip|max:4096',
            'consentement' => 'required|accepted',
        ], [
            'consentement.accepted' => 'Vous devez accepter le traitement de vos données pour soumettre la demande.'
        ]);
        // Stocker la demande en base
        $data = $validated;
        if ($request->hasFile('pj')) {
            $data['pj'] = $request->file('pj')->store('demandes_pj', 'public');
        }
        $data['consentement'] = true;
        \App\Models\Demande::create($data);

        // (Optionnel) Notifier l’admin par email
        /*
        \Mail::to(config('mail.admin_address', 'admin@csar.sn'))->send(
            new \App\Mail\DemandeRecueNotification($data)
        );
        */
        return redirect()->route('demande.create')->with('success', 'Votre demande a bien été envoyée. Nous vous contacterons rapidement.');
    }
}

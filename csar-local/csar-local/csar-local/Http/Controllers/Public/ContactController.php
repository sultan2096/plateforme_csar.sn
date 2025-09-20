<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }
    
    public function submit(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $fullName = $request->first_name . ' ' . $request->last_name;

        $contact = ContactMessage::create([
            'full_name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        // Notification DG (par email)
        try {
            $dgEmail = 'dg@csar.sn'; // À adapter selon la config réelle
            \Mail::raw(
                "Nouveau message de contact reçu :\n\n" .
                "Nom : {$contact->full_name}\n" .
                "Email : {$contact->email}\n" .
                "Téléphone : {$contact->phone}\n" .
                "Sujet : {$contact->subject}\n" .
                "Message :\n{$contact->message}",
                function($message) use ($dgEmail) {
                    $message->to($dgEmail)
                        ->subject('Nouveau message de contact CSAR');
                }
            );
        } catch (\Exception $e) {
            // Log::error('Erreur notification DG: ' . $e->getMessage());
        }

        return back()->with('success', 'Message envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
    }
}

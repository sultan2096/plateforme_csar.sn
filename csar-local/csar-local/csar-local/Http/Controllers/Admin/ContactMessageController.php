<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistiques
        $stats = [
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('status', 'unread')->count(),
            'read_messages' => ContactMessage::where('status', 'read')->count(),
            'replied_messages' => ContactMessage::where('status', 'replied')->count(),
            'archived_messages' => ContactMessage::where('status', 'archived')->count(),
        ];

        return view('admin.contact-messages.index', compact('messages', 'stats'));
    }

    public function show(ContactMessage $contact)
    {
        // Marquer comme lu si non lu
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        // La vue attend une variable $message
        $message = $contact;
        return view('admin.contact-messages.show', compact('message'));
    }

    public function markAsRead(ContactMessage $contact)
    {
        $contact->update(['status' => 'read']);

        return redirect()->route('admin.contact.index')->with('success', 'Message marqué comme lu !');
    }

    public function markAsReplied(ContactMessage $contact)
    {
        $contact->update(['status' => 'replied']);

        return redirect()->route('admin.contact.show', $contact)->with('success', 'Message marqué comme répondu !');
    }

    public function archive(ContactMessage $contact)
    {
        $contact->update(['status' => 'archived']);

        return redirect()->route('admin.contact.index')->with('success', 'Message archivé !');
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Message supprimé !');
    }

    public function exportCsv()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();
        
        $filename = 'messages_contact_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($messages) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, ['ID', 'Nom', 'Email', 'Sujet', 'Message', 'Statut', 'Date de création']);
            
            // Données
            foreach ($messages as $message) {
                fputcsv($file, [
                    $message->id,
                    $message->name,
                    $message->email,
                    $message->subject,
                    strip_tags($message->message),
                    $message->status,
                    $message->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

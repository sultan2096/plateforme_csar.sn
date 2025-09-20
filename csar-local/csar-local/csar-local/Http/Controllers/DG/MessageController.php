<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();
        
        // Filtres
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $messages = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Statistiques
        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('is_read', false)->count(),
            'read' => ContactMessage::where('is_read', true)->count(),
            'this_week' => ContactMessage::where('created_at', '>=', now()->subWeek())->count(),
        ];
        
        return view('dg.messages.index', compact('messages', 'stats'));
    }
    
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // Marquer comme lu
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        
        return view('dg.messages.show', compact('message'));
    }
} 
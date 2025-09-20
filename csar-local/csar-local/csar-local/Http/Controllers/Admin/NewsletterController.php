<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $subscribers = $query->latest('subscribed_at')->paginate(25)->withQueryString();

        $stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::where('is_active', true)->count(),
            'inactive' => NewsletterSubscriber::where('is_active', false)->count(),
        ];
        
        return view('admin.newsletter.index', compact('subscribers', 'stats'));
    }

    public function show(NewsletterSubscriber $subscriber)
    {
        return view('admin.newsletter.show', compact('subscriber'));
    }

    public function toggleActive(NewsletterSubscriber $subscriber)
    {
        $subscriber->update(['is_active' => ! $subscriber->is_active]);
        return back()->with('success', 'Statut de l\'abonné mis à jour.');
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.newsletter.index')->with('success', 'Abonné supprimé avec succès');
    }

    public function exportCsv()
    {
        $subscribers = NewsletterSubscriber::orderByDesc('subscribed_at')->get();

        $filename = 'newsletter-subscribers-' . date('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($subscribers) {
            $output = fopen('php://output', 'w');
            // BOM UTF-8 pour Excel/Windows
            fwrite($output, "\xEF\xBB\xBF");
            // En-têtes CSV
            fputcsv($output, ['ID', 'Email', 'Date d\'inscription', 'Actif']);
            // Données
            foreach ($subscribers as $subscriber) {
                $date = $subscriber->subscribed_at ?: $subscriber->created_at;
                $dateStr = $date ? $date->format('d/m/Y H:i') : '';
                fputcsv($output, [
                    $subscriber->id,
                    $subscriber->email,
                    $dateStr,
                    $subscriber->is_active ? 'Oui' : 'Non',
                ]);
            }
            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}

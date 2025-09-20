<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PublicContent;
use App\Models\News;
use App\Models\PublicRequest;
use App\Models\Newsletter;
use App\Models\ContactMessage;
use App\Models\Warehouse;
use App\Models\Speech;
use App\Models\HomeBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        // Récupération de toutes les images de fond actives, triées par ordre d'affichage
        $backgrounds = HomeBackground::active()
            ->ordered()
            ->get();
            
        // Si aucune image de fond n'est définie, utiliser une valeur par défaut
        $backgroundImage = $backgrounds->isNotEmpty() ? $backgrounds->first()->image_url : asset('img/1.jpg');
        
        // Préparer les données pour le slider d'arrière-plan
        $backgroundSlider = [];
        foreach ($backgrounds as $bg) {
            $backgroundSlider[] = [
                'image' => $bg->image_url,
                'title' => $bg->title,
                'description' => $bg->description
            ];
        }
        
        // Récupération du contenu dynamique
        $aboutContent = PublicContent::where('section', 'about')->get()->keyBy('key_name');
        $stats = [
            'agents' => $aboutContent->get('agents_count', (object)['value' => '137'])->value,
            'warehouses' => $aboutContent->get('warehouses_count', (object)['value' => '70'])->value,
            'capacity' => $aboutContent->get('capacity_count', (object)['value' => '86'])->value,
            'experience' => $aboutContent->get('experience_count', (object)['value' => '50'])->value
        ];
        
        // Gestion sécurisée des actualités
        try {
            $latestNews = News::where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get()
                ->map(function($news) {
                    $news->excerpt = Str::limit(strip_tags($news->content), 150);
                    return $news;
                });
        } catch (\Exception $e) {
            $latestNews = collect([]); // Collection vide si erreur
        }
        
        // Gestion sécurisée des discours
        try {
            $latestSpeeches = Speech::orderBy('date', 'desc')
                ->take(3)
                ->get()
                ->map(function($speech) {
                    $speech->excerpt = Str::limit(strip_tags($speech->content), 100);
                    return $speech;
                });
        } catch (\Exception $e) {
            $latestSpeeches = collect([]); // Collection vide si erreur
        }
        
        // Récupération des entrepôts actifs
        $warehouses = Warehouse::where('is_active', true)->get();
        
        // Récupération des discours institutionnels
        $ministerSpeech = PublicContent::where('section', 'speeches')
            ->where('key_name', 'minister_speech')
            ->first();
            
        $dgSpeech = PublicContent::where('section', 'speeches')
            ->where('key_name', 'dg_speech')
            ->first();
            
        // Préparation des données pour la vue
        $viewData = [
            'backgroundImage' => $backgroundImage,
            'backgroundSlider' => $backgroundSlider,
            'stats' => $stats,
            'latestNews' => $latestNews,
            'warehouses' => $warehouses,
            'speeches' => $latestSpeeches,
            'ministerSpeech' => $ministerSpeech,
            'dgSpeech' => $dgSpeech,
            'requests' => []
        ];
        
        return view('public.home', $viewData);
    }

    public function about()
    {
        $aboutContent = PublicContent::where('section', 'about')->get()->keyBy('key_name');
        return view('public.about', compact('aboutContent'));
    }

    public function institution()
    {
        $institutionContent = PublicContent::where('section', 'institution')->get()->keyBy('key_name');
        return view('public.institution', compact('institutionContent'));
    }

    public function news()
    {
        $news = News::where('is_published', true)->orderBy('published_at', 'desc')->paginate(10);
        return view('public.news', compact('news'));
    }

    public function newsShow($id)
    {
        $news = News::where('is_published', true)->findOrFail($id);
        $relatedNews = News::where('is_published', true)
            ->where('id', '!=', $id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        
        return view('public.news.show', compact('news', 'relatedNews'));
    }

    public function reports()
    {
        return view('public.reports');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function action()
    {
        return view('public.request-form');
    }

    public function submitRequest(Request $request)
    {
        $request->validate([
            'type' => 'required|in:aide,partenariat,audience,autre',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'region' => 'required|string|max:255',
            'description' => 'required|string',
            'urgency' => 'required|in:low,medium,high',
            'preferred_contact' => 'required|in:email,phone,sms'
        ]);

        $trackingCode = $this->generateTrackingCode();

        $publicRequest = PublicRequest::create([
            'type' => $request->type,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'region' => $request->region,
            'description' => $request->description,
            'urgency' => $request->urgency,
            'preferred_contact' => $request->preferred_contact,
            'tracking_code' => $trackingCode,
            'status' => 'pending'
        ]);

        // Envoyer un SMS de confirmation si le numéro est fourni
        if ($request->phone) {
            try {
                $message = "Votre demande CSAR a été reçue. Code de suivi: {$trackingCode}. Nous vous contacterons bientôt.";
                // Ici vous pouvez intégrer votre service SMS
                // SmsService::send($request->phone, $message);
            } catch (\Exception $e) {
                // Log l'erreur mais ne pas faire échouer la soumission
                \Log::error('Erreur SMS: ' . $e->getMessage());
            }
        }

        return redirect()->route('success')->with('tracking_code', $trackingCode);
    }

    public function track()
    {
        return view('public.track');
    }

    public function trackRequest(Request $request)
    {
        $request->validate([
            'tracking_code' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20'
        ]);

        $publicRequest = PublicRequest::where('tracking_code', $request->tracking_code)->first();

        if (!$publicRequest) {
            return back()->withErrors(['tracking_code' => 'Code de suivi non trouvé.']);
        }

        // Vérifier le numéro de téléphone si fourni
        if ($request->phone && $publicRequest->phone !== $request->phone) {
            return back()->withErrors(['phone' => 'Le numéro de téléphone ne correspond pas à celui de la demande.']);
        }

        return view('public.track-result', compact('publicRequest'));
    }

    public function downloadPdf($code)
    {
        $publicRequest = PublicRequest::where('tracking_code', $code)->firstOrFail();
        
        $pdf = \PDF::loadView('public.request-pdf', compact('publicRequest'));
        
        return $pdf->download("demande-{$code}.pdf");
    }

    public function success()
    {
        $trackingCode = session('tracking_code');
        return view('public.success', compact('trackingCode'));
    }

    public function requestSuccess(Request $request)
    {
        $code = $request->query('code');
        $publicRequest = null;
        
        if ($code) {
            $publicRequest = PublicRequest::where('tracking_code', $code)->first();
        }
        
        return view('public.request-success', compact('publicRequest', 'code'));
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email'
        ]);

        \App\Models\NewsletterSubscriber::create([
            'email' => $request->email,
            'is_active' => true,
        ]);

        return back()->with('success', 'Inscription à la newsletter réussie !');
    }

    public function submitContact(Request $request)
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

        // Ici vous pouvez ajouter l'envoi d'email de notification
        // Mail::to('admin@csar.sn')->send(new ContactMessageNotification($contact));

        return back()->with('success', 'Message envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
    }

    public function speeches()
    {
        $speeches = \App\Models\Speech::orderByDesc('date')->get();
        return view('public.speeches.index', compact('speeches'));
    }

    public function speech($id)
    {
        $speech = \App\Models\Speech::findOrFail($id);
        return view('public.speeches.show', compact('speech'));
    }

    public function gallery()
    {
        $images = \App\Models\GalleryImage::orderByDesc('created_at')->get();
        return view('public.gallery.index', compact('images'));
    }

    private function generateTrackingCode()
    {
        do {
            $code = 'CSAR' . date('Y') . strtoupper(Str::random(6));
        } while (PublicRequest::where('tracking_code', $code)->exists());

        return $code;
    }
} 
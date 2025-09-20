<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use App\Models\PublicContent;
use App\Models\News;
use App\Models\Speech;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class PublicContentController extends Controller
{
    /**
     * Afficher la liste des contenus publics
     */
    public function index(Request $request)
    {
        $query = PublicContent::query();
        
        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }
        
        $contents = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Statistiques
        $stats = [
            'total_contents' => PublicContent::count(),
            'about_pages' => PublicContent::where('type', 'about')->count(),
            'institution_pages' => PublicContent::where('type', 'institution')->count(),
            'news_articles' => News::count(),
            'speeches' => Speech::count(),
            'gallery_images' => GalleryImage::count(),
        ];
        
        return view('dg.public-content.index', compact('contents', 'stats'));
    }
    
    /**
     * Afficher les détails d'un contenu
     */
    public function show($id)
    {
        $content = PublicContent::findOrFail($id);
        return view('dg.public-content.show', compact('content'));
    }
    
    /**
     * Afficher la liste des actualités
     */
    public function news(Request $request)
    {
        $query = News::query();
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }
        
        $news = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('dg.public-content.news', compact('news'));
    }
    
    /**
     * Afficher le détail d'une actualité
     */
    public function showNews($id)
    {
        $news = News::findOrFail($id);
        return view('dg.public-content.news-show', compact('news'));
    }
    
    /**
     * Afficher la liste des discours
     */
    public function speeches(Request $request)
    {
        $query = Speech::query();
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }
        
        $speeches = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('dg.public-content.speeches', compact('speeches'));
    }
    
    /**
     * Afficher la galerie d'images
     */
    public function gallery(Request $request)
    {
        $query = GalleryImage::query();
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        $images = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('dg.public-content.gallery', compact('images'));
    }
    
    /**
     * Afficher les rapports et documents
     */
    public function reports(Request $request)
    {
        $query = PublicContent::where('type', 'report');
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }
        
        $reports = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('dg.public-content.reports', compact('reports'));
    }
}

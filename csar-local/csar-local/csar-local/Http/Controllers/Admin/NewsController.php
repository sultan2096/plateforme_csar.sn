<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:article,communique,evenement',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'is_published' => 'nullable|boolean',
        ], [
            'title.required' => 'Le titre est requis.',
            'content.required' => 'Le contenu est requis.',
            'type.required' => 'Le type d\'actualité est requis.',
            'type.in' => 'Le type doit être article, communiqué ou événement.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'image.max' => 'L\'image ne doit pas dépasser 2MB.',
            'video_url.url' => 'L\'URL de la vidéo doit être valide.',
            'document.file' => 'Le document doit être un fichier valide.',
            'document.mimes' => 'Le document doit être au format PDF, DOC ou DOCX.',
            'document.max' => 'Le document ne doit pas dépasser 5MB.',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'video_url' => $request->video_url,
            'is_published' => $request->has('is_published'),
            'created_by' => Auth::id(),
        ];

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news/images', 'public');
            $data['image'] = $imagePath;
        }

        // Gestion du document
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('news/documents', 'public');
            $data['document'] = $documentPath;
        }

        // Date de publication si publié
        if ($request->has('is_published')) {
            $data['published_at'] = now();
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité créée avec succès !');
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.show', compact('news'));
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:article,communique,evenement',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'is_published' => 'nullable|boolean',
        ], [
            'title.required' => 'Le titre est requis.',
            'content.required' => 'Le contenu est requis.',
            'type.required' => 'Le type d\'actualité est requis.',
            'type.in' => 'Le type doit être article, communiqué ou événement.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF.',
            'image.max' => 'L\'image ne doit pas dépasser 2MB.',
            'video_url.url' => 'L\'URL de la vidéo doit être valide.',
            'document.file' => 'Le document doit être un fichier valide.',
            'document.mimes' => 'Le document doit être au format PDF, DOC ou DOCX.',
            'document.max' => 'Le document ne doit pas dépasser 5MB.',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'video_url' => $request->video_url,
            'is_published' => $request->has('is_published'),
        ];

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news/images', 'public');
            $data['image'] = $imagePath;
        }

        // Gestion du document
        if ($request->hasFile('document')) {
            // Supprimer l'ancien document
            if ($news->document) {
                Storage::disk('public')->delete($news->document);
            }
            $documentPath = $request->file('document')->store('news/documents', 'public');
            $data['document'] = $documentPath;
        }

        // Date de publication si publié
        if ($request->has('is_published') && !$news->is_published) {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité mise à jour avec succès !');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Supprimer les fichiers associés
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        if ($news->document) {
            Storage::disk('public')->delete($news->document);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité supprimée avec succès !');
    }

    public function togglePublish($id)
    {
        $news = News::findOrFail($id);
        
        $news->update([
            'is_published' => !$news->is_published,
            'published_at' => !$news->is_published ? now() : null,
        ]);

        $status = $news->is_published ? 'publiée' : 'dépubliée';
        return redirect()->route('admin.news.index')
            ->with('success', "Actualité {$status} avec succès !");
    }
}

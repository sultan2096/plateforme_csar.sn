<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    public function index()
    {
        $images = GalleryImage::orderByDesc('created_at')->paginate(20);
        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        $categories = GalleryImage::getCategories();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'file' => 'required|image|max:4096',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('gallery', 'public');
            
            $imageData = [
                'title' => $data['title'],
                'category' => $data['category'] ?? 'Autre',
                'description' => $data['description'],
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'alt_text' => $data['title'] ?? $file->getClientOriginalName(),
                'status' => 'active'
            ];

            GalleryImage::create($imageData);
            
            return redirect()->route('admin.gallery.index')
                ->with('success', 'Image ajoutée à la galerie avec succès !');
        }

        return back()->withErrors(['file' => 'Aucun fichier sélectionné.']);
    }

    public function show(GalleryImage $galleryImage)
    {
        return view('admin.gallery.show', ['image' => $galleryImage]);
    }

    public function edit(GalleryImage $galleryImage)
    {
        $categories = GalleryImage::getCategories();
        return view('admin.gallery.edit', compact('galleryImage', 'categories'));
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'file' => 'nullable|image|max:4096',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
        ]);

        $updateData = [
            'title' => $data['title'],
            'category' => $data['category'] ?? 'Autre',
            'description' => $data['description'],
            'alt_text' => $data['title'] ?? $galleryImage->file_name
        ];

        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier
            if ($galleryImage->file_path) {
                Storage::disk('public')->delete($galleryImage->file_path);
            }
            
            $file = $request->file('file');
            $filePath = $file->store('gallery', 'public');
            
            $updateData['file_path'] = $filePath;
            $updateData['file_name'] = $file->getClientOriginalName();
            $updateData['file_size'] = $file->getSize();
            $updateData['file_type'] = $file->getMimeType();
        }

        $galleryImage->update($updateData);
        
        return redirect()->route('admin.gallery.index')
            ->with('success', 'Image modifiée avec succès !');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        // Supprimer le fichier physique
        if ($galleryImage->file_path) {
            Storage::disk('public')->delete($galleryImage->file_path);
        }
        
        $galleryImage->delete();
        
        return redirect()->route('admin.gallery.index')
            ->with('success', 'Image supprimée avec succès !');
    }

    /**
     * Toggle le statut d'une image (active/inactive)
     */
    public function toggleStatus(GalleryImage $galleryImage)
    {
        $galleryImage->update([
            'status' => $galleryImage->status === 'active' ? 'inactive' : 'active'
        ]);

        return back()->with('success', 'Statut de l\'image mis à jour !');
    }

    /**
     * Toggle le statut "en vedette" d'une image
     */
    public function toggleFeatured(GalleryImage $galleryImage)
    {
        $galleryImage->update([
            'is_featured' => !$galleryImage->is_featured
        ]);

        return back()->with('success', 'Statut "en vedette" mis à jour !');
    }
}

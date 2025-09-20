<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class HomeBackgroundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Affiche la liste des images de fond
     */
    public function index()
    {
        $backgrounds = HomeBackground::orderBy('display_order')->get();
        return view('admin.backgrounds.index', compact('backgrounds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Affiche le formulaire de création d'une nouvelle image de fond
     */
    public function create()
    {
        return view('admin.backgrounds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Enregistre une nouvelle image de fond
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Traitement de l'image
        $path = $request->file('image')->store('backgrounds', 'public');

        // Création de l'enregistrement
        HomeBackground::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $path,
            'is_active' => $request->has('is_active'),
            'display_order' => $request->display_order ?? 0
        ]);

        return redirect()->route('admin.backgrounds.index')
            ->with('success', 'Image de fond ajoutée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Affiche les détails d'une image de fond
     */
    public function show(string $id)
    {
        $background = HomeBackground::findOrFail($id);
        return view('admin.backgrounds.show', compact('background'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Affiche le formulaire d'édition d'une image de fond
     */
    public function edit(string $id)
    {
        $background = HomeBackground::findOrFail($id);
        return view('admin.backgrounds.edit', compact('background'));
    }

    /**
     * Met à jour l'ordre d'affichage des images de fond
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:home_backgrounds,id'
        ]);

        foreach ($request->order as $index => $id) {
            HomeBackground::where('id', $id)->update(['display_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
    /**
     * Met à jour une image de fond existante
     */
    public function update(Request $request, string $id)
    {
        $background = HomeBackground::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'display_order' => $request->display_order ?? $background->display_order
        ];

        // Mise à jour de l'image si une nouvelle est fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($background->image_path && Storage::disk('public')->exists($background->image_path)) {
                Storage::disk('public')->delete($background->image_path);
            }
            $data['image_path'] = $request->file('image')->store('backgrounds', 'public');
        }

        $background->update($data);

        return redirect()->route('admin.backgrounds.index')
            ->with('success', 'Image de fond mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Supprime une image de fond
     */
    public function destroy(string $id)
    {
        $background = HomeBackground::findOrFail($id);
        
        // Supprimer le fichier image s'il existe
        if ($background->image_path && Storage::disk('public')->exists($background->image_path)) {
            Storage::disk('public')->delete($background->image_path);
        }
        
        $background->delete();
        
        return redirect()->route('admin.backgrounds.index')
            ->with('success', 'Image de fond supprimée avec succès !');
    }
}

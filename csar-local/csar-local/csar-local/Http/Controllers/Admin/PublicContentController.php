<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicContent;
use Illuminate\Http\Request;

class PublicContentController extends Controller
{
    public function index()
    {
        // Construire une map avec plusieurs alias de clés pour compatibilité:
        // - section.key_name (ex: about.agents_count)
        // - key_name (ex: agents_count)
        // - about_{key_name} si section=about (ex: about_agents_count)
        $map = collect();
        foreach (PublicContent::orderByDesc('updated_at')->get() as $c) {
            // brut
            $map->put($c->key_name, $c);
            // section.key
            if (!empty($c->section)) {
                $map->put($c->section . '.' . $c->key_name, $c);
                if ($c->section === 'about' && strpos($c->key_name, 'about_') !== 0) {
                    $map->put('about_' . $c->key_name, $c);
                }
            }
        }
        $contents = $map;
        return view('admin.public-content.index', compact('contents'));
    }

    public function edit($key)
    {
        $content = PublicContent::where('key', $key)->firstOrFail();
        
        return view('admin.public-content.edit', compact('content'));
    }

    public function update(Request $request, $key)
    {
        $content = PublicContent::where('key', $key)->firstOrFail();
        
        $request->validate([
            'value' => 'required|string',
            'description' => 'nullable|string',
        ], [
            'value.required' => 'La valeur est requise.',
        ]);

        $content->update([
            'value' => $request->value,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.public-content.index')->with('success', 'Contenu mis à jour avec succès !');
    }

    public function updateInstitution(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'mission' => 'required|string',
            'vision' => 'required|string',
            'values' => 'required|string',
        ]);

        // Mettre à jour ou créer chaque champ de contenu institutionnel
        $fields = [
            'title' => $request->title,
            'description' => $request->description,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'values' => $request->values,
        ];

        foreach ($fields as $key => $value) {
            PublicContent::updateOrCreate(
                ['section' => 'institution', 'key' => $key],
                ['value' => $value, 'type' => $key === 'values' ? 'text' : 'html']
            );
        }

        return redirect()->back()->with('success', 'Contenu institutionnel mis à jour avec succès !');
    }

    public function updateAboutPage(Request $request)
    {
        $request->validate([
            'agents_count' => 'required|integer|min:0',
            'warehouses_count' => 'required|integer|min:0',
            'capacity_tonnes' => 'required|integer|min:0',
            'regions_count' => 'required|integer|min:1|max:14',
            'years_experience' => 'required|integer|min:1',
        ], [
            'agents_count.required' => 'Le nombre d\'agents est requis.',
            'agents_count.integer' => 'Le nombre d\'agents doit être un nombre entier.',
            'warehouses_count.required' => 'Le nombre d\'entrepôts est requis.',
            'warehouses_count.integer' => 'Le nombre d\'entrepôts doit être un nombre entier.',
            'capacity_tonnes.required' => 'La capacité en tonnes est requise.',
            'capacity_tonnes.integer' => 'La capacité doit être un nombre entier.',
            'regions_count.required' => 'Le nombre de régions est requis.',
            'regions_count.integer' => 'Le nombre de régions doit être un nombre entier.',
            'regions_count.min' => 'Le nombre de régions doit être au moins 1.',
            'regions_count.max' => 'Le nombre de régions ne peut pas dépasser 14.',
            'years_experience.required' => 'Le nombre d\'années d\'expérience est requis.',
            'years_experience.integer' => 'Le nombre d\'années doit être un nombre entier.',
        ]);

        // 1) Mettre à jour les contenus (schéma central unique)
        $this->updateContent('about', 'agents_count', $request->agents_count);
        $this->updateContent('about', 'warehouses_count', $request->warehouses_count);
        $this->updateContent('about', 'capacity_count', $request->capacity_tonnes);
        $this->updateContent('about', 'regions_count', $request->regions_count);
        $this->updateContent('about', 'experience_count', $request->years_experience);

        // 2) Nettoyage des anciennes clés pour éviter toute ambiguïté d'affichage
        $this->purgeLegacyAboutKeys();

        // 3) Purge des caches (dev) pour refléter tout de suite
        try {
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch (\Throwable $e) {
            // ignore
        }

        return redirect()->route('admin.public-content.index')->with('success', 'Page "À propos" mise à jour avec succès !');
    }

    public function updateInstitutionPage(Request $request)
    {
        $request->validate([
            'magasins_count' => 'required|integer|min:0',
            'regions_count' => 'required|integer|min:1|max:14',
            'functionnaires_count' => 'required|integer|min:0',
            'budget_annuel' => 'required|string',
        ], [
            'magasins_count.required' => 'Le nombre de magasins est requis.',
            'magasins_count.integer' => 'Le nombre de magasins doit être un nombre entier.',
            'regions_count.required' => 'Le nombre de régions est requis.',
            'regions_count.integer' => 'Le nombre de régions doit être un nombre entier.',
            'functionnaires_count.required' => 'Le nombre de fonctionnaires est requis.',
            'functionnaires_count.integer' => 'Le nombre de fonctionnaires doit être un nombre entier.',
            'budget_annuel.required' => 'Le budget annuel est requis.',
        ]);

        // Mettre à jour les contenus de la page Institution (section = 'institution')
        $this->updateContent('institution', 'magasins_count', $request->magasins_count);
        $this->updateContent('institution', 'regions_count', $request->regions_count);
        $this->updateContent('institution', 'functionnaires_count', $request->functionnaires_count);
        $this->updateContent('institution', 'budget_annuel', $request->budget_annuel);

        return redirect()->route('admin.public-content.index')->with('success', 'Page "Institution" mise à jour avec succès !');
    }

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document_type' => 'required|in:pdf,video,image',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
        ], [
            'document_type.required' => 'Le type de document est requis.',
            'document_type.in' => 'Le type de document doit être pdf, video ou image.',
            'title.required' => 'Le titre est requis.',
            'file.required' => 'Le fichier est requis.',
            'file.max' => 'Le fichier ne doit pas dépasser 10MB.',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public-content/' . $request->document_type, 'public');
            
            // Créer un nouveau contenu pour le document
            PublicContent::create([
                'key' => 'document_' . time(),
                'value' => $path,
                'description' => $request->description,
                'type' => $request->document_type,
                'title' => $request->title,
            ]);

            return redirect()->route('admin.public-content.index')->with('success', 'Document uploadé avec succès !');
        }

        return back()->withErrors(['file' => 'Erreur lors du téléchargement du fichier.']);
    }

    private function updateContent(string $section, string $keyName, $value): void
    {
        PublicContent::updateOrCreate(
            ['section' => $section, 'key_name' => $keyName],
            ['value' => (string)$value, 'type' => 'text', 'is_active' => true]
        );
    }

    /**
     * Supprime les anciennes variantes de clés pour la section about
     */
    private function purgeLegacyAboutKeys(): void
    {
        $legacyInSection = [
            'about_agents_count',
            'about_warehouses_count',
            'about_capacity_tonnes',
            'about_regions_count',
            'about_years_experience',
        ];

        \App\Models\PublicContent::where('section', 'about')
            ->whereIn('key_name', $legacyInSection)
            ->delete();

        // Anciennes lignes sans section
        $central = ['agents_count','warehouses_count','capacity_count','regions_count','experience_count'];
        \App\Models\PublicContent::whereNull('section')
            ->whereIn('key_name', $central)
            ->delete();
    }
}

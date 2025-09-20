<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpeechController extends Controller
{
    public function index()
    {
        $speeches = Speech::orderByDesc('date')->paginate(10);
        return view('admin.speeches.index', compact('speeches'));
    }

    public function create()
    {
        return view('admin.speeches.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'author' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'portrait' => 'nullable|image|max:2048',
            'date' => 'nullable|date',
        ]);

        if ($request->hasFile('portrait')) {
            $data['portrait'] = $request->file('portrait')->store('portraits', 'public');
        }

        Speech::create($data);
        return redirect()->route('admin.speeches.index')->with('success', 'Discours ajouté !');
    }

    public function show(Speech $speech)
    {
        return view('admin.speeches.show', compact('speech'));
    }

    public function edit(Speech $speech)
    {
        return view('admin.speeches.edit', compact('speech'));
    }

    public function update(Request $request, Speech $speech)
    {
        $data = $request->validate([
            'author' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'portrait' => 'nullable|image|max:2048',
            'date' => 'nullable|date',
        ]);

        if ($request->hasFile('portrait')) {
            if ($speech->portrait) {
                Storage::disk('public')->delete($speech->portrait);
            }
            $data['portrait'] = $request->file('portrait')->store('portraits', 'public');
        }

        $speech->update($data);
        return redirect()->route('admin.speeches.index')->with('success', 'Discours modifié !');
    }

    public function destroy(Speech $speech)
    {
        if ($speech->portrait) {
            Storage::disk('public')->delete($speech->portrait);
        }
        $speech->delete();
        return redirect()->route('admin.speeches.index')->with('success', 'Discours supprimé !');
    }
}

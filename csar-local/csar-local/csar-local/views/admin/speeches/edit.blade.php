@extends('layouts.admin')

@section('title', 'Modifier le discours')
@section('page-title', 'Modifier le discours officiel')
@section('page-subtitle', $speech->author)

@section('content')
@if($errors->any())
    <div class="admin-card" style="background-color: #fee2e2; border-left: 4px solid #dc2626;">
        <ul style="color: #991b1b; margin: 0; padding-left: 1rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="admin-card">
    <form action="{{ route('admin.speeches.update', $speech) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="admin-grid admin-grid-2">
            <div>
                <label for="author">Auteur *</label>
                <input type="text" id="author" name="author" value="{{ old('author', $speech->author) }}" required class="form-input">
            </div>
            <div>
                <label for="title">Titre *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $speech->title) }}" required class="form-input">
            </div>
            <div>
                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="{{ old('date', $speech->date) }}" class="form-input">
            </div>
            <div>
                <label for="portrait">Portrait (photo)</label>
                @if($speech->portrait)
                    <div style="margin-bottom: 0.5rem;"><img src="{{ asset('storage/'.$speech->portrait) }}" alt="Portrait" style="max-width: 80px; border-radius: 8px;"></div>
                @endif
                <input type="file" id="portrait" name="portrait" class="form-input" accept="image/*">
            </div>
        </div>
        <div style="margin-top: 1.5rem;">
            <label for="excerpt">Extrait (citation)</label>
            <textarea id="excerpt" name="excerpt" rows="2" class="form-input">{{ old('excerpt', $speech->excerpt) }}</textarea>
        </div>
        <div style="margin-top: 1.5rem;">
            <label for="content">Contenu complet *</label>
            <textarea id="content" name="content" rows="8" required class="form-input">{{ old('content', $speech->content) }}</textarea>
        </div>
        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="admin-btn">💾 Enregistrer</button>
            <a href="{{ route('admin.speeches.index') }}" class="admin-btn-secondary">❌ Annuler</a>
        </div>
    </form>
</div>
@endsection 
@extends('layouts.admin')

@section('title', 'Modifier l\'image de fond : ' . $background->title)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier l'image de fond</h1>
        <a href="{{ route('admin.backgrounds.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.backgrounds.update', $background->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Titre *</label>
                            <input type="text" name="title" id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $background->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description', $background->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" 
                                       name="is_active" value="1" 
                                       {{ old('is_active', $background->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Image active</label>
                            </div>
                            <small class="form-text text-muted">Décochez pour désactiver cette image de fond.</small>
                        </div>

                        <div class="form-group">
                            <label for="display_order">Ordre d'affichage</label>
                            <input type="number" name="display_order" id="display_order" 
                                   class="form-control @error('display_order') is-invalid @enderror" 
                                   value="{{ old('display_order', $background->display_order) }}" min="0">
                            @error('display_order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Définit l'ordre d'affichage des images (plus le nombre est petit, plus l'image apparaîtra en haut).</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image actuelle</label>
                            <div class="mb-3">
                                <img src="{{ $background->image_url }}" alt="{{ $background->title }}" 
                                     class="img-fluid rounded" style="max-height: 200px; width: auto;">
                            </div>
                            
                            <label for="image">Changer l'image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                <label class="custom-file-label" for="image">Choisir un nouveau fichier</label>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Laissez vide pour conserver l'image actuelle. Format recommandé : 1920x1080px. Taille maximale : 5MB.</small>
                            
                            <div class="mt-3 text-center">
                                <img id="image-preview" src="#" alt="Aperçu de la nouvelle image" 
                                     class="img-fluid d-none" style="max-height: 200px; width: auto;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <a href="{{ route('admin.backgrounds.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Aperçu de la nouvelle image avant upload
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('image-preview');
        const label = document.querySelector('.custom-file-label');
        
        if (file) {
            // Mettre à jour le label avec le nom du fichier
            label.textContent = file.name;
            
            // Afficher l'aperçu de la nouvelle image
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            label.textContent = 'Choisir un fichier';
            preview.src = '#';
            preview.classList.add('d-none');
        }
    });
    
    // Validation du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        const fileInput = document.getElementById('image');
        const file = fileInput.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (file && file.size > maxSize) {
            e.preventDefault();
            alert('La taille du fichier ne doit pas dépasser 5MB.');
            return false;
        }
        
        return true;
    });
</script>
@endpush

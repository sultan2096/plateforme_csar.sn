@extends('layouts.admin')

@section('title', 'Gestion des images de fond')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des images de fond</h1>
        <a href="{{ route('admin.backgrounds.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une image
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($backgrounds->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="backgrounds-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Titre</th>
                                <th>Statut</th>
                                <th>Ordre</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            @foreach($backgrounds as $background)
                                <tr data-id="{{ $background->id }}">
                                    <td>
                                        <div class="bg-image" style="background-image: url('{{ $background->image_url }}');
                                            width: 100px; height: 60px; background-size: cover; background-position: center;">
                                        </div>
                                    </td>
                                    <td>{{ $background->title }}</td>
                                    <td>
                                        <span class="badge {{ $background->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $background->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="handle">
                                            <i class="fas fa-arrows-alt-v"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.backgrounds.edit', $background->id) }}" 
                                           class="btn btn-sm btn-primary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.backgrounds.destroy', $background->id) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette image de fond ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    Aucune image de fond n'a été trouvée.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .handle {
        cursor: move;
        cursor: -webkit-grabbing;
        color: #ccc;
    }
    .sortable-ghost {
        opacity: 0.5;
        background: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortable = new Sortable(document.getElementById('sortable'), {
            handle: '.handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                const itemEl = evt.item;
                const itemId = itemEl.dataset.id;
                const newIndex = evt.newIndex;
                
                const order = [];
                document.querySelectorAll('#sortable tr').forEach((row, index) => {
                    order.push({
                        id: row.dataset.id,
                        position: index + 1
                    });
                });
                
                // Envoyer la nouvelle commande au serveur
                fetch('{{ route("admin.backgrounds.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order.map(item => item.id) })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Rafraîchir la page pour refléter les changements
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la mise à jour de l\'ordre :', error);
                    // Recharger la page en cas d'erreur
                    window.location.reload();
                });
            }
        });
    });
</script>
@endpush

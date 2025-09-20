@extends('layouts.admin')

@section('title', 'Agenda hebdomadaire')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-start mb-3">
    <div>
      <h2 class="fw-bold">Agenda hebdomadaire</h2>
      <p class="text-secondary mb-0">Vue liste (calendrier à venir)</p>
    </div>
    <a href="{{ route('admin.weekly-agendas.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Nouvel agenda</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Période</th>
            <th>Titre</th>
            <th>Actif</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($agendas as $agenda)
          <tr>
            <td>{{ optional($agenda->week_start)->format('d/m/Y') }} — {{ optional($agenda->week_end)->format('d/m/Y') }}</td>
            <td>{{ $agenda->title }}</td>
            <td>@if($agenda->is_active)<span class="badge bg-success">Oui</span>@else<span class="badge bg-secondary">Non</span>@endif</td>
            <td class="d-flex gap-2">
              <a href="{{ route('admin.weekly-agendas.show', $agenda) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
              <a href="{{ route('admin.weekly-agendas.edit', $agenda) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{ route('admin.weekly-agendas.destroy', $agenda) }}" onsubmit="return confirm('Supprimer cet agenda ?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted py-4">Aucun agenda pour le moment.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3">{{ $agendas->links() }}</div>
  </div>
</div>
@endsection





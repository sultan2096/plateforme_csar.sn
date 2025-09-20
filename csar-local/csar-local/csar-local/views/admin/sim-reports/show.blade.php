@extends('layouts.admin')

@section('title', 'Détail du Rapport SIM')

@section('content')
<style>
.sim-show{max-width:1200px;margin:0 auto;padding:2rem}
.show-header{background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;padding:2rem;border-radius:1rem;margin-bottom:2rem;box-shadow:0 10px 25px rgba(15,23,42,.3)}
.show-header h1{font-size:2rem;font-weight:800;margin:0 0 .25rem;background:linear-gradient(135deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.show-card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;box-shadow:0 4px 15px rgba(0,0,0,.06);padding:1.5rem}
.meta{color:#475569}
.badge-published{background:#dcfce7;color:#166534;padding:.35rem .6rem;border-radius:999px;font-weight:700}
.badge-draft{background:#e5e7eb;color:#374151;padding:.35rem .6rem;border-radius:999px;font-weight:700}
</style>
<div class="sim-show">
  <div class="show-header">
    <h1>{{ $simReport->title }}</h1>
    <p class="meta">Période: {{ $simReport->period }} • Date: {{ optional($simReport->report_date)->format('d/m/Y') }}</p>
    <div>
      @if($simReport->is_published)
        <span class="badge-published">Publié</span>
      @else
        <span class="badge-draft">Brouillon</span>
      @endif
    </div>
  </div>

  <div class="show-card mb-3">
    <h5 class="fw-bold mb-2">Résumé</h5>
    <p>{{ $simReport->summary ?: '—' }}</p>
  </div>

  <div class="show-card mb-3">
    <h5 class="fw-bold mb-2">Contexte et objectifs</h5>
    <p>{{ $simReport->context_objectives ?: '—' }}</p>
  </div>

  <div class="show-card mb-3">
    <h5 class="fw-bold mb-2">Méthodologie</h5>
    <p>{{ $simReport->methodology ?: '—' }}</p>
  </div>

  <div class="d-flex gap-2">
    <a href="{{ route('admin.sim-reports.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
    <a href="{{ route('admin.sim-reports.edit', $simReport) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</a>
    @if($simReport->document_file)
      <a href="{{ Storage::url($simReport->document_file) }}" target="_blank" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Voir le PDF</a>
    @endif
    @if($simReport->cover_image)
      <a href="{{ Storage::url($simReport->cover_image) }}" target="_blank" class="btn btn-success"><i class="fas fa-image"></i> Voir l'image</a>
    @endif
  </div>
</div>
@endsection




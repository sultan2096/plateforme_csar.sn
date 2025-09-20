@extends('layouts.admin')

@section('title', 'Modifier un Rapport SIM')

@section('content')
<style>
.edit-sim-container{max-width:1200px;margin:0 auto;padding:2rem}
.edit-header{background:linear-gradient(135deg,#0f172a 0%, #1e293b 100%);color:#fff;padding:2rem;border-radius:1rem;margin-bottom:2rem;box-shadow:0 10px 25px rgba(15,23,42,0.3);position:relative;overflow:hidden}
.edit-header::before{content:'';position:absolute;inset:0;opacity:.25;background:url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');pointer-events:none}
.edit-header > *{position:relative;z-index:1}
.edit-header h1{font-size:2.2rem;font-weight:700;margin:0 0 .5rem;background:linear-gradient(135deg,#60a5fa 0%, #a78bfa 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.form-container{background:#fff;border:1px solid rgba(15,23,42,.1);border-radius:1rem;padding:2rem;box-shadow:0 4px 15px rgba(0,0,0,.06)}
</style>

<div class="edit-sim-container">
  <div class="edit-header">
    <h1>✏️ Modifier le Rapport SIM</h1>
    <p>Mettre à jour les informations et pièces jointes</p>
    <div class="mt-2">
      <a href="{{ route('admin.sim-reports.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
    </div>
  </div>

  <div class="form-container">
    <form action="{{ route('admin.sim-reports.update', $report) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Titre *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $report->title) }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Période *</label>
            <input type="text" name="period" class="form-control" value="{{ old('period', $report->period) }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Date *</label>
            <input type="date" name="report_date" class="form-control" value="{{ old('report_date', optional($report->report_date)->format('Y-m-d')) }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Statut *</label>
            <select name="status" class="form-control" required>
              @php($st = old('status', $report->status))
              <option value="draft" {{ $st=='draft'?'selected':'' }}>Brouillon</option>
              <option value="review" {{ $st=='review'?'selected':'' }}>En révision</option>
              <option value="published" {{ $st=='published'?'selected':'' }}>Publié</option>
              <option value="archived" {{ $st=='archived'?'selected':'' }}>Archivé</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Nouveau PDF</label>
            <input type="file" name="document_file" class="form-control" accept=".pdf">
            @if($report->document_file)
              <small class="text-muted d-block mt-1">PDF actuel: <a href="{{ Storage::url($report->document_file) }}" target="_blank">ouvrir</a></small>
            @endif
          </div>
          <div class="form-group">
            <label class="form-label">Nouvelle image de couverture</label>
            <input type="file" name="cover_image" class="form-control" accept="image/*">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Résumé</label>
        <textarea name="summary" rows="3" class="form-control">{{ old('summary', $report->summary) }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Contexte et objectifs</label>
        <textarea name="context_objectives" rows="5" class="form-control">{{ old('context_objectives', $report->context_objectives) }}</textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Méthodologie</label>
        <textarea name="methodology" rows="4" class="form-control">{{ old('methodology', $report->methodology) }}</textarea>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Enregistrer</button>
        <a href="{{ route('admin.sim-reports.show', $report) }}" class="btn btn-outline-secondary">Aperçu</a>
      </div>
    </form>
  </div>
</div>
@endsection




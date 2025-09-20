@extends('layouts.admin')

@section('title', 'Détail de la Demande - Administration CSAR')

@section('content')
<style>
.request-show-container { max-width: 1100px; margin: 0 auto; padding: 1.5rem; }
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.header-left { display: flex; align-items: center; gap: 0.75rem; }
.badge-status { display: inline-flex; align-items: center; gap: 0.5rem; padding: .35rem .7rem; border-radius: 999px; font-weight: 600; font-size: .875rem; }
.badge-pending { background: #fef3c7; color: #b45309; }
.badge-approved { background: #dcfce7; color: #166534; }
.badge-rejected { background: #fee2e2; color: #991b1b; }
.badge-completed { background: #dbeafe; color: #1d4ed8; }
.card { background: #fff; border-radius: 14px; border: 1px solid #eef2f7; box-shadow: 0 6px 20px rgba(0,0,0,.06); }
.card + .card { margin-top: 1rem; }
.card-body { padding: 1.25rem 1.5rem; }
.info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem; }
.info-item { display: flex; gap: .75rem; align-items: flex-start; color: #374151; }
.info-item i { color: #6b7280; margin-top: .15rem; }
.section-title { font-weight: 700; color: #0f172a; margin-bottom: .75rem; display: flex; gap: .5rem; align-items: center; }
.actions { display: flex; flex-wrap: wrap; gap: .5rem; }
.btn { display: inline-flex; align-items: center; gap: .5rem; padding: .6rem .9rem; border-radius: 10px; border: 1px solid transparent; text-decoration: none; font-weight: 600; }
.btn-outline { border-color: #e5e7eb; color: #374151; background: #fff; }
.btn-primary { background: #2563eb; color: #fff; }
.btn-success { background: #16a34a; color: #fff; }
.btn-danger { background: #dc2626; color: #fff; }
.btn-warning { background: #d97706; color: #fff; }
.meta { color: #6b7280; font-size: .9rem; }
.divider { height: 1px; background: #eef2f7; margin: .75rem 0; }
@media (max-width: 640px) { .page-header { flex-direction: column; align-items: flex-start; gap: .75rem; } }
</style>

<div class="request-show-container">
	<div class="page-header">
		<div class="header-left">
			<a href="{{ route('admin.requests.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Retour</a>
			<h2 style="margin:0; font-weight:800; color:#111827;">Détail de la Demande</h2>
		</div>
		<div>
			<a href="{{ route('admin.requests.export-pdf', $request) }}" class="btn btn-outline"><i class="fas fa-file-pdf"></i> Export PDF</a>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<div style="display:flex; justify-content: space-between; align-items:center; gap: 1rem; flex-wrap: wrap;">
				<div>
					<h3 style="margin:0; font-weight:800; color:#1f2937;">{{ $request->full_name }}</h3>
					<div class="meta">Code: <strong>{{ $request->tracking_code }}</strong> • {{ $request->type }} • {{ $request->region }}</div>
				</div>
				<div>
					@php($status = $request->status)
					<span class="badge-status {{ 'badge-' . $status }}">
						<i class="fas {{ $status === 'pending' ? 'fa-clock' : ($status === 'approved' ? 'fa-check' : ($status === 'completed' ? 'fa-check-double' : 'fa-times')) }}"></i>
						{{ ucfirst($status) === 'Pending' ? 'En attente' : (ucfirst($status) === 'Approved' ? 'Approuvée' : (ucfirst($status) === 'Completed' ? 'Terminée' : 'Rejetée')) }}
					</span>
				</div>
			</div>
			<div class="divider"></div>
			<div class="info-grid">
				<div class="info-item"><i class="fas fa-envelope"></i><div><div class="meta">Email</div><div>{{ $request->email ?? '—' }}</div></div></div>
				<div class="info-item"><i class="fas fa-phone"></i><div><div class="meta">Téléphone</div><div>{{ $request->phone ?? '—' }}</div></div></div>
				<div class="info-item"><i class="fas fa-map-marker-alt"></i><div><div class="meta">Adresse</div><div>{{ $request->address ?? '—' }}</div></div></div>
				<div class="info-item"><i class="fas fa-calendar"></i><div><div class="meta">Soumise le</div><div>{{ optional($request->created_at)->format('d/m/Y H:i') }}</div></div></div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<h4 class="section-title"><i class="fas fa-align-left"></i> Description</h4>
			<p style="margin:0; color:#1f2937; line-height:1.6;">{{ $request->description }}</p>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<h4 class="section-title"><i class="fas fa-tools"></i> Actions</h4>
			<div class="actions">
				@if($request->status !== 'approved')
					<form method="POST" action="{{ route('admin.requests.update-status', $request) }}">@csrf @method('PATCH')
						<input type="hidden" name="status" value="approved">
						<button class="btn btn-success" type="submit"><i class="fas fa-check"></i> Approuver</button>
					</form>
				@endif
				@if($request->status !== 'rejected')
					<form method="POST" action="{{ route('admin.requests.update-status', $request) }}">@csrf @method('PATCH')
						<input type="hidden" name="status" value="rejected">
						<button class="btn btn-danger" type="submit"><i class="fas fa-times"></i> Rejeter</button>
					</form>
				@endif
				@if($request->status !== 'completed')
					<form method="POST" action="{{ route('admin.requests.update-status', $request) }}">@csrf @method('PATCH')
						<input type="hidden" name="status" value="completed">
						<button class="btn btn-primary" type="submit"><i class="fas fa-check-double"></i> Terminer</button>
					</form>
				@endif
				<a href="{{ route('admin.requests.edit', $request) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Modifier</a>
			</div>
		</div>
	</div>
</div>
@endsection




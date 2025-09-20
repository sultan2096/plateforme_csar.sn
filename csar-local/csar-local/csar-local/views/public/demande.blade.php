@extends('layouts.public')
@section('title', 'Formulaire de demande - CSAR')
@section('content')
<div style="max-width:650px;margin:40px auto 60px auto;background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.07);padding:38px 24px 28px 24px;">
    <h1 style="font-size:2rem;font-weight:800;margin-bottom:4px;color:#0d9488;">Formulaire de demande</h1>
    <div style="font-size:1.1rem;color:#0284c7;margin-bottom:22px;">Demande d'aide alimentaire ou matérielle</div>
    @if(session('success'))
    <div style="background:#dcfce7;color:#166534;border-radius:8px;padding:18px 22px;margin-bottom:22px;font-weight:600;box-shadow:0 2px 8px rgba(34,197,94,0.08);">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i> {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div style="background:#fee2e2;color:#991b1b;border-radius:8px;padding:14px 18px;margin-bottom:20px;font-weight:500;box-shadow:0 2px 8px rgba(220,38,38,0.08);">
        <ul style="margin:0;padding-left:1rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('demande.store') }}" id="demandeForm" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <fieldset style="border:none;padding:0;margin-bottom:26px;">
            <legend style="font-size:1.02rem;font-weight:700;color:#0284c7;margin-bottom:12px;">Informations personnelles</legend>
            <label for="nom" style="font-weight:600;">Nom *</label>
            <input type="text" name="nom" id="nom" required maxlength="255" value="{{ old('nom') }}" placeholder="Votre nom" style="width:100%;padding:8px 10px;margin:4px 0 12px 0;border:1px solid #cbd5e1;border-radius:6px;">
            <label for="prenom" style="font-weight:600;">Prénom *</label>
            <input type="text" name="prenom" id="prenom" required maxlength="255" value="{{ old('prenom') }}" placeholder="Votre prénom" style="width:100%;padding:8px 10px;margin:4px 0 12px 0;border:1px solid #cbd5e1;border-radius:6px;">
            <label for="email" style="font-weight:600;">Email *</label>
            <input type="email" name="email" id="email" required maxlength="255" value="{{ old('email') }}" placeholder="votre.email@exemple.com" style="width:100%;padding:8px 10px;margin:4px 0 12px 0;border:1px solid #cbd5e1;border-radius:6px;">
            <label for="telephone" style="font-weight:600;">Téléphone *</label>
            <input type="text" name="telephone" id="telephone" required maxlength="30" value="{{ old('telephone') }}" placeholder="+221 77 123 45 67" style="width:100%;padding:8px 10px;margin:4px 0 12px 0;border:1px solid #cbd5e1;border-radius:6px;">
        </fieldset>
        <fieldset style="border:none;padding:0;margin-bottom:26px;">
            <legend style="font-size:1.02rem;font-weight:700;color:#0284c7;margin-bottom:12px;">Détails de la demande</legend>
            <label for="objet" style="font-weight:600;">Objet de la demande *</label>
            <input type="text" name="objet" id="objet" required maxlength="255" value="{{ old('objet') }}" placeholder="Ex : Demande d’aide alimentaire" style="width:100%;padding:8px 10px;margin:4px 0 12px 0;border:1px solid #cbd5e1;border-radius:6px;">
            <label for="description" style="font-weight:600;">Description détaillée *</label>
            <textarea name="description" id="description" required maxlength="2000" placeholder="Décrivez votre demande en détail..." style="width:100%;padding:8px 10px;margin:4px 0 12px 0;border:1px solid #cbd5e1;border-radius:6px;min-height:90px;">{{ old('description') }}</textarea>
        </fieldset>
        <fieldset style="border:none;padding:0;margin-bottom:26px;">
            <legend style="font-size:1.02rem;font-weight:700;color:#0284c7;margin-bottom:12px;">Pièce jointe (optionnel)</legend>
            <input type="file" name="pj" id="pj" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.zip" style="width:100%;padding:8px 10px;margin:4px 0 12px 0;border:1px solid #cbd5e1;border-radius:6px;">
            <small style="color:#64748b;">Formats acceptés : pdf, jpg, png, doc, zip. 4 Mo max.</small>
        </fieldset>
        <fieldset style="border:none;padding:0;margin-bottom:26px;">
            <legend style="font-size:1.02rem;font-weight:700;color:#0284c7;margin-bottom:12px;">Consentement</legend>
            <label style="display:flex;align-items:center;font-weight:500;">
                <input type="checkbox" name="consentement" required style="margin-right:8px;"> J’accepte que mes données soient utilisées pour le traitement de ma demande par le CSAR.
            </label>
        </fieldset>
        <button type="submit" id="btn-submit" style="background:linear-gradient(90deg,#0d9488 0%,#0284c7 100%);color:#fff;font-weight:700;padding:10px 32px;border:none;border-radius:6px;font-size:1rem;cursor:pointer;transition:background 0.2s;">Envoyer ma demande</button>
    </form>
</div>
<script>
function activerGeoloc() {
    const btn = document.getElementById('btn-geoloc');
    const status = document.getElementById('geo-status');
    btn.disabled = true;
    status.textContent = 'Recherche de votre position...';
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('latitude').value = pos.coords.latitude;
            document.getElementById('longitude').value = pos.coords.longitude;
            status.innerHTML = '<span style="color:#16a34a;font-weight:600;">Géolocalisation activée !</span> (' + pos.coords.latitude.toFixed(5) + ', ' + pos.coords.longitude.toFixed(5) + ')';
            document.getElementById('btn-submit').disabled = false;
            document.getElementById('btn-submit').style.opacity = 1;
        }, function() {
            status.innerHTML = '<span style="color:#dc2626;font-weight:600;">Échec de la géolocalisation. Veuillez autoriser l\'accès à votre position.</span>';
            btn.disabled = false;
        });
    } else {
        status.innerHTML = '<span style="color:#dc2626;font-weight:600;">Géolocalisation non supportée par votre navigateur.</span>';
        btn.disabled = false;
    }
}
</script>
@endsection

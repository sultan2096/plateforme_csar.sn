@extends('layouts.public')

@section('title', 'Faire une demande')

@section('content')
<div class="container" style="max-width: 700px; margin: 0 auto;">
    <h1 class="section-title">Faire une demande</h1>
    <p class="section-subtitle">Remplissez le formulaire ci-dessous pour effectuer votre demande auprès du CSAR.</p>
    <form action="{{ route('request.submit') }}" method="POST" id="requestForm" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #e5e7eb; padding: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf
        <div>
            <label for="type" style="font-weight: 600;">Type de demande *</label>
            <select id="type" name="type" required class="form-input">
                <option value="">Sélectionnez un type</option>
                <option value="aide">Demande d'aide alimentaire ou matérielle</option>
                <option value="partenariat">Demande de partenariat institutionnel</option>
                <option value="audience">Demande d'audience</option>
                <option value="autre">Autre demande</option>
            </select>
        </div>
        <div>
            <label for="full_name" style="font-weight: 600;">Nom complet *</label>
            <input type="text" id="full_name" name="full_name" required class="form-input" placeholder="Votre nom et prénom">
        </div>
        <div>
            <label for="phone" style="font-weight: 600;">Téléphone *</label>
            <input type="tel" id="phone" name="phone" required class="form-input" placeholder="Numéro de téléphone">
        </div>
        <div>
            <label for="email" style="font-weight: 600;">Email</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="Adresse email (optionnel)">
        </div>
        <div>
            <label for="address" style="font-weight: 600;">Adresse *</label>
            <input type="text" id="address" name="address" required class="form-input" placeholder="Adresse complète">
        </div>
        <div>
            <label for="region" style="font-weight: 600;">Région *</label>
            <input type="text" id="region" name="region" required class="form-input" placeholder="Région de résidence">
        </div>
        <div>
            <label for="description" style="font-weight: 600;">Description de la demande *</label>
            <textarea id="description" name="description" rows="4" required class="form-input" placeholder="Expliquez votre demande"></textarea>
        </div>
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">
        <div id="geoloc-status" style="color: #059669; font-size: 0.95rem; margin-bottom: 0.5rem;"></div>
        <button type="submit" class="btn btn-primary" style="font-size: 1rem; padding: 0.75rem 2rem;">Envoyer la demande</button>
    </form>
</div>
<script>
window.addEventListener('DOMContentLoaded', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            document.getElementById('geoloc-status').textContent = 'Votre position a été détectée automatiquement.';
        }, function(error) {
            document.getElementById('geoloc-status').textContent = "La géolocalisation n'a pas pu être récupérée (vous pouvez continuer sans).";
        });
    } else {
        document.getElementById('geoloc-status').textContent = "La géolocalisation n'est pas supportée par votre navigateur.";
    }
});
</script>
@endsection 
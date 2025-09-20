@extends('layouts.admin')

@section('title', 'Paramètres de Notification')
@section('page-title', 'Paramètres de Notification')
@section('page-subtitle', 'Gérez vos préférences de notification et testez la configuration email')

@section('content')
<style>
:root {
    --primary-color: #22c55e;
    --primary-dark: #16a34a;
    --secondary-color: #3b82f6;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --dark-color: #0f172a;
    --gray-light: #f8fafc;
    --gray-medium: #6b7280;
    --gray-dark: #374151;
    --text-dark: #1f2937;
    --border-light: #e5e7eb;
    --shadow-light: 0 4px 15px rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 10px 25px rgba(0, 0, 0, 0.15);
    --shadow-heavy: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.notifications-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

/* Header */
.notifications-header {
    background: linear-gradient(135deg, var(--secondary-color) 0%, #1d4ed8 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-heavy);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.notifications-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.2;
}

.notifications-header-content {
    position: relative;
    z-index: 1;
}

.notifications-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.notifications-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

/* Layout des sections */
.notifications-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

/* Cards */
.card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-light);
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.card-icon.preferences {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
}

.card-icon.test {
    background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
}

.card-icon.config {
    background: linear-gradient(135deg, var(--secondary-color) 0%, #1d4ed8 100%);
}

.card-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
}

/* Status de configuration */
.config-status {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    border-radius: 12px;
    font-weight: 600;
}

.config-status.configured {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.config-status.not-configured {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

/* Préférences de notification */
.preference-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-light);
}

.preference-item:last-child {
    border-bottom: none;
}

.preference-info {
    flex: 1;
}

.preference-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.preference-description {
    font-size: 0.9rem;
    color: var(--gray-medium);
}

/* Toggle switch */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: var(--primary-color);
}

input:checked + .slider:before {
    transform: translateX(26px);
}

/* Formulaires */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--gray-dark);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-light);
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

/* Boutons */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    border-color: var(--primary-color);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
}

.btn-warning {
    background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
    color: white;
    border-color: var(--warning-color);
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.3);
}

.btn-secondary {
    background: white;
    color: var(--gray-medium);
    border-color: var(--border-light);
}

.btn-secondary:hover {
    border-color: var(--gray-medium);
    color: var(--gray-dark);
}

/* Informations de configuration */
.config-info {
    background: var(--gray-light);
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
}

.config-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-light);
}

.config-row:last-child {
    border-bottom: none;
}

.config-label {
    font-weight: 600;
    color: var(--gray-dark);
}

.config-value {
    color: var(--gray-medium);
    font-family: monospace;
}

/* Responsive */
@media (max-width: 768px) {
    .notifications-container {
        padding: 1rem;
    }
    
    .notifications-layout {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .card {
        padding: 1.5rem;
    }
}

/* Animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: slideInUp 0.6s ease forwards;
}

.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
.card:nth-child(4) { animation-delay: 0.4s; }
</style>

<div class="notifications-container">
    <!-- Header -->
    <div class="notifications-header">
        <div class="notifications-header-content">
            <h1>
                <i class="fas fa-bell"></i>
                Paramètres de Notification
            </h1>
            <p>Gérez vos préférences de notification et testez la configuration email</p>
        </div>
    </div>

    <!-- Layout principal -->
    <div class="notifications-layout">
        <!-- Section 1: Préférences de notification -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon preferences">
                    <i class="fas fa-cogs"></i>
                </div>
                <h3 class="card-title">Mes Préférences</h3>
            </div>

            <form action="{{ route('admin.notifications.update-preferences') }}" method="POST">
                @csrf
                
                <!-- Email global -->
                <div class="preference-item">
                    <div class="preference-info">
                        <div class="preference-label">📧 Notifications par email</div>
                        <div class="preference-description">Activer/désactiver toutes les notifications par email</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="email_enabled" {{ $preferences->email_enabled ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Assignation de tâches -->
                <div class="preference-item">
                    <div class="preference-info">
                        <div class="preference-label">📋 Assignation de tâches</div>
                        <div class="preference-description">Recevoir un email quand une tâche vous est assignée</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="task_assignments" {{ $preferences->task_assignments ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Mises à jour de demandes -->
                <div class="preference-item">
                    <div class="preference-info">
                        <div class="preference-label">📬 Mises à jour de demandes</div>
                        <div class="preference-description">Notifications de changement de statut des demandes publiques</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="request_updates" {{ $preferences->request_updates ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Alertes de prix -->
                <div class="preference-item">
                    <div class="preference-info">
                        <div class="preference-label">🚨 Alertes de prix</div>
                        <div class="preference-description">Notifications d'alertes de prix critiques</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="price_alerts" {{ $preferences->price_alerts ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Actualités -->
                <div class="preference-item">
                    <div class="preference-info">
                        <div class="preference-label">📰 Nouvelles actualités</div>
                        <div class="preference-description">Notifications de publication d'actualités</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="news_updates" {{ $preferences->news_updates ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Notifications système -->
                <div class="preference-item">
                    <div class="preference-info">
                        <div class="preference-label">⚙️ Notifications système</div>
                        <div class="preference-description">Notifications importantes du système</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="system_notifications" {{ $preferences->system_notifications ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Digest hebdomadaire -->
                <div class="preference-item">
                    <div class="preference-info">
                        <div class="preference-label">📊 Digest hebdomadaire</div>
                        <div class="preference-description">Résumé hebdomadaire des activités</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="weekly_digest" {{ $preferences->weekly_digest ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <div style="text-align: center; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Sauvegarder les préférences
                    </button>
                </div>
            </form>
        </div>

        <!-- Section 2: Test d'email -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon test">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h3 class="card-title">Test d'Email</h3>
            </div>

            <!-- Status de configuration -->
            <div class="config-status {{ $emailConfig['configured'] ? 'configured' : 'not-configured' }}">
                <i class="fas fa-{{ $emailConfig['configured'] ? 'check-circle' : 'exclamation-triangle' }}"></i>
                <span>
                    @if($emailConfig['configured'])
                        Configuration email active
                    @else
                        Configuration email non configurée
                    @endif
                </span>
            </div>

            @if($emailConfig['configured'])
                <!-- Informations de configuration -->
                <div class="config-info">
                    <div class="config-row">
                        <span class="config-label">Serveur :</span>
                        <span class="config-value">{{ $emailConfig['mailer'] }}</span>
                    </div>
                    <div class="config-row">
                        <span class="config-label">Expéditeur :</span>
                        <span class="config-value">{{ $emailConfig['from_address'] }}</span>
                    </div>
                    <div class="config-row">
                        <span class="config-label">Nom :</span>
                        <span class="config-value">{{ $emailConfig['from_name'] }}</span>
                    </div>
                </div>

                <!-- Formulaire de test -->
                <form action="{{ route('admin.notifications.test-email') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="test_email" class="form-label">📧 Email de test</label>
                        <input type="email" 
                               id="test_email" 
                               name="test_email" 
                               class="form-input" 
                               placeholder="email@exemple.com"
                               value="{{ Auth::user()->email }}"
                               required>
                    </div>
                    
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-paper-plane"></i>
                        Envoyer un email de test
                    </button>
                </form>

                <!-- Actions supplémentaires -->
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light);">
                    <form action="{{ route('admin.notifications.send-digest') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-newspaper"></i>
                            Envoyer digest hebdomadaire
                        </button>
                    </form>
                </div>
            @else
                <p style="color: var(--gray-medium); margin-bottom: 1.5rem;">
                    La configuration email n'est pas encore configurée. Utilisez notre assistant de configuration rapide pour configurer les notifications en quelques clics.
                </p>
                
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="{{ route('admin.notifications.quick-setup') }}" class="btn btn-primary">
                        <i class="fas fa-rocket"></i>
                        Configuration Rapide
                    </a>
                    <a href="{{ route('admin.notifications.email-config') }}" class="btn btn-secondary">
                        <i class="fas fa-cog"></i>
                        Guide Complet
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript pour les interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gérer les toggles de préférences
    const emailToggle = document.querySelector('input[name="email_enabled"]');
    const otherToggles = document.querySelectorAll('input[type="checkbox"]:not([name="email_enabled"])');
    
    function updateTogglesState() {
        const emailEnabled = emailToggle.checked;
        otherToggles.forEach(toggle => {
            toggle.disabled = !emailEnabled;
            toggle.parentElement.style.opacity = emailEnabled ? '1' : '0.5';
        });
    }
    
    // État initial
    updateTogglesState();
    
    // Écouter les changements
    emailToggle.addEventListener('change', updateTogglesState);
    
    console.log('✅ Page de paramètres de notification initialisée !');
});
</script>
@endsection

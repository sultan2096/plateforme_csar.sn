@extends('layouts.admin')

@section('title', 'Configuration Rapide - Notifications')
@section('page-title', 'Configuration Rapide')
@section('page-subtitle', 'Configurez rapidement les notifications email')

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

.setup-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.setup-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-heavy);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.setup-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.2;
}

.setup-header-content {
    position: relative;
    z-index: 1;
}

.setup-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.setup-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
    margin-bottom: 2rem;
}

.step {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--gray-light);
    border-radius: 15px;
    border-left: 4px solid var(--primary-color);
}

.step-number {
    background: var(--primary-color);
    color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
    font-size: 1.1rem;
}

.step-content {
    flex: 1;
}

.step-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.step-description {
    color: var(--gray-medium);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.config-example {
    background: #1f2937;
    color: #e5e7eb;
    padding: 1rem;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 1rem 0;
    position: relative;
    overflow-x: auto;
}

.copy-btn {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.7rem;
    transition: all 0.3s ease;
}

.copy-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 10px;
    margin: 1rem 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-info {
    background: rgba(59, 130, 246, 0.1);
    color: #1d4ed8;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.alert-warning {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.alert-success {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

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

.btn-secondary {
    background: white;
    color: var(--gray-medium);
    border-color: var(--border-light);
}

.btn-secondary:hover {
    border-color: var(--gray-medium);
    color: var(--gray-dark);
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

.checklist {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: var(--shadow-light);
    border: 1px solid var(--border-light);
}

.checklist-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-light);
}

.checklist-item:last-child {
    border-bottom: none;
}

.check-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    color: white;
    flex-shrink: 0;
}

.check-pending {
    background: var(--gray-medium);
}

.check-done {
    background: var(--primary-color);
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 2rem;
}

.action-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: var(--shadow-light);
    border: 1px solid var(--border-light);
    transition: all 0.3s ease;
    cursor: pointer;
}

.action-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
}

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin: 0 auto 1rem;
}

.gmail-bg {
    background: linear-gradient(135deg, #ea4335 0%, #fbbc05 100%);
}

.outlook-bg {
    background: linear-gradient(135deg, #0078d4 0%, #005a9e 100%);
}

.test-bg {
    background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
}
</style>

<div class="setup-container">
    <!-- Header -->
    <div class="setup-header">
        <div class="setup-header-content">
            <h1>
                <i class="fas fa-rocket"></i>
                Configuration Rapide
            </h1>
            <p>Configurez les notifications email en 3 étapes simples</p>
        </div>
    </div>

    <!-- Guide étape par étape -->
    <div class="setup-card">
        <h2 style="margin-bottom: 2rem; color: var(--text-dark);">🚀 Guide de Configuration</h2>

        <!-- Étape 1 -->
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-content">
                <div class="step-title">Configurer votre email</div>
                <div class="step-description">
                    Ouvrez le fichier <code>.env</code> à la racine de votre projet et ajoutez/modifiez ces lignes :
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Gmail recommandé :</strong> Utilisez un mot de passe d'application pour Gmail (plus sécurisé)
                    </div>
                </div>

                <div class="config-example">
                    <button class="copy-btn" onclick="copyConfig('gmail')">
                        <i class="fas fa-copy"></i> Copier
                    </button>
                    <div id="gmail-config">MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="votre-email@gmail.com"
MAIL_FROM_NAME="CSAR Platform"</div>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Important :</strong> Remplacez "votre-email@gmail.com" et "votre-mot-de-passe-app" par vos vraies informations !
                    </div>
                </div>
            </div>
        </div>

        <!-- Étape 2 -->
        <div class="step">
            <div class="step-number">2</div>
            <div class="step-content">
                <div class="step-title">Redémarrer le serveur</div>
                <div class="step-description">
                    Après avoir modifié le fichier .env, redémarrez votre serveur web pour appliquer les changements.
                </div>
                
                <div class="config-example">
                    <div>Arrêtez et relancez votre serveur XAMPP
ou
Relancez : demarrer_plateforme.ps1</div>
                </div>
            </div>
        </div>

        <!-- Étape 3 -->
        <div class="step">
            <div class="step-number">3</div>
            <div class="step-content">
                <div class="step-title">Tester la configuration</div>
                <div class="step-description">
                    Utilisez le bouton ci-dessous pour tester l'envoi d'email et vérifier que tout fonctionne.
                </div>
                
                <div style="margin-top: 1rem;">
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Tester maintenant
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Checklist -->
    <div class="checklist">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-dark);">✅ Checklist de Vérification</h3>
        
        <div class="checklist-item">
            <div class="check-icon check-pending" id="check-1">
                <i class="fas fa-times"></i>
            </div>
            <div>
                <strong>Fichier .env configuré</strong><br>
                <small>Paramètres SMTP ajoutés avec vos vraies informations</small>
            </div>
        </div>
        
        <div class="checklist-item">
            <div class="check-icon check-pending" id="check-2">
                <i class="fas fa-times"></i>
            </div>
            <div>
                <strong>Serveur redémarré</strong><br>
                <small>XAMPP redémarré pour appliquer les changements</small>
            </div>
        </div>
        
        <div class="checklist-item">
            <div class="check-icon check-pending" id="check-3">
                <i class="fas fa-times"></i>
            </div>
            <div>
                <strong>Email testé</strong><br>
                <small>Test d'envoi effectué avec succès</small>
            </div>
        </div>
        
        <div class="checklist-item">
            <div class="check-icon check-pending" id="check-4">
                <i class="fas fa-times"></i>
            </div>
            <div>
                <strong>Préférences configurées</strong><br>
                <small>Vos préférences de notification définies</small>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="quick-actions">
        <a class="action-card" href="https://myaccount.google.com/apppasswords" target="_blank" rel="noopener">
            <div class="action-icon gmail-bg">
                <i class="fab fa-google"></i>
            </div>
            <h4>Mot de passe Gmail</h4>
            <p>Générer un mot de passe d'application</p>
        </a>
        
        <a class="action-card" href="{{ route('admin.notifications.index') }}">
            <div class="action-icon test-bg">
                <i class="fas fa-paper-plane"></i>
            </div>
            <h4>Tester Email</h4>
            <p>Vérifier la configuration</p>
        </a>
        
        <a class="action-card" href="{{ route('admin.notifications.email-config') }}">
            <div class="action-icon outlook-bg">
                <i class="fas fa-book"></i>
            </div>
            <h4>Guide Complet</h4>
            <p>Documentation détaillée</p>
        </a>
    </div>

    <!-- Statut final -->
    <div class="alert alert-success" style="margin-top: 2rem; display: none;" id="success-alert">
        <i class="fas fa-check-circle"></i>
        <div>
            <strong>Configuration terminée !</strong> Votre système de notifications est opérationnel. 
            Les emails seront envoyés automatiquement lors des événements (création d'utilisateur, assignation de tâche, etc.).
        </div>
    </div>
</div>

<script>
// Simulation de progression
let completedSteps = 0;

function copyConfig(type) {
    const element = document.getElementById(type + '-config');
    const text = element.textContent;
    
    navigator.clipboard.writeText(text).then(function() {
        // Feedback visuel
        const copyBtn = element.parentElement.querySelector('.copy-btn');
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check"></i> Copié !';
        copyBtn.style.background = 'rgba(34, 197, 94, 0.3)';
        
        // Marquer cette étape comme terminée
        markStepCompleted(1);
        
        setTimeout(() => {
            copyBtn.innerHTML = originalText;
            copyBtn.style.background = 'rgba(255, 255, 255, 0.1)';
        }, 2000);
    }).catch(function(err) {
        console.error('Erreur lors de la copie:', err);
        alert('Impossible de copier automatiquement. Veuillez sélectionner et copier manuellement le texte.');
    });
}

function markStepCompleted(stepNumber) {
    const checkIcon = document.getElementById('check-' + stepNumber);
    if (checkIcon) {
        checkIcon.classList.remove('check-pending');
        checkIcon.classList.add('check-done');
        checkIcon.innerHTML = '<i class="fas fa-check"></i>';
        
        completedSteps++;
        
        // Si toutes les étapes sont terminées
        if (completedSteps >= 4) {
            document.getElementById('success-alert').style.display = 'flex';
        }
    }
}

// Simulation du processus
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si on revient de la page de test
    if (localStorage.getItem('email-tested') === 'true') {
        markStepCompleted(3);
        localStorage.removeItem('email-tested');
    }
    
    // Marquer automatiquement certaines étapes si applicable
    setTimeout(() => {
        // Simuler que le serveur a été redémarré après quelques secondes
        markStepCompleted(2);
    }, 3000);
});

console.log('✅ Page de configuration rapide initialisée !');
</script>
@endsection

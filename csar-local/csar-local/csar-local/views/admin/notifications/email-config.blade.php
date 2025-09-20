@extends('layouts.admin')

@section('title', 'Configuration Email - Notifications')
@section('page-title', 'Configuration Email')
@section('page-subtitle', 'Guide pour configurer les notifications par email')

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

.config-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 2rem;
}

/* Header */
.config-header {
    background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-heavy);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.config-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.2;
}

.config-header-content {
    position: relative;
    z-index: 1;
}

.config-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.config-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

/* Status actuel */
.current-status {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
}

.status-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-light);
}

.status-row:last-child {
    border-bottom: none;
}

.status-label {
    font-weight: 600;
    color: var(--gray-dark);
}

.status-value {
    font-family: monospace;
    padding: 0.5rem 1rem;
    background: var(--gray-light);
    border-radius: 8px;
    color: var(--gray-medium);
}

.status-configured {
    color: #16a34a;
    background: rgba(34, 197, 94, 0.1);
}

.status-not-configured {
    color: #dc2626;
    background: rgba(239, 68, 68, 0.1);
}

/* Tabs pour les différents providers */
.provider-tabs {
    display: flex;
    background: white;
    border-radius: 15px;
    padding: 0.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-light);
}

.tab-btn {
    flex: 1;
    padding: 1rem;
    border: none;
    background: transparent;
    cursor: pointer;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    color: var(--gray-medium);
}

.tab-btn.active {
    background: var(--primary-color);
    color: white;
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
}

.tab-btn:hover:not(.active) {
    background: var(--gray-light);
}

/* Contenu des tabs */
.tab-content {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: var(--shadow-medium);
    border: 1px solid var(--border-light);
    display: none;
}

.tab-content.active {
    display: block;
}

.provider-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.provider-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
}

.gmail-icon {
    background: linear-gradient(135deg, #ea4335 0%, #fbbc05 100%);
}

.outlook-icon {
    background: linear-gradient(135deg, #0078d4 0%, #005a9e 100%);
}

.custom-icon {
    background: linear-gradient(135deg, var(--gray-dark) 0%, var(--text-dark) 100%);
}

/* Code blocks */
.config-code {
    background: #1f2937;
    color: #e5e7eb;
    padding: 1.5rem;
    border-radius: 10px;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 1rem 0;
    position: relative;
    overflow-x: auto;
}

.copy-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.copy-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Instructions */
.instructions {
    margin: 2rem 0;
}

.instruction-step {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: var(--gray-light);
    border-radius: 10px;
}

.step-number {
    background: var(--primary-color);
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
}

.step-content {
    flex: 1;
}

.step-title {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.step-description {
    color: var(--gray-medium);
    line-height: 1.5;
}

/* Alertes */
.alert {
    padding: 1rem 1.5rem;
    border-radius: 10px;
    margin: 1rem 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-warning {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.alert-info {
    background: rgba(59, 130, 246, 0.1);
    color: #1d4ed8;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.alert-success {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.2);
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

.btn-secondary {
    background: white;
    color: var(--gray-medium);
    border-color: var(--border-light);
}

.btn-secondary:hover {
    border-color: var(--gray-medium);
    color: var(--gray-dark);
}

/* Responsive */
@media (max-width: 768px) {
    .config-container {
        padding: 1rem;
    }
    
    .provider-tabs {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .status-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>

<div class="config-container">
    <!-- Header -->
    <div class="config-header">
        <div class="config-header-content">
            <h1>
                <i class="fas fa-cog"></i>
                Configuration Email
            </h1>
            <p>Guide pour configurer les notifications par email sur votre plateforme CSAR</p>
        </div>
    </div>

    <!-- Status actuel -->
    <div class="current-status">
        <h3 style="margin-bottom: 1.5rem; color: var(--text-dark); font-weight: 700;">📊 Configuration Actuelle</h3>
        
        <div class="status-row">
            <span class="status-label">Statut :</span>
            <span class="status-value {{ $config['configured'] ? 'status-configured' : 'status-not-configured' }}">
                {{ $config['configured'] ? '✅ Configuré' : '❌ Non configuré' }}
            </span>
        </div>
        
        <div class="status-row">
            <span class="status-label">Serveur de mail :</span>
            <span class="status-value">{{ $config['mailer'] }}</span>
        </div>
        
        <div class="status-row">
            <span class="status-label">Adresse expéditeur :</span>
            <span class="status-value">{{ $config['from_address'] }}</span>
        </div>
        
        <div class="status-row">
            <span class="status-label">Nom expéditeur :</span>
            <span class="status-value">{{ $config['from_name'] }}</span>
        </div>
    </div>

    @if(!$config['configured'])
        <!-- Alertes -->
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Configuration requise :</strong> Pour activer les notifications par email, vous devez configurer les paramètres SMTP dans votre fichier .env
            </div>
        </div>
    @endif

    <!-- Tabs des providers -->
    <div class="provider-tabs">
        <button class="tab-btn active" data-tab="gmail">
            <i class="fab fa-google"></i> Gmail
        </button>
        <button class="tab-btn" data-tab="outlook">
            <i class="fab fa-microsoft"></i> Outlook
        </button>
        <button class="tab-btn" data-tab="custom">
            <i class="fas fa-server"></i> Serveur personnalisé
        </button>
    </div>

    <!-- Configuration Gmail -->
    <div class="tab-content active" id="gmail-tab">
        <div class="provider-title">
            <div class="provider-icon gmail-icon">
                <i class="fab fa-google"></i>
            </div>
            Configuration Gmail
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Note :</strong> Pour Gmail, vous devez utiliser un "Mot de passe d'application" plutôt que votre mot de passe habituel.
            </div>
        </div>

        <div class="instructions">
            <div class="instruction-step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <div class="step-title">Activer l'authentification à 2 facteurs</div>
                    <div class="step-description">Allez dans les paramètres de votre compte Google et activez l'authentification à 2 facteurs si ce n'est pas déjà fait.</div>
                </div>
            </div>

            <div class="instruction-step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <div class="step-title">Générer un mot de passe d'application</div>
                    <div class="step-description">Dans les paramètres de sécurité Google, créez un nouveau "Mot de passe d'application" pour votre plateforme CSAR.</div>
                </div>
            </div>

            <div class="instruction-step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <div class="step-title">Configurer le fichier .env</div>
                    <div class="step-description">Ajoutez les lignes suivantes dans votre fichier .env :</div>
                </div>
            </div>
        </div>

        <div class="config-code">
            <button class="copy-btn" onclick="copyToClipboard('gmail-config')">
                <i class="fas fa-copy"></i> Copier
            </button>
            <div id="gmail-config">{{ implode("\n", $envSample['gmail']) }}</div>
        </div>

        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Important :</strong> Remplacez "votre-email@gmail.com" par votre vraie adresse Gmail et "votre-mot-de-passe-app" par le mot de passe d'application généré.
            </div>
        </div>
    </div>

    <!-- Configuration Outlook -->
    <div class="tab-content" id="outlook-tab">
        <div class="provider-title">
            <div class="provider-icon outlook-icon">
                <i class="fab fa-microsoft"></i>
            </div>
            Configuration Outlook/Hotmail
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Note :</strong> Pour Outlook, vous pouvez utiliser votre mot de passe habituel si l'authentification à 2 facteurs n'est pas activée.
            </div>
        </div>

        <div class="config-code">
            <button class="copy-btn" onclick="copyToClipboard('outlook-config')">
                <i class="fas fa-copy"></i> Copier
            </button>
            <div id="outlook-config">{{ implode("\n", $envSample['outlook']) }}</div>
        </div>

        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Important :</strong> Remplacez "votre-email@outlook.com" et "votre-mot-de-passe" par vos vraies informations de connexion.
            </div>
        </div>
    </div>

    <!-- Configuration serveur personnalisé -->
    <div class="tab-content" id="custom-tab">
        <div class="provider-title">
            <div class="provider-icon custom-icon">
                <i class="fas fa-server"></i>
            </div>
            Serveur SMTP Personnalisé
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Note :</strong> Contactez votre hébergeur ou administrateur système pour obtenir les paramètres SMTP corrects.
            </div>
        </div>

        <div class="config-code">
            <button class="copy-btn" onclick="copyToClipboard('custom-config')">
                <i class="fas fa-copy"></i> Copier
            </button>
            <div id="custom-config">{{ implode("\n", $envSample['custom']) }}</div>
        </div>

        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Important :</strong> Remplacez tous les paramètres par ceux fournis par votre hébergeur.
            </div>
        </div>
    </div>

    <!-- Instructions finales -->
    <div style="background: white; border-radius: 15px; padding: 2rem; margin-top: 2rem; box-shadow: var(--shadow-medium);">
        <h3 style="color: var(--text-dark); margin-bottom: 1.5rem;">🚀 Étapes Finales</h3>
        
        <div class="instruction-step">
            <div class="step-number">1</div>
            <div class="step-content">
                <div class="step-title">Redémarrer les services</div>
                <div class="step-description">Après avoir modifié le fichier .env, redémarrez votre serveur web pour appliquer les changements.</div>
            </div>
        </div>

        <div class="instruction-step">
            <div class="step-number">2</div>
            <div class="step-content">
                <div class="step-title">Tester la configuration</div>
                <div class="step-description">Retournez sur la page des notifications et utilisez la fonction "Test d'email" pour vérifier que tout fonctionne.</div>
            </div>
        </div>

        <div class="instruction-step">
            <div class="step-number">3</div>
            <div class="step-content">
                <div class="step-title">Configurer les préférences</div>
                <div class="step-description">Une fois les emails fonctionnels, configurez vos préférences de notification selon vos besoins.</div>
            </div>
        </div>
    </div>

    @if($config['configured'])
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Configuration active :</strong> Votre système de notification par email est configuré et fonctionnel !
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div style="text-align: center; margin-top: 3rem;">
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i>
            Retour aux notifications
        </a>
        
        @if($config['configured'])
            <a href="{{ route('admin.notifications.index') }}#test" class="btn btn-secondary">
                <i class="fas fa-paper-plane"></i>
                Tester la configuration
            </a>
        @endif
    </div>
</div>

<!-- JavaScript pour les interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des tabs
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Désactiver tous les tabs
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Activer le tab sélectionné
            this.classList.add('active');
            document.getElementById(targetTab + '-tab').classList.add('active');
        });
    });
});

// Fonction pour copier le code
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    const text = element.textContent;
    
    navigator.clipboard.writeText(text).then(function() {
        // Feedback visuel
        const copyBtn = element.parentElement.querySelector('.copy-btn');
        const originalText = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check"></i> Copié !';
        copyBtn.style.background = 'rgba(34, 197, 94, 0.2)';
        
        setTimeout(() => {
            copyBtn.innerHTML = originalText;
            copyBtn.style.background = 'rgba(255, 255, 255, 0.1)';
        }, 2000);
    }).catch(function(err) {
        console.error('Erreur lors de la copie:', err);
        alert('Impossible de copier automatiquement. Veuillez sélectionner et copier manuellement le texte.');
    });
}

console.log('✅ Page de configuration email initialisée !');
</script>
@endsection


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationPreference;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Afficher les paramètres de notification
     */
    public function index()
    {
        $user = Auth::user();
        $preferences = $user->notificationPreferences ?? NotificationPreference::createDefaultForUser($user->id);
        $emailConfig = $this->notificationService->checkEmailConfiguration();
        
        return view('admin.notifications.index', compact('preferences', 'emailConfig'));
    }

    /**
     * Mettre à jour les préférences de notification
     */
    public function updatePreferences(Request $request)
    {
        $request->validate([
            'email_enabled' => 'boolean',
            'task_assignments' => 'boolean',
            'request_updates' => 'boolean',
            'price_alerts' => 'boolean',
            'news_updates' => 'boolean',
            'system_notifications' => 'boolean',
            'weekly_digest' => 'boolean'
        ]);

        $user = Auth::user();
        $preferences = $user->notificationPreferences ?? new NotificationPreference(['user_id' => $user->id]);
        
        $preferences->fill([
            'email_enabled' => $request->has('email_enabled'),
            'task_assignments' => $request->has('task_assignments'),
            'request_updates' => $request->has('request_updates'),
            'price_alerts' => $request->has('price_alerts'),
            'news_updates' => $request->has('news_updates'),
            'system_notifications' => $request->has('system_notifications'),
            'weekly_digest' => $request->has('weekly_digest')
        ]);

        $preferences->save();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Préférences de notification mises à jour avec succès !');
    }

    /**
     * Tester l'envoi d'email
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        $success = $this->notificationService->testEmail($request->test_email);

        if ($success) {
            return redirect()->route('admin.notifications.index')
                ->with('success', 'Email de test envoyé avec succès à ' . $request->test_email . ' !');
        } else {
            return redirect()->route('admin.notifications.index')
                ->with('error', 'Échec de l\'envoi de l\'email de test. Vérifiez la configuration.');
        }
    }

    /**
     * Envoyer le digest hebdomadaire manuellement
     */
    public function sendWeeklyDigest()
    {
        try {
            $this->notificationService->sendWeeklyDigest();
            return redirect()->route('admin.notifications.index')
                ->with('success', 'Digest hebdomadaire envoyé avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('admin.notifications.index')
                ->with('error', 'Erreur lors de l\'envoi du digest : ' . $e->getMessage());
        }
    }

    /**
     * Afficher la configuration email
     */
    public function emailConfig()
    {
        $config = $this->notificationService->checkEmailConfiguration();
        $envSample = $this->getEmailConfigSample();
        
        return view('admin.notifications.email-config', compact('config', 'envSample'));
    }

    /**
     * Obtenir un exemple de configuration email
     */
    private function getEmailConfigSample()
    {
        return [
            'gmail' => [
                'MAIL_MAILER=smtp',
                'MAIL_HOST=smtp.gmail.com',
                'MAIL_PORT=587',
                'MAIL_USERNAME=votre-email@gmail.com',
                'MAIL_PASSWORD=votre-mot-de-passe-app',
                'MAIL_ENCRYPTION=tls',
                'MAIL_FROM_ADDRESS=votre-email@gmail.com',
                'MAIL_FROM_NAME="CSAR Platform"'
            ],
            'outlook' => [
                'MAIL_MAILER=smtp',
                'MAIL_HOST=smtp-mail.outlook.com',
                'MAIL_PORT=587',
                'MAIL_USERNAME=votre-email@outlook.com',
                'MAIL_PASSWORD=votre-mot-de-passe',
                'MAIL_ENCRYPTION=tls',
                'MAIL_FROM_ADDRESS=votre-email@outlook.com',
                'MAIL_FROM_NAME="CSAR Platform"'
            ],
            'custom' => [
                'MAIL_MAILER=smtp',
                'MAIL_HOST=smtp.votre-serveur.com',
                'MAIL_PORT=587',
                'MAIL_USERNAME=votre-email@domaine.com',
                'MAIL_PASSWORD=votre-mot-de-passe',
                'MAIL_ENCRYPTION=tls',
                'MAIL_FROM_ADDRESS=votre-email@domaine.com',
                'MAIL_FROM_NAME="CSAR Platform"'
            ]
        ];
    }
}


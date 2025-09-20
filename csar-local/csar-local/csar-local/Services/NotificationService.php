<?php

namespace App\Services;

use App\Models\User;
use App\Models\Task;
use App\Models\PublicRequest;
use App\Models\PriceAlert;
use App\Models\News;
use App\Notifications\UserWelcomeNotification;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\RequestStatusChangedNotification;
use App\Notifications\PriceAlertNotification;
use App\Notifications\NewsPublishedNotification;
use App\Notifications\WeeklyDigestNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Envoyer une notification de bienvenue à un nouvel utilisateur
     */
    public function sendWelcomeNotification(User $user, $temporaryPassword = null)
    {
        try {
            if ($user->wantsNotification('system_notifications')) {
                $user->notify(new UserWelcomeNotification($user, $temporaryPassword));
                Log::info('Notification de bienvenue envoyée', ['user_id' => $user->id]);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de la notification de bienvenue', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer une notification d'assignation de tâche
     */
    public function sendTaskAssignedNotification(Task $task)
    {
        try {
            if ($task->assignedTo && $task->assignedTo->wantsNotification('task_assignments')) {
                $task->assignedTo->notify(new TaskAssignedNotification($task));
                Log::info('Notification de tâche assignée envoyée', [
                    'task_id' => $task->id,
                    'user_id' => $task->assignedTo->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de la notification de tâche', [
                'task_id' => $task->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer une notification de changement de statut de demande
     */
    public function sendRequestStatusNotification(PublicRequest $request, $oldStatus = null)
    {
        try {
            // Créer un utilisateur temporaire avec l'email du demandeur
            $tempUser = new User();
            $tempUser->name = $request->full_name;
            $tempUser->email = $request->email;
            
            $tempUser->notify(new RequestStatusChangedNotification($request, $oldStatus));
            Log::info('Notification de changement de statut envoyée', [
                'request_id' => $request->id,
                'email' => $request->email,
                'new_status' => $request->status
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de la notification de demande', [
                'request_id' => $request->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer une alerte de prix aux utilisateurs concernés
     */
    public function sendPriceAlertNotification(PriceAlert $alert)
    {
        try {
            // Envoyer aux administrateurs et responsables
            $recipients = User::whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'dg', 'responsable']);
            })->get();

            foreach ($recipients as $user) {
                if ($user->wantsNotification('price_alerts')) {
                    $user->notify(new PriceAlertNotification($alert));
                }
            }

            Log::info('Notifications d\'alerte de prix envoyées', [
                'alert_id' => $alert->id,
                'recipients_count' => $recipients->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi des alertes de prix', [
                'alert_id' => $alert->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer une notification de nouvelle actualité
     */
    public function sendNewsPublishedNotification(News $news)
    {
        try {
            // Envoyer aux utilisateurs qui veulent recevoir les actualités
            $subscribers = User::whereHas('notificationPreferences', function ($query) {
                $query->where('news_updates', true)->where('email_enabled', true);
            })->get();

            foreach ($subscribers as $user) {
                $user->notify(new NewsPublishedNotification($news));
            }

            Log::info('Notifications d\'actualité envoyées', [
                'news_id' => $news->id,
                'subscribers_count' => $subscribers->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi des notifications d\'actualité', [
                'news_id' => $news->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer un digest hebdomadaire
     */
    public function sendWeeklyDigest()
    {
        try {
            $subscribers = User::whereHas('notificationPreferences', function ($query) {
                $query->where('weekly_digest', true)->where('email_enabled', true);
            })->get();

            // Récupérer les données de la semaine
            $weekData = $this->getWeeklyData();

            foreach ($subscribers as $user) {
                // Envoyer le digest personnalisé selon le rôle
                $this->sendPersonalizedWeeklyDigest($user, $weekData);
            }

            Log::info('Digest hebdomadaire envoyé', [
                'subscribers_count' => $subscribers->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du digest hebdomadaire', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Récupérer les données de la semaine
     */
    private function getWeeklyData()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        return [
            'tasks_created' => Task::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
            'tasks_completed' => Task::where('status', 'done')
                ->whereBetween('updated_at', [$startOfWeek, $endOfWeek])->count(),
            'requests_processed' => PublicRequest::whereIn('status', ['approved', 'rejected', 'completed'])
                ->whereBetween('updated_at', [$startOfWeek, $endOfWeek])->count(),
            'news_published' => News::where('is_published', true)
                ->whereBetween('published_at', [$startOfWeek, $endOfWeek])->count(),
            'price_alerts' => PriceAlert::where('is_active', true)
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
        ];
    }

    /**
     * Envoyer un digest personnalisé
     */
    private function sendPersonalizedWeeklyDigest(User $user, array $weekData)
    {
        try {
            $user->notify(new WeeklyDigestNotification($weekData, $user));
            Log::info('Digest hebdomadaire envoyé à l\'utilisateur', [
                'user_id' => $user->id,
                'user_name' => $user->name
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du digest personnalisé', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Vérifier la configuration email
     */
    public function checkEmailConfiguration()
    {
        $defaultMailer = config('mail.default', 'log');
        $fromAddress = config('mail.from.address', 'hello@example.com');
        $fromName = config('mail.from.name', config('app.name', 'CSAR Platform'));

        $isConfigured = true;

        // Considérer les mailers de développement comme "configurés"
        if (in_array($defaultMailer, ['log', 'array'])) {
            if ($fromAddress === 'hello@example.com' || empty($fromAddress)) {
                $fromAddress = 'admin@example.com';
            }
        } else {
            // En production, exiger une adresse expéditeur valide
            $isConfigured = !empty($fromAddress) && $fromAddress !== 'hello@example.com';
        }

        return [
            'configured' => $isConfigured,
            'mailer' => $defaultMailer,
            'from_address' => $fromAddress,
            'from_name' => $fromName,
        ];
    }

    /**
     * Tester l'envoi d'email
     */
    public function testEmail($email)
    {
        try {
            $testUser = new User();
            $testUser->name = 'Test';
            $testUser->email = $email;
            
            Notification::send($testUser, new \App\Notifications\TestNotification());
            
            return true;
        } catch (\Exception $e) {
            Log::error('Test d\'email échoué', ['error' => $e->getMessage()]);
            return false;
        }
    }
}

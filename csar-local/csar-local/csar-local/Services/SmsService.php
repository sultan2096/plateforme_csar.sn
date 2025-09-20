<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private $apiKey;
    private $apiSecret;
    private $senderName;

    public function __construct()
    {
        $this->apiKey = config('services.orange.sms_api_key');
        $this->apiSecret = config('services.orange.sms_api_secret');
        $this->senderName = config('services.orange.sms_sender_name', 'CSAR');
    }

    public function sendSms($phone, $message)
    {
        if (!$this->apiKey || !$this->apiSecret) {
            Log::warning('SMS API credentials not configured');
            return false;
        }

        try {
            // Obtenir le token d'accès
            $token = $this->getAccessToken();
            
            if (!$token) {
                Log::error('Failed to get SMS API access token');
                return false;
            }

            // Envoyer le SMS
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post('https://api.orange.com/smsmessaging/v1/outbound/' . $this->senderName . '/requests', [
                'outboundSMSMessageRequest' => [
                    'address' => [$phone],
                    'senderAddress' => $this->senderName,
                    'outboundSMSTextMessage' => [
                        'message' => $message
                    ]
                ]
            ]);

            if ($response->successful()) {
                Log::info('SMS sent successfully', [
                    'phone' => $phone,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error('SMS sending failed', [
                    'phone' => $phone,
                    'response' => $response->json()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('SMS service error', [
                'message' => $e->getMessage(),
                'phone' => $phone
            ]);
            return false;
        }
    }

    private function getAccessToken()
    {
        try {
            $response = Http::asForm()->post('https://api.orange.com/oauth/v3/token', [
                'grant_type' => 'client_credentials'
            ])->withHeaders([
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret)
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['access_token'] ?? null;
            }

            Log::error('Failed to get SMS API token', [
                'response' => $response->json()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('SMS token error', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function sendRequestConfirmation($request)
    {
        $message = "CSAR: Votre demande {$request->tracking_code} a été reçue. " .
                   "Vous recevrez une notification du statut. " .
                   "Suivez votre demande sur notre site web.";

        return $this->sendSms($request->phone, $message);
    }

    public function sendRequestStatusUpdate($request)
    {
        $statusText = match($request->status) {
            'approved' => 'approuvée',
            'rejected' => 'rejetée',
            'completed' => 'terminée',
            default => 'en cours de traitement'
        };

        $message = "CSAR: Votre demande {$request->tracking_code} a été {$statusText}. " .
                   "Consultez notre site web pour plus de détails.";

        return $this->sendSms($request->phone, $message);
    }
} 
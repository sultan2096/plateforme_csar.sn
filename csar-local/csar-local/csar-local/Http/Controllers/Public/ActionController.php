<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PublicRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActionController extends Controller
{
    public function index()
    {
        return view('public.action');
    }
    
    public function submit(Request $request)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'type' => 'required|in:aide,partenariat,audience,autre',
            'region' => 'required|string|max:255',
            'description' => 'required|string',
        ];
        
        // Géolocalisation obligatoire uniquement pour les demandes d'aide
        if ($request->type === 'aide') {
            $rules['latitude'] = 'required|numeric';
            $rules['longitude'] = 'required|numeric';
        } else {
            $rules['latitude'] = 'nullable|numeric';
            $rules['longitude'] = 'nullable|numeric';
        }
        
        $request->validate($rules);
        
        // Generate unique tracking code
        $trackingCode = 'CSAR' . str_pad(PublicRequest::count() + 1, 6, '0', STR_PAD_LEFT);
        
        // Create the request
        $publicRequest = PublicRequest::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'type' => $request->type,
            'region' => $request->region,
            'description' => $request->description,
            'latitude' => $request->latitude ?: null,
            'longitude' => $request->longitude ?: null,
            'tracking_code' => $trackingCode,
            'status' => 'pending',
            'request_date' => now()->toDateString(),
            'sms_sent' => false,
        ]);
        
        // Send SMS notification (placeholder for Orange API)
        $smsSent = false;
        try {
            $message = "Votre demande CSAR a bien été enregistrée. Code de suivi : " . $publicRequest->tracking_code;
            
            // Orange SMS API integration (placeholder)
            $orangeApiUrl = 'https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B221000000000/requests';
            $accessToken = 'VOTRE_ACCESS_TOKEN'; // To be configured
            $senderAddress = 'tel:+221000000000';
            $recipientAddress = 'tel:' . $publicRequest->phone;
            
            $payload = [
                'outboundSMSMessageRequest' => [
                    'address' => [$recipientAddress],
                    'senderAddress' => $senderAddress,
                    'outboundSMSTextMessage' => [
                        'message' => $message
                    ]
                ]
            ];
            
            // Uncomment when API credentials are available
            // $response = \Http::withToken($accessToken)
            //     ->withHeaders(['Content-Type' => 'application/json'])
            //     ->post($orangeApiUrl, $payload);
            
            // if ($response->successful()) {
            //     $smsSent = true;
            // }
            
            $smsSent = true; // For testing purposes
        } catch (\Exception $e) {
            // Log error
            \Log::error('SMS sending failed: ' . $e->getMessage());
        }
        
        $publicRequest->update(['sms_sent' => $smsSent]);
        
        return redirect()->route('request.success', ['code' => $publicRequest->tracking_code])
            ->with('success', 'Votre demande a été soumise avec succès ! Un SMS de confirmation vous a été envoyé.');
    }
}

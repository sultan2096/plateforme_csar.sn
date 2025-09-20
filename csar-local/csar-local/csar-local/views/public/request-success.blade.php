@extends('layouts.public')

@section('title', 'Demande soumise avec succès - CSAR')

@push('styles')
<style>
    /* Styles personnalisés pour corriger la taille des icônes */
    .success-icon {
        width: 2rem !important;
        height: 2rem !important;
    }
    
    .success-icon-large {
        width: 3rem !important;
        height: 3rem !important;
    }
    
    .success-icon-small {
        width: 1rem !important;
        height: 1rem !important;
    }
    
    .success-icon-medium {
        width: 1.5rem !important;
        height: 1.5rem !important;
    }
    
    .success-circle {
        width: 3rem !important;
        height: 3rem !important;
    }
    
    .success-circle-large {
        width: 4rem !important;
        height: 4rem !important;
    }
    
    .success-circle-small {
        width: 2rem !important;
        height: 2rem !important;
    }
</style>
@endpush

@section('content')
<!-- Main Content - Centré et responsive -->
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex items-center justify-center py-8 px-4">
    <div class="w-full max-w-2xl">
        
        <!-- Success Card - Design moderne et centré -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <!-- Success Header avec animation -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-8 text-center relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-white opacity-10"></div>
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                
                <div class="relative z-10">
                    <!-- Success Animation -->
                    <div class="inline-flex items-center justify-center success-circle-large bg-white bg-opacity-20 rounded-full mb-6 animate-pulse">
                        <svg class="success-icon-large text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-4xl font-bold mb-4">Demande soumise avec succès !</h2>
                    <p class="text-xl opacity-90">Votre demande a été enregistrée et sera traitée dans les plus brefs délais</p>
                </div>
            </div>

            <!-- Content principal -->
            <div class="p-8">
                
                <!-- Confirmation Section -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center success-circle bg-green-100 rounded-full mb-4">
                        <svg class="success-icon text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-3">Demande enregistrée</h3>
                    <p class="text-gray-600 text-lg">Votre demande a été soumise avec succès et est maintenant en cours de traitement.</p>
                </div>

                <!-- Résumé de la demande -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="success-icon-medium text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Résumé de la demande
                    </h4>
                    
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <!-- Code de suivi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Code de suivi</label>
                            <div class="flex items-center bg-white border border-gray-300 rounded-lg p-3 hover:border-blue-400 transition-colors">
                                <span class="font-mono text-lg font-semibold text-gray-800 flex-1">{{ $code ?? 'CSAR000001' }}</span>
                                <button onclick="copyToClipboard('{{ $code ?? 'CSAR000001' }}')" class="ml-2 p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition-colors" title="Copier le code">
                                    <svg class="success-icon-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Statut -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <div class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg">
                                <svg class="success-icon-small mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">En attente</span>
                            </div>
                        </div>
                    </div>

                    @if($publicRequest)
                    <!-- Détails de la demande -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Détails de la demande</label>
                        <div class="grid md:grid-cols-3 gap-4">
                            <div class="bg-white p-3 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                                <span class="text-xs text-gray-500 uppercase tracking-wide">Type</span>
                                <p class="font-medium text-gray-800">{{ ucfirst($publicRequest->type) }}</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                                <span class="text-xs text-gray-500 uppercase tracking-wide">Région</span>
                                <p class="font-medium text-gray-800">{{ $publicRequest->region }}</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                                <span class="text-xs text-gray-500 uppercase tracking-wide">Date de soumission</span>
                                <p class="font-medium text-gray-800">{{ $publicRequest->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Note importante -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="success-icon-medium text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-blue-800 font-medium">Important :</p>
                                <p class="text-blue-700 text-sm">Conservez précieusement ce code de suivi. Il vous sera nécessaire pour suivre l'évolution de votre demande.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton principal "Suivre ma demande" -->
                <div class="text-center mb-8">
                    <a href="{{ route('track') }}" class="inline-flex items-center px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg text-center transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl text-lg">
                        <svg class="success-icon mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Suivre ma demande
                    </a>
                </div>

                <!-- Boutons secondaires -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <a href="{{ route('action') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all duration-200 flex items-center justify-center transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="success-icon-medium mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nouvelle demande
                    </a>
                    
                    <button onclick="downloadReceipt()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition-all duration-200 flex items-center justify-center transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="success-icon-medium mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Télécharger le reçu
                    </button>
                </div>
            </div>
        </div>

        <!-- Section "Besoin d'aide ?" -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mt-8">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-8 text-center">
                <h3 class="text-3xl font-bold text-gray-800 mb-3">Besoin d'aide ?</h3>
                <p class="text-gray-600 text-lg">Nous sommes là pour vous accompagner</p>
            </div>
            
            <div class="p-8">
                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Contact téléphonique -->
                    <div class="text-center p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                        <div class="inline-flex items-center justify-center success-circle bg-blue-600 text-white rounded-full mb-4 shadow-lg">
                            <svg class="success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Contactez-nous</h4>
                        <p class="text-gray-600 text-sm mb-4">Appelez notre service client pour toute question</p>
                        <a href="tel:+221331234567" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="success-icon-small mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +221 33 123 45 67
                        </a>
                    </div>

                    <!-- Contact email -->
                    <div class="text-center p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                        <div class="inline-flex items-center justify-center success-circle bg-green-600 text-white rounded-full mb-4 shadow-lg">
                            <svg class="success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Envoyez un message</h4>
                        <p class="text-gray-600 text-sm mb-4">Écrivez-nous pour obtenir de l'aide</p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="success-icon-small mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Nous contacter
                        </a>
                    </div>

                    <!-- FAQ -->
                    <div class="text-center p-6 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                        <div class="inline-flex items-center justify-center success-circle bg-orange-600 text-white rounded-full mb-4 shadow-lg">
                            <svg class="success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">FAQ</h4>
                        <p class="text-gray-600 text-sm mb-4">Consultez nos questions fréquemment posées</p>
                        <a href="{{ route('about') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="success-icon-small mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Voir la FAQ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const btn = event.target.closest('button');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = `
            <svg class="success-icon-medium text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        `;
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
        }, 2000);
    }).catch(function(err) {
        console.error('Erreur lors de la copie: ', err);
    });
}

function downloadReceipt() {
    const receiptContent = `
        <html>
        <head>
            <title>Reçu de demande CSAR</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    margin: 40px; 
                    line-height: 1.6;
                    color: #333;
                }
                .header { 
                    text-align: center; 
                    margin-bottom: 30px; 
                    border-bottom: 2px solid #3b82f6;
                    padding-bottom: 20px;
                }
                .receipt { 
                    border: 2px solid #3b82f6; 
                    padding: 30px; 
                    border-radius: 10px; 
                    background: #f8fafc;
                }
                .code { 
                    background: #e2e8f0; 
                    padding: 15px; 
                    border-radius: 5px; 
                    font-family: monospace;
                    font-size: 18px;
                    font-weight: bold;
                    color: #1e40af;
                }
                .info-row {
                    display: flex;
                    justify-content: space-between;
                    margin: 10px 0;
                    padding: 10px 0;
                    border-bottom: 1px solid #e2e8f0;
                }
                .label {
                    font-weight: bold;
                    color: #374151;
                }
                .value {
                    color: #6b7280;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1 style="color: #1e40af; margin: 0;">CSAR</h1>
                <h2 style="color: #6b7280; margin: 10px 0;">Commissariat à la Sécurité Alimentaire et à la Résilience</h2>
                <p style="color: #9ca3af; margin: 0;">Reçu de demande officiel</p>
            </div>
            <div class="receipt">
                <h3 style="color: #1e40af; margin-top: 0;">Reçu de demande</h3>
                
                <div class="info-row">
                    <span class="label">Code de suivi:</span>
                    <span class="code">{{ $code ?? 'CSAR000001' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Date de soumission:</span>
                    <span class="value">{{ date('d/m/Y à H:i') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Statut:</span>
                    <span class="value">En attente</span>
                </div>
                
                @if($publicRequest)
                <div class="info-row">
                    <span class="label">Type de demande:</span>
                    <span class="value">{{ ucfirst($publicRequest->type) }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Région:</span>
                    <span class="value">{{ $publicRequest->region }}</span>
                </div>
                @endif
                
                <div style="margin-top: 30px; padding: 20px; background: #dbeafe; border-radius: 8px; border-left: 4px solid #3b82f6;">
                    <p style="margin: 0; color: #1e40af; font-weight: bold;">Important :</p>
                    <p style="margin: 5px 0 0 0; color: #1e40af;">Votre demande a été enregistrée avec succès dans notre système. Conservez ce reçu pour vos archives.</p>
                </div>
                
                <div style="margin-top: 20px; text-align: center; color: #6b7280; font-size: 14px;">
                    <p>Pour toute question, contactez-nous au +221 33 123 45 67</p>
                    <p>© 2025 CSAR - Tous droits réservés</p>
                </div>
            </div>
        </body>
        </html>
    `;
    
    const blob = new Blob([receiptContent], { type: 'text/html' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'recu-demande-csar.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('.card, .help-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
});
</script>
@endsection
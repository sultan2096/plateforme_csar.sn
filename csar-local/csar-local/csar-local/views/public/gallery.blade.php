@extends('layouts.public')

@section('title', 'Nos Missions en Images - CSAR')

@section('content')
<!-- Hero Section Modernisé -->
<section class="hero fade-in" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(34, 197, 94, 0.9) 100%), url('{{ asset('img/1.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 80px 0; position: relative; overflow: hidden;">
    
    <!-- Grid pattern animé -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 60px 60px; animation: gridMove 20s linear infinite; opacity: 0.2;"></div>
    
    <!-- Particules flottantes -->
    <div style="position: absolute; top: 15%; left: 10%; width: 8px; height: 8px; background: rgba(34,197,94,0.8); border-radius: 50%; animation: float 6s ease-in-out infinite; box-shadow: 0 0 20px rgba(34,197,94,0.6);"></div>
    <div style="position: absolute; top: 25%; right: 15%; width: 6px; height: 6px; background: rgba(59,130,246,0.7); border-radius: 50%; animation: float 8s ease-in-out infinite reverse; box-shadow: 0 0 15px rgba(59,130,246,0.6);"></div>
    <div style="position: absolute; bottom: 20%; left: 20%; width: 10px; height: 10px; background: rgba(245,158,11,0.6); border-radius: 50%; animation: float 7s ease-in-out infinite; box-shadow: 0 0 25px rgba(245,158,11,0.6);"></div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
        <!-- Badge moderne -->
        <div style="display: inline-block; background: rgba(255,255,255,0.1); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.2); border-radius: 50px; padding: 12px 25px; margin-bottom: 30px;">
            <span style="color: #22c55e; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">📸 Galerie CSAR</span>
        </div>
        
        <h1 class="main-title" style="font-size: 4rem; font-weight: 900; color: #fff; margin-bottom: 25px; letter-spacing: -2px; line-height: 1.1; text-shadow: 0 6px 12px rgba(0,0,0,0.4);">
            Nos Missions en Images
        </h1>
        <p class="main-subtitle" style="font-size: 1.4rem; color: rgba(255,255,255,0.9); max-width: 700px; margin: 0 auto; line-height: 1.7; text-shadow: 0 3px 6px rgba(0,0,0,0.3);">
            Découvrez nos actions humanitaires et interventions de résilience à travers le Sénégal
        </p>
    </div>
</section>

<!-- Diaporama Section -->
<section class="slideshow-section" style="background: linear-gradient(135deg, #f8fafc 0%, #ffffff 50%, #f1f5f9 100%); padding: 80px 0; position: relative; overflow: hidden;">
    <!-- Décoration arrière-plan -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(circle at 20% 80%, rgba(34,197,94,0.03) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(59,130,246,0.03) 0%, transparent 50%);"></div>
    
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
        <!-- En-tête -->
        <div style="text-align: center; margin-bottom: 60px;">
            <div style="display: inline-block; background: rgba(34,197,94,0.1); color: #22c55e; padding: 8px 20px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">
                📸 Galerie Photos
            </div>
            <h2 style="font-size: 3rem; font-weight: 800; color: #1f2937; margin-bottom: 20px; background: linear-gradient(135deg, #1f2937 0%, #22c55e 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Nos Actions sur le Terrain
            </h2>
        </div>

        <!-- Diaporama principal -->
        <div class="slideshow-container" style="position: relative; max-width: 1200px; margin: 0 auto; border-radius: 25px; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.15); background: #fff;">
            
            <!-- Images du diaporama -->
            <div class="slideshow-images" style="position: relative; height: 600px; overflow: hidden;">
                
                <!-- Slide 1 -->
                <div class="slide active" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 1; transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);">
                    <img src="{{ asset('img/1.jpg') }}" alt="Actions Humanitaires" 
                         style="width: 100%; height: 100%; object-fit: cover; object-position: center top;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(34,197,94,0.3) 100%);"></div>
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.9)); color: #fff; padding: 50px; z-index: 2;">
                        <h3 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; text-shadow: 0 4px 8px rgba(0,0,0,0.5);">Actions Humanitaires</h3>
                        <p style="font-size: 1.2rem; line-height: 1.6; margin-bottom: 20px; opacity: 0.9;">Distribution d'aide alimentaire et assistance aux populations vulnérables</p>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span style="background: rgba(34,197,94,0.3); color: #22c55e; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">Mission 2024</span>
                            <span style="font-size: 0.9rem; opacity: 0.8;">📍 Région de Dakar</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);">
                    <img src="{{ asset('img/2.jpg') }}" alt="Interventions de Résilience" 
                         style="width: 100%; height: 100%; object-fit: cover; object-position: center top;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(59,130,246,0.3) 100%);"></div>
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.9)); color: #fff; padding: 50px; z-index: 2;">
                        <h3 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; text-shadow: 0 4px 8px rgba(0,0,0,0.5);">Interventions de Résilience</h3>
                        <p style="font-size: 1.2rem; line-height: 1.6; margin-bottom: 20px; opacity: 0.9;">Renforcement des capacités locales et programmes de développement durable</p>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span style="background: rgba(59,130,246,0.3); color: #3b82f6; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">Mission 2024</span>
                            <span style="font-size: 0.9rem; opacity: 0.8;">📍 Région de Thiès</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);">
                    <img src="{{ asset('img/3.jpg') }}" alt="Mobilisations Locales" 
                         style="width: 100%; height: 100%; object-fit: cover; object-position: center top;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(245,158,11,0.3) 100%);"></div>
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.9)); color: #fff; padding: 50px; z-index: 2;">
                        <h3 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; text-shadow: 0 4px 8px rgba(0,0,0,0.5);">Mobilisations Locales</h3>
                        <p style="font-size: 1.2rem; line-height: 1.6; margin-bottom: 20px; opacity: 0.9;">Engagement communautaire et sensibilisation des populations</p>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span style="background: rgba(245,158,11,0.3); color: #f59e0b; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">Mission 2024</span>
                            <span style="font-size: 0.9rem; opacity: 0.8;">📍 Région de Saint-Louis</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="slide" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);">
                    <img src="{{ asset('img/4.jpg') }}" alt="Programmes Nutritionnels" 
                         style="width: 100%; height: 100%; object-fit: cover; object-position: center top;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(139,92,246,0.3) 100%);"></div>
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.9)); color: #fff; padding: 50px; z-index: 2;">
                        <h3 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; text-shadow: 0 4px 8px rgba(0,0,0,0.5);">Programmes Nutritionnels</h3>
                        <p style="font-size: 1.2rem; line-height: 1.6; margin-bottom: 20px; opacity: 0.9;">Lutte contre la malnutrition et promotion de la sécurité alimentaire</p>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span style="background: rgba(139,92,246,0.3); color: #8b5cf6; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">Mission 2024</span>
                            <span style="font-size: 0.9rem; opacity: 0.8;">📍 Région de Kaolack</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contrôles de navigation -->
            <button class="prev-btn" onclick="changeSlide(-1)" style="position: absolute; left: 30px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.9); border: none; width: 60px; height: 60px; border-radius: 50%; cursor: pointer; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease; z-index: 10; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-chevron-left" style="font-size: 20px; color: #1f2937; margin-right: 2px;"></i>
            </button>
            
            <button class="next-btn" onclick="changeSlide(1)" style="position: absolute; right: 30px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.9); border: none; width: 60px; height: 60px; border-radius: 50%; cursor: pointer; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease; z-index: 10; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-chevron-right" style="font-size: 20px; color: #1f2937; margin-left: 2px;"></i>
            </button>

            <!-- Indicateurs -->
            <div class="slide-indicators" style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 10;">
                <button class="indicator active" onclick="goToSlide(0)" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: #22c55e; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(34, 197, 94, 0.4);"></button>
                <button class="indicator" onclick="goToSlide(1)" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s ease;"></button>
                <button class="indicator" onclick="goToSlide(2)" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s ease;"></button>
                <button class="indicator" onclick="goToSlide(3)" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s ease;"></button>
            </div>
        </div>

        <!-- Contrôles de lecture -->
        <div style="text-align: center; margin-top: 40px;">
            <button id="playPauseBtn" onclick="toggleAutoplay()" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #fff; border: none; padding: 15px 30px; border-radius: 15px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3); display: inline-flex; align-items: center; gap: 10px;">
                <i class="fas fa-pause" id="playPauseIcon"></i>
                <span id="playPauseText">Pause</span>
            </button>
        </div>
    </div>
</section>

<!-- Key Figures Section -->
<section class="section fade-in" style="background: #fff; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        {{-- Section chiffres clés supprimée --}}
    </div>
</section>

<!-- Mission Types Section -->
<section class="section fade-in" style="background: #f8fafc; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">Types d'Interventions</h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                Nos différentes missions sur le terrain
            </p>
        </div>
        
        <div class="cards-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
            <div class="card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #f3f4f6; transition: all 0.3s ease;">
                <div class="card-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 32px; color: #fff; box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 15px; text-align: center;">Actions Humanitaires</h3>
                <p style="color: #6b7280; margin-bottom: 25px; line-height: 1.6; text-align: center;">Distribution d'aide alimentaire d'urgence et matériel humanitaire</p>
                <ul style="margin: 0; padding-left: 20px; color: #6b7280; line-height: 1.8;">
                    <li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #22c55e; margin-right: 10px;"></i>Distribution de denrées alimentaires</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #22c55e; margin-right: 10px;"></i>Fourniture de matériel médical</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #22c55e; margin-right: 10px;"></i>Support logistique d'urgence</li>
                </ul>
            </div>
            
            <div class="card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #f3f4f6; transition: all 0.3s ease;">
                <div class="card-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 32px; color: #fff; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 15px; text-align: center;">Interventions de Résilience</h3>
                <p style="color: #6b7280; margin-bottom: 25px; line-height: 1.6; text-align: center;">Renforcement des capacités locales et prévention des crises</p>
                <ul style="margin: 0; padding-left: 20px; color: #6b7280; line-height: 1.8;">
                    <li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #3b82f6; margin-right: 10px;"></i>Formation des communautés</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #3b82f6; margin-right: 10px;"></i>Développement de systèmes d'alerte</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #3b82f6; margin-right: 10px;"></i>Renforcement des infrastructures</li>
                </ul>
            </div>
            
            <div class="card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #f3f4f6; transition: all 0.3s ease;">
                <div class="card-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 32px; color: #fff; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                    <i class="fas fa-truck"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 15px; text-align: center;">Livraisons et Mobilisations</h3>
                <p style="color: #6b7280; margin-bottom: 25px; line-height: 1.6; text-align: center;">Transport et distribution stratégique des ressources</p>
                <ul style="margin: 0; padding-left: 20px; color: #6b7280; line-height: 1.8;">
                    <li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #f59e0b; margin-right: 10px;"></i>Transport de marchandises</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #f59e0b; margin-right: 10px;"></i>Coordination logistique</li>
                    <li style="margin-bottom: 8px;"><i class="fas fa-check" style="color: #f59e0b; margin-right: 10px;"></i>Mobilisation des équipes</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section fade-in" style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%); padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; max-width: 700px; margin: 0 auto;">
            <h3 style="font-size: 2rem; font-weight: 700; color: #fff; margin-bottom: 20px;">En savoir plus sur nos missions</h3>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.8); margin-bottom: 40px; line-height: 1.6;">
                Pour plus d'informations sur nos interventions ou pour demander des photos spécifiques, 
                n'hésitez pas à nous contacter.
            </p>
            <a href="{{ route('contact') }}" class="btn btn-primary zoom-hover" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 15px 30px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #fff; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);">
                <i class="fas fa-envelope"></i>
                Nous contacter
            </a>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.95); backdrop-filter: blur(10px);">
    <div class="lightbox-content" onclick="event.stopPropagation()" style="position: relative; margin: auto; padding: 30px; width: 90%; max-width: 900px; top: 50%; transform: translateY(-50%);">
        <span class="lightbox-close" onclick="closeLightbox()" style="position: absolute; top: 15px; right: 25px; color: white; font-size: 40px; font-weight: bold; cursor: pointer; z-index: 1001; transition: all 0.3s ease;">&times;</span>
        <img id="lightbox-image" src="" alt="" style="width: 100%; max-height: 70vh; object-fit: contain; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
        <div class="lightbox-info" style="background: rgba(255, 255, 255, 0.98); padding: 30px; border-radius: 12px; margin-top: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <h3 id="lightbox-title" style="color: #1f2937; margin-bottom: 15px; font-size: 1.5rem; font-weight: 700;"></h3>
            <p id="lightbox-description" style="color: #6b7280; line-height: 1.6; font-size: 1.1rem;"></p>
        </div>
    </div>
</div>
<!-- Styles CSS pour le diaporama -->
<style>
/* Animations de base */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(60px, 60px); }
}

@keyframes slideIn {
    from { 
        opacity: 0; 
        transform: translateY(30px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

/* Styles pour le diaporama */
.slideshow-container {
    position: relative;
    transition: all 0.3s ease;
}

.slideshow-container:hover {
    transform: scale(1.01);
    box-shadow: 0 30px 100px rgba(0,0,0,0.2);
}

.slide {
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide.active {
    opacity: 1;
    transform: translateX(0);
}

.slide:not(.active) {
    opacity: 0;
    transform: translateX(100px);
}

/* Boutons de navigation */
.prev-btn, .next-btn {
    transition: all 0.3s ease;
}

.prev-btn:hover, .next-btn:hover {
    background: #22c55e !important;
    color: #fff !important;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 10px 30px rgba(34, 197, 94, 0.4);
}

.prev-btn:hover i, .next-btn:hover i {
    color: #fff !important;
}

/* Indicateurs */
.indicator {
    transition: all 0.3s ease;
}

.indicator:hover {
    transform: scale(1.3);
}

.indicator.active {
    background: #22c55e !important;
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.4);
    transform: scale(1.2);
}

/* Animations d'apparition */
.fade-in {
    animation: slideIn 0.8s ease forwards;
}

/* Responsive */
@media (max-width: 768px) {
    .slideshow-images {
        height: 400px !important;
    }
    
    .slide h3 {
        font-size: 1.8rem !important;
    }
    
    .slide p {
        font-size: 1rem !important;
    }
    
    .slide > div:last-child {
        padding: 30px 20px !important;
    }
    
    .prev-btn, .next-btn {
        width: 50px !important;
        height: 50px !important;
    }
    
    .prev-btn {
        left: 15px !important;
    }
    
    .next-btn {
        right: 15px !important;
    }
}
</style>

<!-- JavaScript pour le diaporama -->
<script>
let currentSlide = 0;
let isAutoplay = true;
let autoplayInterval;

// Démarre le diaporama automatique
function startAutoplay() {
    autoplayInterval = setInterval(() => {
        if (isAutoplay) {
            changeSlide(1);
        }
    }, 5000); // Change toutes les 5 secondes
}

// Arrête le diaporama automatique
function stopAutoplay() {
    clearInterval(autoplayInterval);
}

// Change de slide
function changeSlide(direction) {
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.indicator');
    
    // Retirer la classe active de la slide actuelle
    slides[currentSlide].classList.remove('active');
    slides[currentSlide].style.opacity = '0';
    indicators[currentSlide].classList.remove('active');
    indicators[currentSlide].style.background = 'rgba(255,255,255,0.5)';
    indicators[currentSlide].style.boxShadow = 'none';
    
    // Calculer la nouvelle slide
    currentSlide += direction;
    
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    } else if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    
    // Activer la nouvelle slide
    setTimeout(() => {
        slides[currentSlide].classList.add('active');
        slides[currentSlide].style.opacity = '1';
        indicators[currentSlide].classList.add('active');
        indicators[currentSlide].style.background = '#22c55e';
        indicators[currentSlide].style.boxShadow = '0 2px 8px rgba(34, 197, 94, 0.4)';
    }, 100);
}

// Va directement à une slide spécifique
function goToSlide(slideIndex) {
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.indicator');
    
    // Retirer la classe active de toutes les slides
    slides.forEach(slide => {
        slide.classList.remove('active');
        slide.style.opacity = '0';
    });
    
    indicators.forEach(indicator => {
        indicator.classList.remove('active');
        indicator.style.background = 'rgba(255,255,255,0.5)';
        indicator.style.boxShadow = 'none';
    });
    
    // Activer la slide sélectionnée
    currentSlide = slideIndex;
    setTimeout(() => {
        slides[currentSlide].classList.add('active');
        slides[currentSlide].style.opacity = '1';
        indicators[currentSlide].classList.add('active');
        indicators[currentSlide].style.background = '#22c55e';
        indicators[currentSlide].style.boxShadow = '0 2px 8px rgba(34, 197, 94, 0.4)';
    }, 100);
}

// Toggle autoplay
function toggleAutoplay() {
    const playPauseIcon = document.getElementById('playPauseIcon');
    const playPauseText = document.getElementById('playPauseText');
    
    isAutoplay = !isAutoplay;
    
    if (isAutoplay) {
        playPauseIcon.className = 'fas fa-pause';
        playPauseText.textContent = 'Pause';
        startAutoplay();
    } else {
        playPauseIcon.className = 'fas fa-play';
        playPauseText.textContent = 'Lecture';
        stopAutoplay();
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Démarrer l'autoplay
    startAutoplay();
    
    // Pause au hover
    const slideshowContainer = document.querySelector('.slideshow-container');
    slideshowContainer.addEventListener('mouseenter', () => {
        if (isAutoplay) stopAutoplay();
    });
    
    slideshowContainer.addEventListener('mouseleave', () => {
        if (isAutoplay) startAutoplay();
    });
    
    // Navigation au clavier
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            changeSlide(-1);
        } else if (e.key === 'ArrowRight') {
            changeSlide(1);
        } else if (e.key === ' ') {
            e.preventDefault();
            toggleAutoplay();
        }
    });
    
    // Animation d'apparition des éléments
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, {
        threshold: 0.1
    });
    
    // Observer les sections
    document.querySelectorAll('.section, .slideshow-section').forEach(el => {
        observer.observe(el);
    });
    
    console.log('🎬 Diaporama CSAR initialisé avec succès !');
});

// Préchargement des images
window.addEventListener('load', function() {
    const images = document.querySelectorAll('.slide img');
    images.forEach(img => {
        if (!img.complete) {
            img.addEventListener('load', () => {
                console.log(`✅ Image chargée: ${img.alt}`);
            });
        }
    });
});
</script>

@endsection

@push('styles')
<style>
/* Animations pour les cercles flottants */
@keyframes float {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg); 
    }
    50% { 
        transform: translateY(-20px) rotate(180deg); 
    }
}

.floating-circle {
    animation: float 6s ease-in-out infinite;
}

/* Animation du titre principal - effet de typewriter */
.animated-title {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px;
}

.title-word {
    animation: color-animation 4s linear infinite;
    display: inline-block;
    position: relative;
    overflow: hidden;
}

.title-word::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shine 3s infinite;
}

.title-word-1 {
    --color-1: #ffffff;
    --color-2: #e5e7eb;
    --color-3: #d1d5db;
    animation-delay: 0s;
}

.title-word-2 {
    --color-1: #e5e7eb;
    --color-2: #ffffff;
    --color-3: #d1d5db;
    animation-delay: 0.5s;
}

.title-word-3 {
    --color-1: #d1d5db;
    --color-2: #ffffff;
    --color-3: #e5e7eb;
    animation-delay: 1s;
}

.title-word-4 {
    --color-1: #e5e7eb;
    --color-2: #ffffff;
    --color-3: #d1d5db;
    animation-delay: 1.5s;
}

@keyframes color-animation {
    0%    { color: var(--color-1) }
    32%   { color: var(--color-1) }
    33%   { color: var(--color-2) }
    65%   { color: var(--color-2) }
    66%   { color: var(--color-3) }
    99%   { color: var(--color-3) }
    100%  { color: var(--color-1) }
}

@keyframes shine {
    0% { left: -100%; }
    50% { left: 100%; }
    100% { left: 100%; }
}

/* Animation du sous-titre - effet de fade-in progressif */
.animated-subtitle {
    animation: subtitle-animation 2s ease-out;
    opacity: 0;
    animation-fill-mode: forwards;
    animation-delay: 1s;
}

@keyframes subtitle-animation {
    0% {
        opacity: 0;
        transform: translateY(30px);
        filter: blur(5px);
    }
    50% {
        opacity: 0.5;
        transform: translateY(15px);
        filter: blur(2px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
        filter: blur(0);
    }
}

/* Animation de fade-in générale */
.fade-in {
    animation: fadeIn 0.8s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Effet de zoom au hover */
.zoom-hover:hover {
    transform: scale(1.02);
    transition: all 0.3s ease;
}

/* Gallery Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.gallery-item {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    background: #fff;
}

.gallery-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.gallery-item img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
    color: white;
    padding: 30px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    transform: translateY(0);
}

.gallery-overlay h3 {
    font-size: 1.3rem;
    margin-bottom: 12px;
    font-weight: 700;
}

.gallery-overlay p {
    font-size: 1rem;
    margin-bottom: 15px;
    opacity: 0.9;
    line-height: 1.5;
}

.gallery-date {
    font-size: 0.9rem;
    opacity: 0.8;
    font-weight: 600;
}

/* Empty Gallery */
.empty-gallery {
    text-align: center;
    padding: 80px 20px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 2px dashed #e5e7eb;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.stat-item {
    text-align: center;
    padding: 40px 30px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    font-size: 32px;
    color: #fff;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 1.1rem;
    color: #6b7280;
    font-weight: 600;
}

/* Cards Grid */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
}

.card {
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid #f3f4f6;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.card-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    font-size: 32px;
    color: #fff;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 15px;
    text-align: center;
}

.card p {
    color: #6b7280;
    margin-bottom: 25px;
    line-height: 1.6;
    text-align: center;
}

.card ul {
    margin: 0;
    padding-left: 20px;
    color: #6b7280;
    line-height: 1.8;
}

.card li {
    margin-bottom: 8px;
}

/* Lightbox */
.lightbox {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(10px);
}

.lightbox-content {
    position: relative;
    margin: auto;
    padding: 30px;
    width: 90%;
    max-width: 900px;
    top: 50%;
    transform: translateY(-50%);
}

.lightbox-close {
    position: absolute;
    top: 15px;
    right: 25px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    z-index: 1001;
    transition: all 0.3s ease;
}

.lightbox-close:hover {
    color: #ccc;
    transform: scale(1.1);
}

#lightbox-image {
    width: 100%;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.lightbox-info {
    background: rgba(255, 255, 255, 0.98);
    padding: 30px;
    border-radius: 12px;
    margin-top: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.lightbox-info h3 {
    color: #1f2937;
    margin-bottom: 15px;
    font-size: 1.5rem;
    font-weight: 700;
}

.lightbox-info p {
    color: #6b7280;
    line-height: 1.6;
    font-size: 1.1rem;
}

/* Button hover effects */
.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(34, 197, 94, 0.4) !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .main-title {
        font-size: 2.5rem !important;
    }
    
    .title-word {
        font-size: 2.2rem !important;
    }
    
    .main-subtitle {
        font-size: 1.1rem !important;
    }
    
    .animated-title {
        flex-direction: column;
        gap: 4px;
    }
    
    .gallery-grid {
        grid-template-columns: 1fr;
    }
    
    .gallery-overlay {
        transform: translateY(0);
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .cards-grid {
        grid-template-columns: 1fr;
    }
    
    .lightbox-content {
        width: 95%;
        padding: 15px;
    }
}

@media (max-width: 480px) {
    .title-word {
        font-size: 1.8rem !important;
    }
    
    .main-subtitle {
        font-size: 1rem !important;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-item {
        padding: 30px 20px;
    }
    
    .card {
        padding: 30px 20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function openLightbox(imageSrc, title, description) {
    document.getElementById('lightbox-image').src = imageSrc;
    document.getElementById('lightbox-title').textContent = title;
    document.getElementById('lightbox-description').textContent = description;
    document.getElementById('lightbox').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Fermer avec la touche Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeLightbox();
    }
});
</script>
@endpush 
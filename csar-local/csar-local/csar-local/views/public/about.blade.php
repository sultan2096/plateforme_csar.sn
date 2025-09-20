@extends('layouts.public')
@section('title', 'À propos - CSAR')

@section('content')
<!-- Hero Section -->
<section class="hero fade-in" style="background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%); min-height: 40vh; display: flex; align-items: center; justify-content: center; padding: 50px 0; position: relative; overflow: hidden;">
    <!-- Motifs décoratifs animés -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.08;">
        <div class="floating-shape" style="position: absolute; top: 10%; left: 10%; width: 100px; height: 100px; background: #fff; border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div class="floating-shape" style="position: absolute; top: 20%; right: 15%; width: 60px; height: 60px; background: #fff; border-radius: 50%; animation: float 6s ease-in-out infinite reverse;"></div>
        <div class="floating-shape" style="position: absolute; bottom: 30%; left: 20%; width: 80px; height: 80px; background: #fff; border-radius: 50%; animation: float 10s ease-in-out infinite;"></div>
        <div class="floating-shape" style="position: absolute; bottom: 20%; right: 10%; width: 120px; height: 120px; background: #fff; border-radius: 50%; animation: float 7s ease-in-out infinite reverse;"></div>
    </div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
        <h1 class="main-title" style="font-size: 2.8rem; font-weight: 800; color: #fff; margin-bottom: 20px; letter-spacing: -1px; line-height: 1.2; text-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            À propos du CSAR
        </h1>
        <p class="main-subtitle" style="font-size: 1.2rem; color: #f0f9ff; max-width: 800px; margin: 0 auto; line-height: 1.6; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            Découvrez notre histoire, nos missions et notre vision pour la sécurité alimentaire au Sénégal
        </p>
    </div>
{{-- end section --}}
</section>

<!-- Introduction Section -->
<section class="section fade-in" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 80px 0; position: relative; overflow: hidden;">
    <!-- Motifs de fond subtils -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.03;">
        <div style="position: absolute; top: 20%; left: 5%; width: 200px; height: 200px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; filter: blur(40px);"></div>
        <div style="position: absolute; bottom: 20%; right: 5%; width: 150px; height: 150px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; filter: blur(30px);"></div>
    </div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 2;">
        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 60px; align-items: center;">
            <div class="intro-content">
                <div style="position: relative; margin-bottom: 30px;">
                    <div style="position: absolute; left: -20px; top: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, #22c55e 0%, #16a34a 100%); border-radius: 2px;"></div>
                    <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 24px; padding-left: 20px; position: relative;">
                        <span style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Le Commissariat à la Sécurité Alimentaire et à la Résilience</span>
                    </h2>
                </div>
                
                <div style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #f3f4f6; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);"></div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 20px; margin-bottom: 25px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 15px rgba(34,197,94,0.3);">
                            <i class="fas fa-building" style="font-size: 20px; color: #fff;"></i>
                        </div>
                        <div>
                            <p style="font-size: 1.2rem; color: #374151; line-height: 1.8; margin: 0; font-weight: 500;">
                                {!! optional($aboutContent->get('content'))->value ?? 'Le Commissariat à la Sécurité Alimentaire et à la Résilience (CSAR) est un établissement public à caractère administratif, chargé de coordonner les politiques nationales de sécurité alimentaire, de prévention des crises et de résilience des populations vulnérables.' !!}
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 15px rgba(59,130,246,0.3);">
                            <i class="fas fa-clock" style="font-size: 20px; color: #fff;"></i>
                        </div>
                        <div>
                            <p style="font-size: 1.1rem; color: #6b7280; line-height: 1.7; margin: 0;">
                                Notre institution œuvre depuis plus de 50 ans pour assurer que chaque citoyen sénégalais ait accès à une alimentation suffisante et nutritive, en développant des mécanismes de prévention, de gestion et de réponse aux crises alimentaires.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="intro-logo" style="text-align: center;">
                <div style="width: 200px; height: 200px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); position: relative; overflow: hidden; border: 3px solid #f3f4f6;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, transparent 30%, rgba(34,197,94,0.05) 50%, transparent 70%); animation: shine 3s infinite;"></div>
                    <img src="{{ asset('images/logos/LOGO CSAR vectoriel-01.png') }}" alt="Logo CSAR" style="width: 140px; height: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                </div>
                <h3 style="font-size: 1.8rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">CSAR</h3>
                <p style="color: #6b7280; font-size: 0.95rem;">Institution Publique</p>
            </div>
        </div>
    </div>
</section>

<!-- Mission, Vision, Valeurs Section -->
<section class="section fade-in" style="background: #f8fafc; padding: 80px 0; position: relative; overflow: hidden;">

    
    <!-- Motifs décoratifs supplémentaires -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.03;">
        <div class="floating-shape" style="position: absolute; top: 15%; left: 8%; width: 80px; height: 80px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; animation: float 12s ease-in-out infinite;"></div>
        <div class="floating-shape" style="position: absolute; top: 25%; right: 12%; width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; animation: float 10s ease-in-out infinite reverse;"></div>
        <div class="floating-shape" style="position: absolute; bottom: 20%; left: 15%; width: 100px; height: 100px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 50%; animation: float 14s ease-in-out infinite;"></div>
        <div class="floating-shape" style="position: absolute; bottom: 35%; right: 8%; width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; animation: float 11s ease-in-out infinite reverse;"></div>
    </div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 2;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Notre Fondation
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                Les piliers qui guident nos actions au quotidien
            </p>
        </div>
        
        <div class="mvp-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
            <!-- Mission -->
            <div class="mvp-card zoom-hover" style="background: linear-gradient(135deg, #fff 0%, #f8fffe 100%); border-radius: 24px; padding: 40px; text-align: center; box-shadow: 0 12px 40px rgba(34,197,94,0.15), 0 4px 12px rgba(0,0,0,0.05); border: 2px solid rgba(34,197,94,0.1); transition: all 0.4s ease; position: relative; overflow: hidden; backdrop-filter: blur(10px);">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 24px 24px 0 0;"></div>
                <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(34,197,94,0.03) 0%, transparent 70%); animation: rotate 20s linear infinite;"></div>
                <div class="mvp-icon" style="width: 90px; height: 90px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 36px; color: #fff; box-shadow: 0 12px 35px rgba(34,197,94,0.4); position: relative; z-index: 2;">
                    <i class="fas fa-compass"></i>
                </div>
                <h3 style="font-size: 1.6rem; font-weight: 800; color: #1f2937; margin-bottom: 20px; position: relative; z-index: 2;">Mission</h3>
                <p style="font-size: 1.1rem; color: #4b5563; line-height: 1.8; position: relative; z-index: 2; font-weight: 500;">
                    Garantir une sécurité alimentaire durable au Sénégal en mettant en place des mécanismes de prévention, de gestion et de réponse aux crises alimentaires.
                </p>
            </div>
            
            <!-- Vision -->
            <div class="mvp-card zoom-hover vision-card" style="background: linear-gradient(135deg, #fff 0%, #f8fbff 100%); border-radius: 24px; padding: 40px; text-align: center; box-shadow: 0 12px 40px rgba(59,130,246,0.15), 0 4px 12px rgba(0,0,0,0.05); border: 2px solid rgba(59,130,246,0.1); transition: all 0.4s ease; position: relative; overflow: hidden; backdrop-filter: blur(10px);">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 24px 24px 0 0;"></div>
                <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(59,130,246,0.03) 0%, transparent 70%); animation: rotate 25s linear infinite reverse;"></div>
                
                <!-- Logo Sénégal 2050 AVEC EFFETS SPECTACULAIRES 🔥 -->
                <div class="logo-container-ultra-modern" style="width: 130px; height: 130px; margin: 0 auto 24px; position: relative; z-index: 3;">
                    
                    <!-- Aura extérieure pulsante -->
                    <div style="position: absolute; inset: -20px; background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, rgba(34,197,94,0.08) 50%, transparent 100%); border-radius: 50%; animation: logoAura 3s ease-in-out infinite alternate;"></div>
                    
                    <!-- Anneaux orbitaux multiples -->
                    <div style="position: absolute; inset: -10px; border: 2px solid rgba(59,130,246,0.3); border-radius: 50%; animation: logoOrbit1 8s linear infinite;"></div>
                    <div style="position: absolute; inset: -5px; border: 1px solid rgba(34,197,94,0.4); border-radius: 50%; animation: logoOrbit2 6s linear infinite reverse;"></div>
                    <div style="position: absolute; inset: 0; border: 1px solid rgba(245,158,11,0.3); border-radius: 50%; animation: logoOrbit3 10s linear infinite;"></div>
                    
                    <!-- Cercles de fond animés -->
                    <div style="position: absolute; inset: 5px; background: conic-gradient(from 0deg, transparent, rgba(59,130,246,0.15), transparent, rgba(34,197,94,0.1), transparent); border-radius: 50%; animation: logoSpin1 12s linear infinite;"></div>
                    <div style="position: absolute; inset: 10px; background: conic-gradient(from 180deg, transparent, rgba(245,158,11,0.12), transparent, rgba(139,92,246,0.1), transparent); border-radius: 50%; animation: logoSpin2 15s linear infinite reverse;"></div>
                    
                    <!-- Container principal avec effet glassmorphism -->
                    <div style="position: absolute; inset: 15px; background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,251,255,0.85) 100%); border-radius: 50%; backdrop-filter: blur(15px); box-shadow: 0 15px 40px rgba(59,130,246,0.4), 0 5px 15px rgba(0,0,0,0.1), inset 0 2px 20px rgba(255,255,255,0.6); border: 2px solid rgba(255,255,255,0.8);">
                        
                        <!-- Container du logo avec effet 3D -->
                        <div style="position: relative; z-index: 3; width: 100%; height: 100%; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 15px; transform: perspective(200px) rotateX(5deg); animation: logoFloat 4s ease-in-out infinite;">
                            <img src="{{ asset('images/partners/senegal2050-home-spot.webp') }}" alt="Sénégal 2050" 
                                 style="width: 70px; height: auto; max-height: 70px; object-fit: contain; filter: brightness(1.2) contrast(1.25) saturate(1.4) drop-shadow(0 4px 8px rgba(0,0,0,0.15)); transition: all 0.3s ease;">
                        </div>
                        
                        <!-- Particules flottantes -->
                        <div style="position: absolute; top: 20%; left: 15%; width: 4px; height: 4px; background: radial-gradient(circle, #22c55e 0%, transparent 100%); border-radius: 50%; animation: logoParticle1 3s ease-in-out infinite;"></div>
                        <div style="position: absolute; top: 30%; right: 20%; width: 3px; height: 3px; background: radial-gradient(circle, #3b82f6 0%, transparent 100%); border-radius: 50%; animation: logoParticle2 4s ease-in-out infinite 0.5s;"></div>
                        <div style="position: absolute; bottom: 25%; left: 25%; width: 5px; height: 5px; background: radial-gradient(circle, #f59e0b 0%, transparent 100%); border-radius: 50%; animation: logoParticle3 3.5s ease-in-out infinite 1s;"></div>
                        <div style="position: absolute; bottom: 35%; right: 15%; width: 3px; height: 3px; background: radial-gradient(circle, #8b5cf6 0%, transparent 100%); border-radius: 50%; animation: logoParticle4 4.5s ease-in-out infinite 1.5s;"></div>
                        
                        <!-- Effet de brillance dynamique -->
                        <div style="position: absolute; top: 15%; left: 15%; width: 35px; height: 35px; background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0.3) 40%, transparent 100%); border-radius: 50%; z-index: 4; animation: logoShine 6s ease-in-out infinite;"></div>
                        
                        <!-- Reflets arc-en-ciel -->
                        <div style="position: absolute; inset: 2px; background: conic-gradient(from 45deg, transparent 0%, rgba(255,0,150,0.1) 10%, transparent 20%, rgba(0,255,255,0.1) 30%, transparent 40%, rgba(255,255,0,0.1) 50%, transparent 60%, rgba(150,0,255,0.1) 70%, transparent 80%); border-radius: 50%; animation: logoRainbow 20s linear infinite; opacity: 0.6;"></div>
                    </div>
                </div>
                
                <h3 style="font-size: 1.6rem; font-weight: 800; color: #1f2937; margin-bottom: 20px; position: relative; z-index: 2;">Vision</h3>
                <p style="font-size: 1.1rem; color: #4b5563; line-height: 1.8; position: relative; z-index: 2; font-weight: 500;">
                    Un Sénégal résilient face aux défis alimentaires et climatiques, où chaque citoyen a accès à une alimentation suffisante et nutritive.
                </p>
            </div>
            
            <!-- Valeurs -->
            <div class="mvp-card zoom-hover" style="background: linear-gradient(135deg, #fff 0%, #fdfbff 100%); border-radius: 24px; padding: 40px; text-align: center; box-shadow: 0 12px 40px rgba(139,92,246,0.15), 0 4px 12px rgba(0,0,0,0.05); border: 2px solid rgba(139,92,246,0.1); transition: all 0.4s ease; position: relative; overflow: hidden; backdrop-filter: blur(10px);">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 24px 24px 0 0;"></div>
                <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(139,92,246,0.03) 0%, transparent 70%); animation: rotate 30s linear infinite;"></div>
                <div class="mvp-icon" style="width: 90px; height: 90px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 36px; color: #fff; box-shadow: 0 12px 35px rgba(139,92,246,0.4); position: relative; z-index: 2;">
                    <i class="fas fa-globe"></i>
                </div>
                <h3 style="font-size: 1.6rem; font-weight: 800; color: #1f2937; margin-bottom: 20px; position: relative; z-index: 2;">Valeurs</h3>
                <div style="display: flex; flex-direction: column; gap: 16px; position: relative; z-index: 2;">
                    <div style="color: #4b5563; font-weight: 600; font-size: 1.1rem; padding: 8px 16px; background: rgba(139,92,246,0.05); border-radius: 12px; border-left: 4px solid #8b5cf6;">• Solidarité</div>
                    <div style="color: #4b5563; font-weight: 600; font-size: 1.1rem; padding: 8px 16px; background: rgba(139,92,246,0.05); border-radius: 12px; border-left: 4px solid #8b5cf6;">• Responsabilité</div>
                    <div style="color: #4b5563; font-weight: 600; font-size: 1.1rem; padding: 8px 16px; background: rgba(139,92,246,0.05); border-radius: 12px; border-left: 4px solid #8b5cf6;">• Transparence</div>
                    <div style="color: #4b5563; font-weight: 600; font-size: 1.1rem; padding: 8px 16px; background: rgba(139,92,246,0.05); border-radius: 12px; border-left: 4px solid #8b5cf6;">• Innovation</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Objectifs stratégiques Section -->
<section class="section fade-in" style="background: #fff; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Objectifs stratégiques (jusqu'en 2028)
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                Nos priorités pour renforcer la sécurité alimentaire au Sénégal
            </p>
        </div>
        
        <div class="objectives-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <div class="objective-card zoom-hover" style="background: #f8fafc; border-radius: 20px; padding: 32px; border: 2px solid #f3f4f6; transition: all 0.3s ease;">
                <div class="objective-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 24px; color: #fff;">
                    <i class="fas fa-warehouse"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 600; color: #1f2937; margin-bottom: 12px;">Renforcer les capacités de stockage et distribution</h3>
                <p style="color: #6b7280; line-height: 1.6;">Améliorer nos infrastructures de stockage et optimiser les réseaux de distribution pour une meilleure accessibilité.</p>
            </div>
            
            <div class="objective-card zoom-hover" style="background: #f8fafc; border-radius: 20px; padding: 32px; border: 2px solid #f3f4f6; transition: all 0.3s ease;">
                <div class="objective-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 24px; color: #fff;">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 600; color: #1f2937; margin-bottom: 12px;">Numériser les processus de gestion</h3>
                <p style="color: #6b7280; line-height: 1.6;">Moderniser nos systèmes de gestion pour améliorer l'efficacité et la transparence de nos opérations.</p>
            </div>
            
            <div class="objective-card zoom-hover" style="background: #f8fafc; border-radius: 20px; padding: 32px; border: 2px solid #f3f4f6; transition: all 0.3s ease;">
                <div class="objective-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 24px; color: #fff;">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 600; color: #1f2937; margin-bottom: 12px;">Impliquer les collectivités locales</h3>
                <p style="color: #6b7280; line-height: 1.6;">Renforcer la collaboration avec les collectivités territoriales pour une approche décentralisée.</p>
            </div>
            
            <div class="objective-card zoom-hover" style="background: #f8fafc; border-radius: 20px; padding: 32px; border: 2px solid #f3f4f6; transition: all 0.3s ease;">
                <div class="objective-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 24px; color: #fff;">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 600; color: #1f2937; margin-bottom: 12px;">Promouvoir les partenariats publics-privés</h3>
                <p style="color: #6b7280; line-height: 1.6;">Développer des collaborations stratégiques avec le secteur privé pour maximiser l'impact de nos actions.</p>
            </div>
            
            <div class="objective-card zoom-hover" style="background: #f8fafc; border-radius: 20px; padding: 32px; border: 2px solid #f3f4f6; transition: all 0.3s ease;">
                <div class="objective-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 24px; color: #fff;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 600; color: #1f2937; margin-bottom: 12px;">Développer la résilience des communautés</h3>
                <p style="color: #6b7280; line-height: 1.6;">Renforcer la capacité des populations à résister aux chocs alimentaires et climatiques.</p>
            </div>
        </div>
    </div>
</section>

<!-- Chiffres clés dynamiques Section -->
<section class="section fade-in" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #fff; margin-bottom: 16px;">
                Chiffres clés dynamiques
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #e5e7eb; max-width: 600px; margin: 0 auto;">
                L'impact du CSAR en chiffres
            </p>
        </div>
        
        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <div class="stat-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                <div class="stat-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number counter-number" data-target="137" style="font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 8px;" id="counter-1">0</div>
                <div class="stat-label" style="font-size: 1rem; color: #6b7280; font-weight: 500;">Agents recensés</div>
            </div>
            
            <div class="stat-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                <div class="stat-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff;">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="stat-number counter-number" data-target="71" style="font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 8px;" id="counter-2">0</div>
                <div class="stat-label" style="font-size: 1rem; color: #6b7280; font-weight: 500;">Magasins de stockage</div>
            </div>
            
            <div class="stat-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                <div class="stat-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff;">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="stat-number counter-number" data-target="86" style="font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 8px;" id="counter-3">0</div>
                <div class="stat-label" style="font-size: 1rem; color: #6b7280; font-weight: 500;">000 tonnes de capacité</div>
            </div>
            
            <div class="stat-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                <div class="stat-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff;">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stat-number counter-number" data-target="50" data-suffix="+" style="font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 8px;" id="counter-4">0</div>
                <div class="stat-label" style="font-size: 1rem; color: #6b7280; font-weight: 500;">Années d'expérience</div>
            </div>
        </div>
    </div>
</section>

<script>
// Animation chronométrique EN BOUCLE CONTINUE
window.addEventListener('load', function() {
    console.log('🎬 ANIMATION CHRONOMÉTRIQUE EN BOUCLE');
    
    function startCounterLoop() {
        // Remettre tous les compteurs à 0
        document.getElementById('counter-1').textContent = '0';
        document.getElementById('counter-2').textContent = '0';
        document.getElementById('counter-3').textContent = '0';
        document.getElementById('counter-4').textContent = '0';
        
        // Animation compteur 1 : Agents (137)
        setTimeout(function() {
            let count1 = 0;
            const timer1 = setInterval(function() {
                count1 += 2;
                document.getElementById('counter-1').textContent = count1;
                document.getElementById('counter-1').style.color = '#22c55e';
                document.getElementById('counter-1').style.transform = 'scale(1.1)';
                document.getElementById('counter-1').style.textShadow = '0 2px 8px rgba(34, 197, 94, 0.4)';
                
                if (count1 >= 137) {
                    document.getElementById('counter-1').textContent = '137';
                    document.getElementById('counter-1').style.color = '#1f2937';
                    document.getElementById('counter-1').style.transform = 'scale(1)';
                    document.getElementById('counter-1').style.textShadow = 'none';
                    clearInterval(timer1);
                }
            }, 15);
        }, 200);
        
        // Animation compteur 2 : Magasins (71)
        setTimeout(function() {
            let count2 = 0;
            const timer2 = setInterval(function() {
                count2 += 1;
                document.getElementById('counter-2').textContent = count2;
                document.getElementById('counter-2').style.color = '#3b82f6';
                document.getElementById('counter-2').style.transform = 'scale(1.1)';
                document.getElementById('counter-2').style.textShadow = '0 2px 8px rgba(59, 130, 246, 0.4)';
                
                if (count2 >= 71) {
                    document.getElementById('counter-2').textContent = '71';
                    document.getElementById('counter-2').style.color = '#1f2937';
                    document.getElementById('counter-2').style.transform = 'scale(1)';
                    document.getElementById('counter-2').style.textShadow = 'none';
                    clearInterval(timer2);
                }
            }, 25);
        }, 500);
        
        // Animation compteur 3 : Tonnes (86)
        setTimeout(function() {
            let count3 = 0;
            const timer3 = setInterval(function() {
                count3 += 1;
                document.getElementById('counter-3').textContent = count3;
                document.getElementById('counter-3').style.color = '#f59e0b';
                document.getElementById('counter-3').style.transform = 'scale(1.1)';
                document.getElementById('counter-3').style.textShadow = '0 2px 8px rgba(245, 158, 11, 0.4)';
                
                if (count3 >= 86) {
                    document.getElementById('counter-3').textContent = '86';
                    document.getElementById('counter-3').style.color = '#1f2937';
                    document.getElementById('counter-3').style.transform = 'scale(1)';
                    document.getElementById('counter-3').style.textShadow = 'none';
                    clearInterval(timer3);
                }
            }, 25);
        }, 800);
        
        // Animation compteur 4 : Années (50+)
        setTimeout(function() {
            let count4 = 0;
            const timer4 = setInterval(function() {
                count4 += 1;
                document.getElementById('counter-4').textContent = count4;
                document.getElementById('counter-4').style.color = '#8b5cf6';
                document.getElementById('counter-4').style.transform = 'scale(1.1)';
                document.getElementById('counter-4').style.textShadow = '0 2px 8px rgba(139, 92, 246, 0.4)';
                
                if (count4 >= 50) {
                    document.getElementById('counter-4').textContent = '50+';
                    document.getElementById('counter-4').style.color = '#1f2937';
                    document.getElementById('counter-4').style.transform = 'scale(1)';
                    document.getElementById('counter-4').style.textShadow = 'none';
                    clearInterval(timer4);
                }
            }, 30);
        }, 1100);
    }
    
    // Démarrer la première animation après 2 secondes
    setTimeout(function() {
        startCounterLoop();
        
        // Répéter l'animation toutes les 8 secondes
        setInterval(function() {
            console.log('🔄 REDÉMARRAGE ANIMATION CHRONOMÉTRIQUE');
            startCounterLoop();
        }, 8000); // 8 secondes = temps pour finir + pause + redémarrage
        
    }, 2000);
});
</script>

<!-- Historique / Frise chronologique Section -->
<section class="section fade-in" style="background: linear-gradient(135deg, #f8fafc 0%, #ffffff 50%, #f1f5f9 100%); padding: 100px 0; position: relative; overflow: hidden;">
    <!-- Arrière-plan animé avec patterns géométriques -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.02;">
        <div style="position: absolute; top: 10%; left: 5%; width: 200px; height: 200px; background: conic-gradient(from 0deg, #22c55e, #3b82f6, #8b5cf6, #f59e0b, #22c55e); border-radius: 50%; animation: rotate 60s linear infinite;"></div>
        <div style="position: absolute; top: 60%; right: 8%; width: 150px; height: 150px; background: conic-gradient(from 180deg, #3b82f6, #8b5cf6, #f59e0b, #22c55e, #3b82f6); border-radius: 50%; animation: rotate 45s linear infinite reverse;"></div>
        <div style="position: absolute; bottom: 15%; left: 15%; width: 120px; height: 120px; background: conic-gradient(from 90deg, #8b5cf6, #f59e0b, #22c55e, #3b82f6, #8b5cf6); border-radius: 50%; animation: rotate 80s linear infinite;"></div>
    </div>
    
    <!-- Particules flottantes modernisées -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.04;">
        <div class="floating-particle" style="position: absolute; top: 8%; left: 12%; width: 8px; height: 8px; background: #22c55e; border-radius: 50%; animation: floatParticle 15s ease-in-out infinite;"></div>
        <div class="floating-particle" style="position: absolute; top: 25%; right: 18%; width: 6px; height: 6px; background: #3b82f6; border-radius: 50%; animation: floatParticle 18s ease-in-out infinite reverse;"></div>
        <div class="floating-particle" style="position: absolute; top: 45%; left: 8%; width: 10px; height: 10px; background: #8b5cf6; border-radius: 50%; animation: floatParticle 12s ease-in-out infinite;"></div>
        <div class="floating-particle" style="position: absolute; top: 65%; right: 12%; width: 7px; height: 7px; background: #f59e0b; border-radius: 50%; animation: floatParticle 20s ease-in-out infinite reverse;"></div>
        <div class="floating-particle" style="position: absolute; bottom: 25%; left: 25%; width: 9px; height: 9px; background: #ef4444; border-radius: 50%; animation: floatParticle 16s ease-in-out infinite;"></div>
        <div class="floating-particle" style="position: absolute; bottom: 35%; right: 30%; width: 5px; height: 5px; background: #06b6d4; border-radius: 50%; animation: floatParticle 14s ease-in-out infinite reverse;"></div>
    </div>
    
    <!-- Logo CSAR modernisé en arrière-plan -->
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1; opacity: 0.025;">
        <div style="width: 500px; height: 500px; background: conic-gradient(from 0deg, rgba(34,197,94,0.1), rgba(59,130,246,0.1), rgba(139,92,246,0.1), rgba(245,158,11,0.1), rgba(34,197,94,0.1)); border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: rotate 120s linear infinite;">
            <div style="width: 350px; height: 350px; background: linear-gradient(135deg, rgba(34,197,94,0.1) 0%, rgba(59,130,246,0.1) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <div style="text-align: center;">
                    <div style="font-size: 4.5rem; font-weight: 900; color: rgba(31,41,55,0.1); text-shadow: 0 0 20px rgba(34,197,94,0.2);">CSAR</div>
                    <i class="fas fa-wheat-awn" style="font-size: 3.5rem; color: rgba(31,41,55,0.1); margin-top: 15px;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container" style="max-width: 1000px; margin: 0 auto; position: relative; z-index: 2;">
        <div style="text-align: center; margin-bottom: 80px; position: relative;">
            <!-- Effet de background pour le titre -->
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 300px; height: 80px; background: linear-gradient(135deg, rgba(34,197,94,0.1), rgba(59,130,246,0.1)); border-radius: 40px; filter: blur(20px); z-index: -1;"></div>
            
            <h2 class="section-title" style="font-size: 3rem; font-weight: 900; background: linear-gradient(135deg, #1f2937 0%, #374151 50%, #1f2937 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 20px; text-shadow: 0 4px 8px rgba(0,0,0,0.1); position: relative;">
                Notre Historique
            </h2>
            <div style="width: 100px; height: 4px; background: linear-gradient(135deg, #22c55e 0%, #3b82f6 50%, #8b5cf6 100%); margin: 0 auto 20px; border-radius: 2px;"></div>
            <p class="section-subtitle" style="font-size: 1.3rem; color: #6b7280; max-width: 700px; margin: 0 auto; font-weight: 500; line-height: 1.6;">
                Les étapes clés de notre évolution à travers le temps
            </p>
        </div>
        
        <div class="timeline" style="position: relative;">
            <!-- Ligne verticale centrale modernisée avec effets multiples -->
            <div class="timeline-line" style="position: absolute; left: 50%; top: 0; bottom: 0; width: 6px; background: linear-gradient(180deg, #22c55e 0%, #3b82f6 25%, #8b5cf6 50%, #f59e0b 75%, #ef4444 100%); transform: translateX(-50%); border-radius: 3px; box-shadow: 0 0 30px rgba(34,197,94,0.4), inset 0 0 10px rgba(255,255,255,0.2);"></div>
            
            <!-- Effet de pulsation sur la ligne -->
            <div style="position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: linear-gradient(180deg, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0.8) 100%); transform: translateX(-50%); border-radius: 1px; animation: timelinePulse 3s ease-in-out infinite;"></div>
            
            <!-- Événements de la timeline modernisés -->
            <div class="timeline-item" style="position: relative; margin-bottom: 100px; display: flex; align-items: center; animation: slideInFromRight 0.8s ease-out;">
                <div class="timeline-content modern-card" style="width: 45%; padding: 35px; background: linear-gradient(135deg, #fff 0%, #f8fff8 100%); border-radius: 24px; box-shadow: 0 20px 50px rgba(34,197,94,0.15), 0 8px 20px rgba(0,0,0,0.08); margin-right: auto; border: 2px solid rgba(34,197,94,0.1); transition: all 0.4s ease; position: relative; overflow: hidden; backdrop-filter: blur(10px);">
                    <!-- Effet de shine animé -->
                    <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: conic-gradient(from 0deg, transparent 0%, rgba(34,197,94,0.1) 50%, transparent 100%); animation: rotate 8s linear infinite;"></div>
                    <!-- Bordure supérieure gradient -->
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 6px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 24px 24px 0 0;"></div>
                    <!-- Badge de date modernisé -->
                    <div class="timeline-date" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #fff; padding: 12px 24px; border-radius: 30px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; box-shadow: 0 6px 20px rgba(34,197,94,0.4); position: relative; z-index: 2;">
                        <i class="fas fa-calendar-alt" style="font-size: 14px;"></i>
                        2025
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin-bottom: 15px; position: relative; z-index: 2;">Objectif 2028</h3>
                    <p style="color: #4b5563; line-height: 1.7; font-weight: 500; position: relative; z-index: 2;">Engagement vers la souveraineté alimentaire du Sénégal d'ici 2028</p>
                    <!-- Icône décorative -->
                    <div style="position: absolute; bottom: 15px; right: 15px; width: 40px; height: 40px; background: rgba(34,197,94,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-target" style="color: #22c55e; font-size: 18px;"></i>
                    </div>
                </div>
                <div class="timeline-marker modern-marker" style="position: absolute; left: 50%; width: 32px; height: 32px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border: 6px solid #fff; border-radius: 50%; transform: translateX(-50%); box-shadow: 0 12px 35px rgba(34,197,94,0.5), 0 0 0 4px rgba(34,197,94,0.2); animation: markerPulse 3s ease-in-out infinite; display: flex; align-items: center; justify-content: center;">
                    <div style="width: 8px; height: 8px; background: #fff; border-radius: 50%; animation: innerPulse 2s ease-in-out infinite;"></div>
                </div>
            </div>
            
            <div class="timeline-item" style="position: relative; margin-bottom: 100px; display: flex; align-items: center; animation: slideInFromLeft 0.8s ease-out 0.2s both;">
                <div class="timeline-content modern-card" style="width: 45%; padding: 35px; background: linear-gradient(135deg, #fff 0%, #f8fbff 100%); border-radius: 24px; box-shadow: 0 20px 50px rgba(59,130,246,0.15), 0 8px 20px rgba(0,0,0,0.08); margin-left: auto; border: 2px solid rgba(59,130,246,0.1); transition: all 0.4s ease; position: relative; overflow: hidden; backdrop-filter: blur(10px);">
                    <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: conic-gradient(from 45deg, transparent 0%, rgba(59,130,246,0.1) 50%, transparent 100%); animation: rotate 10s linear infinite reverse;"></div>
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 6px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 24px 24px 0 0;"></div>
                    <div class="timeline-date" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: #fff; padding: 12px 24px; border-radius: 30px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; box-shadow: 0 6px 20px rgba(59,130,246,0.4); position: relative; z-index: 2;">
                        <i class="fas fa-star" style="font-size: 14px;"></i>
                        2024
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin-bottom: 15px; position: relative; z-index: 2;">CSAR - Nouvelle ère</h3>
                    <p style="color: #4b5563; line-height: 1.7; font-weight: 500; position: relative; z-index: 2;">Création du CSAR par décret N°2024-11 du 05 2024 avec autonomie administrative et financière</p>
                    <div style="position: absolute; bottom: 15px; right: 15px; width: 40px; height: 40px; background: rgba(59,130,246,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-building" style="color: #3b82f6; font-size: 18px;"></i>
                    </div>
                </div>
                <div class="timeline-marker modern-marker" style="position: absolute; left: 50%; width: 32px; height: 32px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: 6px solid #fff; border-radius: 50%; transform: translateX(-50%); box-shadow: 0 12px 35px rgba(59,130,246,0.5), 0 0 0 4px rgba(59,130,246,0.2); animation: markerPulse 3s ease-in-out infinite 0.5s; display: flex; align-items: center; justify-content: center;">
                    <div style="width: 8px; height: 8px; background: #fff; border-radius: 50%; animation: innerPulse 2s ease-in-out infinite 0.5s;"></div>
                </div>
            </div>
            
            <div class="timeline-item" style="position: relative; margin-bottom: 80px; display: flex; align-items: center; animation: slideInFromRight 0.8s ease-out 0.4s both;">
                <div class="timeline-content" style="width: 45%; padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin-right: auto; border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);"></div>
                    <div class="timeline-date" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: #fff; padding: 10px 20px; border-radius: 25px; font-weight: 600; display: inline-block; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(139,92,246,0.3);">1984</div>
                                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #1f2937; margin-bottom: 10px;">Commissariat à la Sécurité Alimentaire et à la Résilience</h3>
                <p style="color: #6b7280; line-height: 1.6;">Réorganisation en Commissariat à la Sécurité Alimentaire et à la Résilience (CSAR)</p>
                </div>
                <div class="timeline-marker" style="position: absolute; left: 50%; width: 24px; height: 24px; background: #fff; border: 4px solid #8b5cf6; border-radius: 50%; transform: translateX(-50%); box-shadow: 0 8px 25px rgba(139,92,246,0.4); animation: pulse 2s infinite 1s;"></div>
            </div>
            
            <div class="timeline-item" style="position: relative; margin-bottom: 80px; display: flex; align-items: center; animation: slideInFromLeft 0.8s ease-out 0.6s both;">
                <div class="timeline-content" style="width: 45%; padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin-left: auto; border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);"></div>
                    <div class="timeline-date" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; padding: 10px 20px; border-radius: 25px; font-weight: 600; display: inline-block; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(245,158,11,0.3);">1976</div>
                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #1f2937; margin-bottom: 10px;">Commissariat à l'Aide Alimentaire</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Evolution vers le Commissariat à l'Aide Alimentaire (CAA)</p>
                </div>
                <div class="timeline-marker" style="position: absolute; left: 50%; width: 24px; height: 24px; background: #fff; border: 4px solid #f59e0b; border-radius: 50%; transform: translateX(-50%); box-shadow: 0 8px 25px rgba(245,158,11,0.4); animation: pulse 2s infinite 1.5s;"></div>
            </div>
            
            <div class="timeline-item" style="position: relative; margin-bottom: 80px; display: flex; align-items: center; animation: slideInFromRight 0.8s ease-out 0.8s both;">
                <div class="timeline-content" style="width: 45%; padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin-right: auto; border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);"></div>
                    <div class="timeline-date" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: #fff; padding: 10px 20px; border-radius: 25px; font-weight: 600; display: inline-block; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(6,182,212,0.3);">1973-1974</div>
                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #1f2937; margin-bottom: 10px;">Bureau des Aides</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Transformation du Bureau des Aides en Commissariat aux Sinistres de la Sécheresse</p>
                </div>
                <div class="timeline-marker" style="position: absolute; left: 50%; width: 24px; height: 24px; background: #fff; border: 4px solid #06b6d4; border-radius: 50%; transform: translateX(-50%); box-shadow: 0 8px 25px rgba(6,182,212,0.4); animation: pulse 2s infinite 2s;"></div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('styles')
<style>
/* Additional styles for about page */
.zoom-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

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

/* Animations pour la timeline */
@keyframes slideInFromRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInFromLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0% {
        transform: translateX(-50%) scale(1);
        box-shadow: 0 8px 25px rgba(34,197,94,0.4);
    }
    50% {
        transform: translateX(-50%) scale(1.1);
        box-shadow: 0 12px 35px rgba(34,197,94,0.6);
    }
    100% {
        transform: translateX(-50%) scale(1);
        box-shadow: 0 8px 25px rgba(34,197,94,0.4);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes shine {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

@keyframes floatParticle {
    0%, 100% {
        transform: translateY(0px) translateX(0px);
        opacity: 0.4;
    }
    25% {
        transform: translateY(-15px) translateX(5px);
        opacity: 0.8;
    }
    50% {
        transform: translateY(-30px) translateX(0px);
        opacity: 1;
    }
    75% {
        transform: translateY(-15px) translateX(-5px);
        opacity: 0.8;
    }
}

@keyframes timelinePulse {
    0%, 100% {
        opacity: 0.8;
        transform: translateX(-50%) scaleY(1);
    }
    50% {
        opacity: 1;
        transform: translateX(-50%) scaleY(1.1);
    }
}

@keyframes markerPulse {
    0%, 100% {
        transform: translateX(-50%) scale(1);
        box-shadow: 0 12px 35px rgba(34,197,94,0.5), 0 0 0 4px rgba(34,197,94,0.2);
    }
    50% {
        transform: translateX(-50%) scale(1.15);
        box-shadow: 0 16px 45px rgba(34,197,94,0.7), 0 0 0 8px rgba(34,197,94,0.3);
    }
}

@keyframes innerPulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.5);
        opacity: 0.8;
    }
}

/* Effets hover pour les cartes timeline modernisées */
.modern-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 60px rgba(0,0,0,0.2), 0 12px 30px rgba(0,0,0,0.1);
    border-color: rgba(34,197,94,0.3);
}

.modern-marker:hover {
    transform: translateX(-50%) scale(1.3);
    animation-play-state: paused;
}

.timeline-content:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.timeline-marker:hover {
    transform: translateX(-50%) scale(1.2);
}

/* Effet de parallax pour les particules */
.floating-particle {
    will-change: transform;
}

/* Animations SPECTACULAIRES pour le logo 🔥 */

/* Aura pulsante */
@keyframes logoAura {
    0%, 100% { 
        transform: scale(1); 
        opacity: 0.3; 
    }
    50% { 
        transform: scale(1.1); 
        opacity: 0.6; 
    }
}

/* Anneaux orbitaux */
@keyframes logoOrbit1 {
    0% { transform: rotate(0deg) scale(1); }
    50% { transform: rotate(180deg) scale(1.05); }
    100% { transform: rotate(360deg) scale(1); }
}

@keyframes logoOrbit2 {
    0% { transform: rotate(0deg) scale(1); }
    33% { transform: rotate(120deg) scale(0.95); }
    66% { transform: rotate(240deg) scale(1.05); }
    100% { transform: rotate(360deg) scale(1); }
}

@keyframes logoOrbit3 {
    0% { transform: rotate(0deg) scale(1); }
    25% { transform: rotate(90deg) scale(1.02); }
    50% { transform: rotate(180deg) scale(0.98); }
    75% { transform: rotate(270deg) scale(1.02); }
    100% { transform: rotate(360deg) scale(1); }
}

/* Rotations des cercles de fond */
@keyframes logoSpin1 {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes logoSpin2 {
    from { transform: rotate(360deg); }
    to { transform: rotate(0deg); }
}

/* Flottement 3D du logo */
@keyframes logoFloat {
    0%, 100% { 
        transform: perspective(200px) rotateX(5deg) translateY(0px); 
    }
    50% { 
        transform: perspective(200px) rotateX(-2deg) translateY(-3px); 
    }
}

/* Particules flottantes */
@keyframes logoParticle1 {
    0%, 100% { 
        transform: translateY(0px) scale(1); 
        opacity: 0.7; 
    }
    50% { 
        transform: translateY(-8px) scale(1.2); 
        opacity: 1; 
    }
}

@keyframes logoParticle2 {
    0%, 100% { 
        transform: translateX(0px) scale(1); 
        opacity: 0.6; 
    }
    50% { 
        transform: translateX(6px) scale(1.3); 
        opacity: 1; 
    }
}

@keyframes logoParticle3 {
    0%, 100% { 
        transform: translate(0px, 0px) scale(1); 
        opacity: 0.8; 
    }
    50% { 
        transform: translate(-4px, -6px) scale(1.1); 
        opacity: 1; 
    }
}

@keyframes logoParticle4 {
    0%, 100% { 
        transform: translate(0px, 0px) scale(1); 
        opacity: 0.5; 
    }
    50% { 
        transform: translate(5px, 4px) scale(1.4); 
        opacity: 1; 
    }
}

/* Brillance dynamique */
@keyframes logoShine {
    0%, 100% { 
        transform: scale(1) rotate(0deg); 
        opacity: 0.6; 
    }
    25% { 
        transform: scale(1.2) rotate(90deg); 
        opacity: 0.9; 
    }
    50% { 
        transform: scale(0.8) rotate(180deg); 
        opacity: 0.4; 
    }
    75% { 
        transform: scale(1.1) rotate(270deg); 
        opacity: 0.8; 
    }
}

/* Arc-en-ciel rotatif */
@keyframes logoRainbow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Effets hover pour le nouveau logo */
.logo-container-ultra-modern {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.logo-container-ultra-modern:hover {
    transform: scale(1.1) rotate(5deg);
    filter: brightness(1.1) saturate(1.2);
}

.mvp-card:hover .logo-container-ultra-modern {
    transform: scale(1.15) rotate(-3deg);
    filter: brightness(1.15) saturate(1.3);
}

.logo-container-ultra-modern:hover img {
    transform: scale(1.1);
    filter: brightness(1.3) contrast(1.3) saturate(1.5) drop-shadow(0 6px 12px rgba(0,0,0,0.2));
}

/* Responsive pour la timeline moderne */
@media (max-width: 768px) {
    .modern-card {
        padding: 25px !important;
    }
    
    .timeline-date {
        padding: 10px 18px !important;
        font-size: 0.9rem !important;
    }
    
    .modern-marker {
        width: 24px !important;
        height: 24px !important;
    }
}

/* Effet de survol pour les cartes de statistiques */
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    border: 2px solid #3b82f6;
}

.stat-card {
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .intro-content {
        grid-column: 1 / -1;
        text-align: center;
    }
    
    .intro-logo {
        grid-column: 1 / -1;
        order: -1;
    }
    
    .mvp-grid {
        grid-template-columns: 1fr !important;
    }
    
    .objectives-grid {
        grid-template-columns: 1fr !important;
    }
    
    .stats-grid {
        grid-template-columns: 1fr 1fr !important;
    }
    
    .timeline-content {
        width: 100% !important;
        margin: 0 !important;
    }
    
    .timeline-line {
        left: 20px !important;
    }
    
    .timeline-marker {
        left: 20px !important;
    }
    
    .link-card {
        flex-direction: column !important;
        text-align: center !important;
    }
    
    .main-title {
        font-size: 2.5rem !important;
    }
    
    .section-title {
        font-size: 2rem !important;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr !important;
    }
    
    .main-title {
        font-size: 2.2rem !important;
    }
    
    .section-title {
        font-size: 1.8rem !important;
    }
}

/* Styles pour l'animation des compteurs */
.counter-number {
    transition: color 0.3s ease;
}

.counter-number.counting {
    color: #22c55e !important;
}
</style>

<script>
// Animation compteur ULTRA SIMPLE
function startCounterAnimation() {
    console.log('DÉMARRAGE ANIMATION');
    
    // Sélectionner tous les compteurs
    const counters = document.querySelectorAll('.counter-number');
    console.log('Compteurs trouvés:', counters.length);
    
    // Animer chaque compteur
    counters.forEach(function(counter, index) {
        const target = parseInt(counter.getAttribute('data-target'));
        const suffix = counter.getAttribute('data-suffix') || '';
        
        console.log('Animation compteur:', target);
        
        let current = 0;
        const step = target / 100; // 100 étapes
        
        const timer = setInterval(function() {
            current += step;
            
            if (current >= target) {
                current = target;
                clearInterval(timer);
                counter.style.color = '#1f2937';
            } else {
                counter.style.color = '#22c55e';
            }
            
            counter.textContent = Math.floor(current) + suffix;
        }, 20); // 20ms par étape = 2 secondes total
    });
}

// Démarrer dès que possible
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM CHARGÉ');
    
    // Démarrage immédiat
    setTimeout(startCounterAnimation, 1000);
    
    // Test: mettre les valeurs directement si l'animation ne marche pas
    setTimeout(function() {
        const counters = document.querySelectorAll('.counter-number');
        counters.forEach(function(counter) {
            if (counter.textContent === '0') {
                const target = counter.getAttribute('data-target');
                const suffix = counter.getAttribute('data-suffix') || '';
                counter.textContent = target + suffix;
                console.log('Valeur forcée:', target);
            }
        });
    }, 5000);
});

// Animation pour les cartes de stats (existant)
document.addEventListener('DOMContentLoaded', function() {
    const statCards = document.querySelectorAll('.stat-card');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';
                entry.target.style.transition = 'all 0.6s ease';
                
                setTimeout(function() {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, Math.random() * 200);
            }
        });
    }, observerOptions);
    
    statCards.forEach(function(card) {
        observer.observe(card);
    });
});
</script>
@endsection 

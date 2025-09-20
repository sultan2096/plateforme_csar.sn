@extends('layouts.public')

@section('title', 'Institution - CSAR')

@section('content')
<!-- Hero Section Modernisé -->
<section class="hero fade-in" style="background: linear-gradient(135deg, #4ade80 0%, #22c55e 50%, #16a34a 100%); min-height: 50vh; display: flex; align-items: center; justify-content: center; padding: 80px 0; position: relative; overflow: hidden;">
    <!-- Arrière-plan animé ultra-moderne -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;">
        <!-- Particules flottantes géométriques -->
        <div class="floating-particle" style="position: absolute; top: 15%; left: 8%; width: 120px; height: 120px; background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.15), transparent); border-radius: 50%; animation: floatParticle 12s ease-in-out infinite, rotate 20s linear infinite;"></div>
        <div class="floating-particle" style="position: absolute; top: 25%; right: 12%; width: 80px; height: 80px; background: conic-gradient(from 45deg, transparent, rgba(255,255,255,0.1), transparent); border-radius: 50%; animation: floatParticle 8s ease-in-out infinite reverse, rotate 15s linear infinite reverse;"></div>
        <div class="floating-particle" style="position: absolute; bottom: 30%; left: 15%; width: 100px; height: 100px; background: conic-gradient(from 90deg, transparent, rgba(255,255,255,0.12), transparent); border-radius: 50%; animation: floatParticle 15s ease-in-out infinite, rotate 25s linear infinite;"></div>
        <div class="floating-particle" style="position: absolute; bottom: 20%; right: 8%; width: 140px; height: 140px; background: conic-gradient(from 180deg, transparent, rgba(255,255,255,0.08), transparent); border-radius: 50%; animation: floatParticle 10s ease-in-out infinite reverse, rotate 18s linear infinite reverse;"></div>
        
        <!-- Formes géométriques modernes -->
        <div style="position: absolute; top: 40%; left: 5%; width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 20% 80% 75% 25% / 30% 25% 75% 70%; animation: float 14s ease-in-out infinite, morph 8s ease-in-out infinite;"></div>
        <div style="position: absolute; top: 60%; right: 5%; width: 80px; height: 80px; background: rgba(255,255,255,0.08); border-radius: 75% 25% 20% 80% / 70% 75% 25% 30%; animation: float 11s ease-in-out infinite reverse, morph 6s ease-in-out infinite reverse;"></div>
        
        <!-- Grille subtile -->
        <div style="position: absolute; inset: 0; background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.03) 1px, transparent 0); background-size: 40px 40px; opacity: 0.5;"></div>
    </div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
        <!-- Titre modernisé avec effet glassmorphism -->
        <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 20px; padding: 40px 60px; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 8px 32px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h1 class="main-title" style="font-size: 3.2rem; font-weight: 900; background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 20px; letter-spacing: -2px; line-height: 1.1;">
            Organisation Institutionnelle
        </h1>
            <div style="width: 80px; height: 4px; background: linear-gradient(135deg, #ffffff 0%, rgba(255,255,255,0.6) 100%); margin: 0 auto 20px; border-radius: 2px;"></div>
            <p class="main-subtitle" style="font-size: 1.3rem; color: rgba(255,255,255,0.95); max-width: 700px; margin: 0 auto; line-height: 1.7; font-weight: 500;">
                Découvrez la structure moderne et l'organisation stratégique du CSAR
            </p>
        </div>
        
        <!-- Badge moderne -->
        <div style="display: inline-flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); padding: 12px 24px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.2);">
            <div style="width: 8px; height: 8px; background: #ffffff; border-radius: 50%; animation: pulse 2s ease-in-out infinite;"></div>
            <span style="color: #ffffff; font-weight: 600; font-size: 0.95rem;">Établissement Public Autonome</span>
        </div>
    </div>
</section>

<!-- Statut juridique Section -->
<section class="section fade-in" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 80px 0; position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.03;">
        <div style="position: absolute; top: 20%; left: 5%; width: 200px; height: 200px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; filter: blur(40px);"></div>
        <div style="position: absolute; bottom: 20%; right: 5%; width: 150px; height: 150px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; filter: blur(30px);"></div>
    </div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 2;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Statut juridique
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                Cadre légal et institutionnel du CSAR
            </p>
        </div>
        
        <div style="max-width: 900px; margin: 0 auto;">
            <div class="legal-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 50px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid #f3f4f6; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);"></div>
                
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(34,197,94,0.3);">
                        <i class="fas fa-gavel" style="font-size: 24px; color: #fff;"></i>
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; color: #1f2937; margin: 0;">Cadre juridique</h3>
                </div>
                
                <p style="font-size: 1.1rem; line-height: 1.8; color: #374151; margin-bottom: 30px; font-weight: 500;">
                    Le Commissariat à la Sécurité Alimentaire et à la Résilience (CSAR) est un établissement public à caractère administratif, doté de l'autonomie administrative et financière, placé sous la tutelle technique du Ministère de la Famille et des Solidarités et sous la tutelle financière du Ministère des Finances et du Budget.
                </p>
                
                <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 30px; border-radius: 15px; border: 1px solid #e0f2fe;">
                    <h4 style="color: #1f2937; margin-bottom: 20px; font-size: 1.3rem; font-weight: 600;">Missions principales :</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; flex-shrink: 0;"></div>
                            <span style="color: #374151; font-weight: 500;">Réguler les marchés de céréales locales et étudier le marché céréalier</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; flex-shrink: 0;"></div>
                            <span style="color: #374151; font-weight: 500;">Participer à l'établissement du bilan céréalier annuel</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; flex-shrink: 0;"></div>
                            <span style="color: #374151; font-weight: 500;">Assurer le suivi et l'interprétation des prix pratiqués sur les marchés</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; flex-shrink: 0;"></div>
                            <span style="color: #374151; font-weight: 500;">Identifier et suivre les groupes à risques alimentaires</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; flex-shrink: 0;"></div>
                            <span style="color: #374151; font-weight: 500;">Gérer les stocks de sécurité alimentaire de l'État</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; flex-shrink: 0;"></div>
                            <span style="color: #374151; font-weight: 500;">Élaborer et mettre en œuvre des plans de réponse à l'insécurité alimentaire</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tutelles Section -->
<section class="section fade-in" style="background: #fff; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Tutelles
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                Cadre de supervision et de coordination
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
            <!-- Tutelle principale -->
            <div class="tutelle-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);"></div>
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: #fff; box-shadow: 0 8px 25px rgba(34,197,94,0.3);">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 style="font-size: 1.4rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Tutelle principale</h3>
                    <p style="font-size: 1.1rem; color: #374151; font-weight: 600; margin-bottom: 15px;">Ministère de la Famille et des Solidarités</p>
                    <p style="color: #6b7280; line-height: 1.6;">
                        Supervision générale et coordination des politiques de solidarité et de sécurité alimentaire
                    </p>
                </div>
            </div>
            
            <!-- Tutelle technique -->
            <div class="tutelle-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);"></div>
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: #fff; box-shadow: 0 8px 25px rgba(59,130,246,0.3);">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3 style="font-size: 1.4rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Tutelle technique</h3>
                    <p style="font-size: 1.1rem; color: #374151; font-weight: 600; margin-bottom: 15px;">Ministère de l'Agriculture, de la Souveraineté Alimentaire et de l'Élevage</p>
                    <p style="color: #6b7280; line-height: 1.6;">
                        Supervision technique des activités agricoles et de production alimentaire
                    </p>
                </div>
            </div>
            
            <!-- Tutelle financière -->
            <div class="tutelle-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);"></div>
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: #fff; box-shadow: 0 8px 25px rgba(245,158,11,0.3);">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3 style="font-size: 1.4rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Tutelle financière</h3>
                    <p style="font-size: 1.1rem; color: #374151; font-weight: 600; margin-bottom: 15px;">Ministère de l'Économie, du Plan et de la Coopération</p>
                    <p style="color: #6b7280; line-height: 1.6;">
                        Gestion budgétaire et allocation des ressources financières
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Budget Section -->
<section class="section fade-in" style="background: #fff; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Budget et ressources
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                Allocation des ressources pour la sécurité alimentaire
            </p>
        </div>
        
        <div style="max-width: 900px; margin: 0 auto;">
            <div class="budget-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 50px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid #f3f4f6; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);"></div>
                
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(34,197,94,0.3);">
                        <i class="fas fa-chart-pie" style="font-size: 24px; color: #fff;"></i>
                    </div>
                    <h3 style="font-size: 1.8rem; font-weight: 700; color: #1f2937; margin: 0;">Répartition budgétaire</h3>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 30px 0;">
                    <div style="text-align: center; padding: 30px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 15px; border: 2px solid #e0f2fe;">
                        <div style="font-size: 2.5rem; font-weight: 800; color: #22c55e; margin-bottom: 10px;">40%</div>
                        <div style="color: #374151; font-weight: 600; font-size: 1.1rem;">Opérations</div>
                    </div>
                    
                    <div style="text-align: center; padding: 30px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 15px; border: 2px solid #e0f2fe;">
                        <div style="font-size: 2.5rem; font-weight: 800; color: #3b82f6; margin-bottom: 10px;">25%</div>
                        <div style="color: #374151; font-weight: 600; font-size: 1.1rem;">Personnel</div>
                    </div>
                    
                    <div style="text-align: center; padding: 30px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 15px; border: 2px solid #e0f2fe;">
                        <div style="font-size: 2.5rem; font-weight: 800; color: #f59e0b; margin-bottom: 10px;">20%</div>
                        <div style="color: #374151; font-weight: 600; font-size: 1.1rem;">Infrastructure</div>
                    </div>
                    
                    <div style="text-align: center; padding: 30px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 15px; border: 2px solid #e0f2fe;">
                        <div style="font-size: 2.5rem; font-weight: 800; color: #ef4444; margin-bottom: 10px;">15%</div>
                        <div style="color: #374151; font-weight: 600; font-size: 1.1rem;">Études & Développement</div>
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 25px; border-radius: 15px; border: 1px solid #e0f2fe; text-align: center;">
                    <p style="font-size: 1.2rem; line-height: 1.6; color: #374151; font-weight: 600; margin: 0;">
                        Le CSAR dispose d'un budget annuel de <span style="color: #22c55e; font-weight: 800;">50 milliards de FCFA</span> pour assurer ses missions de sécurité alimentaire et de résilience.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Structure organisationnelle Section -->
<section class="section fade-in" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Structure organisationnelle
            </h2>
            <p class="section-subtitle" style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                Organisation administrative du CSAR selon le Bilan Social 2024
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <!-- Conseil d'administration -->
            <a href="#conseil-administration" style="text-decoration: none; color: inherit;">
                <div class="structure-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden; cursor: pointer;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);"></div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff; box-shadow: 0 8px 25px rgba(34,197,94,0.3);">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Conseil d'administration</h3>
                        <p style="color: #6b7280; font-size: 0.95rem;">Organe de gouvernance</p>
                    </div>
                </div>
            </a>
            
            <!-- Direction Générale -->
            <a href="{{ route('about') }}" style="text-decoration: none; color: inherit;">
                <div class="structure-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden; cursor: pointer;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);"></div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff; box-shadow: 0 8px 25px rgba(59,130,246,0.3);">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Direction Générale</h3>
                        <p style="color: #6b7280; font-size: 0.95rem;">Coordination générale</p>
                    </div>
                </div>
            </a>
            
            <!-- Secrétariat général -->
            <a href="{{ route('action') }}" style="text-decoration: none; color: inherit;">
                <div class="structure-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden; cursor: pointer;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);"></div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff; box-shadow: 0 8px 25px rgba(245,158,11,0.3);">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Secrétariat général</h3>
                        <p style="color: #6b7280; font-size: 0.95rem;">Administration centrale</p>
                    </div>
                </div>
            </a>
            
            <!-- DSAR -->
            <a href="{{ route('sim.index') }}" style="text-decoration: none; color: inherit;">
                <div class="structure-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden; cursor: pointer;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);"></div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff; box-shadow: 0 8px 25px rgba(139,92,246,0.3);">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Direction Sécurité Alimentaire et Résilience</h3>
                        <p style="color: #6b7280; font-size: 0.95rem;">DSAR</p>
                    </div>
                </div>
            </a>
            
            <!-- DFC -->
            <a href="{{ route('about') }}" style="text-decoration: none; color: inherit;">
                <div class="structure-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden; cursor: pointer;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);"></div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff; box-shadow: 0 8px 25px rgba(6,182,212,0.3);">
                            <i class="fas fa-coins"></i>
                        </div>
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Direction Financière et de la Coopération</h3>
                        <p style="color: #6b7280; font-size: 0.95rem;">DFC</p>
                    </div>
                </div>
            </a>
            
            <!-- DPSE -->
            <div class="structure-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);"></div>
                <div style="text-align: center;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff; box-shadow: 0 8px 25px rgba(239,68,68,0.3);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Direction Planification & Suivi Évaluation</h3>
                    <p style="color: #6b7280; font-size: 0.95rem;">DPSE</p>
                </div>
            </div>
            
            <!-- DRH -->
            <div class="structure-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #10b981 0%, #059669 100%);"></div>
                <div style="text-align: center;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff; box-shadow: 0 8px 25px rgba(16,185,129,0.3);">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Direction des Ressources Humaines</h3>
                    <p style="color: #6b7280; font-size: 0.95rem;">DRH</p>
                </div>
            </div>
            
            <!-- DTL -->
            <div class="structure-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #f3f4f6; transition: all 0.3s ease; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);"></div>
                <div style="text-align: center;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: #fff; box-shadow: 0 8px 25px rgba(245,158,11,0.3);">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 style="font-size: 1.3rem; font-weight: 700; color: #1f2937; margin-bottom: 10px;">Direction Technique et Logistique</h3>
                    <p style="color: #6b7280; font-size: 0.95rem;">DTL</p>
                </div>
            </div>
        </div>
        
        <!-- Cellules -->
        <div style="margin-top: 50px;">
            <h3 style="text-align: center; font-size: 1.8rem; font-weight: 700; color: #1f2937; margin-bottom: 30px;">Cellules spécialisées</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div style="background: #fff; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
                    <h4 style="font-size: 1.1rem; font-weight: 600; color: #1f2937; margin-bottom: 8px;">Cellule Contrôle de Gestion</h4>
                    <p style="color: #6b7280; font-size: 0.9rem;">CCG</p>
                </div>
                <div style="background: #fff; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
                    <h4 style="font-size: 1.1rem; font-weight: 600; color: #1f2937; margin-bottom: 8px;">Cellule Audit Interne</h4>
                    <p style="color: #6b7280; font-size: 0.9rem;">CIA</p>
                </div>
                <div style="background: #fff; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
                    <h4 style="font-size: 1.1rem; font-weight: 600; color: #1f2937; margin-bottom: 8px;">Cellule Passation des Marchés</h4>
                    <p style="color: #6b7280; font-size: 0.9rem;">CPM</p>
                </div>
                <div style="background: #fff; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
                    <h4 style="font-size: 1.1rem; font-weight: 600; color: #1f2937; margin-bottom: 8px;">Cellule Informatique</h4>
                    <p style="color: #6b7280; font-size: 0.9rem;">CI</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
/* Animations de base */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes shine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Nouvelles animations modernes */
@keyframes floatParticle {
    0%, 100% { 
        transform: translateY(0px) translateX(0px); 
    }
    25% { 
        transform: translateY(-20px) translateX(10px); 
    }
    50% { 
        transform: translateY(-35px) translateX(-5px); 
    }
    75% { 
        transform: translateY(-15px) translateX(-10px); 
    }
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes morph {
    0%, 100% { 
        border-radius: 20% 80% 75% 25% / 30% 25% 75% 70%; 
        transform: scale(1);
    }
    25% { 
        border-radius: 75% 25% 30% 70% / 80% 70% 30% 20%; 
        transform: scale(1.1);
    }
    50% { 
        border-radius: 50% 50% 50% 50% / 50% 50% 50% 50%; 
        transform: scale(0.9);
    }
    75% { 
        border-radius: 80% 20% 70% 30% / 25% 75% 25% 75%; 
        transform: scale(1.05);
    }
}

@keyframes pulse {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.7; 
        transform: scale(1.2);
    }
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* Effets de hover modernisés */
.zoom-hover:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0,0,0,0.2);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.tutelle-card:hover {
    transform: translateY(-10px) rotateY(5deg);
    box-shadow: 0 30px 60px rgba(0,0,0,0.15);
}

.structure-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    filter: brightness(1.05);
}

/* Classes d'animation */
.fade-in {
    animation: fadeIn 1s ease-out;
}

.floating-particle {
    will-change: transform;
}

/* Responsive design amélioré */
@media (max-width: 768px) {
    .main-title {
        font-size: 2.2rem !important;
        letter-spacing: -1px !important;
    }
    
    .section-title {
        font-size: 2rem !important;
    }
    
    .tutelle-card, .structure-card {
        padding: 30px 20px !important;
    }
    
    .floating-particle {
        display: none;
    }
    
    .hero {
        min-height: 40vh !important;
        padding: 60px 0 !important;
    }
}

@media (max-width: 480px) {
    .main-title {
        font-size: 1.8rem !important;
    }
    
    .main-subtitle {
        font-size: 1rem !important;
    }
}

/* Améliorations de performance */
* {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.hero, .section {
    will-change: transform;
}
</style>
@endsection

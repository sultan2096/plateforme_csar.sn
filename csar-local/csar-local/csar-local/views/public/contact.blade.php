@extends('layouts.public')

@section('title', 'Contact - CSAR')

@section('content')

<!-- Hero Section -->
<section class="hero-section fade-in" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); min-height: 40vh; padding: 50px 0; position: relative; overflow: hidden;">
    <!-- Floating decorative elements -->
    <div style="position: absolute; top: 20px; left: 10%; width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
    <div style="position: absolute; top: 80px; right: 15%; width: 40px; height: 40px; background: rgba(255,255,255,0.08); border-radius: 50%; animation: float 8s ease-in-out infinite reverse;"></div>
    <div style="position: absolute; bottom: 40px; left: 20%; width: 50px; height: 50px; background: rgba(255,255,255,0.06); border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; text-align: center; position: relative; z-index: 2;">
        <h1 class="main-title" style="font-size: 2.8rem; font-weight: 800; color: #fff; margin-bottom: 20px; text-shadow: 0 4px 8px rgba(0,0,0,0.3);">
            Contactez-nous
        </h1>
        <p class="main-subtitle" style="font-size: 1.2rem; color: rgba(255,255,255,0.9); max-width: 800px; margin: 0 auto; line-height: 1.6; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            Notre équipe est à votre disposition pour vous accompagner
        </p>
        

    </div>
</section>



<!-- Main Contact Section -->
<section class="contact-main-section fade-in" style="background: #f8fafc; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start;">
            
            <!-- Formulaire de contact -->
            <div class="contact-form-card" style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
                    <div style="background: linear-gradient(135deg, #059669 0%, #047857 100%); padding: 15px; border-radius: 15px;">
                        <i class="fas fa-envelope" style="font-size: 1.5rem; color: #fff;"></i>
                    </div>
                    <div>
                        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1f2937; margin-bottom: 5px;">Envoyez-nous un message</h2>
                        <p style="color: #6b7280; font-size: 0.95rem;">Notre équipe vous répondra dans les plus brefs délais</p>
                    </div>
                </div>
                
                <form action="{{ route('contact.submit') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label for="first_name" style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Prénom *</label>
                            <input type="text" id="first_name" name="first_name" required 
                                   style="width: 100%; padding: 15px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 0.95rem; transition: all 0.3s ease; background: #f9fafb;">
                        </div>
                        
                        <div>
                            <label for="last_name" style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Nom *</label>
                            <input type="text" id="last_name" name="last_name" required 
                                   style="width: 100%; padding: 15px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 0.95rem; transition: all 0.3s ease; background: #f9fafb;">
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label for="email" style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Email *</label>
                            <input type="email" id="email" name="email" required 
                                   style="width: 100%; padding: 15px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 0.95rem; transition: all 0.3s ease; background: #f9fafb;">
                        </div>
                        
                        <div>
                            <label for="phone" style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Téléphone *</label>
                            <input type="tel" id="phone" name="phone" required 
                                   style="width: 100%; padding: 15px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 0.95rem; transition: all 0.3s ease; background: #f9fafb;">
                        </div>
                    </div>
                    
                    <div>
                        <label for="subject" style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Sujet *</label>
                        <input type="text" id="subject" name="subject" required 
                               placeholder="Entrez le sujet de votre message"
                               style="width: 100%; padding: 15px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 0.95rem; transition: all 0.3s ease; background: #f9fafb;">
                    </div>
                    
                    <div>
                        <label for="message" style="display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px;">Votre message *</label>
                        <textarea id="message" name="message" rows="6" required 
                                  placeholder="Décrivez votre demande..."
                                  style="width: 100%; padding: 15px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 0.95rem; resize: vertical; transition: all 0.3s ease; background: #f9fafb; font-family: inherit;"></textarea>
                    </div>
                    
                    <button type="submit" 
                            style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; font-size: 1rem; font-weight: 600; padding: 18px 30px; border: none; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3); display: inline-flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="fas fa-paper-plane"></i>
                        Envoyer le message
                    </button>
                </form>
            </div>
            
            <!-- Section droite avec informations -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                
                <!-- Section Urgence -->
                <div class="emergency-card zoom-hover" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); border-radius: 20px; padding: 30px; color: white; box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                        <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 15px;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; color: #fff;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1.4rem; font-weight: 700; margin-bottom: 5px;">Urgence</h3>
                            <p style="opacity: 0.9; font-size: 0.9rem;">Pour les situations d'urgence alimentaire</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 15px; background: rgba(255,255,255,0.1); padding: 20px; border-radius: 15px; backdrop-filter: blur(10px);">
                        <i class="fas fa-phone" style="font-size: 1.5rem;"></i>
                        <span style="font-size: 1.2rem; font-weight: 600;">+221 77 645 92 42</span>
                    </div>
                </div>
                
                <!-- Informations de contact -->
                <div class="info-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
                    <h3 style="font-size: 1.4rem; font-weight: 700; color: #1f2937; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-info-circle" style="color: #059669;"></i>
                        Informations de contact
                    </h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f9fafb; border-radius: 12px;">
                            <div style="background: linear-gradient(135deg, #059669 0%, #047857 100%); padding: 12px; border-radius: 12px;">
                                <i class="fas fa-envelope" style="font-size: 1.2rem; color: #fff;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #1f2937; margin-bottom: 2px;">Email</div>
                                <div style="color: #6b7280; font-size: 0.9rem;">contact@csar.sn</div>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f9fafb; border-radius: 12px;">
                            <div style="background: linear-gradient(135deg, #059669 0%, #047857 100%); padding: 12px; border-radius: 12px;">
                                <i class="fas fa-clock" style="font-size: 1.2rem; color: #fff;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #1f2937; margin-bottom: 2px;">Horaires</div>
                                <div style="color: #6b7280; font-size: 0.9rem;">Lun - Ven: 8h00 - 17h00</div>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f9fafb; border-radius: 12px;">
                            <div style="background: linear-gradient(135deg, #059669 0%, #047857 100%); padding: 12px; border-radius: 12px;">
                                <i class="fas fa-globe" style="font-size: 1.2rem; color: #fff;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #1f2937; margin-bottom: 2px;">Site web</div>
                                <div style="color: #6b7280; font-size: 0.9rem;">www.csar.sn</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Réseaux sociaux -->
                <div class="social-card zoom-hover" style="background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
                    <h3 style="font-size: 1.4rem; font-weight: 700; color: #1f2937; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-share-alt" style="color: #059669;"></i>
                        Suivez-nous
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                        <a href="https://www.instagram.com/csar.sn?igsh=MWcxbTJnNzBnZGo5Mg%3D%3D&utm_source=qr" target="_blank" class="social-btn" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px; background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); border-radius: 12px; color: white; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);">
                            <i class="fab fa-instagram" style="font-size: 1.2rem;"></i>
                            <span>Instagram</span>
                        </a>
                        
                        <a href="https://x.com/csar_sn?s=21" target="_blank" class="social-btn" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px; background: #000000; border-radius: 12px; color: white; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                            <i class="fab fa-twitter" style="font-size: 1.2rem;"></i>
                            <span>X (Twitter)</span>
                        </a>
                        
                        <a href="https://www.facebook.com/share/1A15LpvcqT/?mibextid=wwXIfr" target="_blank" class="social-btn" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px; background: #1877f2; border-radius: 12px; color: white; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);">
                            <i class="fab fa-facebook-f" style="font-size: 1.2rem;"></i>
                            <span>Facebook</span>
                        </a>
                        
                        <a href="https://www.linkedin.com/company/commissariat-%C3%A0-la-s%C3%A9curit%C3%A9-alimentaire-et-%C3%A0-la-r%C3%A9silience/" target="_blank" class="social-btn" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px; background: #0077b5; border-radius: 12px; color: white; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 119, 181, 0.3);">
                            <i class="fab fa-linkedin-in" style="font-size: 1.2rem;"></i>
                            <span>LinkedIn</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Localisation -->
<section class="location-section fade-in" style="background: #fff; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                Notre Localisation
            </h2>
            <p style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                Retrouvez-nous au cœur de Dakar pour tous vos besoins en sécurité alimentaire
            </p>
        </div>
        
        <div class="location-card" style="background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #f3f4f6;">
            <!-- Adresse cliquable -->
            <div id="address-container" style="text-align: center; margin-bottom: 30px; cursor: pointer;" onclick="openMaps()">
                <div style="display: inline-block; padding: 20px 30px; background: #f9fafb; border-radius: 12px; transition: all 0.3s ease;" 
                     onmouseover="this.style.background='#f3f4f6'" 
                     onmouseout="this.style.background='#f9fafb'">
                    <i class="fas fa-map-marker-alt" style="font-size: 1.5rem; color: #059669; margin-bottom: 10px; display: block;"></i>
                    <div style="font-weight: 600; font-size: 1.1rem; margin-bottom: 5px;">22 Rue Amadou Assane NDOYE X Béranger Féraud</div>
                    <div style="color: #6b7280;">BP 170 Dakar, Sénégal</div>
                    <div style="margin-top: 10px; font-size: 0.9rem; color: #059669;">
                        <i class="fas fa-map-marked-alt"></i> Cliquez pour voir la carte
                    </div>
                </div>
            </div>
            
            <!-- Carte Google Maps centrée sur l'adresse (un seul marqueur) -->
            <div style="width:100%; max-width:700px; margin:40px auto 0; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px #0002;">
              <iframe
                src="https://www.google.com/maps?q=loc:14.668611,-17.430778&hl=fr&z=18&output=embed"
                width="100%"
                height="420"
                style="border:0; border-radius:12px;"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                aria-label="22 Rue Amadou Assane NDOYE X Béranger Féraud, BP 170 Dakar, Sénégal (14.668611,-17.430778)"></iframe>
            </div>
            <div style="text-align:center; margin-top:10px;">
              <a href="https://www.google.com/maps/place/14%C2%B040'07.0%22N+17%C2%B025'50.8%22W/@14.668611,-17.430778,18z"
                 target="_blank"
                 style="color:#059669; font-weight:500; text-decoration:none;">
                 <i class="fas fa-external-link-alt"></i> Ouvrir dans Google Maps
              </a>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in {
    animation: fadeIn 0.8s ease-out;
}

.zoom-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* Styles pour les inputs */
input:focus, textarea:focus {
    outline: none;
    border-color: #059669 !important;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    background: #fff !important;
}

/* Styles pour les boutons */
#show-map-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(5, 150, 105, 0.4) !important;
    background: rgba(255,255,255,0.25) !important;
    border-color: rgba(255,255,255,0.4) !important;
}

.address-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(5, 150, 105, 0.4);
}

.social-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

.map-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .main-title { font-size: 2.2rem !important; }
    .container { padding: 0 15px !important; }
    .contact-main-section .container > div { grid-template-columns: 1fr !important; gap: 30px !important; }
    .social-card .social-btn { grid-template-columns: 1fr !important; }
}
</style>

<script>
function openMaps() {
    window.open('https://www.google.com/maps/place/14%C2%B040%2707.0%22N+17%C2%B025%2750.8%22W/@14.668611,-17.430778,18z', '_blank');
}

document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.zoom-hover').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection 
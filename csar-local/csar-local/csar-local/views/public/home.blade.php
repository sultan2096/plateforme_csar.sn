@extends('layouts.public')

@section('title', 'Accueil - CSAR')

@section('content')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si le slider existe et contient des diapositives
    const slider = document.querySelector('.background-slider');
    if (!slider) return;
    
    const slides = document.querySelectorAll('.background-slide');
    // Appliquer les backgrounds depuis data-bg (évite les erreurs de lint sur style inline)
    slides.forEach(function(s){
        var bg = s.getAttribute('data-bg');
        if (bg) {
            s.style.backgroundImage = "url('" + bg + "')";
        }
    });
    if (slides.length <= 1) return; // Pas besoin d'animer s'il n'y a qu'une seule image
    
    let currentSlide = 0;
    const slideCount = slides.length;
    const slideInterval = 5000; // 5 secondes entre chaque transition
    
    // Fonction pour passer à la diapositive suivante
    function nextSlide() {
        // Masquer la diapositive actuelle
        slides[currentSlide].style.opacity = '0';
        
        // Passer à la diapositive suivante
        currentSlide = (currentSlide + 1) % slideCount;
        
        // Afficher la nouvelle diapositive
        slides[currentSlide].style.opacity = '1';
    }
    
    // Démarrer l'animation du slider
    let slideTimer = setInterval(nextSlide, slideInterval);
    
    // Arrêter le slider quand l'utilisateur interagit avec la page
    function pauseSlider() {
        clearInterval(slideTimer);
    }
    
    // Reprendre le slider après une période d'inactivité
    function resumeSlider() {
        clearInterval(slideTimer);
        slideTimer = setInterval(nextSlide, slideInterval);
    }
    
    // Gérer la pause/reprise au survol (optionnel)
    slider.addEventListener('mouseenter', pauseSlider);
    slider.addEventListener('mouseleave', resumeSlider);
    
    // Reprendre le slider quand la fenêtre est à nouveau visible
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            pauseSlider();
        } else {
            resumeSlider();
        }
    });
    
    // Pour les appareils tactiles
    let touchStartX = 0;
    let touchEndX = 0;
    
    slider.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        pauseSlider();
    }, { passive: true });
    
    slider.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        resumeSlider();
    }, { passive: true });
    
    function handleSwipe() {
        const swipeThreshold = 50; // Seuil de balayage minimal en pixels
        const swipeDifference = touchStartX - touchEndX;
        
        // Balayage vers la gauche (diapositive suivante)
        if (swipeDifference > swipeThreshold) {
            nextSlide();
        } 
        // Balayage vers la droite (diapositive précédente)
        else if (swipeDifference < -swipeThreshold) {
            // Masquer la diapositive actuelle
            slides[currentSlide].style.opacity = '0';
            
            // Passer à la diapositive précédente
            currentSlide = (currentSlide - 1 + slideCount) % slideCount;
            
            // Afficher la nouvelle diapositive
            slides[currentSlide].style.opacity = '1';
        }
    }
});
</script>

<!-- Hero Section with Dynamic Background -->
<section class="hero fade-in" style="
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 80px 0;
    position: relative;
    overflow: hidden;
    background-image: url('/img/1.jpg');
    background-size: cover;
    background-position: center;">
    
    <!-- Slider d'images de fond -->
        <div class="background-slider">
        
        @if(!empty($backgroundSlider) && count($backgroundSlider) > 0)
            @foreach($backgroundSlider as $index => $slide)
                <div class="background-slide {{ $index === 0 ? 'active' : '' }}" data-bg="{{ $slide['image'] }}"></div>
            @endforeach
        @else
            <!-- Image de fond par défaut si aucune image n'est configurée -->
            @php($defaultBg = !empty($backgroundImage) ? $backgroundImage : asset('img/1.jpg'))
            <div class="background-slide active" data-bg="{{ $defaultBg }}"></div>
        @endif

        <!-- Assombrissement doux au-dessus de l'image -->
        <div class="background-overlay"></div>
        

        <!-- Motifs décoratifs animés -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1; z-index: 0; pointer-events: none;">
            <div class="floating-circle" style="position: absolute; top: 10%; left: 10%; width: 100px; height: 100px; background: #fff; border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
            <div class="floating-circle" style="position: absolute; top: 20%; right: 15%; width: 60px; height: 60px; background: #fff; border-radius: 50%; animation: float 8s ease-in-out infinite reverse;"></div>
            <div class="floating-circle" style="position: absolute; bottom: 30%; left: 20%; width: 80px; height: 80px; background: #fff; border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
            <div class="floating-circle" style="position: absolute; bottom: 20%; right: 10%; width: 120px; height: 120px; background: #fff; border-radius: 50%; animation: float 9s ease-in-out infinite reverse;"></div>
        </div>
    </div>
    
    <div class="container hero-glow" style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2; color: #fff;">

        <h1 class="main-title animated-title" style="font-size: 3.5rem; font-weight: 900; color: #fff; margin-bottom: 24px; letter-spacing: -1px; line-height: 1.2; text-shadow: 0 8px 24px #222, 0 2px 8px #000; position: relative;">
            <span data-typewriter="Commissariat à la Sécurité Alimentaire et à la Résilience"
                  data-typewriter-mode="letter"
                  data-typewriter-letter-delay="35"
                  data-typewriter-erase-delay="20"
                  data-typewriter-loop="true"
                  data-typewriter-loop-ms="10000"
                  data-typewriter-caret="true"></span>
        </h1>
        <p class="main-subtitle animated-subtitle" style="font-size: 1.4rem; color: #f3f4f6; max-width: 800px; margin: 0 auto 40px; line-height: 1.6; text-shadow: 0 4px 16px #222, 0 1px 4px #000; font-weight: 600; letter-spacing: 0.5px;">

            Le Commissariat à la Sécurité Alimentaire et à la Résilience œuvre pour garantir l'accès à une alimentation suffisante et nutritive pour tous les Sénégalais, tout en renforçant leur capacité à faire face aux crises et aux défis climatiques
        </p>
        
        <div class="animated-buttons" style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-top: 30px;">

            <a href="{{ route('action') }}" class="btn btn-primary zoom-hover" style="background: #2563eb; color: #fff; padding: 18px 36px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.15rem; display: inline-flex; align-items: center; gap: 12px; box-shadow: 0 8px 32px #1e293b99, 0 2px 8px #0004; transition: all 0.3s cubic-bezier(.23,1.01,.32,1); border: none; outline: none;">
                <i class="fas fa-clipboard-list"></i> Effectuer une demande
            </a>
            <a href="{{ route('about') }}" class="btn btn-secondary zoom-hover" style="background: rgba(255,255,255,0.12); color: #fff; border: 2px solid #fff; padding: 18px 36px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.15rem; display: inline-flex; align-items: center; gap: 12px; transition: all 0.3s cubic-bezier(.23,1.01,.32,1); box-shadow: 0 4px 16px #2228, 0 1px 4px #0003;">
                <i class="fas fa-info-circle"></i> Découvrir le CSAR
            </a>
        </div>
    </div>
</section>

<script>
(function () {
  const el = document.querySelector('[data-typewriter]');
  if (!el) return;

  const text = el.dataset.typewriter || el.textContent.trim();
  const mode = el.dataset.typewriterMode || 'letter'; // 'word' | 'letter'
  const wordDelay = Number(el.dataset.typewriterWordDelay || 420);
  const letterDelay = Number(el.dataset.typewriterLetterDelay || 35);
  const eraseDelay = Number(el.dataset.typewriterEraseDelay || 20);
  const loop = (el.dataset.typewriterLoop || 'true') === 'true';
  const loopMs = Number(el.dataset.typewriterLoopMs || 10000);
  const showCaret = (el.dataset.typewriterCaret || 'true') === 'true';

  el.setAttribute('aria-live', 'polite');
  el.setAttribute('aria-atomic', 'true');
  el.style.whiteSpace = 'pre-wrap';

  // caret
  const styleId = 'tw-caret-style';
  if (!document.getElementById(styleId)) {
    const s = document.createElement('style');
    s.id = styleId;
    s.textContent = '@keyframes twblink{0%{opacity:1}50%{opacity:0}100%{opacity:1}}';
    document.head.appendChild(s);
  }
  const caret = document.createElement('span');
  caret.textContent = '▍';
  caret.style.marginLeft = '6px';
  caret.style.opacity = '0.85';
  caret.style.animation = 'twblink 1s steps(1,end) infinite';
  if (showCaret) el.appendChild(caret);

  const setText = (t) => {
    if (el.firstChild && el.firstChild.nodeType === Node.TEXT_NODE) {
      el.firstChild.nodeValue = t;
    } else {
      el.insertBefore(document.createTextNode(t), el.firstChild || el);
    }
  };
  const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

  async function wordByWord() {
    setText('');
    const words = text.split(/\s+/);
    let current = '';
    for (let i = 0; i < words.length; i++) {
      current += (i ? ' ' : '') + words[i];
      setText(current);
      await sleep(wordDelay);
    }
  }

  async function letterByLetter() {
    setText('');
    for (let i = 0; i < text.length; i++) {
      setText(text.slice(0, i + 1));
      await sleep(letterDelay);
    }
  }

  async function eraseLetters() {
    for (let i = text.length; i >= 0; i--) {
      setText(text.slice(0, i));
      await sleep(eraseDelay);
    }
  }

  async function runOnce() {
    if (mode === 'letter') {
      await letterByLetter();
    } else {
      await wordByWord();
    }
  }

  (async function loopAnim() {
    if (!loop) { await runOnce(); return; }
    // Calcule un cycle total de ~loopMs
    const typeTime = (mode === 'letter') ? text.length * letterDelay : (text.split(/\s+/).length * wordDelay);
    const eraseTime = (mode === 'letter') ? text.length * eraseDelay : (text.split(/\s+/).length * 60);
    const rest = Math.max(0, loopMs - typeTime - eraseTime);
    const pauseBeforeErase = Math.floor(rest / 2);
    const pauseAfterErase = Math.max(0, rest - pauseBeforeErase);
    // boucle infinie
    // eslint-disable-next-line no-constant-condition
    while (true) {
      await runOnce();
      await sleep(pauseBeforeErase);
      await eraseLetters();
      await sleep(pauseAfterErase);
    }
  })();
})();
</script>

<!-- Section Actualités & Informations -->
<section class="section fade-in" style="background: #f8fafc; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <h2 class="section-title" style="text-align: center; font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">Actualités & Informations</h2>
        <p class="section-subtitle" style="text-align: center; font-size: 1.2rem; color: #6b7280; margin-bottom: 60px;">Restez informés des dernières nouvelles et initiatives du CSAR</p>
        
        <div class="news-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
            @if(isset($latestNews) && $latestNews->count() > 0)
                @foreach($latestNews as $news)
                <div class="news-card zoom-hover" style="background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    @if($news->image)
                    <div class="news-image" style="height: 200px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @endif
                    <div class="news-content" style="padding: 24px;">
                        <h3 style="font-size: 1.2rem; font-weight: 600; color: #1f2937; margin-bottom: 12px; line-height: 1.4;">{{ $news->title }}</h3>
                        <p style="color: #6b7280; margin-bottom: 16px; line-height: 1.6;">{{ $news->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($news->content), 120) }}</p>
                        <div class="news-meta" style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="news-date" style="color: #9ca3af; font-size: 0.9rem;">
                                <i class="fas fa-calendar"></i> {{ $news->published_at ? $news->published_at->format('d/m/Y') : $news->created_at->format('d/m/Y') }}
                            </span>
                            <a href="{{ route('news.show', $news->id) }}" class="btn btn-primary" style="background: #3b82f6; color: #fff; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 500;">Lire plus</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="news-empty" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <div class="empty-icon" style="width: 80px; height: 80px; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: #9ca3af;">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #6b7280; margin-bottom: 12px;">Aucune actualité disponible</h3>
                    <p style="color: #9ca3af;">Les actualités seront publiées prochainement</p>
                </div>
            @endif
        </div>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('news') }}" class="btn btn-primary zoom-hover" style="background: #3b82f6; color: #fff; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 1.1rem; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-arrow-right"></i>
                Voir toutes les actualités
            </a>
        </div>
    </div>
</section>

<!-- Section Galerie de missions -->
<section class="section fade-in" style="background: #fff; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <h2 class="section-title" style="text-align: center; font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 16px;">Galerie de missions</h2>
        <p class="section-subtitle" style="text-align: center; font-size: 1.2rem; color: #6b7280; margin-bottom: 60px;">Découvrez nos actions sur le terrain</p>
        
        <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <a href="{{ route('gallery') }}" class="gallery-card zoom-hover" style="background: #f8fafc; border-radius: 15px; padding: 40px 30px; text-align: center; border: 1px solid #e5e7eb; transition: all 0.3s ease; text-decoration: none; display: block; cursor: pointer;">
                <div class="gallery-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 32px; color: #fff;">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 600; color: #1f2937; margin-bottom: 15px;">Distributions alimentaires</h3>
                <p style="color: #6b7280; line-height: 1.6;">Nos équipes distribuent des denrées alimentaires aux populations dans le besoin à travers tout le Sénégal</p>
            </a>
            
            <a href="{{ route('institution') }}" class="gallery-card zoom-hover" style="background: #f8fafc; border-radius: 15px; padding: 40px 30px; text-align: center; border: 1px solid #e5e7eb; transition: all 0.3s ease; text-decoration: none; display: block; cursor: pointer;">
                <div class="gallery-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 32px; color: #fff;">
                    <i class="fas fa-warehouse"></i>
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 600; color: #1f2937; margin-bottom: 15px;">Magasins de stockage CSAR</h3>
                <p style="color: #6b7280; line-height: 1.6;">Notre réseau de magasins de stockage stratégiques assure le stockage et la distribution des denrées alimentaires</p>
            </a>
            
            <a href="{{ route('action') }}" class="gallery-card zoom-hover" style="background: #f8fafc; border-radius: 15px; padding: 40px 30px; text-align: center; border: 1px solid #e5e7eb; transition: all 0.3s ease; text-decoration: none; display: block; cursor: pointer;">
                <div class="gallery-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 32px; color: #fff;">
                    <i class="fas fa-users"></i>
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 600; color: #1f2937; margin-bottom: 15px;">Opérations terrain</h3>
                <p style="color: #6b7280; line-height: 1.6;">Nos agents déployés sur le terrain coordonnent les opérations de sécurité alimentaire</p>
            </a>
        </div>
    </div>
</section>


@endsection

@section('styles')
<style>
.background-slider { position:absolute; top:0; left:0; width:100%; height:100%; z-index:0; }
.background-slide { position:absolute; top:0; left:0; width:100%; height:100%; background-position:center; background-size:cover; background-repeat:no-repeat; background-attachment:fixed; transition:opacity 1.5s ease-in-out; z-index:0; opacity:0; }
.background-slide.active { opacity:1; }
.background-overlay { position:absolute; inset:0; background: rgba(0,0,0,1); z-index:1; pointer-events:none; }
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

/* Effet de survol pour les cartes cliquables */
.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    border-color: #3b82f6;
}

.gallery-card {
    transition: all 0.3s ease;
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
    --color-1: #ffffff;
    --color-2: #d1d5db;
    --color-3: #e5e7eb;
    animation-delay: 1.5s;
}

.title-word-5 {
    --color-1: #e5e7eb;
    --color-2: #d1d5db;
    --color-3: #ffffff;
    animation-delay: 2s;
}

.title-word-6 {
    --color-1: #d1d5db;
    --color-2: #ffffff;
    --color-3: #e5e7eb;
    animation-delay: 2.5s;
}

.hero-glow {
    position: relative;
    z-index: 2; /* le texte et les boutons au-dessus de l'overlay */
}
.hero-glow::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -55%);
    width: 90%;
    height: 80%;
    background: radial-gradient(ellipse at center, rgba(255,255,255,0.99) 0%, rgba(255,255,255,0.85) 60%, rgba(255,255,255,0.22) 100%);
    filter: blur(52px);
    opacity: 1;
    z-index: 1;
    pointer-events: none;
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

/* Animation des boutons - effet de slide-in */
.animated-buttons {
    animation: buttons-animation 1.5s ease-out;
    opacity: 0;
    animation-fill-mode: forwards;
    animation-delay: 2s;
}

@keyframes buttons-animation {
    0% {
        opacity: 0;
        transform: translateY(50px) scale(0.8);
    }
    50% {
        opacity: 0.7;
        transform: translateY(25px) scale(0.9);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Effet de pulsation pour les boutons */
.btn-primary:hover {
    animation: pulse 0.6s ease-in-out;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Effet de glow pour le titre au hover */
.animated-title:hover .title-word {
    animation: glow 2s ease-in-out infinite alternate;
}

@keyframes glow {
    from {
        text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px #22c55e, 0 0 20px #22c55e;
    }
    to {
        text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #22c55e, 0 0 40px #22c55e;
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
    transform: scale(1.05);
    transition: all 0.3s ease;
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
    
    .news-grid {
        grid-template-columns: 1fr;
    }
    
    .gallery-grid {
        grid-template-columns: 1fr;
    }
    
    .animated-title {
        flex-direction: column;
        gap: 4px;
    }
}

@media (max-width: 480px) {
    .title-word {
        font-size: 1.8rem !important;
    }
    
    .main-subtitle {
        font-size: 1rem !important;
    }
}
@media (max-width: 480px) {
    .title-word {
        font-size: 1.8rem !important;
    }
    
    .main-subtitle {
        font-size: 1rem !important;
    }
}
</style>
@endsection 
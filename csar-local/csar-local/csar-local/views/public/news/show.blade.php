@extends('layouts.public')

@section('title', $news->title . ' - CSAR')

@section('content')
<!-- Hero Section avec Image de l'actualité -->
<section class="hero-article" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.8), rgba(30, 41, 59, 0.8)), url('{{ $news->image ? asset('storage/' . $news->image) : asset('img/1.jpg') }}'); background-size: cover; background-position: center top; min-height: 60vh; display: flex; align-items: center; position: relative; overflow: hidden;">
    <!-- Particules flottantes -->
    <div style="position: absolute; top: 10%; left: 10%; width: 8px; height: 8px; background: rgba(34, 197, 94, 0.8); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
    <div style="position: absolute; top: 20%; right: 15%; width: 6px; height: 6px; background: rgba(59, 130, 246, 0.7); border-radius: 50%; animation: float 8s ease-in-out infinite reverse;"></div>
    <div style="position: absolute; bottom: 15%; left: 20%; width: 10px; height: 10px; background: rgba(245, 158, 11, 0.6); border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
    
    <!-- Grid pattern overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 40px 40px; opacity: 0.3;"></div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 60px 20px; position: relative; z-index: 2;">
        <div style="max-width: 800px;">
            <!-- Breadcrumb -->
            <nav style="margin-bottom: 30px;">
                <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: rgba(255,255,255,0.7);">
                    <a href="{{ route('home') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#22c55e'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Accueil</a>
                    <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                    <a href="{{ route('news') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='#22c55e'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Actualités</a>
                    <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                    <span style="color: #22c55e; font-weight: 600;">{{ Str::limit($news->title, 50) }}</span>
                </div>
            </nav>
            
            <!-- Type et Date -->
            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 25px;">
                <span style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #fff; padding: 10px 20px; border-radius: 25px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4);">
                    {{ ucfirst($news->type ?? 'Actualité') }}
                </span>
                <div style="display: flex; align-items: center; gap: 10px; color: rgba(255,255,255,0.9);">
                    <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                        <i class="fas fa-calendar-alt" style="color: #22c55e; font-size: 16px;"></i>
                    </div>
                    <span style="font-size: 1rem; font-weight: 500;">
                        {{ $news->published_at->format('d F Y à H:i') }}
                    </span>
                </div>
            </div>
            
            <!-- Titre -->
            <h1 style="font-size: 3rem; font-weight: 800; color: #fff; margin-bottom: 20px; line-height: 1.2; text-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                {{ $news->title }}
            </h1>
            
            <!-- Résumé -->
            <p style="font-size: 1.3rem; color: rgba(255,255,255,0.9); line-height: 1.6; font-weight: 400;">
                {{ Str::limit(strip_tags($news->content), 200) }}
            </p>
        </div>
    </div>
</section>

<!-- Contenu de l'article -->
<section style="background: #f8fafc; padding: 80px 0;">
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        <div style="background: #fff; border-radius: 20px; padding: 50px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; position: relative; overflow: hidden;">
            <!-- Décoration en arrière-plan -->
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: linear-gradient(135deg, rgba(34,197,94,0.05) 0%, rgba(59,130,246,0.05) 100%); border-radius: 50%; z-index: 1;"></div>
            <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: linear-gradient(135deg, rgba(245,158,11,0.05) 0%, rgba(139,92,246,0.05) 100%); border-radius: 50%; z-index: 1;"></div>
            
            <div style="position: relative; z-index: 2;">
                <!-- Métadonnées -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; padding-bottom: 30px; border-bottom: 2px solid #f1f5f9;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">
                            <i class="fas fa-user" style="color: #fff; font-size: 18px;"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1f2937; font-size: 1.1rem;">{{ $news->creator->name ?? 'CSAR' }}</div>
                            <div style="color: #6b7280; font-size: 0.9rem;">Auteur de l'article</div>
                        </div>
                    </div>
                    
                    <!-- Boutons de partage -->
                    <div style="display: flex; gap: 10px;">
                        <button onclick="shareOnFacebook()" style="width: 45px; height: 45px; background: #1877f2; border: none; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(24, 119, 242, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(24, 119, 242, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(24, 119, 242, 0.3)'">
                            <i class="fab fa-facebook-f" style="color: #fff; font-size: 16px;"></i>
                        </button>
                        <button onclick="shareOnTwitter()" style="width: 45px; height: 45px; background: #1da1f2; border: none; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(29, 161, 242, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(29, 161, 242, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(29, 161, 242, 0.3)'">
                            <i class="fab fa-twitter" style="color: #fff; font-size: 16px;"></i>
                        </button>
                        <button onclick="shareOnLinkedIn()" style="width: 45px; height: 45px; background: #0a66c2; border: none; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(10, 102, 194, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(10, 102, 194, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(10, 102, 194, 0.3)'">
                            <i class="fab fa-linkedin-in" style="color: #fff; font-size: 16px;"></i>
                        </button>
                        <button onclick="copyToClipboard()" style="width: 45px; height: 45px; background: #6b7280; border: none; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(107, 114, 128, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(107, 114, 128, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(107, 114, 128, 0.3)'">
                            <i class="fas fa-link" style="color: #fff; font-size: 16px;"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Image de l'article (si présente) -->
                @if($news->image)
                <div style="margin-bottom: 40px; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" 
                         style="width: 100%; height: 500px; object-fit: cover; object-position: center top; display: block;">
                </div>
                @endif
                
                <!-- Contenu -->
                <div style="font-size: 1.1rem; line-height: 1.8; color: #374151; word-wrap: break-word;">
                    {!! nl2br(e($news->content)) !!}
                </div>
                
                <!-- Vidéo (si présente) -->
                @if($news->video_url)
                <div style="margin-top: 40px; padding: 30px; background: #f8fafc; border-radius: 15px; border-left: 4px solid #22c55e;">
                    <h4 style="color: #1f2937; margin-bottom: 20px; font-size: 1.2rem; font-weight: 600;">📹 Vidéo associée</h4>
                    <div style="position: relative; padding-bottom: 56.25%; height: 0; border-radius: 10px; overflow: hidden;">
                        <iframe src="{{ $news->video_url }}" 
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; border-radius: 10px;"
                                allowfullscreen></iframe>
                    </div>
                </div>
                @endif
                
                <!-- Document (si présent) -->
                @if($news->document)
                <div style="margin-top: 40px; padding: 25px; background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-radius: 15px; border: 1px solid #e0e7ff;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-pdf" style="color: #fff; font-size: 20px;"></i>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="color: #1f2937; margin: 0 0 5px 0; font-size: 1.1rem; font-weight: 600;">Document associé</h4>
                            <p style="color: #6b7280; margin: 0; font-size: 0.9rem;">Téléchargez le document complet de cette actualité</p>
                        </div>
                        <a href="{{ asset('storage/' . $news->document) }}" target="_blank" 
                           style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: #fff; padding: 12px 20px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);"
                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(59, 130, 246, 0.4)'"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(59, 130, 246, 0.3)'">
                            <i class="fas fa-download" style="margin-right: 8px;"></i>
                            Télécharger
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Bouton retour -->
        <div style="text-align: center; margin-top: 50px;">
            <a href="{{ route('news') }}" 
               style="display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #fff; padding: 15px 30px; border-radius: 15px; text-decoration: none; font-weight: 600; font-size: 1rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);"
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(34, 197, 94, 0.4)'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(34, 197, 94, 0.3)'">
                <i class="fas fa-arrow-left"></i>
                Retour aux actualités
            </a>
        </div>
    </div>
</section>

<!-- Section Actualités similaires -->
@if(isset($relatedNews) && $relatedNews->count() > 0)
<section style="background: #fff; padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: #1f2937; margin-bottom: 15px;">
                Actualités similaires
            </h2>
            <p style="font-size: 1.2rem; color: #6b7280; max-width: 600px; margin: 0 auto;">
                Découvrez d'autres actualités qui pourraient vous intéresser
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            @foreach($relatedNews as $article)
            <a href="{{ route('news.show', $article->id) }}" style="background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 1px solid #f3f4f6; transition: all 0.3s ease; text-decoration: none; display: block;">
                @if($article->image)
                <div style="height: 180px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                </div>
                @endif
                <div style="padding: 25px;">
                    <div style="color: #22c55e; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; margin-bottom: 10px;">
                        {{ ucfirst($article->type ?? 'Actualité') }}
                    </div>
                    <h3 style="font-size: 1.1rem; font-weight: 600; color: #1f2937; margin-bottom: 10px; line-height: 1.4;">
                        {{ Str::limit($article->title, 80) }}
                    </h3>
                    <div style="color: #6b7280; font-size: 0.85rem;">
                        {{ $article->published_at->format('d F Y') }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.hero-article {
    background-attachment: fixed;
}

@media (max-width: 768px) {
    .hero-article h1 {
        font-size: 2rem !important;
    }
    
    .hero-article p {
        font-size: 1.1rem !important;
    }
    
    .container {
        padding: 40px 15px !important;
    }
}
</style>

<script>
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('{{ addslashes($news->title) }}');
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('{{ addslashes($news->title) }}');
    window.open(`https://twitter.com/intent/tweet?text=${title}&url=${url}`, '_blank', 'width=600,height=400');
}

function shareOnLinkedIn() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('{{ addslashes($news->title) }}');
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
}

function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        // Créer une notification temporaire
        const notification = document.createElement('div');
        notification.textContent = 'Lien copié !';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #22c55e;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            z-index: 9999;
            animation: slideIn 0.3s ease;
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 2000);
    });
}

// Animation d'apparition pour les éléments
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });
    
    // Observer tous les éléments avec animation
    document.querySelectorAll('section').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
});
</script>

@endsection

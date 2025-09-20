@extends('layouts.public')

@section('title', 'Actualités - CSAR')

@section('content')
<!-- Hero Section Modernisé -->
<section class="hero-section fade-in" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.9) 50%, rgba(34, 197, 94, 0.9) 100%), url('{{ asset('img/1.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 50vh; display: flex; align-items: center; position: relative; overflow: hidden;">
    
    <!-- Animated Background Grid -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 50px 50px; animation: gridMove 20s linear infinite; opacity: 0.3;"></div>
    
    <!-- Floating geometric shapes -->
    <div style="position: absolute; top: 15%; left: 8%; width: 120px; height: 120px; background: linear-gradient(135deg, rgba(34,197,94,0.2) 0%, rgba(59,130,246,0.1) 100%); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 8s ease-in-out infinite;"></div>
    <div style="position: absolute; top: 25%; right: 12%; width: 100px; height: 100px; background: linear-gradient(135deg, rgba(245,158,11,0.2) 0%, rgba(139,92,246,0.1) 100%); border-radius: 50%; animation: float 10s ease-in-out infinite reverse;"></div>
    <div style="position: absolute; bottom: 20%; left: 15%; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(59,130,246,0.2) 0%, rgba(34,197,94,0.1) 100%); clip-path: polygon(50% 0%, 0% 100%, 100% 100%); animation: float 6s ease-in-out infinite;"></div>
    
    <!-- Particles -->
    <div style="position: absolute; top: 12%; left: 25%; width: 6px; height: 6px; background: #22c55e; border-radius: 50%; animation: float 4s ease-in-out infinite; box-shadow: 0 0 10px rgba(34,197,94,0.8);"></div>
    <div style="position: absolute; top: 35%; right: 30%; width: 4px; height: 4px; background: #3b82f6; border-radius: 50%; animation: float 6s ease-in-out infinite reverse; box-shadow: 0 0 8px rgba(59,130,246,0.8);"></div>
    <div style="position: absolute; bottom: 30%; right: 20%; width: 8px; height: 8px; background: #f59e0b; border-radius: 50%; animation: float 5s ease-in-out infinite; box-shadow: 0 0 12px rgba(245,158,11,0.8);"></div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 80px 20px; text-align: center; position: relative; z-index: 2;">
        <!-- Badge moderne -->
        <div style="display: inline-block; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 50px; padding: 12px 25px; margin-bottom: 30px;">
            <span style="color: #22c55e; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">📰 Centre d'Information</span>
        </div>
        
        <h1 class="main-title" style="font-size: 4rem; font-weight: 900; color: #fff; margin-bottom: 25px; text-shadow: 0 4px 8px rgba(0,0,0,0.3); line-height: 1.1; background: linear-gradient(135deg, #fff 0%, #22c55e 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            Actualités & Informations
        </h1>
        <p class="main-subtitle" style="font-size: 1.5rem; color: rgba(255,255,255,0.9); max-width: 700px; margin: 0 auto; line-height: 1.7; font-weight: 400;">
            Découvrez les dernières nouvelles, communiqués et informations du Commissariat à la Sécurité Alimentaire et à la Résilience
        </p>
        
        <!-- Call to action subtil -->
        <div style="margin-top: 40px;">
            <div style="display: inline-flex; align-items: center; gap: 15px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 15px; padding: 15px 25px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-newspaper" style="color: #fff; font-size: 16px;"></i>
                </div>
                <span style="color: rgba(255,255,255,0.9); font-weight: 500;">Restez informé des dernières actualités</span>
            </div>
        </div>
    </div>
</section>

<!-- Section Filtres et Recherche -->
<section style="background: #fff; padding: 40px 0; border-bottom: 1px solid #e5e7eb;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: center; justify-content: space-between;">
            <!-- Barre de recherche -->
            <div style="flex: 1; min-width: 300px; max-width: 500px;">
                <div style="position: relative;">
                    <input type="text" id="searchNews" placeholder="Rechercher dans les actualités..." 
                           style="width: 100%; padding: 15px 50px 15px 20px; border: 2px solid #e5e7eb; border-radius: 15px; font-size: 1rem; transition: all 0.3s ease; background: #f8fafc;"
                           onfocus="this.style.borderColor='#22c55e'; this.style.background='#fff'; this.style.boxShadow='0 0 0 3px rgba(34,197,94,0.1)'"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f8fafc'; this.style.boxShadow='none'">
                    <div style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #6b7280;">
                        <i class="fas fa-search" style="font-size: 16px;"></i>
                    </div>
                </div>
            </div>
            
            <!-- Filtres par type -->
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button class="filter-btn active" data-filter="all" 
                        style="padding: 12px 20px; border: 2px solid #22c55e; background: #22c55e; color: #fff; border-radius: 25px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;">
                    Tous
                </button>
                <button class="filter-btn" data-filter="article"
                        style="padding: 12px 20px; border: 2px solid #e5e7eb; background: #fff; color: #6b7280; border-radius: 25px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;">
                    Articles
                </button>
                <button class="filter-btn" data-filter="communique"
                        style="padding: 12px 20px; border: 2px solid #e5e7eb; background: #fff; color: #6b7280; border-radius: 25px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;">
                    Communiqués
                </button>
                <button class="filter-btn" data-filter="evenement"
                        style="padding: 12px 20px; border: 2px solid #e5e7eb; background: #fff; color: #6b7280; border-radius: 25px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease;">
                    Événements
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Actualités Section -->
<section class="news-section fade-in" style="background: linear-gradient(135deg, #f8fafc 0%, #ffffff 50%, #f1f5f9 100%); padding: 80px 0; position: relative; overflow: hidden;">
    <!-- Décoration arrière-plan -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(circle at 20% 80%, rgba(34,197,94,0.03) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(59,130,246,0.03) 0%, transparent 50%);"></div>
    
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
        <div style="text-align: center; margin-bottom: 60px;">
            <div style="display: inline-block; background: rgba(34,197,94,0.1); color: #22c55e; padding: 8px 20px; border-radius: 20px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">
                📰 Actualités CSAR
            </div>
            <h2 class="section-title" style="font-size: 3rem; font-weight: 800; color: #1f2937; margin-bottom: 20px; background: linear-gradient(135deg, #1f2937 0%, #22c55e 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Dernières Actualités
            </h2>
            <p class="section-subtitle" style="font-size: 1.3rem; color: #6b7280; max-width: 700px; margin: 0 auto; line-height: 1.6;">
                Restez informé des actions et initiatives du CSAR pour la sécurité alimentaire au Sénégal
            </p>
            
            <!-- Statistiques rapides -->
            <div style="display: flex; justify-content: center; gap: 40px; margin-top: 40px; flex-wrap: wrap;">
                <div style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: 800; color: #22c55e; margin-bottom: 5px;">{{ $news->total() }}</div>
                    <div style="font-size: 0.9rem; color: #6b7280; font-weight: 500;">Total actualités</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: 800; color: #3b82f6; margin-bottom: 5px;">{{ $news->where('type', 'article')->count() }}</div>
                    <div style="font-size: 0.9rem; color: #6b7280; font-weight: 500;">Articles</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: 800; color: #f59e0b; margin-bottom: 5px;">{{ $news->where('type', 'communique')->count() }}</div>
                    <div style="font-size: 0.9rem; color: #6b7280; font-weight: 500;">Communiqués</div>
                </div>
            </div>
        </div>

        @if($news->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(380px, 1fr)); gap: 35px;">
            @foreach($news as $article)
            <article class="news-card modern-card" data-type="{{ $article->type ?? 'article' }}" style="background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid rgba(229,231,235,0.6); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; text-decoration: none; display: block; cursor: pointer; backdrop-filter: blur(10px);">
                
                <!-- Effet de brillance au survol -->
                <div class="shine-effect" style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); transition: left 0.6s ease; z-index: 4; pointer-events: none;"></div>
                
                <!-- Image avec overlay moderne -->
                @if($article->image)
                <div style="position: relative; height: 260px; overflow: hidden; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover; object-position: center top; transition: all 0.5s ease; display: block;">
                    
                    <!-- Overlay dégradé dynamique -->
                    <div class="image-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.1) 0%, rgba(34,197,94,0.2) 100%); opacity: 0; transition: all 0.4s ease;"></div>
                    
                    <!-- Badge type avec animation -->
                    <div style="position: absolute; top: 20px; left: 20px; z-index: 3;">
                        <span class="type-badge" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #fff; padding: 10px 18px; border-radius: 25px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4); backdrop-filter: blur(10px); transform: translateY(0); transition: transform 0.3s ease;">
                            {{ ucfirst($article->type ?? 'Actualité') }}
                        </span>
                    </div>
                    
                    <!-- Badge date en coin -->
                    <div style="position: absolute; top: 20px; right: 20px; background: rgba(0,0,0,0.7); color: #fff; padding: 8px 12px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; backdrop-filter: blur(10px); z-index: 3;">
                        {{ $article->published_at->format('d M') }}
                    </div>
                    
                    <!-- Icône de lecture animée -->
                    <div class="read-icon" style="position: absolute; bottom: 20px; right: 20px; width: 55px; height: 55px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; opacity: 0; transform: scale(0.8); transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); z-index: 3; box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);">
                        <i class="fas fa-play" style="color: #fff; font-size: 16px; margin-left: 2px;"></i>
                    </div>
                    
                    <!-- Particules décoratives -->
                    <div style="position: absolute; top: 15%; left: 15%; width: 6px; height: 6px; background: rgba(34,197,94,0.6); border-radius: 50%; animation: float 3s ease-in-out infinite; z-index: 2;"></div>
                    <div style="position: absolute; top: 30%; right: 25%; width: 4px; height: 4px; background: rgba(59,130,246,0.5); border-radius: 50%; animation: float 4s ease-in-out infinite reverse; z-index: 2;"></div>
                </div>
                @else
                <!-- Placeholder pour les articles sans image -->
                <div style="position: relative; height: 240px; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); display: flex; align-items: center; justify-content: center;">
                    <div style="text-align: center; color: #94a3b8;">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                            <i class="fas fa-newspaper" style="font-size: 30px; color: #64748b;"></i>
                        </div>
                        <span style="font-size: 0.9rem; font-weight: 500;">{{ ucfirst($article->type ?? 'Actualité') }}</span>
                    </div>
                    
                    <!-- Badge type pour articles sans image -->
                    <div style="position: absolute; top: 20px; left: 20px; z-index: 3;">
                        <span style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #fff; padding: 10px 18px; border-radius: 25px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4);">
                            {{ ucfirst($article->type ?? 'Actualité') }}
                        </span>
                    </div>
                </div>
                @endif
                
                <!-- Contenu modernisé -->
                <div style="padding: 35px 30px;">
                    <!-- Date et temps de lecture -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 45px; height: 45px; background: linear-gradient(135deg, rgba(34,197,94,0.1) 0%, rgba(22,163,74,0.1) 100%); border: 2px solid rgba(34,197,94,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar-alt" style="color: #22c55e; font-size: 16px;"></i>
                            </div>
                            <div>
                                <div style="color: #1f2937; font-size: 0.9rem; font-weight: 600;">
                                    {{ $article->published_at->format('d F Y') }}
                                </div>
                                <div style="color: #9ca3af; font-size: 0.8rem;">
                                    {{ $article->published_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                        
                        <div style="background: rgba(34,197,94,0.1); color: #22c55e; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-clock" style="margin-right: 4px;"></i>
                            {{ rand(2, 8) }} min
                        </div>
                    </div>
                    
                    <!-- Titre modernisé -->
                    <h3 style="font-size: 1.4rem; font-weight: 700; color: #1f2937; margin-bottom: 15px; line-height: 1.3; min-height: 66px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        {{ $article->title }}
                    </h3>
                    
                    <!-- Extrait modernisé -->
                    <p style="color: #6b7280; line-height: 1.7; margin-bottom: 25px; font-size: 1rem; min-height: 72px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                        {{ Str::limit(strip_tags($article->content), 180) }}
                    </p>
                    
                    <!-- Footer avec auteur et CTA -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);">
                                <i class="fas fa-user" style="color: #fff; font-size: 14px;"></i>
                            </div>
                            <div>
                                <div style="color: #374151; font-size: 0.85rem; font-weight: 600;">
                                    {{ $article->creator->name ?? 'CSAR' }}
                                </div>
                                <div style="color: #9ca3af; font-size: 0.75rem;">
                                    Auteur
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('news.show', $article->id) }}" class="read-more-btn" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #fff; padding: 12px 20px; border-radius: 12px; text-decoration: none; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);">
                            Lire plus
                            <i class="fas fa-arrow-right" style="font-size: 12px; transition: transform 0.3s ease;"></i>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <!-- Pagination modernisée -->
        @if($news->hasPages())
        <div style="margin-top: 80px; display: flex; justify-content: center;">
            <div style="background: #fff; padding: 20px 30px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border: 1px solid #f1f5f9;">
                <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap; justify-content: center;">
                    
                    <!-- Bouton précédent -->
                    @if($news->onFirstPage())
                    <span style="padding: 12px 18px; color: #9ca3af; background: #f8fafc; border-radius: 12px; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 8px; border: 2px solid #f1f5f9;">
                        <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
                        Précédent
                    </span>
                    @else
                    <a href="{{ $news->previousPageUrl() }}" style="padding: 12px 18px; color: #22c55e; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 12px; font-size: 0.9rem; text-decoration: none; font-weight: 600; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; border: 2px solid rgba(34,197,94,0.2);"
                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(34,197,94,0.2)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
                        Précédent
                    </a>
                    @endif
                    
                    <!-- Numéros de pages -->
                    @php
                        $start = max(1, $news->currentPage() - 2);
                        $end = min($news->lastPage(), $news->currentPage() + 2);
                    @endphp
                    
                    @if($start > 1)
                        <a href="{{ $news->url(1) }}" style="padding: 12px 16px; color: #6b7280; background: #f8fafc; border-radius: 10px; font-size: 0.9rem; text-decoration: none; font-weight: 600; transition: all 0.3s ease; border: 2px solid #f1f5f9; min-width: 44px; text-align: center;"
                           onmouseover="this.style.background='#22c55e'; this.style.color='#fff'; this.style.borderColor='#22c55e'"
                           onmouseout="this.style.background='#f8fafc'; this.style.color='#6b7280'; this.style.borderColor='#f1f5f9'">1</a>
                        @if($start > 2)
                            <span style="color: #9ca3af; font-weight: 600;">...</span>
                        @endif
                    @endif
                    
                    @for($i = $start; $i <= $end; $i++)
                        @if($i == $news->currentPage())
                            <span style="padding: 12px 16px; color: #fff; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); border-radius: 10px; font-size: 0.9rem; font-weight: 700; box-shadow: 0 4px 15px rgba(34,197,94,0.4); border: 2px solid #22c55e; min-width: 44px; text-align: center;">{{ $i }}</span>
                        @else
                            <a href="{{ $news->url($i) }}" style="padding: 12px 16px; color: #6b7280; background: #f8fafc; border-radius: 10px; font-size: 0.9rem; text-decoration: none; font-weight: 600; transition: all 0.3s ease; border: 2px solid #f1f5f9; min-width: 44px; text-align: center;"
                               onmouseover="this.style.background='#22c55e'; this.style.color='#fff'; this.style.borderColor='#22c55e'; this.style.transform='translateY(-2px)'"
                               onmouseout="this.style.background='#f8fafc'; this.style.color='#6b7280'; this.style.borderColor='#f1f5f9'; this.style.transform='translateY(0)'">{{ $i }}</a>
                        @endif
                    @endfor
                    
                    @if($end < $news->lastPage())
                        @if($end < $news->lastPage() - 1)
                            <span style="color: #9ca3af; font-weight: 600;">...</span>
                        @endif
                        <a href="{{ $news->url($news->lastPage()) }}" style="padding: 12px 16px; color: #6b7280; background: #f8fafc; border-radius: 10px; font-size: 0.9rem; text-decoration: none; font-weight: 600; transition: all 0.3s ease; border: 2px solid #f1f5f9; min-width: 44px; text-align: center;"
                           onmouseover="this.style.background='#22c55e'; this.style.color='#fff'; this.style.borderColor='#22c55e'"
                           onmouseout="this.style.background='#f8fafc'; this.style.color='#6b7280'; this.style.borderColor='#f1f5f9'">{{ $news->lastPage() }}</a>
                    @endif
                    
                    <!-- Bouton suivant -->
                    @if($news->hasMorePages())
                    <a href="{{ $news->nextPageUrl() }}" style="padding: 12px 18px; color: #22c55e; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 12px; font-size: 0.9rem; text-decoration: none; font-weight: 600; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; border: 2px solid rgba(34,197,94,0.2);"
                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(34,197,94,0.2)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Suivant
                        <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                    </a>
                    @else
                    <span style="padding: 12px 18px; color: #9ca3af; background: #f8fafc; border-radius: 12px; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 8px; border: 2px solid #f1f5f9;">
                        Suivant
                        <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                    </span>
                    @endif
                </div>
                
                <!-- Informations de pagination -->
                <div style="text-align: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                    <span style="color: #6b7280; font-size: 0.85rem;">
                        Affichage de {{ $news->firstItem() }} à {{ $news->lastItem() }} sur {{ $news->total() }} actualités
                    </span>
                </div>
            </div>
        </div>
        @endif
        
        @else
        <!-- Empty State -->
        <div style="text-align: center; padding: 80px 20px;">
            <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                <i class="fas fa-newspaper" style="font-size: 48px; color: #9ca3af;"></i>
            </div>
            <h3 style="font-size: 1.8rem; font-weight: 700; color: #1f2937; margin-bottom: 15px;">
                Aucune actualité disponible
            </h3>
            <p style="color: #6b7280; font-size: 1.1rem; max-width: 500px; margin: 0 auto; line-height: 1.6;">
                Les actualités du CSAR seront bientôt disponibles. Revenez régulièrement pour découvrir nos dernières nouvelles et initiatives.
            </p>
        </div>
        @endif
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section fade-in" style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%); padding: 80px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; max-width: 600px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: #fff; margin-bottom: 20px;">
                Restez informé
            </h2>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.8); margin-bottom: 40px; line-height: 1.6;">
                Recevez nos dernières actualités et informations directement dans votre boîte mail
            </p>
            
            <form action="{{ route('newsletter.subscribe') }}" method="POST" style="display: flex; gap: 15px; max-width: 500px; margin: 0 auto; flex-wrap: wrap;">
                @csrf
                <input type="email" name="email" placeholder="Votre adresse email" required 
                       style="flex: 1; min-width: 250px; padding: 15px 20px; border: none; border-radius: 10px; font-size: 1rem; background: rgba(255,255,255,0.1); color: #fff; backdrop-filter: blur(10px);">
                <button type="submit" style="padding: 15px 30px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: #fff; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; white-space: nowrap;">
                    S'abonner
                </button>
            </form>
            
            <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem; margin-top: 20px;">
                Nous respectons votre vie privée. Désabonnez-vous à tout moment.
            </p>
        </div>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.zoom-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.zoom-hover:hover img {
    transform: scale(1.05);
}

.read-more-btn:hover {
    color: #16a34a;
}

.read-more-btn:hover i {
    transform: translateX(3px);
}

.fade-in {
    animation: fadeIn 1s ease-out;
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

@media (max-width: 768px) {
    .main-title {
        font-size: 2.5rem !important;
    }
    
    .section-title {
        font-size: 2rem !important;
    }
    
    .news-card {
        margin: 0 10px;
    }
    
    form {
        flex-direction: column !important;
    }
    
    input[type="email"] {
        min-width: auto !important;
    }
}
</style>
<!-- Styles CSS modernisés -->
<style>
/* Animations de base */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes morph {
    0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
    25% { border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%; }
    50% { border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%; }
    75% { border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%; }
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
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

/* Styles pour les filtres */
.filter-btn {
    transition: all 0.3s ease !important;
}

.filter-btn:hover {
    border-color: #22c55e !important;
    color: #22c55e !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
}

.filter-btn.active {
    background: #22c55e !important;
    border-color: #22c55e !important;
    color: #fff !important;
    box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4);
}

/* Styles pour les cartes modernes */
.modern-card {
    animation: slideIn 0.6s ease forwards;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.modern-card:hover {
    transform: translateY(-12px) scale(1.03) !important;
    box-shadow: 0 30px 80px rgba(0,0,0,0.15) !important;
}

.modern-card:hover img {
    transform: scale(1.08) !important;
    filter: brightness(1.1) contrast(1.1) saturate(1.1) !important;
}

.modern-card:hover .image-overlay {
    opacity: 1 !important;
}

.modern-card:hover .read-icon {
    opacity: 1 !important;
    transform: scale(1) !important;
}

.modern-card:hover .shine-effect {
    left: 100% !important;
}

.modern-card:hover .type-badge {
    transform: translateY(-3px) !important;
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.5) !important;
}

/* Animation de filtrage */
.modern-card.filtered-out {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
}

.modern-card.filtered-in {
    opacity: 1;
    transform: scale(1);
    pointer-events: all;
}

.read-more-btn:hover {
    transform: translateX(3px) !important;
    box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4) !important;
}

.read-more-btn:hover i {
    transform: translateX(3px) !important;
}

/* Effets pour les images */
.modern-card img {
    filter: brightness(1.02) contrast(1.05);
}

.modern-card:hover img {
    filter: brightness(1.1) contrast(1.1) saturate(1.1);
}

/* Responsive design */
@media (max-width: 768px) {
    .hero-section h1 {
        font-size: 2.5rem !important;
    }
    
    .hero-section p {
        font-size: 1.2rem !important;
    }
    
    .modern-card {
        margin-bottom: 20px;
    }
    
    .container {
        padding: 60px 15px !important;
    }
}

@media (max-width: 480px) {
    .hero-section {
        min-height: 40vh !important;
    }
    
    .hero-section h1 {
        font-size: 2rem !important;
    }
    
    .hero-section p {
        font-size: 1rem !important;
    }
}

/* Animation pour les éléments au scroll */
.fade-in {
    opacity: 0;
    transform: translateY(30px);
    animation: slideIn 0.8s ease forwards;
}

.fade-in:nth-child(2) { animation-delay: 0.2s; }
.fade-in:nth-child(3) { animation-delay: 0.4s; }
.fade-in:nth-child(4) { animation-delay: 0.6s; }

/* Amélioration de la lisibilité */
.modern-card h3 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.modern-card p {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Loading animation pour les images */
.modern-card img {
    opacity: 0;
    animation: fadeInImage 0.6s ease forwards;
}

@keyframes fadeInImage {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>

<!-- JavaScript pour les interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.modern-card');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchNews');
    let currentFilter = 'all';
    let searchTerm = '';
    
    // Animation d'apparition progressive des cartes
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Gestion des filtres
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            filterBtns.forEach(b => {
                b.classList.remove('active');
                b.style.background = '#fff';
                b.style.borderColor = '#e5e7eb';
                b.style.color = '#6b7280';
            });
            
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            this.style.background = '#22c55e';
            this.style.borderColor = '#22c55e';
            this.style.color = '#fff';
            
            currentFilter = this.dataset.filter;
            filterCards();
        });
    });
    
    // Gestion de la recherche
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            searchTerm = this.value.toLowerCase();
            filterCards();
        });
    }
    
    // Fonction de filtrage
    function filterCards() {
        cards.forEach(card => {
            const cardType = card.dataset.type;
            const cardTitle = card.querySelector('h3').textContent.toLowerCase();
            const cardContent = card.querySelector('p').textContent.toLowerCase();
            
            const matchesFilter = currentFilter === 'all' || cardType === currentFilter;
            const matchesSearch = searchTerm === '' || 
                                cardTitle.includes(searchTerm) || 
                                cardContent.includes(searchTerm);
            
            if (matchesFilter && matchesSearch) {
                card.classList.remove('filtered-out');
                card.classList.add('filtered-in');
                card.style.display = 'block';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, 50);
            } else {
                card.classList.remove('filtered-in');
                card.classList.add('filtered-out');
                setTimeout(() => {
                    card.style.display = 'none';
                }, 400);
            }
        });
        
        // Vérifier s'il y a des résultats
        const visibleCards = document.querySelectorAll('.modern-card.filtered-in');
        const noResultsMessage = document.getElementById('no-results');
        
        if (visibleCards.length === 0) {
            if (!noResultsMessage) {
                const message = document.createElement('div');
                message.id = 'no-results';
                message.style.cssText = `
                    grid-column: 1 / -1;
                    text-align: center;
                    padding: 60px 20px;
                    color: #6b7280;
                    font-size: 1.1rem;
                `;
                message.innerHTML = `
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="fas fa-search" style="font-size: 40px; color: #9ca3af;"></i>
                    </div>
                    <h3 style="color: #374151; margin-bottom: 10px;">Aucun résultat trouvé</h3>
                    <p>Essayez de modifier vos critères de recherche ou de filtrage.</p>
                `;
                document.querySelector('.news-section .container > div:last-child').appendChild(message);
            }
        } else if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }
    
    // Scroll smooth pour la pagination
    const paginationLinks = document.querySelectorAll('a[href*="page="]');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Smooth scroll vers le haut de la section actualités
            const newsSection = document.querySelector('.news-section');
            if (newsSection) {
                setTimeout(() => {
                    newsSection.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            }
        });
    });
    
    // Observation des éléments pour les animations au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // Observer tous les éléments animables
    document.querySelectorAll('.modern-card, .section-title, .section-subtitle').forEach(el => {
        observer.observe(el);
    });
    
    // Parallax léger pour le hero
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero-section');
        if (hero && scrolled < hero.offsetHeight) {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
    
    // Préchargement des images
    const images = document.querySelectorAll('.modern-card img');
    images.forEach(img => {
        if (img.complete) {
            img.style.opacity = '1';
        } else {
            img.addEventListener('load', () => {
                img.style.opacity = '1';
            });
        }
    });
});

// Fonction pour copier le lien d'un article
function copyArticleLink(articleId) {
    const url = `${window.location.origin}/actualites/${articleId}`;
    navigator.clipboard.writeText(url).then(() => {
        showNotification('Lien copié !', 'success');
    });
}

// Fonction pour afficher des notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.innerHTML = `
        <div style="
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#22c55e' : '#3b82f6'};
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 9999;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        ">
            ${message}
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>

@endsection 
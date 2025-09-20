@extends('layouts.public')

@section('title', 'Nos Partenaires - CSAR')

@section('content')
<style>
/* Hero */
.partners-hero{background:linear-gradient(135deg,#1e40af,#06b6d4);color:#fff;padding:56px 0 44px;margin-bottom:12px;border-bottom:1px solid rgba(255,255,255,.15)}
.partners-hero .container{text-align:center}
.partners-hero .title{font-size:2.15rem;font-weight:900;margin:0}
.partners-hero .subtitle{opacity:.9;margin-top:8px}

/* Toolbar */
.toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin:0 0 18px 0}
.filter-btn{border:1px solid #e5e7eb;background:#fff;border-radius:999px;padding:8px 12px;font-weight:600;font-size:.9rem;color:#374151;cursor:pointer;transition:all .2s}
.filter-btn.active,.filter-btn:hover{background:#1e40af;color:#fff;border-color:#1e40af}
.search{flex:1;min-width:220px}
.search input{width:100%;border:1px solid #e5e7eb;border-radius:10px;padding:10px 12px;font-size:.95rem}

/* Grid & Card */
.partners-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:18px}
.partner-card{background:#fff;border:1px solid #e8eef6;border-radius:16px;padding:16px;display:flex;gap:14px;align-items:center;position:relative;overflow:hidden;transition:transform .25s,box-shadow .25s,border-color .25s;box-shadow:0 2px 6px rgba(16,24,40,.04)}
.partner-card:hover{transform:translateY(-6px);box-shadow:0 16px 36px rgba(17,24,39,.12);border-color:#dbe3ee}
.partner-logo{width:64px;height:64px;border-radius:12px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;overflow:hidden}
.partner-logo img{width:100%;height:100%;object-fit:contain;filter:grayscale(100%) contrast(1.05) brightness(.95);transition:filter .25s}
.partner-card:hover .partner-logo img{filter:none}
.partner-name{font-weight:900;color:#0f172a;margin:0;line-height:1.2}
.partner-meta{color:#64748b;font-size:.88rem;margin:2px 0 0 0}
.type-badge{position:absolute;right:10px;top:10px;font-size:.7rem;padding:5px 9px;border-radius:999px;background:#eff6ff;color:#1e40af;font-weight:800;letter-spacing:.3px}
.partner-arrow{position:absolute;right:12px;bottom:12px;color:#334155;opacity:.5;transition:transform .2s,opacity .2s}
.partner-card:hover .partner-arrow{opacity:.9;transform:translateX(3px)}
.type-ong{background:#ecfdf5;color:#065f46}
.type-agency{background:#eff6ff;color:#1e40af}
.type-institution{background:#f3f4f6;color:#374151}
.type-government{background:#fff7ed;color:#9a3412}
.type-private{background:#fef2f2;color:#991b1b}

/* Appear effect */
.reveal{opacity:0;transform:translateY(10px);transition:opacity .6s ease,transform .6s ease}
.reveal.visible{opacity:1;transform:none}

/* Big logo strip */
.logo-hero{background:#fff;padding:12px 0 26px}
.logo-hero h2{font-weight:900;text-align:center;margin:0 0 14px 0}
.marquee{position:relative;overflow:hidden}
.marquee::after,.marquee::before{content:"";position:absolute;top:0;width:60px;height:100%;z-index:2;pointer-events:none}
.marquee::before{left:0;background:linear-gradient(to right,#fff,rgba(255,255,255,0))}
.marquee::after{right:0;background:linear-gradient(to left,#fff,rgba(255,255,255,0))}
.marquee .track{display:flex;gap:70px;align-items:center;animation:logos-scroll 45s linear infinite}
.marquee:hover .track{animation-play-state:paused}
.marquee img{height:90px;width:auto;filter:grayscale(100%) contrast(1.05) brightness(.95);opacity:.9;transition:transform .25s,filter .25s,opacity .25s}
.marquee a:hover img{filter:none;opacity:1;transform:scale(1.06)}
@keyframes logos-scroll{from{transform:translateX(0)}to{transform:translateX(-50%)}}
</style>

<div class="partners-hero">
  <div class="container">
    <h1 class="title">Nos partenaires</h1>
    <p class="subtitle">Organisations qui collaborent avec le CSAR.</p>
  </div>
</div>

@php $allItems = collect($grouped)->flatMap(fn($c) => $c)->values(); @endphp
@if($allItems->count() > 0)
<div class="logo-hero">
  <div class="container">
    <h2>Partenaires techniques et financiers</h2>
    <div class="marquee">
      <div class="track">
        @for($dup=0;$dup<2;$dup++)
          @foreach($allItems as $p)
            @php 
              $logo = $p['logo_url'] ?? ($p->logo ? Storage::url($p->logo) : null);
              $url  = $p['website'] ?? '#';
            @endphp
            @if($logo)
              <a href="{{ $url }}" target="_blank" rel="noopener nofollow"><img src="{{ $logo }}" alt="logo"></a>
            @endif
          @endforeach
        @endfor
      </div>
    </div>
  </div>
</div>
@endif

<div class="container py-5">
  <div class="partners-grid" id="partnersGrid">
    @php $typeLabels=['ong'=>'ONG','agency'=>'Agence','institution'=>'Institution','government'=>'Gouvernement','private'=>'Privé']; @endphp
    @foreach(['ong','agency','institution','government','private'] as $type)
      @foreach(($grouped[$type] ?? collect()) as $p)
        @php 
          $logo = $p['logo_url'] ?? ($p->logo ? Storage::url($p->logo) : null);
          $name = $p['name'] ?? $p->name;
          $org  = trim($p['organization'] ?? ($p->organization ?? ''));
          $url  = $p['website'] ?? '#';
          $domain = $url && $url !== '#' ? preg_replace('/^www\./','', parse_url($url, PHP_URL_HOST) ?? '') : '';
        @endphp
        <a class="partner-card reveal" href="{{ $url }}" target="_blank" rel="noopener nofollow" data-type="{{ $type }}" data-name="{{ Str::lower($name.' '.$org) }}">
          <div class="partner-logo">
            @if($logo) <img src="{{ $logo }}" alt="{{ $name }}"/> @else <i class="fas fa-building"></i> @endif
          </div>
          <div>
            <p class="partner-name">{{ $name }}</p>
            @if($org || $domain)
              <p class="partner-meta">{{ $org }} @if($domain) — {{ $domain }} @endif</p>
            @endif
          </div>
          <div class="type-badge type-{{ $type }}">{{ $typeLabels[$type] }}</div>
          <span class="partner-arrow"><i class="fas fa-arrow-up-right-from-square"></i></span>
        </a>
      @endforeach
    @endforeach
  </div>
</div>

@push('scripts')
<script>
// Reveal on scroll
const io=new IntersectionObserver((entries)=>{entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');io.unobserve(e.target);}})},{threshold:.08});
document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
</script>
@endpush
@endsection



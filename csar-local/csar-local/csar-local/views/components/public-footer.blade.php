<footer style="background: linear-gradient(to right, #23ac0eff, #429237); color: #fff; font-family: inherit;">
  <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
    @php
      $footerPartners = \App\Models\TechnicalPartner::where('status','active')
        ->whereNotNull('logo')
        ->orderBy('name')
        ->take(24)
        ->get();
    @endphp
    @if($footerPartners->count() > 0)
      <style>
        @keyframes footer-scroll{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
      </style>
      <div style="display:flex; align-items:center; justify-content:flex-start; padding:8px 0 2px 0; color:#fff;">
        <div style="font-weight:700; letter-spacing:.3px;">Nos partenaires</div>
      </div>
      <div style="overflow:hidden; border-bottom:1px solid rgba(255,255,255,0.18); padding:10px 0; margin-bottom:8px;">
        <div style="display:flex; gap:28px; align-items:center; width:max-content; animation:footer-scroll 38s linear infinite; will-change:transform;">
          @foreach($footerPartners as $p)
            <a href="{{ $p->website ?: '#' }}" target="_blank" rel="noopener nofollow" title="{{ $p->name }}" style="opacity:.9; transition:opacity .2s; display:flex; align-items:center;">
              <img src="{{ Storage::url($p->logo) }}" alt="{{ $p->name }}" style="height:32px; width:auto; filter:drop-shadow(0 1px 2px rgba(0,0,0,.25));">
            </a>
          @endforeach
          @foreach($footerPartners as $p)
            <a href="{{ $p->website ?: '#' }}" target="_blank" rel="noopener nofollow" title="{{ $p->name }}" style="opacity:.9; transition:opacity .2s; display:flex; align-items:center;">
              <img src="{{ Storage::url($p->logo) }}" alt="{{ $p->name }}" style="height:32px; width:auto; filter:drop-shadow(0 1px 2px rgba(0,0,0,.25));">
            </a>
          @endforeach
        </div>
      </div>
    @endif
    <div style="display:grid; grid-template-columns: repeat(4, minmax(220px, 1fr)); gap: 24px; padding: 36px 0 8px 0;">
      <div style="padding-right:12px;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
          <img src="{{ asset('images/csar-logo.png') }}" alt="CSAR" style="width:44px;height:44px; object-fit:contain; filter: drop-shadow(0 2px 8px rgba(0,0,0,.25));">
          <div style="font-size:20px; font-weight:700; letter-spacing:.3px;">CSAR</div>
        </div>
        <div id="footer-typewriter" data-text="Commissariat à la Sécurité Alimentaire et à la Résilience" data-speed="60" style="min-height:46px; font-size:14px; line-height:1.6; color:rgba(255,255,255,0.95);"></div>
        <div class="social-icons" style="display:flex; gap:10px; margin-top:14px;">
          <a href="https://www.linkedin.com/company/commissariat-%C3%A0-la-s%C3%A9curit%C3%A9-alimentaire-et-%C3%A0-la-r%C3%A9silience/" target="_blank" rel="noopener" style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.18);transition:transform .2s, background .2s;" onmouseover="this.style.transform='scale(1.08)';this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.transform='scale(1)';this.style.background='rgba(255,255,255,0.18)'"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://www.facebook.com/share/1A15LpvcqT/?mibextid=wwXIfr" target="_blank" rel="noopener" style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.18);transition:transform .2s, background .2s;" onmouseover="this.style.transform='scale(1.08)';this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.transform='scale(1)';this.style.background='rgba(255,255,255,0.18)'"><i class="fab fa-facebook-f"></i></a>
          <a href="https://x.com/csar_sn?s=21" target="_blank" rel="noopener" style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.18);transition:transform .2s, background .2s;" onmouseover="this.style.transform='scale(1.08)';this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.transform='scale(1)';this.style.background='rgba(255,255,255,0.18)'"><i class="fab fa-twitter"></i></a>
          <a href="https://www.instagram.com/csar.sn?igsh=MWcxbTJnNzBnZGo5Mg%3D%3D&utm_source=qr" target="_blank" rel="noopener" style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.18);transition:transform .2s, background .2s;" onmouseover="this.style.transform='scale(1.08)';this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.transform='scale(1)';this.style.background='rgba(255,255,255,0.18)'"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
      
      <div style="padding-left:12px; border-left:1px solid rgba(255,255,255,0.15);">
        <div style="font-weight:700; font-size:15px; margin-bottom:10px; letter-spacing:.3px;">Liens rapides</div>
        <ul style="font-size:14px; margin:0; padding:0; list-style:none;">
          <li style="margin-bottom:6px;"><a href="/" style="color:#fff; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Accueil</a></li>
          <li style="margin-bottom:6px;"><a href="/about" style="color:#fff; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">À propos</a></li>
          <li style="margin-bottom:6px;"><a href="/institution" style="color:#fff; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Institution</a></li>
          <li style="margin-bottom:6px;"><a href="/actualites" style="color:#fff; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Actualités</a></li>
          <li><a href="{{ route('sim.index') }}" style="color:#fff; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">SIM</a></li>
          <li style="margin-top:6px;"><a href="{{ route('gallery') }}" style="color:#fff; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Nos missions</a></li>
          
        </ul>
      </div>

      <div style="padding-left:12px; border-left:1px solid rgba(255,255,255,0.15);">
        <div style="font-weight:700; font-size:15px; margin-bottom:10px; letter-spacing:.3px;">Partenaires institutionnels</div>
        <ul style="list-style:none; margin:0; padding:0; font-size:14px;">
          <li style="margin:6px 0;">
            <a href="https://femme.gouv.sn/" target="_blank" rel="noopener nofollow" title="Ministère de la Famille et des Solidarités" style="color:#fff; text-decoration:none; display:flex; align-items:center; gap:10px;">
              <img src="{{ asset('images/Logo_MFS_Bas-240x300.png') }}" alt="Ministère de la Famille et des Solidarités" style="width:20px;height:20px;object-fit:contain;filter:drop-shadow(0 1px 2px rgba(0,0,0,.25))">
              <span>Ministère de la Famille et des Solidarités</span><span style="font-size:12px;opacity:.85;">↗</span>
            </a>
          </li>
          <li style="margin:6px 0;">
            <a href="https://primature.sn/" target="_blank" rel="noopener nofollow" title="Primature du Sénégal" style="color:#fff; text-decoration:none; display:flex; align-items:center; gap:10px;">
              <img src="{{ asset('images/Logo SEC GOUV.jpg') }}" alt="Primature" style="width:20px;height:20px;object-fit:contain;filter:drop-shadow(0 1px 2px rgba(0,0,0,.25))">
              <span>Primature</span><span style="font-size:12px;opacity:.85;">↗</span>
            </a>
          </li>
          <li style="margin:6px 0;">
            <a href="https://www.presidence.sn/" target="_blank" rel="noopener nofollow" title="Présidence de la République" style="color:#fff; text-decoration:none; display:flex; align-items:center; gap:10px;">
              <img src="{{ asset('images/presidence.sn.png') }}" alt="Présidence de la République" style="width:20px;height:20px;object-fit:contain;filter:drop-shadow(0 1px 2px rgba(0,0,0,.25))">
              <span>Présidence de la République</span><span style="font-size:12px;opacity:.85;">↗</span>
            </a>
          </li>
          <li style="margin:8px 0 0 0; padding-top:8px; border-top:1px solid rgba(255,255,255,0.15);">
            <a href="{{ route('partners.index') }}" title="Nos partenaires" style="color:#fff; text-decoration:none; display:flex; align-items:center; gap:10px;">
              <i class="fas fa-handshake"></i>
              <span>Nos partenaires</span>
            </a>
          </li>
        </ul>
      </div>
      
      <div style="padding-left:12px; border-left:1px solid rgba(255,255,255,0.15);">
        <div style="font-weight:700; font-size:15px; margin-bottom:10px; letter-spacing:.3px;">Contact</div>
        <ul style="font-size:14px; margin:0; padding:0; list-style:none;">
          <li style="margin-bottom:6px;"><a href="{{ route('demande.create') }}" style="color:#fff; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Effectuer une demande</a></li>
          <li style="margin-bottom:6px;"><a href="{{ route('contact') }}" style="color:#fff; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Nous contacter</a></li>
          <li style="margin-bottom:6px; font-size:13px;"><i class="fas fa-envelope" style="margin-right:6px;"></i>contact@csar.sn</li>
          <li style="margin-bottom:6px; font-size:13px;"><i class="fas fa-phone" style="margin-right:6px;"></i>+221 33 123 45 67</li>
          <li style="font-size:13px;"><i class="fas fa-map-marker-alt" style="margin-right:6px;"></i>Dakar, Sénégal</li>
        </ul>
      </div>
    </div>
  </div>
  <div style="text-align:center; font-size:12px; padding:14px 0; background:rgba(0,0,0,0.08);">
    © 2025 CSAR - Commissariat à la Sécurité Alimentaire et à la Résilience. Tous droits réservés.
  </div>

  <script>
  (function(){
    var el=document.getElementById('footer-typewriter');
    if(!el) return;
    var text=el.getAttribute('data-text')||''; var i=0; var speed=Number(el.getAttribute('data-speed')||70);
    var caret=document.createElement('span'); caret.textContent='▍'; caret.style.marginLeft='6px'; caret.style.animation='blink 1s steps(1,end) infinite'; el.appendChild(caret);
    if(!document.getElementById('ft-blink-style')){var s=document.createElement('style'); s.id='ft-blink-style'; s.textContent='@keyframes blink{0%{opacity:1}50%{opacity:0}100%{opacity:1}}'; document.head.appendChild(s);}    
    function step(){ if(i<text.length){ el.firstChild && el.firstChild.nodeType===3 ? el.firstChild.nodeValue+=text.charAt(i) : el.insertBefore(document.createTextNode(text.charAt(i)), el.firstChild||el); i++; setTimeout(step, speed);} }
    var io=new IntersectionObserver(function(entries){ if(entries[0].isIntersecting){ step(); io.disconnect(); } },{threshold:0.1}); io.observe(el);
  })();
  </script>
</footer>
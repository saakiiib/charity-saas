// Hero slider: autoplay, dots, arrows
(function(){
  document.querySelectorAll('[data-slider]').forEach(function(root){
    var slides = root.querySelectorAll('.hero-slide');
    var dots = root.querySelectorAll('[data-dots] button');
    var i = 0, timer;
    function go(n){
      i = (n + slides.length) % slides.length;
      slides.forEach(function(s,idx){ s.classList.toggle('is-active', idx===i); });
      dots.forEach(function(d,idx){ d.classList.toggle('is-active', idx===i); });
    }
    function next(){ go(i+1); }
    function prev(){ go(i-1); }
    function start(){ stop(); timer = setInterval(next, 5500); }
    function stop(){ if(timer) clearInterval(timer); }
    root.querySelector('[data-next]') && root.querySelector('[data-next]').addEventListener('click', function(){ next(); start(); });
    root.querySelector('[data-prev]') && root.querySelector('[data-prev]').addEventListener('click', function(){ prev(); start(); });
    dots.forEach(function(d){ d.addEventListener('click', function(){ go(+d.dataset.go); start(); }); });
    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);
    start();
  });
})();

// AOS-like staggered reveal
(function(){
  var els = document.querySelectorAll('.reveal');
  if(!els.length) return;
  // assign per-element delay based on position within parent
  els.forEach(function(el){
    if(el.parentElement){
      var siblings = Array.prototype.filter.call(el.parentElement.children, function(c){return c.classList && c.classList.contains('reveal');});
      var idx = siblings.indexOf(el);
      if(idx > -1) el.style.transitionDelay = Math.min(idx*70, 500) + 'ms';
    }
  });
  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); }
    });
  }, {threshold:0.12, rootMargin:'0px 0px -40px 0px'});
  els.forEach(function(el){ io.observe(el); });
})();

// Lightbox for gallery tiles
(function(){
  var lb = document.querySelector('[data-lb]');
  if(!lb) return;
  var img = lb.querySelector('[data-lb-img]');
  var cap = lb.querySelector('[data-lb-cap]');
  var tiles = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox]'));
  if(!tiles.length){ return; }
  var current = 0;

  function urlOf(tile){
    var bg = tile.style.backgroundImage || getComputedStyle(tile).backgroundImage;
    var m = /url\(["']?([^"')]+)["']?\)/.exec(bg);
    if(!m) return null;
    // upgrade w/q for full-screen viewing
    return m[1].replace(/[?&]w=\d+/, '').replace(/[?&]q=\d+/, '') + (m[1].indexOf('?')>-1?'&':'?') + 'w=1800&q=85';
  }
  function captionOf(tile){
    var s = tile.querySelector('span'), e = tile.querySelector('em');
    return [(s&&s.textContent)||'', (e&&e.textContent)||''].filter(Boolean).join(' — ');
  }
  function open(idx){
    current = (idx + tiles.length) % tiles.length;
    var src = urlOf(tiles[current]);
    if(!src) return;
    img.src = src;
    cap.textContent = captionOf(tiles[current]);
    lb.removeAttribute('hidden');
    requestAnimationFrame(function(){ lb.classList.add('is-open'); });
    document.body.classList.add('lb-open');
  }
  function close(){
    lb.classList.remove('is-open');
    document.body.classList.remove('lb-open');
    setTimeout(function(){ lb.setAttribute('hidden',''); img.src=''; }, 320);
  }
  tiles.forEach(function(t,i){
    t.addEventListener('click', function(){ open(i); });
  });
  lb.querySelector('[data-lb-close]').addEventListener('click', close);
  lb.querySelector('[data-lb-next]').addEventListener('click', function(){ open(current+1); });
  lb.querySelector('[data-lb-prev]').addEventListener('click', function(){ open(current-1); });
  lb.addEventListener('click', function(e){ if(e.target===lb) close(); });
  document.addEventListener('keydown', function(e){
    if(lb.hasAttribute('hidden')) return;
    if(e.key==='Escape') close();
    else if(e.key==='ArrowRight') open(current+1);
    else if(e.key==='ArrowLeft') open(current-1);
  });
})();

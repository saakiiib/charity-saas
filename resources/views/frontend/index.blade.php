@extends('frontend.master')

@section('content')

<section class="hero hero-slider" data-slider>
  <div class="hero-slides">
    <div class="hero-slide is-active" style="background-image:url('https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=1600&q=70')"></div>
    <div class="hero-slide" style="background-image:url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1600&q=70')"></div>
    <div class="hero-slide" style="background-image:url('https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&w=1600&q=70')"></div>
  </div>
  <div class="hero-overlay"></div>
  <div class="container hero-inner">
    <span class="eyebrow">Community-led charity · UK</span>
    <h1 class="hero-title">Building brighter futures, together.</h1>
    <p class="hero-sub">We empower communities through food, education and connection — because everyone deserves a chance to thrive.</p>
    <div class="hero-cta">
      <a class="btn btn-primary" href="#donate">Donate now</a>
      <a class="btn btn-ghost" href="about.html">Get involved</a>
    </div>
  </div>
  <button class="hero-arrow hero-prev" aria-label="Previous slide" data-prev>‹</button>
  <button class="hero-arrow hero-next" aria-label="Next slide" data-next>›</button>
  <div class="hero-dots" data-dots>
    <button class="is-active" data-go="0" aria-label="Slide 1"></button>
    <button data-go="1" aria-label="Slide 2"></button>
    <button data-go="2" aria-label="Slide 3"></button>
  </div>
</section>

<section class="section">
  <div class="container">
    <header class="section-head">
      <h2>How we make a difference</h2>
      <p>Three simple pillars that guide everything we do.</p>
    </header>
    <div class="grid grid-3">
      <article class="card"><span class="card-num">01</span><h3>What we do</h3><p>Food programmes, education workshops and community events that bring people together.</p></article>
      <article class="card"><span class="card-num">02</span><h3>Who we help</h3><p>Families facing hardship, isolated elderly and young people needing guidance.</p></article>
      <article class="card"><span class="card-num">03</span><h3>Why it matters</h3><p>Small acts of kindness ripple outward — one person supported lifts a whole community.</p></article>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <header class="section-head"><h2>Our impact so far</h2><p>Numbers that tell the story of our community.</p></header>
    <div class="grid grid-4 stats">
      <div class="stat"><span class="stat-num">12k+</span><span class="stat-label">People supported</span></div>
      <div class="stat"><span class="stat-num">86k+</span><span class="stat-label">Meals served</span></div>
      <div class="stat"><span class="stat-num">340</span><span class="stat-label">Active volunteers</span></div>
      <div class="stat"><span class="stat-num">24</span><span class="stat-label">Programmes</span></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container feature">
    <div class="feature-media" style="background-image:url('https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&w=1200&q=70')"></div>
    <div class="feature-body">
      <span class="eyebrow">April 2026</span>
      <h2>Spring clean-up: 200 volunteers, one amazing day</h2>
      <p>Volunteers of all ages transformed three local parks, planted 50 new trees and collected over 2 tonnes of litter. Proof that small actions make a big difference.</p>
      <a class="btn btn-ghost" href="updates.html">Read more updates →</a>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <header class="section-head"><h2>What people say</h2><p>Real voices from our community.</p></header>
    <div class="grid grid-2">
      <blockquote class="quote"><span class="qmark" aria-hidden="true">“</span><p>“BrightHope didn't just give us food — they gave us dignity. The volunteers treat everyone with such warmth and respect.”</p><footer><strong>Sarah M.</strong><span>Community member</span></footer></blockquote>
      <blockquote class="quote"><span class="qmark" aria-hidden="true">“</span><p>“Volunteering here changed my life. I came to help others but found a second family. This charity is the real deal.”</p><footer><strong>James K.</strong><span>Volunteer</span></footer></blockquote>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <header class="section-head"><h2>Life in our community</h2><p>A glimpse into the events that make BrightHope what it is.</p></header>
    <div class="gallery">
      <figure class="tile" data-lightbox style="background-image:url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=900&q=70')"><span>Food Hub</span><em>Distributing parcels to local families</em></figure>
      <figure class="tile" data-lightbox style="background-image:url('https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=900&q=70')"><span>Green Spaces</span><em>Community gardening day</em></figure>
      <figure class="tile" data-lightbox style="background-image:url('https://images.unsplash.com/photo-1502086223501-7ea6ecd79368?auto=format&fit=crop&w=900&q=70')"><span>Golden Years</span><em>Weekly tea for elderly residents</em></figure>
      <figure class="tile" data-lightbox style="background-image:url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=900&q=70')"><span>Learning Together</span><em>Mentors supporting young learners</em></figure>
      <figure class="tile" data-lightbox style="background-image:url('https://images.unsplash.com/photo-1593113616828-6f22bca04804?auto=format&fit=crop&w=900&q=70')"><span>Clean-Up Day</span><em>200 volunteers, three parks</em></figure>
      <figure class="tile" data-lightbox style="background-image:url('https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&w=900&q=70')"><span>Summer Festival</span><em>Families celebrating together</em></figure>
    </div>
  </div>
</section>

<section id="donate" class="cta-band">
  <div class="container cta-inner">
    <h2>Every bit of support changes a life.</h2>
    <p>Whether it's £5, an hour of your time, or simply sharing our story — you make a real difference.</p>
    <div class="hero-cta">
      <a class="btn btn-primary" href="contact.html">Donate now</a>
      <a class="btn btn-ghost" href="contact.html">Volunteer with us</a>
    </div>
  </div>
</section>

@endsection
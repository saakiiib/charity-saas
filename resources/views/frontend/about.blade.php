@extends('frontend.master')

@section('content')

<section class="page-hero" style="background-image:url('https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&w=1600&q=70')">
  <div class="page-hero-overlay"></div>
  <div class="container hero-inner">
    <span class="eyebrow">BrightHope</span>
    <h1 class="hero-title">About BrightHope</h1>
    <p class="hero-sub">A small Manchester team with a big belief — community changes everything.</p>
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="index.html">Home</a> <i>/</i> <span>About</span></nav>
  </div>
  <div class="hero-orb" aria-hidden="true"></div>
</section>
<section class="section">
  <div class="container feature">
    <div class="feature-media" style="background-image:url('https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&w=1200&q=70')"></div>
    <div class="feature-body">
      <span class="eyebrow">Our story</span>
      <h2>From a single soup kitchen to a city-wide movement.</h2>
      <p>BrightHope began in 2014 in a church hall in Salford. A handful of neighbours wanted to do something — anything — for the families struggling around them. Twelve years later, we run food hubs, mentoring schemes and weekly community events across Greater Manchester.</p>
      <p>We have stayed small enough to know everyone's name, and grown enough to make a measurable difference.</p>
      <a class="btn btn-primary" href="contact.html">Join us</a>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <header class="section-head"><h2>What we believe</h2><p>Four ideas guide every project we run.</p></header>
    <div class="grid grid-4">
      <article class="card"><span class="card-num">01</span><h3>Dignity</h3><p>Every person we meet is treated with warmth and respect — never as a case file.</p></article>
      <article class="card"><span class="card-num">02</span><h3>Community</h3><p>Local people lead local solutions. We listen first, then build together.</p></article>
      <article class="card"><span class="card-num">03</span><h3>Honesty</h3><p>Open books, plain language and a yearly impact report anyone can read.</p></article>
      <article class="card"><span class="card-num">04</span><h3>Hope</h3><p>The belief — backed by years of evidence — that things really can get better.</p></article>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <header class="section-head"><h2>Meet the team</h2><p>Real humans who answer real emails.</p></header>
    <div class="grid grid-3">
      <article class="card"><span class="card-num">Founder</span><h3>Amelia Hart</h3><p>Started BrightHope from her kitchen in 2014. Still makes the best Sunday stew.</p></article>
      <article class="card"><span class="card-num">Programmes</span><h3>Daniel Okafor</h3><p>Designs our mentoring and learning schemes across Greater Manchester.</p></article>
      <article class="card"><span class="card-num">Outreach</span><h3>Priya Shah</h3><p>Connects with families, schools and councils to make sure no-one is missed.</p></article>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container cta-inner">
    <h2>Want to be part of it?</h2>
    <p>Volunteers, partners and donors keep BrightHope running. Come and say hello.</p>
    <div class="hero-cta"><a class="btn btn-primary" href="contact.html">Get in touch</a><a class="btn btn-ghost" href="services.html">See our programmes</a></div>
  </div>
</section>

@endsection
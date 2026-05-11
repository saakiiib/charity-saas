@extends('frontend.master')

@section('content')

{{-- Slider --}}
<section class="hero hero-slider" data-slider>
  <div class="hero-slides">
    @foreach($sliders as $slider)
    <div class="hero-slide {{ $loop->first ? 'is-active' : '' }}"
         style="background-image:url('{{ asset('uploads/slider/' . $slider->image) }}')"></div>
    @endforeach
  </div>
  <div class="hero-overlay"></div>
  <div class="container hero-inner">
    <span class="eyebrow">{{ $sliders->first()?->title }}</span>
    <h1 class="hero-title">{{ $sliders->first()?->sub_title }}</h1>
    <p class="hero-sub">{{ $sliders->first()?->description }}</p>
    <div class="hero-cta">
      @if($sliders->first()?->link1)
        <a class="btn btn-primary" href="{{ $sliders->first()->link1 }}">Donate now</a>
      @endif
      @if($sliders->first()?->link2)
        <a class="btn btn-ghost" href="{{ $sliders->first()->link2 }}">Get involved</a>
      @endif
    </div>
  </div>
  <button class="hero-arrow hero-prev" aria-label="Previous slide" data-prev>‹</button>
  <button class="hero-arrow hero-next" aria-label="Next slide" data-next>›</button>
  <div class="hero-dots" data-dots>
    @foreach($sliders as $slider)
    <button class="{{ $loop->first ? 'is-active' : '' }}" data-go="{{ $loop->index }}" aria-label="Slide {{ $loop->iteration }}"></button>
    @endforeach
  </div>
</section>

{{-- Difference --}}
<section class="section">
  <div class="container">
    <header class="section-head">
      <h2>{{ $difference?->short_title }}</h2>
      <p>{{ $difference?->long_title }}</p>
    </header>
    <div class="grid grid-3">
      @foreach($difference?->content ?? [] as $index => $item)
      <article class="card">
        <span class="card-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
        <h3>{{ $item['key'] }}</h3>
        <p>{{ $item['short_desc'] }}</p>
      </article>
      @endforeach
    </div>
  </div>
</section>

{{-- Stats --}}
<section class="section section-alt">
  <div class="container">
    <header class="section-head">
      <h2>{{ $stats?->short_title }}</h2>
      <p>{{ $stats?->long_title }}</p>
    </header>
    <div class="grid grid-4 stats">
      @foreach($stats?->content ?? [] as $item)
      <div class="stat">
        <span class="stat-num">{{ $item['key'] }}</span>
        <span class="stat-label">{{ $item['short_desc'] }}</span>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Latest Post --}}
<section class="section">
  <div class="container feature">
    <div class="feature-media" style="background-image:url('{{ asset('uploads/posts/' . $latestPost?->image) }}')"></div>
    <div class="feature-body">
      <span class="eyebrow">{{ $latestPost?->created_at?->format('F Y') }}</span>
      <h2>{{ $latestPost?->title }}</h2>
      <p>{{ $latestPost?->short_description }}</p>
      <a class="btn btn-ghost" href="{{ url('/updates') }}">Read more updates →</a>
    </div>
  </div>
</section>

{{-- Testimonials --}}
<section class="section section-alt">
  <div class="container">
    <header class="section-head">
      <h2>{{ $testimonialsSection?->short_title }}</h2>
      <p>{{ $testimonialsSection?->long_title }}</p>
    </header>
    <div class="grid grid-2">
      @foreach($testimonials as $testimonial)
      <blockquote class="quote">
        <span class="qmark" aria-hidden="true">"</span>
        <p>"{{ $testimonial->message }}"</p>
        <footer>
          <strong>{{ $testimonial->name }}</strong>
          <span>{{ $testimonial->designation }}</span>
        </footer>
      </blockquote>
      @endforeach
    </div>
  </div>
</section>

{{-- Gallery --}}
<section class="section">
  <div class="container">
    <header class="section-head">
      <h2>{{ $gallerySection?->short_title }}</h2>
      <p>{{ $gallerySection?->long_title }}</p>
    </header>
    <div class="gallery">
      @foreach($galleries as $gallery)
      <figure class="tile" data-lightbox style="background-image:url('{{ asset('uploads/galleries/' . $gallery->image) }}')">
        <span>{{ $gallery->title }}</span>
      </figure>
      @endforeach
    </div>
  </div>
</section>

{{-- CTA --}}
@include('frontend.cta')

@endsection
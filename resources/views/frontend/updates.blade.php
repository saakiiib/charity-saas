@extends('frontend.master')

@section('content')

{{-- Hero --}}
<section class="page-hero"
    style="background-image:url('{{ $hero?->image ? asset('uploads/masters/' . $hero->image) : '' }}')">
    <div class="page-hero-overlay"></div>
    <div class="container hero-inner">
        <span class="eyebrow">{{ $hero?->short_title }}</span>
        <h1 class="hero-title">{{ $hero?->long_title }}</h1>
        <p class="hero-sub">{{ $hero?->short_description }}</p>
        <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a> <i>/</i> <span>Updates</span></nav>
    </div>
    <div class="hero-orb" aria-hidden="true"></div>
</section>

{{-- Posts --}}
<section class="section">
    <div class="container">
        <div class="grid grid-3">
            @foreach($posts as $post)
            <article class="post">
                <div class="post-media" style="background-image:url('{{ asset('uploads/posts/' . $post->image) }}')"></div>
                <div class="post-body">
                    <span class="post-meta">{{ $post->created_at->format('d F Y') }}</span>
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->short_description }}</p>
                    <a class="card-link" href="{{ route('updates.detail', $post->slug) }}">Read the story →</a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
@include('frontend.cta')

@endsection
@extends('frontend.master')

@section('content')

<section class="page-hero"
    style="background-image:url('{{ $hero?->image ? asset('uploads/masters/' . $hero->image) : '' }}')">
    <div class="page-hero-overlay"></div>
    <div class="container hero-inner">
        <span class="eyebrow">{{ $hero?->short_title }}</span>
        <h1 class="hero-title">{{ $hero?->long_title }}</h1>
        <p class="hero-sub">{{ $hero?->short_description }}</p>
        <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a> <i>/</i> <span>Gallery</span></nav>
    </div>
    <div class="hero-orb" aria-hidden="true"></div>
</section>

<section class="section">
    <div class="container">
        <div class="gallery">
            @foreach($galleries as $gallery)
            <figure class="tile" data-lightbox style="background-image:url('{{ asset('uploads/galleries/' . $gallery->image) }}')">
                <span>{{ $gallery->title }}</span>
            </figure>
            @endforeach
        </div>
    </div>
</section>

@include('frontend.cta')

@endsection
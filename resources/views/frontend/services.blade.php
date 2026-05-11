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
        <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a> <i>/</i> <span>Services</span></nav>
    </div>
    <div class="hero-orb" aria-hidden="true"></div>
</section>

{{-- Services Grid --}}
<section class="section">
    <div class="container">
        <div class="grid grid-2">
            @foreach($services as $index => $service)
            <article class="card">
                <span class="card-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }} · {{ $service->title }}</span>
                <h3>{{ $service->title }}</h3>
                <p>{{ $service->short_description }}</p>
                <a class="card-link" href="{{ route('service.detail', $service->slug) }}">Learn more →</a>
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
        <div class="grid grid-3 stats">
            @foreach($stats?->content ?? [] as $item)
            <div class="stat">
                <span class="stat-num">{{ $item['key'] }}</span>
                <span class="stat-label">{{ $item['short_desc'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
@include('frontend.cta')

@endsection
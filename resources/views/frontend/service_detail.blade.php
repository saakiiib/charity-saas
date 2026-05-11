@extends('frontend.master')

@section('content')

{{-- Hero --}}
<section class="page-hero"
    style="background-image:url('{{ $hero?->image ? asset('uploads/masters/' . $hero->image) : '' }}')">
    <div class="page-hero-overlay"></div>
    <div class="container hero-inner">
        <span class="eyebrow">{{ $hero?->short_title }}</span>
        <h1 class="hero-title">{{ $service->title }}</h1>
        <p class="hero-sub">{{ $service->short_description }}</p>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a> <i>/</i>
            <a href="{{ route('services') }}">Services</a> <i>/</i>
            <span>{{ $service->title }}</span>
        </nav>
    </div>
    <div class="hero-orb" aria-hidden="true"></div>
</section>

{{-- Detail --}}
<section class="section">
    <div class="container detail">
        <div class="detail-body">
            @if($service->image)
            <div class="feature-media" style="margin-bottom:30px;background-image:url('{{ asset('uploads/services/' . $service->image) }}')"></div>
            @endif
            {!! $service->content !!}
        </div>
        <aside class="detail-side">
            <h4>Other services</h4>
            <ul>
                @foreach($services as $s)
                    @if($s->id !== $service->id)
                    <li><a href="{{ route('service.detail', $s->slug) }}">{{ $s->title }}</a></li>
                    @endif
                @endforeach
            </ul>
            <h4 style="margin-top:24px">Need help today?</h4>
            <p style="color:var(--muted);font-size:.95rem;margin:0 0 18px">Our team answers messages within an hour during opening times.</p>
            <a class="btn btn-primary" href="{{ route('contact') }}">Get in touch</a>
        </aside>
    </div>
</section>

{{-- CTA --}}
@include('frontend.cta')

@endsection
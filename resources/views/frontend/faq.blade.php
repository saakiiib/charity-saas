@extends('frontend.master')

@section('content')

<section class="page-hero"
    style="background-image:url('{{ $hero?->image ? asset('uploads/masters/' . $hero->image) : '' }}')">
    <div class="page-hero-overlay"></div>
    <div class="container hero-inner">
        <span class="eyebrow">{{ $hero?->short_title }}</span>
        <h1 class="hero-title">Frequently Asked Questions</h1>
        <p class="hero-sub">{{ $hero?->short_description }}</p>
        <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a> <i>/</i> <span>FAQ</span></nav>
    </div>
    <div class="hero-orb" aria-hidden="true"></div>
</section>

<section class="section faq-section">
    <div class="container">
        <div class="faq" data-faq>
            @foreach($faqs as $faq)
            <details class="faq-item reveal" {{ $loop->first ? 'open' : '' }}>
                <summary><span>{{ $faq->question }}</span><i class="faq-ico" aria-hidden="true"></i></summary>
                <div class="faq-body"><p>{!! $faq->answer !!}</p></div>
            </details>
            @endforeach
        </div>
    </div>
</section>

@include('frontend.cta')

@endsection
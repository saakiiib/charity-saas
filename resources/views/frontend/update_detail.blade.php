@extends('frontend.master')

@section('content')

{{-- Hero --}}
<section class="page-hero"
    style="background-image:url('{{ $hero?->image ? asset('uploads/masters/' . $hero->image) : '' }}')">
    <div class="page-hero-overlay"></div>
    <div class="container hero-inner">
        <span class="eyebrow">{{ $post->created_at->format('F Y') }}</span>
        <h1 class="hero-title">{{ $post->title }}</h1>
        <p class="hero-sub">{{ $post->short_description }}</p>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a> <i>/</i>
            <a href="{{ route('updates') }}">Updates</a> <i>/</i>
            <span>{{ $post->title }}</span>
        </nav>
    </div>
    <div class="hero-orb" aria-hidden="true"></div>
</section>

{{-- Detail --}}
<section class="section">
    <div class="container detail">
        <div class="detail-body">
            @if($post->image)
            <div class="feature-media" style="margin-bottom:30px;background-image:url('{{ asset('uploads/posts/' . $post->image) }}')"></div>
            @endif
            {!! $post->long_description !!}
        </div>
        <aside class="detail-side">
            <h4>More updates</h4>
            <ul>
                @foreach($recent as $r)
                <li><a href="{{ route('updates.detail', $r->slug) }}">{{ $r->title }}</a></li>
                @endforeach
            </ul>
        </aside>
    </div>
</section>

{{-- CTA --}}
@include('frontend.cta')

@endsection
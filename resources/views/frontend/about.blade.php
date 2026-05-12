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
            <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a> <i>/</i> <span>About</span>
            </nav>
        </div>
        <div class="hero-orb" aria-hidden="true"></div>
    </section>

    @foreach ($sections as $sectionName)
        @if ($sectionName === 'story')
            {{-- Story --}}
            <section class="section">
                <div class="container feature">
                    <div class="feature-media"
                        style="background-image:url('{{ $story?->image ? asset('uploads/masters/' . $story->image) : '' }}')">
                    </div>
                    <div class="feature-body">
                        <span class="eyebrow">{{ $story?->short_title }}</span>
                        <h2>{{ $story?->long_title }}</h2>
                        <div>{!! $story?->short_description !!}</div>
                        <div>{!! $story?->long_description !!}</div>
                        @if ($story?->content[0]['short_desc'] ?? null)
                            <a class="btn btn-primary"
                                href="{{ $story->content[0]['long_desc'] ?? route('contact') }}">{{ $story->content[0]['short_desc'] }}</a>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        @if ($sectionName === 'beliefs')
            {{-- Beliefs --}}
            <section class="section section-alt">
                <div class="container">
                    <header class="section-head">
                        <h2>{{ $beliefs?->short_title }}</h2>
                        <p>{{ $beliefs?->long_title }}</p>
                    </header>
                    <div class="grid grid-4">
                        @foreach ($beliefs?->content ?? [] as $item)
                            <article class="card">
                                <span class="card-num">{{ $item['key'] }}</span>
                                <h3>{{ $item['short_desc'] }}</h3>
                                <p>{{ $item['long_desc'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($sectionName === 'team')
            {{-- Team --}}
            <section class="section">
                <div class="container">
                    <header class="section-head">
                        <h2>{{ $team?->short_title }}</h2>
                        <p>{{ $team?->long_title }}</p>
                    </header>
                    <div class="grid grid-3">
                        @foreach ($team?->content ?? [] as $item)
                            <article class="card">
                                <h3>{{ $item['short_desc'] }}</h3>
                                <p>{{ $item['long_desc'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach

    {{-- CTA --}}
    @include('frontend.cta')
@endsection
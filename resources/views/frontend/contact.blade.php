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
        <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a> <i>/</i> <span>Contact</span></nav>
    </div>
    <div class="hero-orb" aria-hidden="true"></div>
</section>

{{-- Contact --}}
<section class="section">
    <div class="container contact-grid">
        <div class="contact-info">
            @if($company?->address1)
            <div class="info-card">
                <h4>Visit</h4>
                <p>
                    {{ $company->address1 }}
                    @if($company->address2)<br>{{ $company->address2 }}@endif
                </p>
            </div>
            @endif

            @if($company?->email1 || $company?->email2)
            <div class="info-card">
                <h4>Email</h4>
                <p>
                    @if($company->email1){{ $company->email1 }}@endif
                    @if($company->email2)<br>{{ $company->email2 }}@endif
                </p>
            </div>
            @endif

            @if($company?->phone1 || $company?->whatsapp)
            <div class="info-card">
                <h4>Phone &amp; WhatsApp</h4>
                <p>
                    @if($company->phone1){{ $company->phone1 }}@endif
                    @if($company->phone2)<br>{{ $company->phone2 }}@endif
                    @if($company->opening_time)<br>{{ $company->opening_time }}@endif
                </p>
            </div>
            @endif

            @if($company?->facebook || $company?->instagram || $company?->twitter || $company?->linkedin || $company?->youtube)
            <div class="info-card">
                <h4>Follow us</h4>
                <p>
                    @if($company->facebook)<a href="{{ $company->facebook }}" target="_blank">Facebook</a><br>@endif
                    @if($company->instagram)<a href="{{ $company->instagram }}" target="_blank">Instagram</a><br>@endif
                    @if($company->twitter)<a href="{{ $company->twitter }}" target="_blank">Twitter / X</a><br>@endif
                    @if($company->linkedin)<a href="{{ $company->linkedin }}" target="_blank">LinkedIn</a><br>@endif
                    @if($company->youtube)<a href="{{ $company->youtube }}" target="_blank">YouTube</a>@endif
                </p>
            </div>
            @endif
        </div>

        <form class="contact-form" action="{{ route('contact.submit') }}" method="POST">
            @csrf
            @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            <div class="row">
                <div>
                    <label for="fn">First name</label>
                    <input id="fn" type="text" name="first_name" required placeholder="Alex" value="{{ old('first_name') }}">
                </div>
                <div>
                    <label for="ln">Last name</label>
                    <input id="ln" type="text" name="last_name" placeholder="Morgan" value="{{ old('last_name') }}">
                </div>
            </div>
            <div class="row">
                <div>
                    <label for="em">Email</label>
                    <input id="em" type="email" name="email" required placeholder="you@example.co.uk" value="{{ old('email') }}">
                </div>
                <div>
                    <label for="ph">Phone (optional)</label>
                    <input id="ph" type="tel" name="phone" placeholder="07000 000000" value="{{ old('phone') }}">
                </div>
            </div>
            <div style="margin-bottom:16px">
                <label for="rs">Subject</label>
                <input id="rs" type="text" name="subject" placeholder="Volunteer · Donate · Need support" value="{{ old('subject') }}">
            </div>
            <div style="margin-bottom:22px">
                <label for="msg">Your message</label>
                <textarea id="msg" name="message" required placeholder="Tell us a little about how we can help.">{{ old('message') }}</textarea>
            </div>
            <button class="btn btn-primary" type="submit">Send message</button>
        </form>
    </div>
</section>

@if($company?->google_map)
<div>{!! $company->google_map !!}</div>
@endif

{{-- CTA --}}
@include('frontend.cta')

@endsection
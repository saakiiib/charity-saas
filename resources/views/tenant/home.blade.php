{{-- resources/views/tenant/home.blade.php --}}
@extends('tenant.layouts.master')
@section('title', $tenant->name . ' - Home')
@section('content')

<section class="hero text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">{{ $tenant->name }}</h1>
        @if($tenant->tagline)<p class="lead mt-3">{{ $tenant->tagline }}</p>@endif
        <a href="/contact" class="btn btn-light btn-lg mt-4">Get In Touch</a>
    </div>
</section>

<section class="section bg-light">
    <div class="container text-center">
        <h2 class="mb-4">What We Do</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4">
                    <i class="ri-heart-line fs-1 text-primary"></i>
                    <h5 class="mt-3">Community Support</h5>
                    <p class="text-muted">We support our local community with essential services and care.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4">
                    <i class="ri-hand-heart-line fs-1 text-primary"></i>
                    <h5 class="mt-3">Volunteering</h5>
                    <p class="text-muted">Join our team of dedicated volunteers making a real difference.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4">
                    <i class="ri-funds-line fs-1 text-primary"></i>
                    <h5 class="mt-3">Fundraising</h5>
                    <p class="text-muted">Your donations help us continue our vital work every day.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container text-center">
        <h2 class="mb-3">Our Services</h2>
        <p class="text-muted mb-4">Explore the range of services we offer to our community.</p>
        <a href="/services" class="btn btn-primary px-4">View All Services</a>
    </div>
</section>

@endsection
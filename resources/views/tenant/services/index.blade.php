{{-- resources/views/tenant/services/index.blade.php --}}
@extends('tenant.layouts.master')
@section('title', $tenant->name . ' - Services')
@section('content')

<section class="hero text-center" style="padding: 60px 0;">
    <div class="container">
        <h1 class="fw-bold">Our Services</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-md-6 col-lg-3">
                <a href="/services/{{ $service['slug'] }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 p-4 text-center">
                        <i class="{{ $service['icon'] }} fs-1 text-primary"></i>
                        <h5 class="mt-3 text-dark">{{ $service['title'] }}</h5>
                        <p class="text-muted small">{{ $service['description'] }}</p>
                        <span class="text-primary small fw-bold">Learn More →</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
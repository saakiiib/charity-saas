{{-- resources/views/tenant/about.blade.php --}}
@extends('tenant.layouts.master')
@section('title', $tenant->name . ' - About')
@section('content')

<section class="hero text-center" style="padding: 60px 0;">
    <div class="container">
        <h1 class="fw-bold">{{ $data['title'] }}</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6">
                <h2 class="fw-bold mb-3">Who We Are</h2>
                <p class="text-muted fs-5">{{ $data['description'] }}</p>
                <p class="text-muted">We have been serving our community for many years, providing essential support and care to those who need it most. Our dedicated team works tirelessly to make a positive impact.</p>
                <a href="/contact" class="btn btn-primary mt-3">Contact Us</a>
            </div>
            <div class="col-md-6 text-center">
                <i class="ri-group-line" style="font-size: 10rem; color: var(--primary); opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<section class="section bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">Meet The Team</h2>
        <div class="row g-4 justify-content-center">
            @foreach($data['team'] as $member)
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm p-4">
                    <div class="rounded-circle bg-secondary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px;">
                        <i class="ri-user-line text-white fs-2"></i>
                    </div>
                    <h5 class="mb-1">{{ $member['name'] }}</h5>
                    <p class="text-muted small mb-0">{{ $member['role'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
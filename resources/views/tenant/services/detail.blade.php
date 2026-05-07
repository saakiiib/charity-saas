{{-- resources/views/tenant/services/detail.blade.php --}}
@extends('tenant.layouts.master')
@section('title', $tenant->name . ' - ' . $service['title'])
@section('content')

<section class="hero text-center" style="padding: 60px 0;">
    <div class="container">
        <i class="{{ $service['icon'] }} fs-1 text-white"></i>
        <h1 class="fw-bold mt-3">{{ $service['title'] }}</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <p class="fs-5 text-muted">{{ $service['description'] }}</p>
                <a href="/contact" class="btn btn-primary mt-4 me-2">Get Involved</a>
                <a href="/services" class="btn btn-outline-secondary mt-4">Back to Services</a>
            </div>
        </div>
    </div>
</section>

@endsection
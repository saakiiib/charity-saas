{{-- resources/views/tenant/contact.blade.php --}}
@extends('tenant.layouts.master')
@section('title', $tenant->name . ' - Contact')
@section('content')

<section class="hero text-center" style="padding: 60px 0;">
    <div class="container">
        <h1 class="fw-bold">Contact Us</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-md-6">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ri-checkbox-circle-line me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <div class="card border-0 shadow-sm p-4">
                    <h4 class="mb-4">Send Us a Message</h4>
                    <form action="/contact" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="mb-4">Get In Touch</h5>
                    @if($tenant->email)
                    <p><i class="ri-mail-line me-2 text-primary"></i>{{ $tenant->email }}</p>
                    @endif
                    @if($tenant->phone)
                    <p><i class="ri-phone-line me-2 text-primary"></i>{{ $tenant->phone }}</p>
                    @endif
                    @if($tenant->tagline)
                    <p class="text-muted mt-3">{{ $tenant->tagline }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection